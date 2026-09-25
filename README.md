# Gestion-réunions

Plateforme web de gestion des réunions développée avec CakePHP 5, permettant de
planifier, organiser et suivre les réunions, de gérer les participants avec des
notifications automatiques.

## Fonctionnalités

- Authentification par email / mot de passe (inscription, connexion, déconnexion)
- Création de réunions avec type, date, lieu et participants
- Validation des réunions par un administrateur
- Planification de réunions et gestion des participants planifiés
- Calendrier (FullCalendar) des réunions
- Notifications (session + rappels) pour les réunions à venir / annulées
- Rôles : `admin` et `membre`

## Prérequis

- PHP >= 8.1 avec extensions `mbstring`, `intl`, `openssl`, `pdo_mysql`
- MySQL / MariaDB
- Composer

## Installation

1. Installer les dépendances :

```bash
composer install --no-dev --optimize-autoloader
```

2. Copier et adapter la configuration locale :

```bash
cp config/app_local.example.php config/app_local.php
```

3. Configurer la base de données dans `config/app_local.php` (ou via la variable
   d'environnement `DATABASE_URL`).

4. Créer la base de données puis lancer les migrations :

```bash
bin/cake migrations migrate
```

5. Démarrer le serveur de développement :

```bash
bin/cake server -p 8765
```

Ou configurer Apache/Nginx pour pointer vers `webroot/`.

## Raccourcis de déploiement

- Désactiver le mode debug : `DEBUG=false`
- Définir une clé de sécurité forte : `SECURITY_SALT`
- Vider le cache après déploiement : `bin/cake cache clear_all`
- Programmer les rappels (cron) : `bin/cake reminders`
- Notifications différées (cron) : `bin/cake send_reminders`

## Tests

```bash
composer test
composer cs-check
```

## Structure

- `src/Controller` — contrôleurs
- `src/Model` — tables et entités
- `templates` — vues
- `config/Migrations` — migrations de base de données