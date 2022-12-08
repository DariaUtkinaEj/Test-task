
Project description
-------------------
This project consists of three parts:
* console — has auth method and create user methods in it. Usage (from app root dir): auth — `php yii user/auth username password`; create — `php yii user/create login password`;
* frontend — has single endpoint: `/site/create`. It expects to be given some json object and stores it into DB. This method also expects to be given `Authorization` header with token produced by console auth as it's value.
* backend — has single page, on which results of requests to frontend are shown. It displays hierarchy of objects saved during each request, and some additional data. You can delete and modify value of each object here.

Project installation
--------------------
1. Clone this repo.
2. Run `composer install`.
3. Run `php init` (you can choose dev or prod env here).
4. Create new database (I use MySql 5.5).
5. Set DB connection data in `common/config/main-local.php` like this:
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

#### Run tests

1. Set the test database connection (name of your main DB + postfix _test): `'dsn' => 'mysql:host=localhost;dbname=test-task_test'` in `common/config/test-local.php`.
2. Create DB.
3. Execute: `php yii_test migrate/up`.
4. Build the test suite: `./vendor/bin/codecept build`.
5. For running all tests: `./vendor/bin/codecept run`, for one part of app (e.g. common): `vendor/bin/codecept run -- -c common`.

#### Nginx example configuration:
```
server {
        charset utf-8;
        client_max_body_size 128M;

        listen 80; ## listen for ipv4
        #listen [::]:80 default_server ipv6only=on; ## listen for ipv6

        server_name frontend.test;
        root        /path/to/yii-application/frontend/web/;
        index       index.php;

        access_log  /path/to/yii-application/log/frontend-access.log;
        error_log   /path/to/yii-application/log/frontend-error.log;

        location / {
            # Redirect everything that isn't a real file to index.php
            try_files $uri $uri/ /index.php$is_args$args;
        }

        # uncomment to avoid processing of calls to non-existing static files by Yii
        #location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
        #    try_files $uri =404;
        #}
        #error_page 404 /404.html;

        # deny accessing php files for the /assets directory
        location ~ ^/assets/.*\.php$ {
            deny all;
        }

        location ~ \.php$ {
            include fastcgi_params;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            fastcgi_pass 127.0.0.1:9000;
            #fastcgi_pass unix:/var/run/php5-fpm.sock;
            try_files $uri =404;
        }
    
        location ~* /\. {
            deny all;
        }
    }
     
    server {
        charset utf-8;
        client_max_body_size 128M;
    
        listen 80; ## listen for ipv4
        #listen [::]:80 default_server ipv6only=on; ## listen for ipv6
    
        server_name backend.test;
        root        /path/to/yii-application/backend/web/;
        index       index.php;
    
        access_log  /path/to/yii-application/log/backend-access.log;
        error_log   /path/to/yii-application/log/backend-error.log;
    
        location / {
            # Redirect everything that isn't a real file to index.php
            try_files $uri $uri/ /index.php$is_args$args;
        }
    
        # uncomment to avoid processing of calls to non-existing static files by Yii
        #location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
        #    try_files $uri =404;
        #}
        #error_page 404 /404.html;

        # deny accessing php files for the /assets directory
        location ~ ^/assets/.*\.php$ {
            deny all;
        }

        location ~ \.php$ {
            include fastcgi_params;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            fastcgi_pass 127.0.0.1:9000;
            #fastcgi_pass unix:/var/run/php5-fpm.sock;
            try_files $uri =404;
        }
    
        location ~* /\. {
            deny all;
        }
    }
```
#### Test-task report in the 'Отчет по тестовому.docx' file.
