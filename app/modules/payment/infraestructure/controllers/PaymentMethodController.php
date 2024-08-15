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
