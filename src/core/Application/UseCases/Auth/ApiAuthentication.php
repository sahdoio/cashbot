<?php

namespace Core\Application\UseCases\Auth;

use Core\Domain\Entities\AccessToken;
use Core\Domain\Entities\User;
use Core\Domain\Exceptions\ForbiddenAccessException;
use Core\Domain\Exceptions\ResourceNotFoundException;
use Core\Domain\Repositories\AccessTokenContract;
use Core\Domain\Repositories\DbRepositoryContract;
use Core\Domain\UseCases\Auth\AuthenticationContract;
use Core\Domain\Utils\EncrypterContract;

readonly class ApiAuthentication implements AuthenticationContract
{
    public function __construct(
        protected DbRepositoryContract $dbRepository,
        protected AccessTokenContract $accessToken,
        protected EncrypterContract $encrypter
    ) {}

    /**
     * @throws ResourceNotFoundException
     * @throws ForbiddenAccessException
     */
    public function exec(AuthenticationInputDTO $data): AuthenticationOutputDTO
    {
        $this->dbRepository->setSchema(User::SCHEMA);
        $user = $this->dbRepository->findOne(['email' => $data->email]);

        if (! $user) {
            throw new ResourceNotFoundException(
                message: 'User not found'
            );
        }

        $userEntity = new User(
            id: $user['id'],
            name: $user['name'],
            email: $user['email'],
            password: $user['password']
        );

        if (! $this->encrypter->check($data->password, $userEntity->password)) {
            throw new ForbiddenAccessException(
                message: 'Invalid password'
            );
        }

        unset($userEntity->password);

        $token = $this->accessToken->generate($userEntity);

        $this->dbRepository->setSchema(AccessToken::SCHEMA);
        $this->dbRepository->create([
            'name' => 'access_token',
            'token' => $token,
            'user_id' => $userEntity->id,
        ]);

        return new AuthenticationOutputDTO(
            user: $userEntity,
            token: $token
        );
    }
}
