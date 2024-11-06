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

## Fonctionnement du système de  liste d'attente de réservation actuel

### 1. Validation automatique de la réservation :
Une réservation est automatiquement validée si elle est la première de la semaine pour l'utilisateur qui la réalise.  
Dans ce cas, les paramètres suivants sont définis :
- **Attente** : 0
- **Niveau d'attente** : 0

### 2. Placement sur liste d'attente :
Si la réservation n'est pas la première de la semaine pour cet utilisateur, il sera placé sur une liste d'attente.  
Dans ce cas, les paramètres suivants sont appliqués :
- **Attente** : 1
- **Niveau d'attente** : 1

L'utilisateur restera en attente jusqu'à 24 heures avant la séance. À ce moment-là, en fonction de sa position sur la liste d'attente et du nombre de places restantes, sa réservation passera de :
- **Attente** : 1
- **Niveau d'attente** : 1  
  à :
- **Attente** : 0
- **Niveau d'attente** : 0

### 3. Indicateurs de réservation :
Les variables **"réservations validées"** et **"réservations en attente"** permettent à l'utilisateur de connaître sa position sur la liste d'attente.
 

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

#  ROUTES LIEES AUX NOTIFICATIONS 

---



## Route `notifications`

Cette route permet de récupérer toutes les notifications de l'utilisateur connecté.

- **Méthode HTTP**: `GET`
- **Endpoint**: `/notifications`

### En-tête:
- `Authorization`: Token de connexion. Exemple: `Bearer token(gjjgvjhvhjgvhjgvjhvjh)`.

### Réponses:
- Une liste des notifications (lues et non lues) de l'utilisateur connecté.

---

## Route `notifications/unread`

Cette route permet de récupérer uniquement les notifications non lues de l'utilisateur connecté.

- **Méthode HTTP**: `GET`
- **Endpoint**: `/notifications/unread`

### En-tête:
- `Authorization`: Token de connexion. Exemple: `Bearer token(gjjgvjhvhjgvhjgvjhvjh)`.

### Réponses:
- Une liste des notifications non lues de l'utilisateur connecté.

---

## Route `notifications/{id}/read`

Cette route permet de marquer une notification spécifique comme lue.

- **Méthode HTTP**: `POST`
- **Endpoint**: `/notifications/{id}/read`

### En-tête:
- `Authorization`: Token de connexion. Exemple: `Bearer token(gjjgvjhvhjgvhjgvjhvjh)`.

### Paramètres:
- `id`: L'ID de la notification à marquer comme lue.

### Réponses:
- Confirmation que la notification a été marquée comme lue.
- Si la notification n'est pas trouvée, un message d'erreur sera renvoyé.



---




Voici la section 2 révisée dans son intégralité, avec l’étude des variations, des asymptotes, et les moments de la distribution.

---

### 2. **Caractéristiques Mathématiques de la Loi Normale**

**Fonction de densité de probabilité (fdp)**  
La loi normale est définie par une fonction de densité de probabilité (fdp) qui permet de modéliser la probabilité d’observer une certaine valeur pour une variable aléatoire. Cette fonction est donnée par la formule suivante :

\[
f(x) = \frac{1}{\sigma \sqrt{2\pi}} e^{-\frac{(x - \mu)^2}{2\sigma^2}}
\]

Où :
- **μ** est la moyenne (le centre de la distribution),
- **σ** est l’écart-type (qui mesure la dispersion des données),
- **x** est la variable aléatoire.

**Interprétation simple :**  
Cette formule montre que la probabilité d’observer une valeur \( x \) est d’autant plus élevée que cette valeur est proche de la moyenne \( μ \). Inversement, plus \( x \) s’éloigne de \( μ \), plus la probabilité d’observer cette valeur diminue rapidement. Ce comportement se traduit graphiquement par une courbe en cloche.

---

**Étude de la fonction de densité**  

