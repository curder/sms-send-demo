## Dependencies

[![GitHub Tests Action Status](https://github.com/curder/sms-send-demo/actions/workflows/run-test.yml/badge.svg)](https://github.com/curder/sms-send-demo/actions?query=run-test%3Amaster)
[![GitHub Code Style Action Status](https://github.com/curder/sms-send-demo/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/curder/sms-send-demo/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)

- php ^8.2
- [composer](https://getcomposer.org/download/) v1.10.20
- node v18.18.2
- mysql v5.7.29 Or sqlite

## Download

```bash
git clone http://github.com/curder/sms-send-demo.git
```

## Install php and node dependencies

```bash
composer install # install php dependencies

yarn # install node dependencies

yarn prod # when production
```

## `.env` file

```bash
cp .env.example .env
```

## Project key

```bash
php artisna key:generate
```

## Change database config

change your database config file `.env`, support MySQL or sqlite.

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```

## config sms service

change your sms service config file `.env`, support `aliyunintl`, `errorlog`.

```dotenv
SMS_GATEWAY=aliyunintl
ALIYUN_INTL_ACCESS_KEY_ID=your_access_key_id
ALIYUN_INTL_ACCESS_KEY_SECRET=your_access_key_secret
ALIYUN_INTL_SIGN_NAME=your_sign_name
ALIYUN_INTL_TEMPLATE_CODE=your_template_code
```

aliyun intl access key、secret、template code and sign name can get from [aliyun docs](https://www.alibabacloud.com/help/en/sms/list-of-operations-by-function).

also you can use `errorlog` gateway to test, it will log error message to `storage/logs/laravel-sms.log` file.

## Test

open your browser see `http://localhost/register`, fill your phone and click **获取验证码**, you can get a sms code from `http://localhost/verify-codes`.

also you can get a response `{message: "短信验证码发送成功，请注意查收", success: true, type: "sms_sent_success"}`

Please check the table contents of your database，you will see a record.