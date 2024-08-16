<?php

namespace app\modules\payment\infraestructure\controllers;

use App\Http\Controllers\Controller;
use app\modules\payment\application\dtos\request\CreatePaymentRequestDto;
use app\modules\payment\application\dtos\request\FindPaymentRequestDto;
use app\modules\payment\application\dtos\request\ProcessPaymentRequestDto;
use app\modules\payment\application\services\PaymentService;
use Illuminate\Http\Request;

use app\shared\dtos\api\response\CreateResponseDto;
use app\shared\dtos\api\response\ErrorResponseDto;
use app\shared\dtos\api\response\ResponseDto;
use app\shared\utils\enums\ProcessStatusEnum;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

/**
 * @OA\Info(
 *     title="Smart Fast Pay - Payment Processing API",
 *     version="1.0.0",
 *     description="Smart Fast Pay - Payment Processing API",
 *     @OA\Contact(
 *         email="jhonlpjr@gmail.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class PaymentController extends Controller
{
    protected PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * @OA\Post(
     *     path="/api/payment/create",
     *     summary="New payment register",
     *     tags={"Payments"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="customer_name", type="string", example="Ran"),
     *             @OA\Property(property="cpf", type="string", example="11223344"),
     *             @OA\Property(property="description", type="string", example="description"),
     *             @OA\Property(property="value", type="number", format="float", example=200),
     *             @OA\Property(property="payment_method", type="string", example="pix"),
     *             @OA\Property(property="payment_date", type="string", example="2024-01-01"),
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
            $paymentDto = new CreatePaymentRequestDto($requestBody);

            $paymentCreated = $this->paymentService->createPayment($paymentDto);

            // Log de entrada de la solicitud
            Log::info('Solicitud recibida en PaymentService.create', ['request' => $requestBody]);

            $response = new CreateResponseDto(['data' => $paymentCreated]);
            return response()->json($response, $response->statusCode);
        } catch (ValidationException $e) {
            // Manejar los errores de validación...
            $response = new ErrorResponseDto(['data' => $e->errors(), 'message' => 'Validation error', 'statusCode' => Response::HTTP_BAD_REQUEST]);
            return response()->json($response, $response->statusCode);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/payment/delete/{id}",
     *     summary="Delete payment",
     *     tags={"Payments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the payment to delete"
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
            Log::info('Solicitud recibida en delete', ['id' => $id]);

            $paymentDeleted = $this->paymentService->deletePayment($id);

            $response = new ResponseDto(['data' => $paymentDeleted]);
            return response()->json($response, $response->statusCode);
        } catch (ValidationException $e) {
            // Manejar los errores de validación...
            $response = new ErrorResponseDto(['data' => $e->errors(), 'message' => 'Validation error', 'statusCode' => Response::HTTP_BAD_REQUEST]);
            return response()->json($response, $response->statusCode);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/payment/find",
     *     summary="Search of payments",
     *     tags={"Payments"},
     *     @OA\Parameter(
     *         name="customer_name",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string"),
     *         description="Name of customer"
     *     ),
     *     @OA\Parameter(
     *         name="payment_method",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string"),
     *         description="Method of payment"
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string"),
     *         description="Status of payment"
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
    public function find(Request $request)
    {
        try {

            // Obtén todos los datos queryParams de la solicitud
            $queryParams = $request->query();

            // Log de entrada de la solicitud
            Log::info('Solicitud recibida en findOne', ['queryParams' => $queryParams]);

            // Crea una instancia de CreateUserRequest y valida los datos
            $findPaymentsDto = new FindPaymentRequestDto($queryParams);

            $payment = $this->paymentService->findPayments($findPaymentsDto);

            $response = new ResponseDto(['data' => $payment]);
            return response()->json($response, $response->statusCode);
        } catch (ValidationException $e) {
            // Manejar los errores de validación...
            $response = new ErrorResponseDto(['data' => $e->errors(), 'message' => 'Validation error', 'statusCode' => Response::HTTP_BAD_REQUEST]);
            return response()->json($response, $response->statusCode);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/payment/find/{id}",
     *     summary="Search of payment by id",
     *     tags={"Payments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=false,
     *         @OA\Schema(type="integer"),
     *         description="Payment Id"
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

            $payment = $this->paymentService->findOnePayment($id);

            $response = new ResponseDto(['data' => $payment]);
            return response()->json($response, $response->statusCode);
        } catch (ValidationException $e) {
            // Manejar los errores de validación...
            $response = new ErrorResponseDto(['data' => $e->errors(), 'message' => 'Validation error', 'statusCode' => Response::HTTP_BAD_REQUEST]);
            return response()->json($response, $response->statusCode);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/payment/process",
     *     summary="Process payment",
     *     tags={"Payments"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="payment_id", type="number", format="integer",
     *                 example=1),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
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
    public function process(Request $request)
    {
        try {

            // Obtén todos los datos del cuerpo de la solicitud
            $requestBody = $request->all();

            // Log de entrada de la solicitud
            Log::info('Solicitud recibida en create', ['request' => $requestBody]);

            // Crea una instancia de CreateUserRequest y valida los datos
            $paymentDto = new ProcessPaymentRequestDto($requestBody);

            $paymentProcessed = $this->paymentService->processPayment($paymentDto);

            $response = new ResponseDto(['statusCode' => $paymentProcessed['status'] === ProcessStatusEnum::Success->value ? Response::HTTP_OK : Response::HTTP_PAYMENT_REQUIRED, 'message' => $paymentProcessed['message']]);
            return response()->json($response, $response->statusCode);
        } catch (ValidationException $e) {
            // Manejar los errores de validación...
            $response = new ErrorResponseDto(['data' => $e->errors(), 'message' => 'Validation error', 'statusCode' => Response::HTTP_BAD_REQUEST]);
            return response()->json($response, $response->statusCode);
        }
    }
}
