FROM devilbox/php-fpm-7.4:latest
MAINTAINER George Paulenka <wargot@gmail.com>

RUN apt-get update \
	&& apt-get install -y --no-install-recommends \
        zlib1g-dev \
		#libicu52 \
        libicu-dev \
		libpng-dev \
		libfreetype6-dev \
		libjpeg62-turbo-dev \
		libmcrypt4 \
		libmcrypt-dev \
		libtool \
		libwebp-dev \
		libzip-dev \
	&& docker-php-ext-install \
		intl \
		zip \
		exif \
		gd \
		pdo_mysql \
        mysqli \
		#mcrypt \
	&& docker-php-ext-enable \
		opcache \
		pdo_mysql \
        mysqli \
	&& apt-get purge -y \
		zlib1g-dev \
		libicu-dev \
		libpng-dev \
		libfreetype6-dev \
		libjpeg62-turbo-dev \
		libmcrypt-dev \
	&& apt-get clean all

RUN mkdir /var/php/
RUN mkdir /var/php/log
