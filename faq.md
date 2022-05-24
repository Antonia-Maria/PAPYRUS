# FAQ

## Eroare 500
Repro steps:
1. Vad in browser eroare 500 dupa instalare Laravel

De verificat:
1. Ai fisierul `.env` ?

PROJECT_PATH = un aveti voi instalat laravel, ex: c:/laragon/www/laravel

Daca NU: `cd PROJECT_PATH && cp .env.example .env && php artisan key:generate`
2. Ai `APP_KEY` completata in `.env` ?

Daca NU: `cd PROJECT_PATH && php artisan key:generate`

## Eroare autoload
Warning: require(E:\laragon\www\laravel\public/../vendor/autoload.php): failed to open stream: No such file or directory in E:\laragon\www\laravel\public\index.php on line 24

Fix: ruleaza composer install in folderul laravel

##   Changing columns for table "customers" requires Doctrine DBAL. Please install the doctrine/dbal package.
To fix, check your `composer.json` and see whether you `doctrine/dbal` there.

If it's not, then run `composer require doctrine/dbal`.
If it is, you should rerun `composer install`

## Db seed
```
php artisan migrate
php artisan db:seed
php artisan migrate:fresh --seed
```
