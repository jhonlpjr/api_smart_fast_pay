<?php

namespace app\modules\payment\application\dtos\request;

use app\modules\payment\domain\entities\Payment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreatePaymentRequestDto extends Payment
{
    private array $receivedRequest;
    private PaymentMethodValidator $validator;

    public function __construct(array $receivedRequest)
    {
        parent::__construct($receivedRequest);
        $this->receivedRequest = $receivedRequest;
        $this->validator = new PaymentMethodValidator();
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
            'value' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'payment_method' => 'required|string|max:255',
            'payment_date' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Payment method name is required.',
            'name.string' => 'Payment method name must be string.',
            'name.max' => 'Payment method name cannot be longer than 255 characters.',
            'slug.required' => 'Slug is required.',
            'slug.string' => 'Slug must be string.',
            'slug.max' => 'Slug cannot be longer than 255 characters.',
        ];
    }
}
