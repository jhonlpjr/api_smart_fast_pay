<?php
namespace app\modules\paymentmethod\application\services;

use app\modules\paymentmethod\application\usecases\CreatePaymentMethodUsecase;
use app\modules\paymentmethod\application\usecases\FindPaymentMethodsUsecase;
use app\modules\paymentmethod\domain\entities\PaymentMethod;
use app\modules\paymentmethod\application\usecases\DeletePaymentMethodUsecase;
use app\modules\paymentmethod\application\usecases\FindOnePaymentMethodUsecase;

class PaymentMethodService
{
    private $createPaymentMethodUseCase;
    private $deletePaymentMethodUseCase;
    private $findOnePaymentMethodUseCase;
    private $findPaymentMethodsUseCase;

    public function __construct(
        CreatePaymentMethodUsecase $createPaymentMethodUseCase,
        DeletePaymentMethodUsecase $deletePaymentMethodUseCase,
        FindOnePaymentMethodUsecase $findOnePaymentMethodUseCase,
        FindPaymentMethodsUsecase $findPaymentMethodsUseCase,
    ) {
        $this->createPaymentMethodUseCase = $createPaymentMethodUseCase;
        $this->deletePaymentMethodUseCase = $deletePaymentMethodUseCase;
        $this->findOnePaymentMethodUseCase = $findOnePaymentMethodUseCase;
        $this->findPaymentMethodsUseCase = $findPaymentMethodsUseCase;
    }

    public function createPaymentMethod(PaymentMethod $data)
    {
        return $this->createPaymentMethodUseCase->execute($data);
    }

    public function deletePaymentMethod($id)
    {
        return $this->deletePaymentMethodUseCase->execute($id);
    }

    public function findOnePaymentMethod($id)
    {
        return $this->findOnePaymentMethodUseCase->execute($id);
    }

    public function findPaymentMethods(PaymentMethod $data)
    {
        return $this->findPaymentMethodsUseCase->execute($data);
    }
}