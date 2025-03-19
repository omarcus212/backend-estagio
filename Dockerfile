FROM php:8.2-fpm

# Atualiza e instala dependências necessárias
RUN apt-get update && apt-get install -y \
  zip \
  unzip \
  git \
  libsqlite3-dev \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install gd pdo pdo_mysql pdo_sqlite \
  && rm -rf /var/lib/apt/lists/*

# Definir diretório de trabalho
WORKDIR /var/www

# Instalar o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --no-plugins

# Expor a porta 8000 para o container
EXPOSE 8000

# Configurar o comando de inicialização do container (se necessário)
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
