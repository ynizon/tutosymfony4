Démarrer l'objet Avec Symfony 4

L'objectif est de creer une petite application qui va gerer les commandes de bases:
Ajouter, afficher, modifier, supprimer (CRUD)
Il va s'agir d'ajouter une entite materiel avec les champs (nom + duree)

Puis, on verra comment lui ajouter des des commentaires , des graphiques, un back office...


Commencer par installer PHP 7
Avec Laragon - https://laragon.org/download/
Puis Composer - https://getcomposer.org/
Puis phpMyAdmin - https://www.phpmyadmin.net/

(Cela necessite peut etre un redemarrage)

Puis Symfony avec la commande:
composer create-project symfony/website-skeleton my_project

Les routes ne sont pas gérées nativement, il faut donc ajouter le paquet avec le .htaccess 
composer require apache-pack 

Puis, on commence par creer la base de données, et la relier via le fichier .ENV 

puis les entites
materiel
php bin/console make:entity

(pour la MAJ c est)
doctrine:generate:entities

Creation du SQL
php bin/console doctrine:schema:update --dump-sql
Creation en DB
php bin/console doctrine:schema:update --force



Quelques commandes supplémentaires:
Faire le .SQL depuis la base
php bin/console doctrine:migrations:diff

Appliquer les changements
php bin/console doctrine:migrations:migrate


Attention aux espaces dans vos routes !


Ajout d'un backoffice:
composer req orm admin api
Dans config/packages/easy_admin ajouter l'entite
        - App\Entity\Materiel