# projet ENI_Sortir.com

## Team project :

-   Dominique AMPS
-   Antoine GUILLOU
-   Christophe RENIER
-   Thomas KERNILIS

## project managment
Lien vers le kanban [Notion](https://www.notion.so/bilienn/0a6d6b7da1cc47b4beae24627ba75458?v=27baf038f4224481ad4073315266c660)

## Guide de déploiement d'un projet Symfony existant (Cas d’une reprise d’un repo Git)
- Run `composer install` pour installer les dépendances.
- Recupération du fichier .env.local à placer à la racine du projet.
- Recréer la database `php bin/console doctrine:database:create`
- Importer le script

## Pour lancer le serveur Symfony (cas d'un serveur local)
- Run `symfony serve` commande à la racine du projet.