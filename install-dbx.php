<?php
require_once "dropbox-sdk/Dropbox/autoload.php";
use \Dropbox as dbx;
$appInfo = dbx\AppInfo::loadFromJsonFile("app-info.json");
$webAuth = new dbx\WebAuthNoRedirect($appInfo, "PHP-Example/1.0");

$authorizeUrl = $webAuth->start();
echo "1. Go to: " . $authorizeUrl . "\n <p>";
echo "2. Click \"Allow\" (you might have to log in first).\n <p>";
echo "3. Copy the authorization code.\n <p>";
$authCode = \trim(\readline("Enter the authorization code here: "));
list($accessToken, $dropboxUserId) = $webAuth->finish($authCode);
print "Access Token: " . $accessToken . "\n";
echo "Please copy this code safely";
?>