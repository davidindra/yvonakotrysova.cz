#!/bin/bash

echo 'Deploying...'
cd /var/www/yvonakotrysova.cz

rm -r temp/cache/*

alias php=php7.0

composer install --no-dev --no-interaction 2>&1;
npm install
bower install
grunt

php www/index.php orm:schema-tool:update --force

echo 'Deployment finished successfully.'
