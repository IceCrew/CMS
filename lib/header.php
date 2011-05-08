<?php
echo '<a name="top"></a><a href="index.php?page=Index"><font color=\"#0000FF\">Index</font></a> | <a href="index.php?page=News"><font color=\"#0000FF\">Alle News</font></a> | <a href="index.php?page=Posts"><font color=\"#0000FF\">Alle Posts</font></a> | <a href="index.php?page=Downloads"><font color=\"#0000FF\">Alle Downloads</font></a>';
@session_start();
require('config.php');
include_once "class.mysql.php";
$mysql->query("Select admin from accounts WHERE username = '".$_SESSION[$sitename.'_adm_user_username']."' and admin = '1'", array());
$rows = mysql_num_rows($mysql->result);
if($rows == 1) { 
echo " | <a href=\"index.php?page=Administration\"><font color=\"#0000FF\">Adminpanel</font></a>";
}
if(!isset($_SESSION[$sitename.'_all_user_id'])) {
echo " | <a href=\"index.php?page=Login\"><font color=\"#0000FF\">Einloggen</font></a> oder <a href=\"index.php?page=Register\"><font color=\"#0000FF\">Registrieren</font></a>";
}
else {
echo " | <a href=\"index.php?page=Hilfe\"><font color=\"#0000FF\">Hilfe</font></a> | <a href=\"index.php?page=Login&ID=logout\"><font color=\"#0000FF\">Ausloggen</font></a>";
}
echo " | <a href=\"index.php?page=Impressum\"><font color=\"#0000FF\">Impressum</font></a><hr>";
?>