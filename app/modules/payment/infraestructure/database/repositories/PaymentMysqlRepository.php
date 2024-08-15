<?php

namespace app\modules\payment\infraestructure\database\repositories;

use app\modules\payment\domain\entities\Payment;
use app\modules\payment\infraestructure\database\models\PaymentModel;
use app\modules\payment\domain\repository\PaymentRepository;


class PaymentMysqlRepository implements PaymentRepository {

    public function findById(int $id): ?PaymentModel {
        return PaymentModel::with(['user', 'paymentMethod'])->find($id);
    }

    public function find(Payment $payment) {
        // echo 'echooo>>'.json_encode($payment);
        $paymensData = PaymentModel::where($payment->toArray())->get();
        // echo 'echooo querrryyy sql>>'.json_encode($paymensData);
        return $paymensData;
    }

    public function save(Payment $payment) {
        $paymentModel = new PaymentModel($payment->toArray());
        $paymentModel->save();
        return $paymentModel;
    }

    public function update(int $id, Payment $payment) {
        $paymentModel = PaymentModel::find($id);
        $paymentModel->fill($payment->toArray());
        $paymentModel->save();
        return $paymentModel;
    }

    public function delete(int $id) {
        return PaymentModel::destroy([$id]);
    }

}