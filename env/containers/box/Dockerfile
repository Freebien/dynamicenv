FROM php:apache

RUN apt update \
    && apt-get install -yq --no-install-recommends \
        libpq-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install -j$(nproc) opcache pgsql
RUN a2enmod rewrite

COPY --chown=www-data:www-data ./htdocs /var/www/html

ENV APACHE_ENVVARS=/etc/apache2/custom.d/envvars

ADD --chown=root:root --chmod=755 ./apache2/envvars /etc/apache2/custom.d/envvars
ADD --chown=root:root --chmod=755 ./apache2/include.sh /etc/apache2/custom.d/include.sh
