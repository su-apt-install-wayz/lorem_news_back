# Utilisez l'image de base PHP avec Apache
FROM php:8.3-apache

# Mettez à jour les paquets et installez les outils nécessaires
RUN apt-get update && \
    apt-get install -y default-mysql-client wget vim git zip unzip zlib1g-dev libzip-dev libpng-dev nano && \
    apt-get install -y nodejs npm

# Installer Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    php -r "unlink('composer-setup.php');"

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install mysqli pdo_mysql gd zip pcntl exif && \
    docker-php-ext-enable mysqli

# Activer les modules Apache nécessaires
RUN a2enmod headers expires rewrite

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier la configuration Apache personnalisée
COPY php/apache.conf /etc/apache2/sites-available/000-default.conf

# Copier le fichier entrypoint.sh dans le conteneur
COPY entrypoint.sh /usr/local/bin/entrypoint.sh

# Rendre le script entrypoint.sh exécutable
RUN chmod +x /usr/local/bin/entrypoint.sh