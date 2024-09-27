# API Laravel - Guide d'Utilisation

Ce document fournit un guide détaillé pour interagir avec l'API Laravel, qui propose plusieurs fonctionnalités telles que l'envoi d'OTP, l'inscription, la connexion, et la gestion des réservations.

---

# ROUTES LIEES A L'AUTHENTIFIATION ET A LA MOFDIFICATION DES IDENTIFIANTS

---

## Route `otp-request`

Cette route permet de demander l'envoi d'un OTP (One-Time Password) à un email donné.

- **Méthode HTTP**: `POST`
- **Endpoint**: `/otp-request`

### Paramètres de la requête:
- `email`: L'adresse e-mail de l'utilisateur.

### Réponses:
- `200`: OTP envoyé avec succès.
- `400`: Erreurs variées, notamment si l'utilisateur est déjà inscrit.

---

## Route `otp-validate`

Cette route permet de valider un OTP pour un email donné.

- **Méthode HTTP**: `POST`
- **Endpoint**: `/otp-validate`

### Paramètres de la requête:
- `email`: L'adresse e-mail de l'utilisateur.
- `otp`: Le One-Time Password à valider.

### Réponses:
Différents messages en fonction de la validité de l'OTP.

---

## Route `register`

Cette route permet à un utilisateur de s'inscrire en fournissant un email, un matricule, et un mot de passe.

- **Méthode HTTP**: `POST`
- **Endpoint**: `/register`

### Paramètres de la requête:
- `email`: L'adresse e-mail de l'utilisateur.
- `matricule`: Le matricule de l'utilisateur.
- `password`: Le mot de passe de l'utilisateur.

### Réponses:
Messages de succès ou d'erreur selon le résultat de l'inscription.

---

## Route `password reset while disconnected`

Cette route permet a un utilisateur non connecte d'initier la reinitialisation de son mot de passe.

- **Méthode HTTP**: `POST`
- **Endpoint**: `/password-reset-while-disconnected`

### Paramètres de la requête:
- `email`: L'adresse e-mail de l'utilisateur.

### Réponses:
Messages de succès ou d'erreur selon le résultat de l'envoi d'email.

---

## Route `login`

Cette route permet à un utilisateur de se connecter en fournissant un email et un mot de passe.

- **Méthode HTTP**: `POST`
- **Endpoint**: `/login`

### Paramètres de la requête:
- `email`: L'adresse e-mail de l'utilisateur.
- `password`: Le mot de passe de l'utilisateur.

### Réponses:
- `200`: Détails de l'utilisateur et token de connexion en cas de succès.
- `403`: Erreur en cas d'échec (utilisateur non trouvé ou mot de passe incorrect).

---


## Route `password reset `

Cette route permet a un utilisateur  connecte d'initier la reinitialisation de son mot de passe.

- **Méthode HTTP**: `POST`
- **Endpoint**: `/password-reset-while-disconnected`

### En-tête:
- `Authorization`: Token de connexion. Exemple: `Bearer token(gjjgvjhvhjgvhjgvjhvjh)`.

### Réponses:
Messages de succès ou d'erreur selon le résultat de l'envoi d'email.



---

## Route `email-reset-init`

Cette route permet de demander l'envoi d'un OTP (One-Time Password) pour confirmer la nouvelle addresse.

- **Méthode HTTP**: `POST`
- **Endpoint**: `/email-reset-init`

### Paramètres de la requête:
- `email`: L'adresse e-mail de l'utilisateur.

### Réponses:
- `200`: OTP envoyé avec succès.
- `400`: Erreurs variées, notamment si l'adresse est la meme que l'adresse actuelle.

---

## Route `email-reset`

Cette route permet de valider un OTP pour confirmer la modification de l'email associee au compte.

- **Méthode HTTP**: `POST`
- **Endpoint**: `/email-reset`

### Paramètres de la requête:
- `email`: L'adresse e-mail de l'utilisateur.
- `otp`: Le One-Time Password à valider.

### Réponses:
Différents messages en fonction de la validité de l'OTP.


---

#  ROUTES LIEES AUX RESERVATIONS ET A L'HISTORIQUE 

---

## Route `booking_params`

Cette route permet d'obtenir les paramètres de réservation pour une semaine donnée.


- **Méthode HTTP**: `POST`
- **Endpoint**: `/booking_params`

