<a name="top"></a><a href="index.php">Index</a> | <a href="index.php?news">Alle News</a> | <a href="index.php?posts">Alle Posts</a>
<?
session_start();
require('config.php');
include_once "class.mysql.php";
$mysql->query("Select admin from accounts WHERE username = '".$_SESSION[$sitename.'_adm_user_username']."' and admin = '1'", array());
$rows = mysql_num_rows($mysql->result);
if($rows == 1) { 
echo " | <a href=\"admin.php\">Adminpanel</a>";
}
if(!isset($_SESSION[$sitename.'_all_user_id'])) {
echo " | <a href=\"login.php\">Einloggen</a> oder <a href=\"login.php?mode=register\">Registrieren</a>";
}
else {
echo " | <a href=\"index.php?help\">Hilfe</a> | <a href=\"login.php?mode=logout\">Ausloggen</a>";
}
?>
<hr>