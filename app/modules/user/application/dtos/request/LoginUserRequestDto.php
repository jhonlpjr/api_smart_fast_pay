<?php

namespace app\modules\user\application\dtos\request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LoginUserRequestDto
{
    private array $receivedRequest;
    private LoginUserValidator $validator;

    public string $username;
    public string $password;

    public function __construct(array $receivedRequest)
    {
        $this->receivedRequest = $receivedRequest;
        $this->validator = new LoginUserValidator();
        $this->validate();
        $this->username = $receivedRequest['username'];
        $this->password = $receivedRequest['password'];
    }

    private function validate()
    {
        $validator = Validator::make($this->receivedRequest, $this->validator->rules(), $this->validator->messages());

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}

class LoginUserValidator extends FormRequest
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
            'password' => 'required|string|min:8',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Username is required.',
            'username.string' => 'Username must be string.',
            'username.max' => 'Username cannot be longer than 255 characters.',
            'password.required' => 'Password is required.',
            'password.string' => 'Password must be string.',
            'password.min' => 'Password must be at least 8 characters.',
        ];
    }
}
