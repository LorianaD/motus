# Motus

Projet réalisé dans le cadre de mon admission au Bachelor Développeur Web.

## Description

Motus est une adaptation du célèbre jeu Motus développée avec **Symfony**. Le joueur doit retrouver un mot choisi aléatoirement parmi ceux enregistrés en base de données en un maximum de **6 tentatives**.

Chaque proposition est analysée afin d'indiquer :

- 🟥 Lettre correcte et bien placée.
- 🟨 Lettre présente mais mal placée.
- 🟦 Lettre absente du mot.

Le projet répond au cahier des charges fourni par La Plateforme.

## Technologies

- PHP 8.4
- Symfony 7
- Doctrine ORM
- Twig
- MySQL
- HTML5
- CSS3
- JavaScript

## Fonctionnalités

### Terminées

- ✅ Authentification des utilisateurs
- ✅ Inscription
- ✅ Connexion / Déconnexion
- ✅ Gestion des entités Doctrine
  - User
  - Word
  - Game
  - Attempt
- ✅ Création d'une partie
- ✅ Sauvegarde des tentatives
- ✅ Vérification des mots (rouge / jaune / bleu)
- ✅ Gestion de la victoire
- ✅ Gestion de la défaite

### À venir

- Grille de jeu entièrement dynamique
- Clavier virtuel
- Wall of Fame
- Amélioration du design
- Niveaux de difficulté

## Installation

```bash
git clone https://github.com/LorianaD/motus.git

cd motus

composer install

cp .env .env.local
```

Configurer ensuite la base de données dans `.env.local`.

Créer la base :

```bash
php bin/console doctrine:database:create
```

Exécuter les migrations :

```bash
php bin/console doctrine:migrations:migrate
```

Lancer le serveur :

```bash
symfony server:start
```

## Structure du projet

```
src/
├── Controller/
├── Entity/
├── Repository/
├── Service/
├── Security/
└── Form/
```

## Auteur

Projet réalisé par **Loriana DIANO**.