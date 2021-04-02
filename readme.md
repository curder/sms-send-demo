## Dependencies

- php ^7.1.3
- [composer](https://getcomposer.org/download/) v1.10.8
- node v10.16.3
- mysql v5.7.29

## Download

```bash
git clone http://github.com/curder/sms-send-demo.git
```

## php and node dependencies

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

## project key

```bash
php artisna key:generate
```

## change database config

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

And you can get a response `{message: "短信验证码发送成功，请注意查收", success: true, type: "sms_sent_success"}`

Please check the table contents of your database，you will see a record.
