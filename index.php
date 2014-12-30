<?php
######################################################################
# Alex-MySQL-Backup-Script v0.1 ALPHA
#
# Script de sauvegarde de BDD entière
# Veuillez ajouter une tâche CRON pour le rendre automatique
######################################################################

// Renseignez les informations de connexion à la base de donnée 
// (se trouvent en général dans le fichier config.php de votre site)

#Adresse de connexion au serveur MySQL
$host = "localhost";
#Nom d'utilisateur MySQL
$user = "root";
#Mot de passe MySQL
$pass = "toor";
#Nom de la base de donnée MySQL
$db = "testDB";

// Autres paremètres (Ne pas modifier si on est pas sûr de ses actes)

#Paramètres de la date
$date = date('d-m');
#Nom du fichier
$file = "/home/obsidia3/public_html/save-'$date'.sql";

######################################################################

// Requêtes SQL et création du fichier
// NE PAS MODIFIER
$result = mysql_connect("$host", "$user", "$pass")
or die("Impossible de se connecter : " . mysql_error());
$result = mysql_query(SELECT '$db' INTO OUTFILE '$file' FROM `wp_commentmeta`, `wp_comments`, `wp_links`, `wp_options`, `wp_postmeta`, `wp_posts`, `wp_terms`, `wp_term_relationships`, `wp_term_taxonomy`, `wp_usermeta`, `wp_users`);

######################################################################

// API et envoi du fichier sur Dropbox
// NE PAS MODIFIER

/* COMING SOON */

?>