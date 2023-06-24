# Utilisez une image basée sur php avec Apache plus légère
FROM php:8.1-apache-bullseye

# Installez les packages nécessaires
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        htop \
        default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

# Install phpMyAdmin
ENV PHPMYADMIN_VERSION=5.1.1
RUN curl -L -o phpmyadmin.tar.gz https://files.phpmyadmin.net/phpMyAdmin/$PHPMYADMIN_VERSION/phpMyAdmin-$PHPMYADMIN_VERSION-all-languages.tar.gz \
    && tar -xzf phpmyadmin.tar.gz -C /var/www/html --strip-components=1 \
    && rm phpmyadmin.tar.gz

# Set phpMyAdmin configuration
RUN { \
    echo '<?php'; \
    echo '$_ENV["PMA_HOST"] = "mysql";'; \
    echo '$_ENV["PMA_PORT"] = "3306";'; \
    echo '$_ENV["PMA_USER"] = "root";'; \
    echo '$_ENV["PMA_PASSWORD"] = "password";'; \
    echo '$_ENV["PMA_AUTH_TYPE"] = "config";'; \
    echo '$_ENV["PMA_ABSOLUTE_URI"] = "/phpmyadmin/";'; \
    } > /var/www/html/config.inc.php

# Enable mod_rewrite
RUN a2enmod rewrite

# Install PDO
RUN docker-php-ext-install pdo_mysql

# Install msqli
RUN docker-php-ext-install mysqli

# Expose port 80
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]