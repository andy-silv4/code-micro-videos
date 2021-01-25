#!/bin/bash

chown -R www-data:www-data .

dockerize -template ./.docker/app/.env.tmpl:.env -wait tcp://db:3306 -timeout 40s 
dockerize -template ./.docker/app/.env.test.tmpl:.env.testing 

composer install
php artisan key:generate
php artisan migrate

php-fpm
