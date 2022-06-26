<h1 align="center">
    DEVELOP NOW
</h1>

## Laravel packages

- Laravel Framework 8.6.12

## Server requirements

- PHP 7.4.19
- MySQL 5.7.33

## Setup at localhost

- composer install
- copy .env.example to .env and setup local database info
- php artisan key:generate
- php artisan optimize
- php artisan migrate

## Refactor code and Logic Test

Please run the following routes after run `php artisan serve` in your command prompt:

- Refactor code: http://<host_name>/refactor-code
- Logic test: http://<host_name>/refactor-code

## Laravel Test

- composer test
