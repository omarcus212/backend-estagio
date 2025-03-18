FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
  zip \
  unzip \
  git \
  sqlite3 \
  libsqlite3-dev \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install gd pdo pdo_mysql \
  && rm -rf /var/lib/apt/lists/*


RUN docker-php-ext-install pdo pdo_sqlite

WORKDIR /var/www

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

EXPOSE 8000
