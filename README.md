API Laravel - Guide d'utilisation
Ce document fournit un guide d'utilisation pour interagir avec l'API Laravel. 
L'API offre plusieurs fonctionnalités,  l'envoi d'OTP, l'inscription, la connexion et la gestion des réservations.


/***********************************************************************************************************************/
///////**********************************Route otp_request*******************************/
/**********************************************************************************************************/
Cette route permet de demander l'envoi d'un OTP (One-Time Password) pour un email donné.

Méthode HTTP: POST
Endpoint: /otp_request

Paramètres de la requête:
email: L'adresse e-mail de l'utilisateur.

Réponses:
Code 200: OTP envoyé avec succès.
Code 400: Différents messages en fonction de l'erreur interne ou si l'utilisateur est déjà inscrit.






/***********************************************************************************************************************/
///////**********************************Route otp_validate *******************************/
/**********************************************************************************************************/
Cette route permet de valider un OTP pour un email donné.

Méthode HTTP: POST
Endpoint: /otp_validate

Paramètres de la requête:
email: L'adresse e-mail de l'utilisateur.
otp: Le One-Time Password à valider.

Réponses:Messages différents selon la validité de l'OTP renseigné.





/***********************************************************************************************************************/
///////**********************************Route register*******************************/
/**********************************************************************************************************/
Cette route permet à un utilisateur de s'inscrire en fournissant un email, un matricule et un mot de passe.

Méthode HTTP: POST
Endpoint: /register


Paramètres de la requête:
email: L'adresse e-mail de l'utilisateur.
matricule: Le matricule de l'utilisateur.
password: Le mot de passe de l'utilisateur.
Réponses:
Message différent en fonction du succès ou de l'échec de l'inscription.





/***********************************************************************************************************************/
///////**********************************Route login*******************************/
/**********************************************************************************************************/
Cette route permet à un utilisateur de se connecter en fournissant un email et un mot de passe.

Méthode HTTP: POST
Endpoint: /login

Paramètres de la requête:
email: L'adresse e-mail de l'utilisateur.
password: Le mot de passe de l'utilisateur.

Réponses:
Code 200 avec les données utilisateur et un token de connexion en cas de succès.
Code 403 avec un message approprié en cas d'erreur (utilisateur non trouvé ou mot de passe incorrect).





/***********************************************************************************************************************/
///////**********************************Route booking_params*******************************/
/**********************************************************************************************************/
Cette route permet d'obtenir les paramètres de réservation pour une semaine donnée.

Méthode HTTP: POST
Endpoint: /booking_params

Paramètres de la requête:
semaine: Le numéro de la semaine pour laquelle effectuer la requête.


En-tête:
Authorization: Token de connexion précédemment retourné. "Bearer token(gjjgvjhvhjgvhjgvjhvjh)"

Réponses:
La semaine, la limite, les heures réservables, les heures non réservables et les heures réservées.






/***********************************************************************************************************************/
///////**********************************Route booking_process*******************************/
/**********************************************************************************************************/
Cette route permet de gérer le processus de réservation.

Méthode HTTP: POST
Endpoint: /booking_process
Paramètres de la requête:

semaine: Le numéro de la semaine pour laquelle effectuer la requête.
add: Tableau des heures à réserver.
delete: Tableau des réservations à annuler.


En-tête:
Authorization: Token de connexion précédemment retourné. "Bearer token(gjjgvjhvhjgvhjgvjhvjh)"

Réponses:
La semaine, la limite, les heures réservables, les heures non réservables et les heures réservées.



Utilisez ces routes avec les méthodes HTTP appropriées et les paramètres requis pour interagir avec l'API et accéder à ses fonctionnalités.
Assurez-vous d'inclure les en-têtes nécessaires, notamment pour l'authentification avec le token retourné lors de la connexion.
Pour toute question ou assistance supplémentaire, veuillez vous référer à la documentation de l'API ou contacter le support technique.



/********************************************************************************************************************************************************/
/***********************************************************************************************************************************************************/
/******************************INSTALLATION DES DEPENDANCES ET DEMARAGE DU PROJET **************************************************************/
/***************************************************************************************************************************************/
/**********************************************************************************************************************************************************************/





Installation des dépendances :

Accédez au répertoire du projet cloné via le terminal.
Exécutez la commande composer install pour installer les dépendances PHP.
Configuration de l'environnement :

Dupliquez le fichier .env.example et renommez-le en .env.
Configurez votre base de données dans le fichier .env.


configurez egalement votre smtp pour simuler l'envoi des mails dans le fichier .env 


Générez une nouvelle clé d'application en utilisant la commande php artisan key:generate.
Exécution des migrations 
/******************************IMPORTANT**************************************************************/
/*******************************************************************************************************************/
/*************************************************************************************************************************************/
Exécutez les migrations pour créer les tables de base de données avec la commande php artisan migrate--path=chemin.
avec respectivement les chemins des fichiers de migrations 
hour_slot
free_hour
student 
admin
puis executer le reste des migrations avec php artisan migrate

/************************************************IMPORTANT*****************************************************************************/
/*******************************************************************************************************************/
/*******************************************************************************************************************/

EXECUTER LA COMMANDE PHP ARTISAN SCHEDULE:WORK PUIS ARRETER SON EXECUTION APRES LE PREMIER SUCCCESS 
elle va executer les taches chron hebdomadaires necessaires au bon fonctionnement du projet 



Lancement du serveur de développement :

Utilisez la commande php artisan serve pour démarrer le serveur de développement.
Vous devriez voir un message confirmant que le serveur est en cours d'exécution, généralement sur http://localhost:8000.
Accéder à l'application dans le navigateur :

Ouvrez votre navigateur Web et accédez à l'URL fournie par le serveur de développement (par défaut, http://localhost:8000).
#   I n t e l l i G y m  
 