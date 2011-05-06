<?php
echo '<a name="top"></a><a href="index.php?page=Index">Index</a> | <a href="index.php?page=News">Alle News</a> | <a href="index.php?page=Posts">Alle Posts</a> | <a href="index.php?page=Downloads">Alle Downloads</a>';
@session_start();
require('config.php');
include_once "class.mysql.php";
$mysql->query("Select admin from accounts WHERE username = '".$_SESSION[$sitename.'_adm_user_username']."' and admin = '1'", array());
$rows = mysql_num_rows($mysql->result);
if($rows == 1) { 
echo " | <a href=\"index.php?page=Administration\">Adminpanel</a>";
}
if(!isset($_SESSION[$sitename.'_all_user_id'])) {
echo " | <a href=\"index.php?page=Login\">Einloggen</a> oder <a href=\"index.php?page=Register\">Registrieren</a> | <a href=\"index.php?page=Impressum\">Impressum</a><hr>";
}
else {
echo " | <a href=\"index.php?page=Hilfe\">Hilfe</a> | <a href=\"index.php?page=Login&ID=logout\">Ausloggen</a> | <a href=\"index.php?page=Impressum\">Impressum</a><hr>";
}
?>