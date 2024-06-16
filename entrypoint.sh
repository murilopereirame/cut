#!/bin/bash

npm install
composer update

npm run dev &
php artisan serve --host 0.0.0.0
