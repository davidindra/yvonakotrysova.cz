#!/bin/bash

echo 'Deploying...'
cd /var/www/yvonakotrysova.cz

rm -r temp/cache/*

/usr/bin/php7.0 /bin/composer install --no-dev --no-interaction 2>&1;
npm install
bower install
grunt

php7.0 www/index.php orm:schema-tool:update --force --dump-sql

echo 'Deployment finished successfully.'
