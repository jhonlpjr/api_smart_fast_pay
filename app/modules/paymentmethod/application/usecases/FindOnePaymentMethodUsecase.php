<?php

namespace app\modules\paymentmethod\application\usecases;

use app\modules\paymentmethod\domain\repository\PaymentMethodRepository;
use DI\ContainerBuilder;

class FindOnePaymentMethodUsecase
{
    private PaymentMethodRepository $paymentMethodRepository;

    public function __construct()
    {
        $containerBuilder = new ContainerBuilder();

        $containerBuilder->addDefinitions(require __DIR__ . '\..\..\infraestructure\containers\PaymentMethodContainer.php');
        $container = $containerBuilder->build();
        $this->paymentMethodRepository = $container->get(PaymentMethodRepository::class);
    }

    public function execute(int $id)
    {
        try {
            return $this->paymentMethodRepository->findById($id);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
