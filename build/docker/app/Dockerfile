FROM nexus.action-media.ru/docker-action-base/base-service-php74:latest as local

# устанавливаем переменные окружения
ENV PHP_DISPLAY_ERRORS 0
ENV PHP_LOG_ERRORS 0
ENV PHP_ERROR_REPORTING 22527
ENV PHP_MEMORY_LIMIT 256M
ENV PHP_OPCACHE_VALIDATE_TIMESTAMPS 0

WORKDIR /var/www/

# setup
RUN yum makecache \
    && yum -y install git \
                      unzip \
                      php-pecl-xdebug \
                      xorg-x11-server-Xvfb \
                      wkhtmltopdf \
                      nodejs \
    && yum -y autoremove \
    && yum clean all \
    && rm -rf /var/cache/yum/

# custom ini
COPY build/docker/app/configs /

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=1.10.16 \
&& composer global require hirak/prestissimo --no-plugins --no-scripts \
&& wget https://github.com/vimeo/psalm/releases/download/3.8.3/psalm.phar \
&& chmod +x psalm.phar \
&& mv psalm.phar /usr/local/bin/psalm

RUN npm install -g n yarn && n stable

##### указываем запускаемый скрипт
CMD ["/bin/sh", "-c", "sh /opt/app.sh"]

FROM local as prod

COPY app/composer.json app/composer.lock app/symfony.lock /var/www/

RUN composer install --no-scripts --prefer-dist --no-autoloader

COPY app /var/www

# Finish composer
RUN composer install

RUN yarn install && yarn encore production

RUN chown www-data:www-data /var/www/ -R

# устанавливаем newrelic
ENV NR_INSTALL_SILENT true
RUN rpm -Uvh http://yum.newrelic.com/pub/newrelic/el5/x86_64/newrelic-repo-5-3.noarch.rpm \
    && yum --disablerepo=rsyslog_v8 -y install newrelic-php5 \
    && newrelic-install install

#cleanup
RUN composer global remove hirak/prestissimo && \
        rm /usr/local/bin/composer && \
        rm /usr/local/bin/psalm && \
        yum remove -y git \
                      unzip \
                      php-pecl-xdebug \
        rm /etc/php.d/xdebug.ini

##### указываем запускаемый скрипт
CMD ["/bin/sh", "-c", "sh /opt/app.sh"]
