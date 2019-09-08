Install dependency

composer install

Setup Database

php bin/console doctrine:schema:create

php bin/console doctrine:fixtures:load

Run Server

php bin/console server:start

php bin/console server:run

Run Test

php bin/phpunit
