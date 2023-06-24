# README - Projet avec Docker

suje de l'exercice
Les élections législatives, en Guignolerie Septentrionale,
obéissent à la règle suivante:
lorsque l'un des candidats obtient plus de 50% des
suffrages, il est élu dès le premier tour.
en ca de deuxième tour, peuvent participer
uniquement les candidats ayant obtenu au moins
12,5% des voix au premier tour.
Travail à Faire:
Vous devez écrire un algorithme qui permette la saisie
des scores de quatre candidats au premier tour. Cet
algorithme traitera ensuite le candidat numéro 1
(et uniquement lui) : il dira s'il est élu, battu, s'il se
trove en ballottage favorable (il participe au second
tour en étant arrivé en tête à l'issue du premier tour)
ou défavorable (il participe au second tour sans avoir
été en tête au premier tour).

Ce projet est un template de base pour un projet utilisant Docker. Il vous permet de démarrer rapidement un environnement de développement avec les fonctionnalités suivantes :

1. Cloner le projet :

```

git clone https://github.com/Mampionona33/php-docker-template.git

```

2. Le répertoire principal du projet se trouve dans le dossier `app`. C'est là que vous travaillerez sur votre application.

3. Les requêtes sont redirigées vers `index.php`. Vous pouvez gérer les routes et la logique de votre application dans ce fichier.

4. Avant de commencer, exécutez la commande suivante dans le répertoire `app` pour installer les dépendances nécessaires à l'aide de npm :

```

npm install

```

5. Les fichiers JavaScript se trouvent dans le répertoire `app/src`, et les fichiers de style se trouvent dans `app/src/styles`. Vous pouvez modifier ces fichiers selon les besoins de votre projet.

6. Pour lancer le serveur et exécuter l'application, rendez-vous à la racine du projet et exécutez la commande suivante :

```

docker-compose up --build

```

7. Pour compiler les fichiers SCSS et JavaScript, exécutez la commande suivante dans le répertoire `app` :

```

npm run dev

```

Ce projet utilise Docker Compose pour gérer les services. Le fichier `docker-compose.yml` contient la configuration des services Apache, MySQL et phpMyAdmin.

Assurez-vous d'avoir les ports suivants disponibles sur votre machine :

- Port pour l'application : 8081
- Port pour phpMyAdmin : 8888

Le fichier `docker-compose.yml` spécifie les ports de redirection pour ces services. Vous pouvez les modifier si nécessaire.

N'oubliez pas de mettre à jour ce README avec des instructions spécifiques à votre projet et de fournir toutes les informations importantes pour les autres développeurs qui travailleront dessus.

```

```
