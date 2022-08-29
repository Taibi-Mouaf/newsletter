-MAILER_DSN utilisé: mailtrap.(Créer une boite mail sur mailtrap pour avoir le Symfony mailer DSN)  
-Lancez la migration : php bin/console doctrine:migrations:migrate # Créer les tables  
-Lancez la fixture : php bin/console d:f:l --no-interaction # Ajouté les types de newsletter  
-Lancez le serveur interne : php bin/console s:r   
-Lancez le messenger : php bin/console messenger:consume async -vv   

-#Ajouter le port 8000 après localhost.  
