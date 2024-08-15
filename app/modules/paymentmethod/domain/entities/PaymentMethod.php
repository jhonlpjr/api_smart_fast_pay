<?php

namespace app\modules\paymentmethod\domain\entities;

class PaymentMethod
{
    public int $id;
    public string $name;
    public string $slug;
    public ?string $created_at;
    public ?string $updated_at;
    public ?string $deleted_at;

    public function __construct(Array $paymentMethodData)
    {
        if(isset($paymentMethodData['id'])) $this->id = $paymentMethodData['id'];
        $this->name = $paymentMethodData['name'] ?? '';
        $this->slug = $paymentMethodData['slug'] ?? '';
        $this->created_at = $paymentMethodData['created_at'] ?? null;
        $this->updated_at = $paymentMethodData['updated_at'] ?? null;
        $this->deleted_at = $paymentMethodData['deleted_at'] ?? null;
    }

    public function toArray() {
        return get_object_vars($this);
    }
}
