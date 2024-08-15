<?php

namespace app\modules\payment\application\dtos\request;

use app\modules\payment\domain\entities\Payment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProcessPaymentRequestDto extends Payment
{
    private array $receivedRequest;
    private ProcessPaymentValidator $validator;

    public function __construct(array $receivedRequest)
    {
        parent::__construct($receivedRequest);
        $this->receivedRequest = $receivedRequest;
        $this->validator = new ProcessPaymentValidator();
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

class ProcessPaymentValidator extends FormRequest
{
    public function authorize()
    {
        // Aquí puedes agregar lógica para autorizar la solicitud
        return true;
    }

    public function rules()
    {
        return [
            'payment_id' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'payment_id.required' => 'Payment ID is required.',
            'payment_id.numeric' => 'Payment ID must be a number.',
        ];
    }
}