1. **Comportement de la fonction** :
   - La fonction \( f(x) \) atteint son maximum en \( x = μ \), indiquant que la valeur la plus probable est la moyenne.
   - La fonction décroît à mesure que \( x \) s’éloigne de \( μ \), reflétant la baisse de probabilité pour les valeurs éloignées de la moyenne.

2. **Asymptotes** :
   - La fonction de densité de probabilité n’a pas d’asymptotes classiques. Bien que les valeurs de \( f(x) \) deviennent très proches de zéro pour \( x \) tendant vers l’infini (à droite et à gauche), la fonction n’atteint jamais exactement zéro. Cela signifie qu'il existe toujours une probabilité non nulle, même pour des valeurs extrêmes, mais celle-ci est très faible.

3. **Calcul des dérivées** :
   - La première dérivée de la fonction de densité, \( f'(x) \), permet d’analyser les variations de la fonction :
     \[
     f'(x) = -\frac{(x - \mu)}{\sigma^2} f(x)
     \]
   - La dérivée est nulle lorsque \( x = μ \), ce qui indique un maximum local en ce point.
   - Elle est négative pour \( x > μ \) et positive pour \( x < μ \), confirmant que la fonction est croissante jusqu’à \( μ \) et décroissante au-delà. Cela montre la symétrie parfaite autour de la moyenne.

4. **Visualisation et points d’inflexion** :
   - En traçant la fonction \( f(x) \), on obtient une courbe symétrique en forme de cloche centrée autour de \( μ \).
   - Les points d’inflexion, où la concavité de la courbe change, se trouvent aux abscisses \( μ - σ \) et \( μ + σ \). Ces points marquent les endroits où la pente de la courbe diminue plus lentement, indiquant que la majeure partie des données se trouve entre ces points.

---

**Courbe en cloche**  
La courbe de la loi normale, également appelée **courbe en cloche**, présente plusieurs caractéristiques :
- **Symétrie** : La courbe est parfaitement symétrique autour de la moyenne \( μ \).
- **Concentration des valeurs** : Dans une distribution normale, les valeurs sont concentrées autour de la moyenne. Les probabilités de s’éloigner significativement de la moyenne sont faibles.
- **68-95-99,7%** : Un principe fondamental de la loi normale est que :
  - Environ 68 % des valeurs se situent à moins d’un écart-type \( σ \) de la moyenne \( μ \),
  - Environ 95 % des valeurs se trouvent à moins de deux écarts-types,
  - Environ 99,7 % des valeurs se trouvent à moins de trois écarts-types.

---

**Moments de la distribution**  
Les moments d’une distribution sont des paramètres statistiques qui caractérisent sa forme. Dans le cas de la loi normale, les moments les plus importants sont les suivants :

- **La moyenne (μ)** : C’est le premier moment, et il indique le centre de la distribution, autour duquel les données sont symétriquement réparties.
- **La variance (σ²)** : Le deuxième moment, qui mesure la dispersion des valeurs autour de la moyenne. L’écart-type \( σ \) est la racine carrée de la variance et détermine la largeur de la courbe.
- **L’asymétrie (skewness)** : La loi normale est parfaitement symétrique, donc son coefficient d’asymétrie est nul. Dans des distributions asymétriques, ce coefficient serait différent de zéro.
- **La kurtose (kurtosis)** : Ce moment décrit la forme des queues de la distribution. La loi normale a une kurtose de 3, ce qui signifie que ses queues ne sont ni trop épaisses (plus de valeurs extrêmes) ni trop fines (moins de valeurs extrêmes).

---

### Objectif de cette section :
- Comprendre les bases mathématiques de la loi normale en analysant la fonction de densité de probabilité.
- Explorer les variations de la fonction de densité pour mieux visualiser la courbe en cloche.
- Appréhender les moments de la distribution pour décrire des caractéristiques clés comme la moyenne, la variance et l’asymétrie.

---

Cette section intègre une étude complète des caractéristiques mathématiques, des variations de la fonction de densité, et des moments de la distribution. Est-ce que cela correspond à ce que tu souhaitais pour la partie 2 ?

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



