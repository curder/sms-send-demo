<?php

namespace App\Enums;

use Overtrue\EasySms\Support\Config;

enum SmsSendTypeEnum: string
{
    case Register = 'register';
    case Login = 'login';


    public function template(): string
    {
        return match ($this) {
            self::Register => 'SMS_11010029', // 感谢您的申请，您的动态验证码${code}，请在5分钟内输入。
            self::Login => 'SMS_11015044', // 验证码${code}，您正在登录，若非本人操作，请勿泄露。
        };
    }

    public function data(): array
    {
        return [
            'template' => $this->template(),
        ];
    }

    public function gateways(): array
    {
        return app()->isProduction()
            ? ['aliyunIntl' => new Config(config('ibrand.sms.easy_sms.gateways.aliyunIntl')),]
            : ['errorlog' => []];
    }
}
