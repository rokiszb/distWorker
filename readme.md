# Distributed worker

This app is a distributed worker that uses a database table. The worker requests each URL inside the table and stores the resulting response code.

SQLite used as a database. Project runs on Symfony 5.1 version.

## Instalation

Use command line to run required commands. Create database, run migrations and fixtures to seed database with some test data.
```sh
$ php bin/console doctrine:database:create 
$ php bin/console make:migration 
$ php bin/console doctrine:migrations:migrate
$ php bin/console doctrine:fixtures:load
```

To run app you can start php server 
```sh
$ php -S localhost:8000 -t public
```

Or symfony server if you have symfony cli installed.
```sh
$ symfony server:start
```
## Routes
| Description | Route |
| ------ | ------ |
| Start proccessing urls | [/start_jobs] |
| GUI to see jobs statuses | [/job/{new,edit,create}] |