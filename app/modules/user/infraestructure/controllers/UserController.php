<?php

namespace app\modules\user\infraestructure\controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use app\modules\user\application\dtos\request\CreateUserRequestDto;
use app\modules\user\application\dtos\request\LoginUserRequestDto;
use app\modules\user\application\services\UserService;
use app\shared\dtos\api\response\CreateResponseDto;
use app\shared\dtos\api\response\ErrorResponseDto;
use app\shared\dtos\api\response\ResponseDto;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Post(
     *     path="/api/users/create",
     *     summary="Register new user ",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="username", type="string", example="ran"),
     *             @OA\Property(property="email", type="string", example="ran@email.com"),
     *             @OA\Property(property="names", type="string", example="Rancos"),
     *             @OA\Property(property="lastnames", type="string", example="Roxette"),
     *             @OA\Property(property="password", type="string", example="12345678"),
     *             @OA\Property(property="identity_document", type="string", example="11223344"),    
     *             @OA\Property(property="balance", type="number", format="float", example=0),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Ok",
     *          @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="statusCode", type="integer"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="statusCode", type="integer"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function create(Request $request)
    {
        try {
            // Get all the data from the request body
            $requestBody = $request->all();

            // Request input log
            Log::info('Solicitud recibida en create', ['request' => $requestBody]);

            // Create an instance of CreateUserRequest and validate the data
            $userDto = new CreateUserRequestDto($requestBody);

            // Create user with the validated data using the service
            $userCreated = $this->userService->createUser($userDto);

            $response = new CreateResponseDto(['data' => $userCreated]);
            return response()->json($response, $response->statusCode);
        } catch (ValidationException $e) {
            // Handling validation errors...
            $response = new ErrorResponseDto(['data' => $e->errors(), 'message' => 'Validation error', 'statusCode' => Response::HTTP_BAD_REQUEST]);
            return response()->json($response, $response->statusCode);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/users/login",
     *     summary="Login ",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="username", type="string", example="ran"),
     *             @OA\Property(property="password", type="string", example="12345678"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Ok",
     *          @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="statusCode", type="integer"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="statusCode", type="integer"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="statusCode", type="integer"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function login(Request $request)
    {
        try {
            // Get all the data from the request body
            $requestBody = $request->all();

            // Request input log
            Log::info('Solicitud recibida en login', ['request' => $requestBody]);

            // Create an instance of CreateUserRequest and validate the data
            $loginDto = new LoginUserRequestDto($requestBody);

            // Get the token sending the validated crededntials using the service
            $token = $this->userService->loginUser($loginDto->username, $loginDto->password);

            $response = new CreateResponseDto(['data' => ['token' => $token]]);
            return response()->json($response, $response->statusCode);
        } catch (ValidationException $e) {
            // Handling validation errors...
            $response = new ErrorResponseDto(['data' => $e->errors(), 'message' => 'Validation error', 'statusCode' => Response::HTTP_BAD_REQUEST]);
            return response()->json($response, $response->statusCode);
        } catch (Exception $e) {
            // Handling general exceptions
            $response = new ErrorResponseDto([
                'data' => [],
                'message' => 'Invalid credentials',
                'statusCode' => Response::HTTP_UNAUTHORIZED
            ]);
            return response()->json($response, $response->statusCode);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/users/balance/{id}",
     *     summary="Get balance of user by id",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=false,
     *         @OA\Schema(type="integer"),
     *         description="ID of user"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ok",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="statusCode", type="integer"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="statusCode", type="integer"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function getBalance($id)
    {
        try {

            // Obtén todos los datos del cuerpo de la solicitud
            //$requestBody = $request->all();

            // Log de entrada de la solicitud
            Log::info('Solicitud recibida en getBalance', ['id' => $id]);

            $userBalance = $this->userService->getUserBalance($id);

            $response = new ResponseDto(['data' => $userBalance]);
            return response()->json($response, $response->statusCode);
        } catch (ValidationException $e) {
            // Manejar los errores de validación...
            $response = new ErrorResponseDto(['data' => $e->errors(), 'message' => 'Validation error', 'statusCode' => Response::HTTP_BAD_REQUEST]);
            return response()->json($response, $response->statusCode);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/users/find/{id}",
     *     summary="Get user by id",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=false,
     *         @OA\Schema(type="integer"),
     *         description="ID of user"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ok",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="statusCode", type="integer"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="statusCode", type="integer"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function findOne($id)
    {
        try {

            // Obtén todos los datos del cuerpo de la solicitud
            //$requestBody = $request->all();

            // Log de entrada de la solicitud
            Log::info('Solicitud recibida en getBalance', ['id' => $id]);

            $userBalance = $this->userService->findUserById($id);

            $response = new ResponseDto(['data' => $userBalance]);
            return response()->json($response, $response->statusCode);
        } catch (ValidationException $e) {
            // Manejar los errores de validación...
            $response = new ErrorResponseDto(['data' => $e->errors(), 'message' => 'Validation error', 'statusCode' => Response::HTTP_BAD_REQUEST]);
            return response()->json($response, $response->statusCode);
        }
    }

     /**
     * @OA\Delete(
     *     path="/api/users/delete/{id}",
     *     summary="Get user by id",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=false,
     *         @OA\Schema(type="integer"),
     *         description="ID of user"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ok",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="statusCode", type="integer"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="statusCode", type="integer"),
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function delete($id)
    {
        try {

            // Obtén todos los datos del cuerpo de la solicitud
            //$requestBody = $request->all();

            // Log de entrada de la solicitud
            Log::info('Solicitud recibida en getBalance', ['id' => $id]);

            $userBalance = $this->userService->deleteUser($id);

            $response = new ResponseDto(['data' => $userBalance]);
            return response()->json($response, $response->statusCode);
        } catch (ValidationException $e) {
            // Manejar los errores de validación...
            $response = new ErrorResponseDto(['data' => $e->errors(), 'message' => 'Validation error', 'statusCode' => Response::HTTP_BAD_REQUEST]);
            return response()->json($response, $response->statusCode);
        }
    }
}
