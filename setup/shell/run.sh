#!/bin/bash

cd /var/www/localhost

echo "start run.sh - env=$APP_ENV"

# APP_ENV解析
if [[ $APP_ENV =~ ^(production|dev|local)_(web|api)_([a-z_]+)$ ]]; then
    SERVER_ENVIROMENT=${BASH_REMATCH[1]}
    SERVER_TYPE=${BASH_REMATCH[2]}
    SERVER_SEGMENT=${BASH_REMATCH[3]}
elif [[ $APP_ENV =~ ^(production|dev|local)_(task)$ ]]; then
    SERVER_ENVIROMENT=${BASH_REMATCH[1]}
    SERVER_TYPE=${BASH_REMATCH[2]}
    SERVER_SEGMENT=
else
    SERVER_ENVIROMENT=
    SERVER_TYPE=
    SERVER_SEGMENT=
    echo "unknown env - ${APP_ENV}"
fi

# clear
PHP_OPT="-d xdebug.remote_autostart=0 -d xdebug.default_enable=0 -d xdebug.remote_enable=0"
php $PHP_OPT artisan --env=$APP_ENV config:clear
php $PHP_OPT artisan --env=$APP_ENV route:clear
php $PHP_OPT artisan --env=$APP_ENV view:clear
php $PHP_OPT artisan --env=$APP_ENV clear-compiled

# gen
php $PHP_OPT /usr/local/bin/composer dump-autoload

# 環境毎に処理分け
if [[ $SERVER_ENVIROMENT =~ ^(production|dev)$ ]]; then
    # config/route cache
    php $PHP_OPT artisan --env=$APP_ENV config:cache
    php $PHP_OPT artisan --env=$APP_ENV route:cache
else
    echo "excute migration."
    if [ "${SERVER_TYPE}" = "api" ]; then
        # DB起動待ち(最大60秒)
        ./setup/db_check.sh
        if [ $? = 0 ]; then
            echo -n "migrate... "
            php $PHP_OPT artisan --env=$APP_ENV migrate --force
            echo "done"
        else
            echo "db connected check timeout"
        fi
    fi
fi

service nginx start
docker-php-entrypoint php-fpm
