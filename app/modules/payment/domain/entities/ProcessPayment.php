<?php

namespace app\modules\payment\domain\entities;

use app\shared\utils\enums\PaymentStatusEnum;
use app\shared\utils\enums\ProcessStatusEnum;

class ProcessPayment
{
    public Payment $payment;

    public function __construct(Payment $paymentData)
    {
        $this->payment = $paymentData;
    }

    public function process() {
    // Generar un número aleatorio entre 0 y 99
    $randomNumber = rand(0, 99);

    if($this->payment->status === PaymentStatusEnum::Payed->value) {
        return [
            'status' => ProcessStatusEnum::Failure->value,
            'message' => 'Payment already processed.'
        ];
    }   

    // Determinar el resultado basado en el número aleatorio
    if ($randomNumber < 70) {
        // Éxito con 70% de probabilidad
        return [
            'status' => ProcessStatusEnum::Success->value,
            'message' => 'Payment processed successfully.'
        ];
    } else {
        // Fallo con 30% de probabilidad
        return [
            'status' => ProcessStatusEnum::Failure->value,
            'message' => 'Payment processing failed.'
        ];
    }
    } 

    public function toArray() {
        return get_object_vars($this);
    }
}
