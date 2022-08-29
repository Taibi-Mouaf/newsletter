MAILER_DSN used mailtrap.
Lancez la migration : php bin/console d:m:m
Lancez la fixture : php bin/console d:f:l --no-interaction
Lancez le serveur interne : php bin/console s:r
Lancez le messenger : php bin/console messenger:consume async -vv