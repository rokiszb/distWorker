## 1. First steps to setup project, create and run migrations and fixtures to seed database with some test data.

1.1. php bin/console doctrine:database:create 

1.2. php bin/console make:migration 

1.3. php bin/console doctrine:migrations:migrate

1.4. php bin/console doctrine:fixtures:load

## 2. To start server type 'symfony server:start' (if you have symfony cli installed), or 'php -S localhost:8000 -t public' to start php server