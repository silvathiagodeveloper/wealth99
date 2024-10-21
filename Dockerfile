FROM php:7.4-apache

RUN docker-php-ext-install pdo pdo_mysql

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN a2enmod rewrite

COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 80

# Copia e usa o script de entrada personalizado
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
CMD ["/entrypoint.sh"]