<?php

namespace app\modules\user\infraestructure\controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use app\modules\user\application\dtos\request\CreateUserRequestDto;
use app\modules\user\application\dtos\request\LoginUserRequestDto;
use app\modules\user\application\services\UserService;
use app\shared\dtos\api\response\CreateResponseDto;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function create(Request $request)
    {


        try {

            // Obtén todos los datos del cuerpo de la solicitud
            $requestBody = $request->all();

            // Log de entrada de la solicitud
            Log::info('Solicitud recibida en create', ['request' => $requestBody]);

            // Crea una instancia de CreateUserRequest y valida los datos
            $userDto = new CreateUserRequestDto($requestBody);

            $userCreated = $this->userService->createUser($userDto);

            // Log de entrada de la solicitud
            Log::info('Solicitud recibida en create', ['request' => $requestBody]);

            return response()->json($userCreated, 201);
        } catch (ValidationException $e) {
            // Manejar los errores de validación...
            return response()->json($e->errors(), 422);
        }
    }

    public function login(Request $request)
    {


        try {

            // Obtén todos los datos del cuerpo de la solicitud
            $requestBody = $request->all();

            // Log de entrada de la solicitud
            Log::info('Solicitud recibida en login', ['request' => $requestBody]);

            // Crea una instancia de CreateUserRequest y valida los datos
            $loginDto = new LoginUserRequestDto($requestBody);

            $token = $this->userService->loginUser($loginDto->username, $loginDto->password);

            // Log de entrada de la solicitud
            Log::info('Solicitud recibida en create', ['request' => $requestBody]);

            $response = new CreateResponseDto(['data' => ['token' => $token]]);
            return response()->json($response, $response->statusCode);
        } catch (ValidationException $e) {
            // Manejar los errores de validación...
            return response()->json($e->errors(), 422);
        }
    }
}
