Question 1:
symfony check:requirements = permet de vérifier si notre environnement est bien configuré pour travailler avec Symfony.

Elle vérifie notamment la version de PHP et la présence des extensions nécessaires.

Les avertissements peuvent concerner :
- Une version de PHP non compatible.
- Des extensions PHP manquantes.
- Une mauvaise configuration de l'environnement

  Question 2:
  Le dossier public/ contient les fichiers accessibles directement depuis le navigateur, comme les images, les fichiers CSS et JavaScript
  Il contient également le fichier index.php, qui est le point d'entrée de notre application Symfony. C'est par ce fichier que passent les requêtes envoyées par le navigateur avant d'être traitées par Symfony.

  Question 3:
  La variable qui contrôle le mode de fonctionnement de Symfony est APP_ENV
  APP_ENV=dev

  Question 4:
  Que se passe-t-il si vous accédez à /profil/abc ? Pourquoi ?

Si on accède à l'adresse /profil/abc, Symfony affiche une erreur 404 (Page Not Found)
  
