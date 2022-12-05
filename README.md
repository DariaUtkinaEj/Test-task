[Latest Stable Version](https://packagist.org/packages/yiisoft/yii2-app-advanced)

Project description
-------------------
This project consists of three parts:
* console — has auth method and create user methods in it. Usage (from app root dir): auth — `php yii user/auth username password`; create — `php yii user/create login password`;
* frontend — has single endpoint: `/site/create`. It expects to be given some json object and stores it into DB. This methed also expects to be given `Authorization` header with token produced by console auth as it's value.
* backend — has single page, on which results of requests to frontend are shown. It displays hierarchy of objects saved during each request, and some additional data. You can delete and modify value of each object here.

Project installation
--------------------
1. Clone this repo.
2. Run `composer install`.
3. Run `php init` (you can choose dev or prod env here).
4. Create new database (I was using MySql 5.5).
5. Specify DB connection data in `common/config/main-local.php` like this:
```
    'db' => [
        'class' => \yii\db\Connection::class,
        'dsn' => 'mysql:host=localhost;dbname=test-task',
        'username' => 'root',
        'password' => 'root',
        'charset' => 'utf8',
    ]
```
6. You need to deploy app locally.
7. Run migration tool to create tables in DB: `php yii migrate/up`.
8. Create new user as it's explained in project description above.
9. From now on you can log in from console and use outputted auth key to call frontend method. Result can be seen on backend.