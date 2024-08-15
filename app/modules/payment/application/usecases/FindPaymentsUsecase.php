<?php

namespace app\modules\payment\application\usecases;

use app\modules\payment\domain\entities\Payment;
use app\modules\payment\domain\repository\PaymentRepository;
use DI\ContainerBuilder;

class FindPaymentsUsecase
{
    private PaymentRepository $paymentRepository;

    public function __construct()
    {
        $containerBuilder = new ContainerBuilder();

        $containerBuilder->addDefinitions(require __DIR__ . '\..\..\infraestructure\containers\PaymentContainer.php');
        $container = $containerBuilder->build();

        $this->paymentRepository = $container->get(PaymentRepository::class);
    }

    public function execute(Payment $paymentData)
    {
        try {
            return  $this->paymentRepository->find($paymentData);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}