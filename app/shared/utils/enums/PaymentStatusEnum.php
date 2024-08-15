<?php
namespace app\shared\utils\enums;

enum PaymentStatusEnum: string {
    case Pending = 'pending';
    case Payed = 'payed';
    case Due = 'due';
    case Failed = 'failed';
}