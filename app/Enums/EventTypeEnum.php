<?php

namespace App\Enums;

enum EventTypeEnum: string
{
    case SmsSendFailed = 'sms-send-failed';
    case SmsSendSuccess = 'sms-send-success';
    case PhoneUpdated = 'phone-updated';
}
