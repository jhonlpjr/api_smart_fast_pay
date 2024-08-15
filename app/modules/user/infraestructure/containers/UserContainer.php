<?php

use app\modules\user\application\usecases\LoginUserUsecase;
use app\modules\user\domain\repository\UserRepository;
use app\modules\user\infraestructure\database\repositories\UserMysqlRepository;

return [
    UserRepository::class => DI\autowire(UserMysqlRepository::class),
];