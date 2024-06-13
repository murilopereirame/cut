#!/bin/bash

npm install
composer update

npm run dev &
php spark serve --host 0.0.0.0 --port 8000
