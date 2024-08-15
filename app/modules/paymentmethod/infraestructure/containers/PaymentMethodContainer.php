<?php

use app\modules\paymentmethod\domain\repository\PaymentMethodRepository;
use app\modules\paymentmethod\infraestructure\database\repositories\PaymentMethodMysqlRepository;

return [
    PaymentMethodRepository::class => DI\autowire(PaymentMethodMysqlRepository::class),
];