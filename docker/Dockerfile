# Utilisez l'image de base PHP avec Apache
FROM php:8.3-apache

# Mettez à jour les paquets et installez les outils nécessaires
RUN apt-get update && \
    apt-get install -y default-mysql-client wget vim git zip unzip zlib1g-dev libzip-dev libpng-dev nano tzdata locales && \
    apt-get install -y nodejs npm

# Configurer le fuseau horaire et les locales
RUN echo "Europe/Paris" > /etc/timezone && \
    dpkg-reconfigure -f noninteractive tzdata && \
    echo "fr_FR.UTF-8 UTF-8" > /etc/locale.gen && \
    locale-gen && \
    update-locale LANG=fr_FR.UTF-8

# Définir les variables d'environnement pour le fuseau horaire et la locale
ENV TZ=Europe/Paris
ENV LANG=fr_FR.UTF-8
ENV LANGUAGE=fr_FR:fr
ENV LC_ALL=fr_FR.UTF-8

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