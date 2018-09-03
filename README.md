Démarrer l'objet Avec Symfony 4

L'objectif est de creer une petite application qui va gerer les commandes de bases:
Ajouter, afficher, modifier, supprimer (CRUD)
Il va s'agir d'ajouter une entite materiel avec les champs (nom + duree)

Puis, on verra comment lui ajouter des des commentaires , des graphiques, un back office...

------------------------------------------------------------------------------------
L'objet en théorie puis mise en place
------------------------------------------------------------------------------------

Commencer par installer PHP 7
Avec Laragon - https://laragon.org/download/
Puis Composer - https://getcomposer.org/
Puis phpMyAdmin - https://www.phpmyadmin.net/ ( a recopier dans le dossier etc/apps)
Puis Yarn - https://yarnpkg.com/en/docs/install#windows-stable

(Cela necessite peut etre un redemarrage)

Puis Symfony avec la commande:
composer create-project symfony/website-skeleton my_project

Puis, on commence par creer la base de données, et la relier via le fichier .ENV 


Tester que la console fonctionne avec php bin/console

puis l' entite
php bin/console make:entity materiel
- nom (string)
- duree (integer)

Creation du fichier SQL
php bin/console doctrine:schema:update --dump-sql
Creation en DB
php bin/console doctrine:schema:update --force

------------------------------------------------------------------------------------
1er partie: le CRUD de l entite materiel
------------------------------------------------------------------------------------
Le modele MVC:
- Entity
- Templates
- Controller 

Decouverte de phpMyAdmin (base, table, champ, enregistrement)

Creation de la page index avec la liste des materiels
- Routes (Attention aux espaces dans vos routes !)
- Doctrine ORM
- Repository
- Templating TWIG
- Layout
- Datatable JS

Creation de la page add
- Pourquoi les routes ne marchent pas ?
  - Les routes ne sont pas gérées nativement, il faut donc ajouter le paquet avec le public/.htaccess 
  - composer require apache-pack (repondre p ermanently)
- Les formulaires (namespace, use et champs)
- Persistance et transaction
- Message retour

Creation de la page edit
- Methode magique: find , findByAttribut
- Gestion d'erreur
- Redirect et explication des code HTTP

Creation de la page delete

Creation de la page search

Creation de la page show

------------------------------------------------------------------------------------
2e partie: le CRUD de l entite comment
------------------------------------------------------------------------------------
Creation via phpMyAdmin de la table comment
Quelques commandes supplémentaires:
Faire la difference en .SQL avec la base
php bin/console doctrine:migrations:diff

Appliquer les changements
php bin/console doctrine:migrations:migrate

php bin/console make:entity comment
- titre (varchar 255)
- contenu (text)
- materiel_id (int)

Creation en DB
php bin/console doctrine:schema:update --force

Refaire le CRUD
Modification des relations addToMany, oneToMany
Relier un commentaire à un matériel

Tester l'héritage de controlleur

Voir les FormType

Recuperer la liste des commentaires sur la page show du matériel

Ajouter un validateur sur la longueur du contenu

------------------------------------------------------------------------------------
3e partie: le reste
------------------------------------------------------------------------------------

Pages d'erreurs:
- Passer en prod et tester la page 404 /toto
- Dupliquer \vendor\symfony\twig-bundle\Resources\views\error.html.twig vers templates\bundles\TwigBundle\Exception\error404.html.twig
- Adapter le layout
- php bin/console cache:clear (ou rm -rf var/cache/prod/*)

Ajout d'un backoffice via composer:
composer req orm admin api
Dans config/packages/easy_admin ajouter les entites
- App\Entity\Materiel
- App\Entity\Comment

Puis dans les bundles EasyCorp\Bundle\EasyAdminBundle\EasyAdminBundle::class => ['all' => true],

Les Traits

Les graphiques

Le SEO
- composer require stof/doctrine-extensions-bundle
- Ajouter dans les bundles Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle::class=>['all' => true],
- Modifier l entite
- doctrine:schema:update --force
- Ajouter le getter et le setter
- Modifier le services.yaml
- Ajouter un commentaire pour verifier que ca fonctionne
- Ajouter un show sur les commentaires via le slug

Les traductions
- composer require symfony/translation
- Configurer le service
- Ajouter les fichiers dans Ressources\translations\messages.fr.php
- Tester avec php bin/console debug:translation:fr

La pagination dans les commentaires
- parametrage des routes
- parametrage du controlleur
- recuperer le parametre des services

Extensions Twig (tag) à ajouter sur l'index des commentaires
- composer require twig/extensions
- Ajout du fichier src\Twig\AppExtension.php

Gestionnaire d'evenements - ajout d'un listener pour ajouter une version Beta
- Ajout du fichier src\Beta\Beta.php (configuration du service)
- Ajout du fichier src\EventListener\BetaListener.php (configuration du service)

Améliorer les temps de chargement:
- composer require webpack-encore
- Configurer webpack.config.js
- modifier le layout pour avoir les assets
- yarn install
- yarn encore dev
- yarn encore production
- php bin/console clear:cache
