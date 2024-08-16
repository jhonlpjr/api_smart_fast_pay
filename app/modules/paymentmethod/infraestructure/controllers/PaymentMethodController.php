<?php

namespace app\modules\paymentmethod\infraestructure\controllers;

use App\Http\Controllers\Controller;
use app\modules\paymentmethod\application\dtos\request\CreatePaymentMethodRequestDto;
use Illuminate\Http\Request;

use app\modules\paymentmethod\application\services\PaymentMethodService;
use app\shared\dtos\api\response\CreateResponseDto;
use app\shared\dtos\api\response\ErrorResponseDto;
use app\shared\dtos\api\response\ResponseDto;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class PaymentMethodController extends Controller
{
    protected PaymentMethodService $paymentMethodService;

    public function __construct(PaymentMethodService $paymentMethodService)
    {
        $this->paymentMethodService = $paymentMethodService;
    }

    /**
     * @OA\Post(
     *     path="/api/payment-method/create",
     *     summary="New payment method register",
     *     tags={"Payment Methods"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Pix"),
     *             @OA\Property(property="slug", type="string", example="pix"),
     *             @OA\Property(property="commission", type="number", example=0.05),
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

            // Obtén todos los datos del cuerpo de la solicitud
            $requestBody = $request->all();

            // Log de entrada de la solicitud
            Log::info('Solicitud recibida en create', ['request' => $requestBody]);

            // Crea una instancia de CreateUserRequest y valida los datos
            $paymentMethodDto = new CreatePaymentMethodRequestDto($requestBody);

            $paymentMethodCreated = $this->paymentMethodService->createPaymentMethod($paymentMethodDto);

            // Log de entrada de la solicitud
            Log::info('Solicitud recibida en create', ['request' => $requestBody]);

            $response = new CreateResponseDto(['data' => $paymentMethodCreated]);
            return response()->json($response, $response->statusCode);
        } catch (ValidationException $e) {
            // Manejar los errores de validación...
            $response = new ErrorResponseDto(['data' => $e->errors(), 'message' => 'Validation error', 'statusCode' => Response::HTTP_BAD_REQUEST]);
            return response()->json($e->errors(), 422);
        }
    }

    public function delete($id)
    {
        try {

            // Obtén todos los datos del cuerpo de la solicitud
            //$requestBody = $request->all();

            // Log de entrada de la solicitud
            Log::info('Solicitud recibida en delete', ['id' => $id]);

            $paymentMethodDeleted = $this->paymentMethodService->deletePaymentMethod($id);

            $response = new ResponseDto(['data' => $paymentMethodDeleted]);
            return response()->json($response, $response->statusCode);
        } catch (ValidationException $e) {
            // Manejar los errores de validación...
            $response = new ErrorResponseDto(['data' => $e->errors(), 'message' => 'Validation error', 'statusCode' => Response::HTTP_BAD_REQUEST]);
            return response()->json($e->errors(), 422);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/payment-method/find/{id}",
     *     summary="Search of payment method by id",
     *     tags={"Payment Methods"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=false,
     *         @OA\Schema(type="integer"),
     *         description="Name of customer"
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
            Log::info('Solicitud recibida en findOne', ['id' => $id]);

            $paymentMethod = $this->paymentMethodService->findOnePaymentMethod($id);

            $response = new ResponseDto(['data' => $paymentMethod]);
            return response()->json($response, $response->statusCode);
        } catch (ValidationException $e) {
            // Manejar los errores de validación...
            $response = new ErrorResponseDto(['data' => $e->errors(), 'message' => 'Validation error', 'statusCode' => Response::HTTP_BAD_REQUEST]);
            return response()->json($e->errors(), 422);
        }
    }
}
