<?php
namespace app\modules\payment\application\services;

use app\modules\payment\application\usecases\CreatePaymentUsecase;
use app\modules\payment\application\usecases\DeletePaymentUsecase;
use app\modules\payment\application\usecases\FindOnePaymentUsecase;
use app\modules\payment\application\usecases\FindPaymentsUsecase;
use app\modules\payment\application\usecases\ProcessPaymentUsecase;
use app\modules\payment\domain\entities\Payment;

class PaymentService
{
    private $createPaymentUseCase;
    private $deletePaymentUseCase;
    private $findOnePaymentUseCase;
    private $findPaymentsUseCase;
    private $processPaymentsUseCase;

    public function __construct(
        CreatePaymentUsecase $createPaymentUseCase,
        DeletePaymentUsecase $deletePaymentUseCase,
        FindOnePaymentUsecase $findOnePaymentUseCase,
        FindPaymentsUsecase $findPaymentsUseCase,
        ProcessPaymentUsecase $processPaymentsUseCase,
    ) {
        $this->createPaymentUseCase = $createPaymentUseCase;
        $this->deletePaymentUseCase = $deletePaymentUseCase;
        $this->findOnePaymentUseCase = $findOnePaymentUseCase;
        $this->findPaymentsUseCase = $findPaymentsUseCase;
        $this->processPaymentsUseCase = $processPaymentsUseCase;
    }

    public function createPayment(Payment $data)
    {
        return $this->createPaymentUseCase->execute($data);
    }

    public function deletePayment($id)
    {
        return $this->deletePaymentUseCase->execute($id);
    }

    public function findOnePayment($id)
    {
        return $this->findOnePaymentUseCase->execute($id);
    }

    public function findPayments(Payment $data)
    {
        return $this->findPaymentsUseCase->execute($data);
    }

    public function processPayment($id)
    {
        return $this->processPaymentsUseCase->execute($id);
    }
}