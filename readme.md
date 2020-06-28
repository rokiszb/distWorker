# Distributed worker

This app is a distributed worker that uses a database table. The worker requests each URL inside the table and stores the resulting response code.

SQLite used as a database. Project runs on Symfony 5.1 version.
To speed up app creation process symfony make:bundle was utilized to create some boilerplate entities, database fixtures, controllers and Job entity CRUD.

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

## Usage

To run app hit /start_jobs url. This will initiate processing of all created jobs. You can either run fixtures so seed database or add manually via /job/new.
/start_jobs returns json status:ok after successful run, to view jobs status go to /job/ url where table displays all jobs statuses.

## Routes
| Description | Route |
| ------ | ------ |
| Start processing urls | [/start_jobs] |
| GUI to see jobs statuses | [/job/{new,edit,create}] |