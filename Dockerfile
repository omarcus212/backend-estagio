FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
  zip \
  unzip \
  git \
  sqlite3 \
  libsqlite3-dev \
  && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-install mysqli

WORKDIR /var/www
RUN curl -sS https://getcomposer.org/installer 
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

EXPOSE 8080