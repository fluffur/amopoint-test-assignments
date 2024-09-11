FROM php:8.3-apache

RUN a2enmod rewrite

CMD ["apache2-foreground"]