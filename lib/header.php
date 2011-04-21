<a href="index.php">Index</a> | <a href="index.php?news">Alle News</a> | <a href="index.php?posts">Alle Posts</a>
<?
session_start();
include 'config.php';
include 'mysql.php';
$sql = ("Select admin from accounts WHERE username = '".$_SESSION['adm_user_username']."' and admin = '1'");
$result = mysql_query($sql);
$rows = mysql_num_rows($result);
if($rows == 1) { 
echo " | <a href=\"admin.php\">Adminpanel</a>";
}
if(!isset($_SESSION['all_user_id'])) {
echo " | <a href=\"login.php\">Einloggen</a> oder <a href=\"login.php?mode=register\">Registrieren</a>";
}
else {
echo " | <a href=\"index.php?help\">Hilfe</a> | <a href=\"login.php?mode=logout\">Ausloggen</a>";
}
?>
<hr>