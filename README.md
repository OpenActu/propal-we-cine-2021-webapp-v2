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

@todo l'authentification est désactivé pour le moment

