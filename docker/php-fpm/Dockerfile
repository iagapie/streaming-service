FROM php:7.4-fpm-alpine as main

LABEL maintainer="igoragapie@gmail.com"

RUN set -ex \
    && mkdir -p /app \
    && chown -Rf www-data:www-data /app \
    && apk add --no-cache --virtual .build-deps \
    	autoconf \
    	dpkg-dev \
    	dpkg \
    	file \
    	g++ \
    	gcc \
    	libc-dev \
    	make \
    	pkgconf \
    	re2c \
    	libgcrypt-dev \
    	libxslt-dev \
    	libxml2-dev \
    	icu-dev \
    && docker-php-ext-install \
		opcache \
		xsl \
		soap \
		xmlrpc \
		pdo_mysql \
		mysqli \
		bcmath \
		intl \
	&& pecl install apcu \
	&& docker-php-ext-enable apcu \
	&& docker-php-source delete \
	&& runDeps="$( \
        scanelf --needed --nobanner --format '%n#p' --recursive /usr/local \
            | tr ',' '\n' \
            | sort -u \
            | awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
    )" \
    && apk add --no-cache --virtual .php-rundeps $runDeps \
    && apk del .build-deps

WORKDIR /app

FROM main as dev

ARG USER_ID
ARG GROUP_ID

RUN set -ex \
	&& apk add --no-cache --virtual .persistent-deps \
		nano \
		unzip \
		zip \
		git \
		shadow \
    && groupdel dialout \
    && groupmod -g $GROUP_ID www-data \
	&& usermod -u $USER_ID www-data \
	&& chown -Rf www-data:www-data /app

RUN set -ex \
	&& apk add --no-cache --virtual .build-deps \
    	autoconf \
    	dpkg-dev \
    	dpkg \
    	file \
    	g++ \
    	gcc \
    	libc-dev \
    	make \
    	pkgconf \
    	re2c \
    	libgcrypt-dev \
    && pecl install xdebug-3.0.2 \
    && docker-php-ext-enable xdebug \
    && docker-php-source delete \
	&& runDeps="$( \
        scanelf --needed --nobanner --format '%n#p' --recursive /usr/local \
            | tr ',' '\n' \
            | sort -u \
            | awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
    )" \
    && apk add --no-cache --virtual .php-rundeps $runDeps \
    && apk del .build-deps \
    && echo '#!/bin/sh' >> /usr/local/bin/xdebug \
	&& echo 'set -e' >> /usr/local/bin/xdebug \
	&& echo '' >> /usr/local/bin/xdebug \
	&& echo 'if [ -s "/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini" ]; then' >> /usr/local/bin/xdebug \
	&& echo '    mv /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.iniOLD \' >> /usr/local/bin/xdebug \
	&& echo '    && kill -USR2 1 \' >> /usr/local/bin/xdebug \
	&& echo '    && echo "========= XDebug was disabled ========="' >> /usr/local/bin/xdebug \
	&& echo 'else' >> /usr/local/bin/xdebug \
	&& echo '    mv /usr/local/etc/php/conf.d/docker-php-ext-xdebug.iniOLD /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \' >> /usr/local/bin/xdebug \
	&& echo '    && kill -USR2 1 \' >> /usr/local/bin/xdebug \
	&& echo '    && echo "========= XDebug was enabled ========="' >> /usr/local/bin/xdebug \
	&& echo 'fi' >> /usr/local/bin/xdebug \
	&& chmod +x /usr/local/bin/xdebug \
	&& echo 'xdebug.idekey=PHPSTORM' >> /usr/local/etc/php/conf.d/custom-xdebug.ini \
	&& echo 'xdebug.cli_color=1' >> /usr/local/etc/php/conf.d/custom-xdebug.ini \
	&& echo 'xdebug.default_enable=1' >> /usr/local/etc/php/conf.d/custom-xdebug.ini \
	&& echo 'xdebug.max_nesting_level=1000' >> /usr/local/etc/php/conf.d/custom-xdebug.ini \
	&& echo 'xdebug.var_display_max_depth=10' >> /usr/local/etc/php/conf.d/custom-xdebug.ini

RUN set -ex \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer
