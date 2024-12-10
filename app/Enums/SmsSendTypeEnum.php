<?php

namespace App\Enums;

enum SmsSendTypeEnum: string
{
    case Register = 'register';
    case Login = 'login';
}
