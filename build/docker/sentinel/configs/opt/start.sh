#!/bin/sh

sed -i "s/\$SENTINEL_SERVICE_NAME/$SENTINEL_SERVICE_NAME/g" /etc/redis/sentinel.conf

exec docker-entrypoint.sh redis-server /etc/redis/sentinel.conf --sentinel
