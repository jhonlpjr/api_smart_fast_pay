<?php

namespace app\modules\payment\application\dtos\request;

use app\modules\payment\domain\entities\Payment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreatePaymentRequestDto extends Payment
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
            'customer_name' => 'required|string|max:255',
            'cpf' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'value' => 'required|numeric',
            'status' => 'nullable|string|max:50',
            'payment_method' => 'required|string|max:50',
            'payment_date' => 'required|date_format:Y-m-d',
        ];
    }

    public function messages()
    {
        return [
            'customer_name.required' => 'Customer name is required.',
            'customer_name.string' => 'Customer name must be string.',
            'customer_name.max' => 'Customer name cannot be longer than 255 characters.',
            'cpf.required' => 'Cpf is required.',
            'cpf.string' => 'Cpf must be string.',
            'cpf.max' => 'Cpf cannot be longer than 255 characters.',
            'description.required' => 'Description name is required.',
            'description.string' => 'Description name must be string.',
            'description.max' => 'Description name cannot be longer than 255 characters.',
            'value.required' => 'Value is required.',
            'value.numeric' => 'Value must be a number.',
            'status.string' => 'Status must be string.',
            'status.max' => 'Status cannot be longer than 50 characters.',
            'payment_method.required' => 'Payment method is required.',
            'payment_method.date_format' => 'Payment method must be a date: YYYY-mm-dd.',
        ];
    }
}
