<?php

namespace app\modules\payment\domain\entities;

use app\modules\paymentmethod\domain\entities\PaymentMethod;
use app\modules\user\domain\entities\User;

class Payment
{
    public int $id;
    public string $customer_name;
    public string $cpf;
    public string $description;
    public float $value;
    public string $status;
    public string $payment_method;
    public string $payment_date;
    public ?User $user;
    public ?PaymentMethod $paymentMethod;
    public ?string $created_at;
    public ?string $updated_at;
    public ?string $deleted_at;

    public function __construct(Array $paymentData)
    {
        if(isset($paymentData['id'])) $this->id = $paymentData['id'];
        if(isset($paymentData['payment_id'])) $this->id = $paymentData['payment_id'];
        if(isset($paymentData['customer_name'])) $this->customer_name = $paymentData['customer_name'];
        if(isset($paymentData['cpf'])) $this->cpf = $paymentData['cpf'];
        if(isset($paymentData['description'])) $this->description = $paymentData['description'];
        if(isset($paymentData['value'])) $this->value = $paymentData['value'];
        if(isset($paymentData['status'])) $this->status = $paymentData['status'];

        if(isset($paymentData['user'])) $this->user = new User($paymentData['user']);
        if(isset($paymentData['payment_method'])) {
            $paymentMethod = $paymentData['payment_method'];
            if (is_string($paymentMethod)) {
                // El método de pago es una cadena
                $this->payment_method = $paymentMethod;
            } elseif (is_array($paymentMethod)) {
                // El método de pago es un arreglo
                $this->payment_method = $paymentMethod['slug'];
                $this->paymentMethod = new PaymentMethod($paymentData['payment_method']);
            }
        }
        if(isset($paymentData['payment_date'])) $this->payment_date = $paymentData['payment_date'];
        if(isset($paymentData['created_at'])) $this->created_at = $paymentData['created_at'];
        if(isset($paymentData['updated_at'])) $this->updated_at = $paymentData['updated_at'];
        if(isset($paymentData['deleted_at'])) $this->deleted_at = $paymentData['deleted_at'];
    }

    public function toArray() {
        return get_object_vars($this);
    }
}
