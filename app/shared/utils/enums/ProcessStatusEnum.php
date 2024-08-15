<?php
namespace app\shared\utils\enums;

enum ProcessStatusEnum: string {
    case Success = 'success';
    case Failure = 'failure';
}