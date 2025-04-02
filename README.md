# Projet-ING1-Dev :

# Gestion de Maison Connectée

## Aperçu du Projet

Ce projet consiste à développer une plateforme web permettant de gérer les objets connectés de la maison de la famille Bon. La plateforme est accessible à la famille Bon et aux utilisateurs avec différents accès selon leur niveau et permet de consulter, modifier et administrer les objets et services de la maison.
L'objectif principal est de proposer une interface intuitive et fonctionnelle pour visualiser et interagir avec les objets connectés, tout en respectant un système de permissions basé sur un système de points.

## Fonctionnalités

### Système de Permissions
L'application repose sur un système de points qui définit les différents niveaux d'accès des utilisateurs :

1. **Module Info (0 pts)** :
   - Accès au "free tour" présentant les informations générales sur la maison. ✅

2. **Module Visualisation** :
   - *Débutant (1 pt)* :
     - Peut modifier son profil (+1 pt). ✅
     - Peut consulter le profil des autres membres. ✅
     - Peut consulter les objets sans les modifier (+1 pt). ✅
   - *Intermédiaire (3 pts)* :
     - Accès aux fonctionnalités du module débutant.

3. **Module Gestion** :
   - *Avancé (5 pt)* :
      - Accès à tous les modules précédents. ✅
      - Peut modifier les objets (température, état...). ✅
      - Peut modifier les descriptions des objets (nom, etc.). ❌
      - Peut ajouter/supprimer un objet (+1 pt). ✅ 
      - Peut générer des rapports d'utilisation et des statistiques historiques. ❌

4. **Module Admin** :
   - *Expert (8 pt)* :
      - Accès à toutes les fonctionnalités précédentes. ✅
      - Peut créer/supprimer un utilisateur. ✅
      - Peut consulter l'historique des connexions des utilisateurs. ✅
      - Peut attribuer des points ou modifier les accès des utilisateurs. ✅
      - Peut modifier la plateforme. ❌

## Installation et Utilisation

### Prérequis
- **WAMP Server** (ou tout autre serveur local avec Apache, MySQL et PHP)
- **phpMyAdmin** pour gérer la base de données

### Installation
1. Installer **WAMP Server** si ce n'est pas déjà fait.
2. Télécharger et extraire le projet dans le répertoire **wamp64/www**.
3. Lancer **WAMP** et accéder à **phpMyAdmin**.
4. Importer les 4 fichiers SQL fournis dans une base de données nommée `utilisateurs`.
5. Accéder au projet via `http://localhost/nom_du_projet` dans votre navigateur.

## Technologies Utilisées
- **Back-end** : PHP, MySQL
- **Front-end** : HTML, CSS, JavaScript(Vue.js)
- **Serveur** : Apache (via WAMP)

## Fonctionnalités manquantes
- Consulter et générer des rapports d'utilisation des objets (par ex. consommation 
énergétique quotidienne ou hebdomadaire) ❌
- L’envoie d’un mail à l’utilisateur pour se connecter ❌
- Générer des statistiques sur l'utilisation des objets et des services pour optimiser 
la gestion des ressources ; ❌
- Ajout de la fonctionnalité de modification de la plateforme par l'admin. ❌

## Auteurs
Projet réalisé par : Paimba-Sail Owen, Axel Guesdon, Abdelah Saidj, Zakaria Chikaoui, Ahmed Aissaoui

