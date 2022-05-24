# Classwork

## Creaza schema
Database window > right click pe conexiunea @localhost > New > Schema
`create schema laravel;`

## Ruleaza migratiile
Terminal > `php artisan migrate`

> Verifica daca ai acces la noile tabele.

Poate ai nevoie de `php artisan migrate:rollback`

## Creaza migratiile pentru customers si payments
* Check [column types](https://laravel.com/docs/9.x/migrations#available-column-types)
