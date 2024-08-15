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

class PaymentController extends Controller
{
    protected PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

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

            $paymentDeleted = $this->paymentService->deletePayment($id);

            $response = new ResponseDto(['data' => $paymentDeleted]);
            return response()->json($response, $response->statusCode);
        } catch (ValidationException $e) {
            // Manejar los errores de validación...
            $response = new ErrorResponseDto(['data' => $e->errors(), 'message' => 'Validation error', 'statusCode' => Response::HTTP_BAD_REQUEST]);
            return response()->json($e->errors(), 422);
        }
    }

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
            return response()->json($e->errors(), 422);
        }
    }

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
            return response()->json($e->errors(), 422);
        }
    }

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
            return response()->json($e->errors(), 422);
        }
    }
}
