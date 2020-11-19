# appliFoot

Application permmetant de gérer des culbs, des joueurs sur différentes saisons de football.

Définitions du modèle de données

Un joueur de football joue dans un ou plusieurs club de football pour une saison donnée
Une saison est représentée par une année de début et une année de fin
Pour un joueur on stocke son nom et son prénom
Possibilité d'accéder à l’historique des clubs d’un joueur
Lorsqu’un joueur appartient à un club, il a un numéro spécifique
Le joueur a une statistique de nombre de buts marqués par club et par saison. Ex : le joueur A a marqué 10 buts pour la saison 2019/2020 avec le club A et 20 buts pour le club B pour la saison 2019/2020.
Un club utilise un logo. On stocke également le nom du club
Possibilité d'accéder à l’historique des logos d’un club avec une date de début et une date de fin

Pages

Page d’accueil utilisateur non connecté : formulaire de login
Page d’accueil utilisateur connecté : liste des clubs avec sélecteur de saison
Page club : lors d’un clic sur un club
	Liste des joueurs pour la saison courante
	Permettre de pouvoir changer la saison courante
Page d’un joueur : lors du clic sur l’un des joueurs
  Liste de ses clubs pour la saison courante, ainsi que les statistiques associées
  Permettre de pouvoir changer la saison courante

Les données sont remplies à l’aide des Fixtures (Clubs, Saisons, Joueurs, Statistiques, Comptes utilisateurs)


Pour tester l'application (sous Windows, avec Composer, Wamp et git bash) : 

- éxécuter "composer create-project symfony/skeleton foot ^4.4.0"
- remplacer les fichiers dans le dossier foot par ceux du projet
- éxécuter "composer require doctrine/doctrine-fixtures-bundle --dev"
- créer une nouvelle base de données vide appelée "foot" via phpMyAdmin par exemple
- éxécuter "php bin/console doctrine:fixtures:load" puis "php bin/console server:run"
- se connecter à localhost:8000 et utiliser un des comptes utilisateurs (ex : User1 passeword : AllezRacing!)
