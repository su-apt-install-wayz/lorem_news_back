#!/bin/bash

# Vérifier si le projet a déjà été initialisé
if [ ! -f "/var/www/html/.init_done" ]; then
    echo "Initialisation du projet Lorem News..."
    
    # Naviguer dans le répertoire du projet si nécessaire
    cd /var/www/html
    
    # Installer les dépendances PHP via Composer
    echo "Installation des dépendances Composer..."
    composer install --no-interaction

    # Installer les dépendances Node.js via npm
    echo "Installation des dépendances npm..."
    npm install
    
    # Attendre que la base de données soit prête (utile si votre DB prend du temps à démarrer)
    echo "Attente de la base de données..."
    while ! /usr/bin/mysqladmin ping -h"lorem_news_symfony-db-1" --silent; do
        sleep 1
    done
    
    # Installer les tables MySql via Doctrine
    echo "Installation des tables MySql..."
    php bin/console doctrine:migrations:migrate --no-interaction

    # Charger les fixtures
    # echo "Chargement des fixtures..."
    # php bin/console doctrine:fixtures:load --no-interaction

    # Marquer le projet comme initialisé pour éviter de répéter ces opérations
    touch /var/www/html/.init_done
    
    echo "Le projet Lorem News a été initialisé avec succès."
else
    echo "Le projet Lorem News a déjà été initialisé."
fi

# Continuer avec le démarrage standard d'Apache (ou le command spécifié dans CMD)
exec docker-php-entrypoint apache2-foreground
