#!/bin/sh

cd "$(dirname "$0")"

# Move assets for elfinder and grant 777 permissions
mv /var/www/public/bundles/fmelfinder /var/www/public/assets/bundles
chmod 777 -R /var/www/public/assets/bundles/fmelfinder

# hostname resolve
VAR_SERVER_NAME=$(cat /etc/hostname)
echo "127.0.0.1 localhost.localdomain $VAR_SERVER_NAME" >> /etc/hosts

# send project vars to nginx
mkdir -p /etc/nginx/vars
echo "set \$NGINX_ENVIRONMENT      $ENVIRONMENT;"      > /etc/nginx/vars/app.conf

sh /opt/start.sh
