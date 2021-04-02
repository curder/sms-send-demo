## Dependencies

[![GitHub Tests Action Status](https://github.com/curder/sms-send-demo/actions/workflows/run-test.yml/badge.svg)](https://github.com/curder/sms-send-demo/actions?query=run-test%3Amaster)
[![GitHub Code Style Action Status](https://github.com/curder/sms-send-demo/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/curder/sms-send-demo/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)

- php ^7.2
- [composer](https://getcomposer.org/download/) v1.10.20
- node v12.21.0
- mysql v5.7.29 Or sqlite

## Download

```bash
git clone http://github.com/curder/sms-send-demo.git
```

## Install php and node dependencies

```bash
composer install # install php dependencies

yarn # install node dependencies

yarn dev # when developer
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

## Test

open your browser see `http://localhost/sms`, fill your phone and click **get sms**.

You can get a response `{message: "短信验证码发送成功，请注意查收", success: true, type: "sms_sent_success"}`

Please check the table contents of your database，you will see a record.
