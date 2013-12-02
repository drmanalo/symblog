#!/bin/sh

sudo chmod -R 777 app/cache
sudo chmod -R 777 app/logs

php app/console cache:clear --env=prod
php app/console cache:clear --env=dev

sudo chmod -R 777 app/cache
sudo chmod -R 777 app/logs
