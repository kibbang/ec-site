#!/bin/bash

# 設定ファイル読み込み
. .env.${APP_ENV}
echo ${DB_HOST}

if [ "${DB_HOST}" = "" ]
then
    exit 1
fi

echo -n "DB connected check[${DB_HOST}]:"

for i in `seq 0 120`
do
    mysqladmin ping -h${DB_HOST} -p${DB_USERNAME} -u${DB_PASSWORD} >/dev/null 2>&1
    if [ $? = 0 ]
    then
        echo "OK"
        exit 0
    fi
    echo -n "."
    sleep 1
done
echo "NG"
exit 1
