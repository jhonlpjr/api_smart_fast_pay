<?php

namespace app\modules\user\application\dtos\request;

use app\modules\user\domain\entities\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreateUserRequestDto extends User
{
    private array $receivedRequest;
    private CreateUserValidator $validator;

    public function __construct(array $receivedRequest) {
        parent::__construct($receivedRequest);
        $this->receivedRequest = $receivedRequest;
        $this->validator = new CreateUserValidator();
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

class CreateUserValidator extends FormRequest
{
    public function authorize()
    {
        // Aquí puedes agregar lógica para autorizar la solicitud
        return true;
    }

    public function rules()
    {
        return [
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'names' => 'nulleable|string|max:255',
            'lastnames' => 'nulleable|string|max:255',
            'password' => 'required|string|min:8',
            'identity_document' => 'required|string|min:8|max:20',
            'balance' => 'nulleable|numeric',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Username is required.',
            'username.string' => 'Username must be string.',
            'username.max' => 'Username cannot be longer than 255 characters.',
            'names.string' => 'Usernames must be string.',
            'names.max' => 'Usernames cannot be longer than 255 characters.',
            'lastnames.string' => 'Usernames must be string.',
            'lastnames.max' => 'Usernames cannot be longer than 255 characters.',
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid address.',
            'email.max' => 'Email cannot be longer than 255 characters.',
            'password.required' => 'The password is required.',
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least 8 characters long.',
            'identity_document.required' => 'Identity Document is required.',
            'identity_document.string' => 'Identity Document must be string.',
            'identity_document.minx' => 'Identity Document cannot be shorter than 8 characters.',
            'identity_document.max' => 'Identity Document cannot be longer than 20 characters.',
            'balance.numeric' => 'Balance must be a number.',
        ];
    }
}