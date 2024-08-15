<?php

namespace app\modules\payment\application\dtos\request;

use app\modules\payment\domain\entities\Payment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class FindPaymentRequestDto extends Payment
{
    private array $receivedRequest;
    private PaymentValidator $validator;

    public function __construct(array $receivedRequest)
    {
        parent::__construct($receivedRequest);
        $this->receivedRequest = $receivedRequest;
        $this->validator = new PaymentValidator();
        $this->validate();
    }

    private function validate()
    {
        $validator = Validator::make($this->receivedRequest, $this->validator->rules(), $this->validator->messages());

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}

class PaymentValidator extends FormRequest
{
    public function authorize()
    {
        // Aquí puedes agregar lógica para autorizar la solicitud
        return true;
    }

    public function rules()
    {
        return [
            'customer_name' => 'nullable|string|max:255',
            'cpf' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'value' => 'nullable|numeric',
            'status' => 'nullable|string|max:50',
            'payment_method' => 'nullable|string|max:50',
            'payment_date' => 'nullable|date_format:Y-m-d',
        ];
    }

    public function messages()
    {
        return [
            'customer_name.string' => 'Customer name must be string.',
            'customer_name.max' => 'Customer name cannot be longer than 255 characters.',
            'cpf.string' => 'Cpf must be string.',
            'cpf.max' => 'Cpf cannot be longer than 255 characters.',
            'description.string' => 'Description name must be string.',
            'description.max' => 'Description name cannot be longer than 255 characters.',
            'value.numeric' => 'Value must be a number.',
            'status.string' => 'Status must be string.',
            'status.max' => 'Status cannot be longer than 50 characters.',
            'payment_method.date_format' => 'Payment method must be a date: YYYY-mm-dd.',
        ];
    }
}
