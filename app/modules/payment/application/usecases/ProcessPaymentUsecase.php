<?php

namespace app\modules\payment\application\usecases;

use app\modules\payment\domain\entities\Payment;
use app\modules\payment\domain\entities\ProcessPayment;
use app\modules\payment\domain\repository\PaymentRepository;
use app\modules\user\domain\repository\UserRepository;
use app\shared\containers\GenericContainer;
use app\shared\utils\enums\PaymentStatusEnum;
use app\shared\utils\enums\ProcessStatusEnum;


class ProcessPaymentUsecase
{
    private PaymentRepository $paymentRepository;
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->paymentRepository = GenericContainer::getDependency(__DIR__,  'PaymentContainer.php', PaymentRepository::class);
        $this->userRepository = GenericContainer::getDependency(__DIR__,  'UserContainer.php', UserRepository::class, '\..\..\..\user');
    }

    public function execute(Payment $payment)
    {
        try {
            $paymentData = $this->paymentRepository->findById($payment->id);
            if (!$paymentData) {
                return ['status' => ProcessStatusEnum::Failure->value, 'message' => 'Payment not found'];
            }
            $payment = new Payment($paymentData->toArray());
            $processPayment = new ProcessPayment($payment);
            $processResult = $processPayment->process();
            if ($processResult['status'] === ProcessStatusEnum::Success->value) {
                $user = $payment->user;
                $commission = $payment->paymentMethod->commission;
                $newbalance = $commission > 0 ?  $payment->value * (1-$commission) : $payment->value;
                $user->balance += $newbalance;
                $payment->status = PaymentStatusEnum::Payed->value;
                $payment->updated_at = date('Y-m-d H:i:s');
                $this->paymentRepository->update($payment->id, $payment);
                $this->userRepository->update($user->id, $user);
            } else {
                if($payment->status != PaymentStatusEnum::Payed->value) $payment->status = PaymentStatusEnum::Failed->value;
                $payment->updated_at = date('Y-m-d H:i:s');
                $this->paymentRepository->update($payment->id, $payment);
            }
            return $processResult;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}
