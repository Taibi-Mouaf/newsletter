-MAILER_DSN utilisé: mailtrap.
-Lancez la migration : php bin/console d:m:m # Créer les tables
-Lancez la fixture : php bin/console d:f:l --no-interaction # Ajouté les types de newsletter
-Lancez le serveur interne : php bin/console s:r 
-Lancez le messenger : php bin/console messenger:consume async -vv 

-#Ajouter le port 8000 après localhost.
