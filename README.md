# Nom final de la formation

Ce dossier Repository est lié au cours `Nom final de la formation`. Le cours entier est disponible sur [LinkedIn Learning][lil-course-url].

![Nom final de la formation][lil-thumbnail-url] 

DESCRIPTION DE LA FORMATION

## Instructions

Ce dossier Repository a des branches pour chacune des vidéos du cours. Vous pouvez utiliser le menu des Branches sur GitHub afin d’accéder aux passages qui vous intéressent. Vous pouvez également rajouter `/tree/BRANCH_NAME` à l’URL afin d’accéder à la branche qui vous intéresse. 

## Branches

Les branches sont structurées de manière à correspondre aux vidéos du cours. La convention de nommage est : `CHAPITRE#_VIDEO#`. Par exemple, la branche nommée`02_03` correspond au second chapitre, et à la troisième vidéo de ce chapitre. Certaines branches ont un état de départ et de fin.  
La branche `02_03_d` correspond au code du début de la vidéo.  
La branche `02_03_f` correspond au code à la fin de la vidéo.  
La branche master correspond au code à la fin de la formation. 

## Installation

### Prérequis
- PHP >= 8.2
- Composer
- Symfony CLI
- MySQL

### Étapes d'installation

#### 1. Cloner le projet

```bash
git clone https://github.com/LinkedInLearning/Symfony_Construire_tester_API-4278176.git
cd Symfony_Construire_tester_API-4278176
```

#### 2. Installer les dépendances

```bash
composer install
```

#### 3. Configurer l'environnement

Modifiez la variable DATABASE_URL depuis le fichier `.env` pour renseigner la information de connexion à votre base de données :

```
DATABASE_URL="mysql://utilisateur:motdepasse@127.0.0.1:3306/nom_de_la_base?serverVersion=8.0&charset=utf8mb4"
```

#### 4. Créer la base de données

```bash
php bin/console doctrine:database:create
```

#### 5. Appliquer les migrations
```bash
php bin/console make:migration
```

```bash
php bin/console doctrine:migrations:migrate
```

#### 6. Charger les fixtures

```bash
php bin/console doctrine:fixtures:load
```

#### 7. Lancer le serveur Symfony

```bash
symfony serve
```
ou

```bash
symfony server:start
```

#### 8. Accéder à l'application

Ouvrez votre navigateur et rendez-vous sur :

```
http://127.0.0.1:8000
```

Votre projet Symfony est maintenant prêt à être utilisé ! 🚀



### Formateur

**Nom du formateur** 

 Retrouvez mes autres formations sur [LinkedIn Learning][lil-URL-trainer].

[0]: # (Replace these placeholder URLs with actual course URLs)
[lil-course-url]: https://www.linkedin.com
[lil-thumbnail-url]: https:
[lil-URL-trainer]: https://

[1]: # (End of FR-Instruction ###############################################################################################)
