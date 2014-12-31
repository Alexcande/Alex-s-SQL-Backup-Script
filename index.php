<?php
######################################################################
# Alex-MySQL-Backup-Script v0.8 ALPHA
#
# Script de sauvegarde de BDD entière
# Veuillez ajouter une tâche CRON pour le rendre automatique
# Veuillez aussi visiter la page install-dbx.php avec votre navigateur et editer le fichier app-info.json
######################################################################

// Renseignez les informations de base
// (se trouvent en général dans le fichier config.php de votre site)

#Adresse de connexion au serveur MySQL
$host = "localhost";
#Nom d'utilisateur MySQL
$user = "root";
#Mot de passe MySQL
$pass = "toor";
#Nom de la base de donnée MySQL
$db = "testDB";

#Activer l'envoi sur Dropbox (true ou false)
$dbxon = "false";
#Token Dropbox obtenu dans install-dbx.php
$accessToken = "YOUR_ACCESS_TOKEN";


######################################################################

// Requêtes SQL et création du fichier
// NE PAS MODIFIER

function backup_tables($host,$user,$pass,$db,$tables = '*')
{
	
$link = mysql_connect($host,$user,$pass);
mysql_select_db($db,$link);
	
	if($tables == '*')
	{
		$tables = array();
		$result = mysql_query('SHOW TABLES');
		while($row = mysql_fetch_row($result))
		{
			$tables[] = $row[0];
		}
	}
	else
	{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	
	foreach($tables as $table)
	{
		$result = mysql_query('SELECT * FROM '.$table);
		$num_fields = mysql_num_fields($result);
		
		$return.= 'DROP TABLE '.$table.';';
		$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
		$return.= "\n\n".$row2[1].";\n\n";
		
		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = mysql_fetch_row($result))
			{
				$return.= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j<$num_fields; $j++) 
				{
					$row[$j] = addslashes($row[$j]);
					$row[$j] = ereg_replace("\n","\\n",$row[$j]);
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j<($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}
	
	$handle = fopen('backup-'.date(d-m-Y).'.sql','w+');
	fwrite($handle,$return);
	fclose($handle);
}

######################################################################

// Envoi du fichier sur Dropbox
// NE PAS MODIFIER

if($dbxon == "true")
	{
	require_once "dropbox-sdk/Dropbox/autoload.php";
	use \Dropbox as dbx;
	$dbxClient = new dbx\Client($accessToken, "PHP-Example/1.0");
	$f = fopen('backup-'.date(d-m-Y).'.sql', 'rb');
	$result = $dbxClient->uploadFile('/save/'.date(d-m-Y).'.sql', dbx\WriteMode::add(), $f);
	$closing = fclose($f);
	}
else
	{
# Fonction d'upload desactivée
	}
?>