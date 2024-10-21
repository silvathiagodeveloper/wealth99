#!/bin/bash
php /var/www/html/artisan config:clear
php /var/www/html/artisan cache:clear
php /var/www/html/artisan config:cache
apache2-foreground