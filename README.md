# API Intelligym - Guide d'Utilisation

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













### La Loi Multinomiale : Exposé

#### Introduction : Historique

La loi multinomiale est une extension de la loi binomiale et appartient à une famille de distributions de probabilité qui traitent des événements discrets et multiples. Le développement de la loi multinomiale remonte aux travaux pionniers en probabilité et statistique des mathématiciens du XVIIe siècle, notamment ceux de Jakob Bernoulli et Abraham de Moivre, qui ont d'abord formulé la loi binomiale. Ces premières découvertes ont permis de mieux comprendre des situations où un événement pouvait se produire de deux façons (succès ou échec). 

Au XIXe siècle, avec le développement des statistiques et des sciences sociales, la nécessité d'une extension de la loi binomiale a émergé, car de nombreux phénomènes de la vie réelle impliquent plusieurs issues possibles. Francis Galton et Karl Pearson ont contribué à développer des outils statistiques pour traiter des situations comportant plus de deux catégories d'événements. La loi multinomiale est ainsi devenue fondamentale pour modéliser des situations de choix multiples, par exemple, dans les sondages d'opinion, les classifications en sciences naturelles, et plus récemment, les applications d'intelligence artificielle (IA) et d'analyse de données (BD). Elle est donc cruciale pour analyser des échantillons et prévoir la probabilité de résultats multiples dans des expériences répétées.

---

### I - Exemple de Problème Illustratif

Supposons que l'on réalise une enquête dans une ville sur le choix de transport quotidien des habitants parmi quatre options : voiture, vélo, transports en commun et marche. L’objectif est de modéliser les résultats d’un échantillon de 100 personnes. Si l'on connaît les probabilités de choix pour chaque moyen de transport (par exemple, 40 % pour la voiture, 20 % pour le vélo, 30 % pour les transports en commun, et 10 % pour la marche), on souhaite prédire la distribution des résultats pour cet échantillon.

La loi multinomiale nous permet de calculer la probabilité d’observer exactement 40 personnes utilisant la voiture, 20 utilisant le vélo, 30 utilisant les transports en commun et 10 marchant. Cet exemple montre bien l’utilité de la loi multinomiale dans des contextes où plusieurs catégories exclusives sont présentes et où l’on s’intéresse aux fréquences de chaque catégorie sur un ensemble d'observations répétées.

---

### II - Loi Binomiale : Une Première Approche

Avant de passer à la loi multinomiale, il est nécessaire de comprendre la loi binomiale, dont elle est une extension. La loi binomiale concerne une situation où il n'y a que deux issues possibles pour chaque essai : par exemple, succès/échec ou vrai/faux. 

#### Formule de la Loi Binomiale

La loi binomiale modélise le nombre de succès dans une séquence de \(n\) essais indépendants, où chaque essai a deux résultats possibles avec une probabilité de succès constante \(p\). Si \(X\) représente le nombre de succès dans \(n\) essais, alors \(X\) suit une loi binomiale, notée \(X \sim B(n, p)\), et la probabilité de réaliser exactement \(k\) succès est donnée par la formule :

\[
P(X = k) = \binom{n}{k} p^k (1 - p)^{n - k}
\]

où \( \binom{n}{k} \) est le coefficient binomial, donné par \(\frac{n!}{k!(n-k)!}\).

Cette loi s'applique dans des cas comme les lancés de pièces ou les tests de succès/échec, où l’on observe la probabilité d’obtenir un certain nombre de succès sur un nombre fixe d’essais indépendants.

---

### III - La Loi Multinomiale : Extension de la Loi Binomiale

La loi multinomiale est une généralisation de la loi binomiale pour des expériences comportant plus de deux issues possibles. Plutôt que de modéliser les probabilités de succès et d’échec, elle traite les cas où un essai peut donner lieu à \(k\) résultats possibles, avec des probabilités respectives \((p_1, p_2, \dots, p_k)\), et où \( \sum_{i=1}^k p_i = 1 \).

Dans le contexte de notre exemple d’enquête de transport, la loi multinomiale permet de calculer la probabilité d'observer une distribution spécifique pour les choix des individus parmi les quatre options.

#### Formule de la Loi Multinomiale

Soit \(X_1, X_2, \dots, X_k\) le nombre d'occurrences de chaque catégorie (ou résultat) dans un échantillon de \(n\) observations, où \(X_1 + X_2 + \dots + X_k = n\). Si chaque observation a une probabilité de tomber dans la catégorie \(i\) égale à \(p_i\), alors la probabilité d'observer exactement \(x_1, x_2, \dots, x_k\) dans chaque catégorie est donnée par :

\[
P(X_1 = x_1, X_2 = x_2, \dots, X_k = x_k) = \frac{n!}{x_1! x_2! \dots x_k!} p_1^{x_1} p_2^{x_2} \dots p_k^{x_k}
\]

Dans cette formule :
- \(n!\) est le nombre total de permutations possibles pour les \(n\) observations,
- \(x_i!\) est le nombre de façons d'ordonner les observations dans la catégorie \(i\),
- \(p_i^{x_i}\) est la probabilité d'observer \(x_i\) occurrences de la catégorie \(i\).

Ainsi, cette loi permet de calculer les probabilités pour des situations multi-catégories, où l’on s'intéresse aux fréquences exactes de chaque catégorie sur un ensemble d'essais indépendants.

---

### Conclusion : Applications en Informatique et en Intelligence Artificielle

La loi multinomiale est largement utilisée en informatique, et en particulier dans l’intelligence artificielle et l’analyse de données, pour modéliser des situations de classification et de choix multiples. Dans les bases de données, elle permet de prédire la répartition des données en fonction de catégories prédéfinies, ce qui est utile pour des analyses de marché, des sondages, et des études de comportement.

En intelligence artificielle, et notamment dans les modèles de traitement du langage naturel (NLP), la loi multinomiale est essentielle pour modéliser des distributions de mots dans des documents. Elle permet de prédire la probabilité d'occurrence de certains mots ou phrases dans un texte, ce qui est une base pour des algorithmes de classification de texte, d'analyse de sentiment, et même de génération automatique de texte. Dans les réseaux bayésiens, la loi multinomiale est utilisée pour estimer les distributions de probabilité dans les modèles de classification supervisée, comme dans le cas du classifieur naïf bayésien, qui repose sur une distribution multinomiale pour la probabilité des mots dans chaque catégorie.

En somme, la loi multinomiale est un outil statistique puissant qui trouve des applications pratiques dans des domaines variés de l’informatique. Elle permet non seulement d’analyser des données multi-catégories, mais aussi de développer des modèles d’IA capables de traiter des informations complexes et variées.
