project
=======

A Symfony project created on January 4, 2017, 3:32 pm.

Config Apache : MAMP ou WAMP

1) chercher le fichier httpd_vhosts.conf qui se surement dans le répertoire conf/extra et rajouter ceci :

<VirtualHost *:8888>
    DocumentRoot "/Applications/MAMP/htdocs"
    ServerName localhost
</VirtualHost>

<VirtualHost *:8888>
    DocumentRoot "/Users/Janany/Documents/M1/Ydays/appli/ydays/web"
    ServerName y-days-projet
    <Directory "/Users/Janany/Documents/M1/Ydays/appli/ydays/web">
        AllowOverride all
    </Directory>
</VirtualHost>

2) dans le fichier httpd.conf dans le répertoire conf/

décommenter la ligne : Include /Applications/MAMP/conf/apache/extra/httpd-vhosts.conf



Commandes à exécuter sur le shell :
1) git clone https://github.com/karineould/ydays
2) composer install