project
=======

A Symfony project created on January 4, 2017, 3:32 pm.

# Installation du projet
Commandes à exécuter sur le shell :
1) git clone https://github.com/karineould/ydays
2) composer install (Péalablement avoir [Composer](https://getcomposer.org/) et PHP)

# Configuration local 
Créer un fichier parameter.yml dans /app/config/
Nous ne fournissons pas ce fichier car il contient des informations sensibles telles que des mots de passe
Le fichier doit contenir les informations suivantes 
*********************************************************
```yaml
parameters:
    database_host: $host_ou_$ip
    database_port: $port
    database_name: $nom_de_la_base
    database_user: $user_mysql
    database_password: $password_mysql
    secret: $token_random
    mailer_transport: smtp
    mailer_encryption : ssl
    mailer_host: smtp.gmail.com
    mailer_auth_mode : login
    mailer_port : 465
    mailer_user : $email_company
    mailer_password : $password_email
 ``` 
*********************************************************
Attention: il faut autoriser l'adresse email a envoyer des mails depuis une connexion distante.

# mapping avec la base de données et création des fichers xml 
```shell
php bin/console doctrine:mapping:convert annotation ./src/TimeProjectBundle/Resources/config/doctrine/metadata/orm --from-database --force
```
# Import the structure
```shell
php bin/console doctrine:mapping:import TimeProjectBundle annotation
```

# Generate Entities file class
```shell
php bin/console doctrine:generate:entities TimeProjectBundle 
```

# mettre à jour la base de données selon les entités existants
```shell
php bin/console doctrine:schema:update --force --complete
```

# vider le cache
```shell
php bin/console cache:clear
```
