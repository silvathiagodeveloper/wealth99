#!/bin/bash

mkdir -p /run/mysqld
chown mysql:mysql /run/mysqld

php /var/www/html/artisan config:clear
php /var/www/html/artisan cache:clear
php /var/www/html/artisan config:cache

# Iniciar o MariaDB em segundo plano
mysqld --user=mysql --skip-networking=0 &
# Aguardar alguns segundos para garantir que o MySQL esteja em execução
sleep 5

mysql -e "CREATE DATABASE IF NOT EXISTS crypto_prices;"

# Configurar o usuário do MySQL e a senha
mysql -e "CREATE USER IF NOT EXISTS 'root'@'localhost' IDENTIFIED BY 'secret';"
mysql -e "GRANT ALL PRIVILEGES ON crypto_prices.* TO 'root'@'localhost';"
mysql -e "FLUSH PRIVILEGES;"
mysql -e "ALTER USER 'root'@'localhost' IDENTIFIED BY 'secret';"

php /var/www/html/artisan migrate
apache2-foreground