<?php

namespace app\modules\payment\domain\repository;

use app\modules\payment\domain\entities\Payment;

interface PaymentRepository
{
    public function findById(int $id);

    public function find(Payment $payment);

    public function save(Payment $payment);

    public function update(int $id, Payment $payment);

    public function delete(int $id);
}