### Paramètres de la requête:
- `semaine`: Le numéro de la semaine pour laquelle obtenir les paramètres.

### En-tête:
- `Authorization`: Token de connexion. Exemple: `Bearer token(gjjgvjhvhjgvhjgvjhvjh)`.

### Réponses:
 3 listes vont s'afficher :
-  -  celle des seances deja reservees 
    ( attente de niveau 1 est due au fait que l'utilisateur a deja une seance cette semaine la )

-  -  celle des seances reservables (elle inclut les seances reservees)

- -  celle des seances non reservables 
     (il y a actuellement un bug donc elle est vide . 
         Apres corrrectif elle afichera les heures non reservables avec le motif de non reservabilite )
- NB : la liste des seances reservables inclut les seances deja reservees
       **Tous ces tableau varient au gres des reservation et des desirs de l'administration et 
              doivent donc etre regulierement actualisees )**
---

## Route `booking_process`

Cette route gère le processus de réservation.

- **Méthode HTTP**: `POST`
- **Endpoint**: `/booking_process`

### Paramètres de la requête:
- `semaine`: Le numéro de la semaine concernée.
- `add`: Tableau des heures à réserver.
- `delete`: Tableau des réservations à annuler.
- (nb : meme si l'un est vide , les 2  tableaux doivent etre soumis )

### En-tête:
- `Authorization`: Token de connexion. Exemple: `Bearer token(gjjgvjhvhjgvhjgvjhvjh)`.

### Réponses:
Elle retoure les listes actualisees en cas de success 
ou un message pour signaler que l'on ne peut faire 2 reservations le meme jour 
---

## Route `histo`

Cette route permet d'obtenir l'historique exclusif de ses reservations de l'utilisateur connecte 

- **Méthode HTTP**: `POST`
- **Endpoint**: `/histo`

### En-tête:
- `Authorization`: Token de connexion. Exemple: `Bearer token(gjjgvjhvhjgvhjgvjhvjh)`.

### Réponses:
- Liste de seances reservees 

---

## Route `data`

Cette route permet d'obtenir les informations de l'utilisateur connecte

- **Méthode HTTP**: `POST`
- **Endpoint**: `/data`

### En-tête:
- `Authorization`: Token de connexion. Exemple: `Bearer token(gjjgvjhvhjgvhjgvjhvjh)`.

### Réponses:
- Donnees sur l'utilisateur 



---

#   ROUTES LIEES A LA TABLETTE 

---


## Route `tab-capmus-set`

Cette route affecte a la tablette le campus de l'admin qui entre ses identifiants.

- **Méthode HTTP**: `POST`
- **Endpoint**: `/tab/campus-set`

### Paramètres de la requête:
- `email`: L'adresse e-mail de l'un des administrateurs d'une ecole du campus.
- `password`: Le mot de passe de l'un des administrateurs d'une ecole du campus.


### Réponses:
Message de sccess ou d'erreur 



## Route `tab-list`

Cette route affiche les etudiant ayant fait une reservation pour la seance ciblee

- **Méthode HTTP**: `POST`
- **Endpoint**: `/tab/list`

### Paramètres de la requête:
- `semaine` : numero de la semain dans l'annee (1...10...34..)
- `d_o_w` :jour de la semaine ( lundi , mardi ...)
- `debut`: heure de debut de la seance ciblee
- `annee`: anneee en cours 
- `campus_id ` :id du campus  (obtenu par la route precedente)


### Réponses:
Liste d'etudiants


---

#     Installation des dépendances et démarrage du projet

---
### Installation des dépendances :

1. Accédez au répertoire du projet via le terminal.
2. Exécutez la commande `composer install` pour installer les dépendances PHP.

### Configuration de l'environnement :

1. Dupliquez le fichier `.env.example` et renommez-le en `.env`.
2. Configurez la base de données dans le fichier `.env`.
3. Configurez également le SMTP pour l'envoi des mails dans le fichier `.env`.

### Génération de la clé d'application :
Exécutez la commande suivante pour générer une nouvelle clé d'application :

- **php artisan key:generate**
- les parametres de la bd si necessaire (sqlite par defaut)
- faites **php artisan migrate** pour migrer la BD
- faites **php artisan db:seed** pour initier les parametres par defaut
- faites **php artisan schedule:work** pour executer les taches chron hebdomadaires necessaires au bon fonctionnement du projet 



