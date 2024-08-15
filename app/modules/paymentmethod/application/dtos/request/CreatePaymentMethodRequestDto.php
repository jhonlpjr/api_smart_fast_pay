<?php

namespace app\modules\paymentmethod\application\dtos\request;

use app\modules\paymentmethod\domain\entities\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreatePaymentMethodRequestDto extends PaymentMethod
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

class PaymentMethodValidator extends FormRequest
{
    public function authorize()
    {
        // Aquí puedes agregar lógica para autorizar la solicitud
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
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
