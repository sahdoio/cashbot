<?php

declare(strict_types=1);

namespace App\Http\Auth;

use App\Http\Controllers\Controller;
use Core\Application\UseCases\Auth\AuthenticationInputDTO;
use Core\Domain\Exceptions\ForbiddenAccessException;
use Core\Domain\Exceptions\ResourceNotFoundException;
use Core\Domain\UseCases\Auth\AuthenticationContract;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function __construct(private readonly AuthenticationContract $authentication) {}

    /**
     * @throws Exception
     */
    public function login(AuthRequest $request): Response|JsonResponse
    {
        try {
            $result = $this->authentication->exec(new AuthenticationInputDTO(
                email: $request->email,
                password: $request->password
            ));

            return response()->json($result, Response::HTTP_OK);
        } catch (ResourceNotFoundException $exception) {
            Log::warning('User not found', ['email' => $request->email, 'exception' => $exception->getMessage()]);

            return response('', Response::HTTP_NOT_FOUND);
        } catch (ForbiddenAccessException $exception) {
            Log::warning('User not allowed to access or invalid password', ['email' => $request->email, 'exception' => $exception->getMessage()]);

            return response('', Response::HTTP_FORBIDDEN);
        } catch (Exception $exception) {
            Log::error('Internal server error', ['email' => $request->email, 'exception' => $exception->getMessage()]);

            throw $exception;
        }
    }
}
