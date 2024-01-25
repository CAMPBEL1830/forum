# Utilisez une image de base appropriée pour PHP avec Apache
FROM php:7.4-apache

# Mise à jour des paquets et installation des extensions PHP nécessaires
RUN apt-get update \
    && apt-get install -y \
        libzip-dev \
        zip \
    && docker-php-ext-install zip \
    && docker-php-ext-install zip mysqli

# Configuration d'Apache : active le module rewrite et définit le répertoire racine
RUN a2enmod rewrite
RUN a2enmod headers
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf

# Définissez le répertoire de travail dans le conteneur
WORKDIR /var/www/html

# Copiez les fichiers de l'application PHP dans le conteneur
COPY . .

# Exposez le port sur lequel le serveur Apache s'exécute
EXPOSE 80

# Commande pour démarrer le serveur Apache
CMD ["apache2-foreground"]
