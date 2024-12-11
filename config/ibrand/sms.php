<?php

/*
 * This file is part of ibrand/laravel-sms.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [
    'route' => [
        'prefix' => 'sms',
        'middleware' => ['web'],
    ],

    'easy_sms' => [
        'timeout' => 5.0,

        // 默认发送配置
        'default' => [
            // 网关调用策略，默认：顺序调用
            'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

            // 默认可用的发送网关
            'gateways' => explode(',', env('SMS_GATEWAY', 'errorlog')),
        ],

        // 可用的网关配置
        'gateways' => [
            'errorlog' => [
                'file' => storage_path('logs/laravel-sms.log'),
            ],

            'yunpian' => [
                'api_key' => '824f0ff2f71cab52936axxxxxxxxxx',
            ],

            'aliyun' => [
                'access_key_id' => 'xxxx',
                'access_key_secret' => 'xxxx',
                'sign_name' => '阿里云短信测试专用',
                'code_template_id' => 'SMS_802xxx',
            ],

            'aliyunIntl' => [
                'access_key_id' => env('ALIYUN_INTL_ACCESS_KEY_ID'),
                'access_key_secret' => env('ALIYUN_INTL_ACCESS_KEY_SECRET'),
                'sign_name' => env('ALIYUN_INTL_SIGN_NAME'),
            ],

            'alidayu' => [
                //...
            ],
        ],
    ],

    'code' => [
        'length' => 6,
        'validMinutes' => 5,
        'maxAttempts' => 3,
    ],

    'data' => [
        'product' => '',
    ],

    'dblog' => true,


    'content' => '【signature】感谢您的申请，您的动态验证码%s，请在%s分钟内输入。',

    'storage' => \iBrand\Sms\Storage\CacheStorage::class,
];
