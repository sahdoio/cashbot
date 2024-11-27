<?php

namespace Core\Domain\Auth\UseCases;

use Core\Application\UseCases\Auth\ApiAuthentication;
use Core\Application\UseCases\Auth\AuthenticationInputDTO;
use Core\Domain\Entities\User;
use Core\Domain\Exceptions\ResourceNotFoundException;
use Core\Domain\Repositories\AccessTokenContract;
use Core\Domain\Repositories\UserDbRepositoryContract;
use Core\Domain\Utils\EncrypterContract;
use PHPUnit\Framework\MockObject\Exception;

beforeEach(
    /**
     * @throws Exception
     */
    function () {
        $this->userEntity = new User(
            id: '1',
            name: 'Jon Doe',
            email: 'test@test.com',
            password: 'any_password'
        );

        $this->dto = new AuthenticationInputDTO(
            email: $this->userEntity->email,
            password: 'any_password'
        );

        $this->accessToken = 'generated_token';
        $this->accessTokenStub = $this->createStub(AccessTokenContract::class);
        $this->accessTokenStub->method('generate')
            ->willReturn($this->accessToken);

        $this->encrypterStub = $this->createStub(EncrypterContract::class);
        $this->encrypterStub->method('check')
            ->willReturn(true);
    }
);

describe('Authentication', function () {
    test('Verifies that token was generated successfully', function () {
        $userRepositoryMock = $this->createMock(UserDbRepositoryContract::class);
        $userRepositoryMock->method('findOne')
            ->with(['email' => $this->userEntity->email])
            ->willReturn([
                'id' => $this->userEntity->id,
                'name' => $this->userEntity->name,
                'email' => $this->userEntity->email,
                'password' => $this->userEntity->password,
            ]);

        $this->sut = new ApiAuthentication($userRepositoryMock, $this->accessTokenStub, $this->encrypterStub);

        $result = $this->sut->exec($this->dto);
        expect($result->token)->toBe($this->accessToken);
    });

    test('Should throw ResourceNotFoundException when trying to login', function () {
        $userRepositoryStub = $this->createStub(UserDbRepositoryContract::class);
        $userRepositoryStub->method('findOne')
            ->willReturn(null);
        $this->sut = new ApiAuthentication($userRepositoryStub, $this->accessTokenStub, $this->encrypterStub);

        $this->expectException(ResourceNotFoundException::class);

        $this->sut->exec($this->dto);
    });
});
