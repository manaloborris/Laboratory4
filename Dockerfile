ARG PHP_VERSION=8.2

FROM php:${PHP_VERSION}-apache

# Install PDO MySQL and enable rewrite
RUN docker-php-ext-install pdo pdo_mysql \
    && a2enmod rewrite

# Copy app files
COPY . /var/www/html/

# Fix permissions and configure Apache to serve public/ correctly
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && sed -i 's#DocumentRoot /var/www/html#DocumentRoot /var/www/html/public#g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's#<Directory /var/www/html>#<Directory /var/www/html/public>#g' /etc/apache2/apache2.conf \
    && sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Ensure static files and .htaccess work correctly
RUN echo '<Directory "/var/www/html/public">\n    Options Indexes FollowSymLinks\n    AllowOverride All\n    Require all granted\n</Directory>' > /etc/apache2/conf-available/public-dir.conf \
    && a2enconf public-dir

EXPOSE 80
CMD ["apache2-foreground"]