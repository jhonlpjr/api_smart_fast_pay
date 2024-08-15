<?php

namespace app\modules\paymentmethod\infraestructure\database\repositories;

use app\modules\paymentmethod\domain\entities\PaymentMethod;
use app\modules\paymentmethod\domain\repository\PaymentMethodRepository;
use app\modules\paymentmethod\infraestructure\database\models\PaymentMethodModel;


class PaymentMethodMysqlRepository implements PaymentMethodRepository {

    public function findById(int $id): ?PaymentMethodModel {
        return PaymentMethodModel::find($id);
    }

    public function find(PaymentMethod $paymentMethod): ?PaymentMethodModel {
        return PaymentMethodModel::find($paymentMethod);
    }
    public function save(PaymentMethod $paymentMethodr) {
        $paymentMethodModel = new PaymentMethodModel($paymentMethodr->toArray());
        $paymentMethodModel->save();
        return $paymentMethodModel;
    }

    public function delete(int $id) {
        return PaymentMethodModel::destroy([$id]);
    }

}