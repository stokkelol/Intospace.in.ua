#!/bin/bash

php artisan config:clear

git config core.fileMode false
git pull

composer install
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan db:seed
php artisan queue:restart
sudo supervisorctl restart all

sudo chown -R www-data:www-data ./ && sudo chmod -R 0770 ./
find ./app/ -type f -exec sudo chmod 0644 {} ";"
find ./bootstrap/ -type f -exec sudo chmod 0644 {} ";"
find ./config/ -type f -exec sudo chmod 0644 {} ";"
find ./database/ -type f -exec sudo chmod 0644 {} ";"
find ./public/ -type f -exec sudo chmod 0644 {} ";"
find ./resources/ -type f -exec sudo chmod 0644 {} ";"
find ./routes/ -type f -exec sudo chmod 0644 {} ";"
find ./tests/ -type f -exec sudo chmod 0644 {} ";"
