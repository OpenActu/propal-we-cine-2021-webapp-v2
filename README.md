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
