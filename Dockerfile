FROM php:7.4-apache

RUN apt-get update && apt-get install -y \
    libzip-dev \
    git \
    unzip \
    libmcrypt-dev \
    mariadb-server \
    default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql

# Instalar o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar o código da aplicação para o diretório do Apache
COPY . /var/www/html/

# Definir o diretório de trabalho
WORKDIR /var/www/html

# Instalar as dependências do Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN a2enmod rewrite

COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80

# Copia e usa o script de entrada personalizado
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
CMD ["/entrypoint.sh"]