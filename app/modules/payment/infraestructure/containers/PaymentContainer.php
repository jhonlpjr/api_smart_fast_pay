<?php

use app\modules\payment\infraestructure\database\repositories\PaymentMysqlRepository;
use app\modules\payment\domain\repository\PaymentRepository;

return [
    PaymentRepository::class => DI\autowire(PaymentMysqlRepository::class),
];