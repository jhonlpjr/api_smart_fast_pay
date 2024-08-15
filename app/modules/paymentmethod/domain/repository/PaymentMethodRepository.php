<?php

namespace app\modules\paymentmethod\domain\repository;

use app\modules\paymentmethod\domain\entities\PaymentMethod;

interface PaymentMethodRepository
{
    public function findById(int $id);

    public function find(PaymentMethod $paymentMethod);

    public function save(PaymentMethod $paymentMethod);

    public function delete(int $id);
}