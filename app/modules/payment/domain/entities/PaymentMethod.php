<?php

namespace app\modules\payment\domain\entities;

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
    public ?string $created_at;
    public ?string $updated_at;
    public ?string $deleted_at;

    public function __construct(Array $paymentData)
    {
        if(isset($paymentData['id'])) $this->id = $paymentData['id'];
        $this->customer_name = $paymentData['customer_name'] ?? '';
        $this->cpf = $paymentData['cpf'] ?? '';
        $this->description = $paymentData['description'] ?? '';
        $this->value = $paymentData['value'] ?? '';
        $this->status = $paymentData['status'] ?? '';
        $this->payment_method = $paymentData['payment_method'] ?? '';
        $this->payment_date = $paymentData['payment_date'] ?? '';
        $this->created_at = $paymentData['created_at'] ?? null;
        $this->updated_at = $paymentData['updated_at'] ?? null;
        $this->deleted_at = $paymentData['deleted_at'] ?? null;
    }

    public function toArray() {
        return get_object_vars($this);
    }
}
