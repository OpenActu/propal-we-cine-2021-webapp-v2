# Installation

## Pré-requis

L'application a été déployée au préalable selon la documentation *../local/README.md*

# Guide d'installation de l'application

1. Se connecter à la machine webapp via docker en ligne de commande

```
docker exec -ti propal-we-cine-2021-webapp-instance /bin/bash
```

2. Exécuter les commandes suivantes :

```
composer install
yarn install
php bin/console assets:install --symlink public
php bin/console doctrine:database:create 
php bin/console doctrine:migration:migrate
yarn watch
```

# Validation de l'application

1. Se connecter à la machine webapp via docker en ligne de commande

```
docker exec -ti propal-we-cine-2021-webapp-instance /bin/bash
```

2. Exécuter les commandes suivantes :

```
php bin/phpunit tests
```

# Authentification

L'authenfication est minimaliste en l'état. Pour se connecter il suffit simplement de saisir sur la mire *guest* en nom d'utilisateur et *guest* en mot de passe.

# Addendum à la version de démo 

1. Migration sf 5.4 vers 6.4  
2. Suppression des références au toolkit FOPG
3. Intégration de REACT sur le chargement des images d'entête
4. Publication des web services via API PLATFORM
5. Import asynchrone des films et images du serveur
6. Ajout d'un switcher pour privilégier la BDD à l'API distante
6. Activer REDIS pour optimiser les chargements des contrôleurs 
7. Stocker les images via AWS dans S3 Minio
8. Activer un service de CDN pour éviter les appels serveur sur les images
8. @todo mettre en place RabbitMQ