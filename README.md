Projet Vierge Symfony
========================

### Actions réalisées

- Suppression du bundle AppBundle dans le répertoire src
- Supprimer l’appel du bundle Appbundle dans le AppKernel.php
- Suppression de la route app dans routing.yml
- Suppression du répertoire default dans app/Ressources/views
- Mettre en commentaire les services liés à AppBundle


### À faire lors de la création d'un bundle

- Suppression du fichier DefaultController.php dans src/monBundle/Controller
- Suppression du dossier Default dans src/monBundle/Ressources/views
- Modifier le composer.json : "AppBundle\\": "src/AppBundle" --> "": "src/"
- Effectuer la commande: >composer dump-autoload
