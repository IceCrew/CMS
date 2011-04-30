<?php
include "lib/config.php";
include "lib/header.php";
include_once "lib/class.mysql.php";
session_start (); 
?> 
<html>  
<body>  
<?if(isset($_GET["error"]))  
{  
  echo "Die Zugangsdaten waren ungültig.";  
}
if(empty($_GET)) {  
?>
<title>Login - <? echo $sitename ?></title>
<form action="login.php?mode=login" method="post">  
Benutzername: <input type="text" name="name" size="20"><br>  
Passwort: <input type="password" name="pwd" size="20"><br>  
<input type="submit" value="Login" name="postlogin">  
</form>  
</body>  
</html>
<?php
}
if(isset($_GET['mode'])) {   
$mode = $_GET['mode'];
if($mode == 'login') {
session_start ();   

$mysql->query("SELECT ".  
    "id, username, password ".  
  "FROM ".  
    "accounts ".  
  "WHERE ".  
    "(username like '".$_POST["name"]."') AND ".  
    "(password = '".sha1($_POST["pwd"])."')", array());  

if (mysql_num_rows ($mysql->result) > 0)  
{   
$data = mysql_fetch_array ($mysql->result);  
$mysql->query("Select admin from accounts WHERE username = '".$_POST['name']."' and admin = '1'", array());
$rows = mysql_num_rows($mysql->result);
if($rows == 1) { 
  $_SESSION["adm_user_id"] = $data["id"];  
  $_SESSION["adm_user_username"] = $data["username"];
  $_SESSION["all_user_id"] = $data["id"];
  $_SESSION["all_user_username"] = $data["username"];

  header ("Location: admin.php");  
}
elseif($rows == 0) {
  $_SESSION["user_id"] = $data["id"];  
  $_SESSION["user_username"] = $data["username"];
  $_SESSION["all_user_id"] = $data["id"];
  $_SESSION["all_user_username"] = $data["username"];
  
  header ("Location: index.php");
}
} 
else  
{  
  header ("Location: login.php?error");  
}
} 
if($mode == 'logout') {   
ob_start ();  

session_start ();  
session_unset ();  
session_destroy ();  

header ("Location: index.php");  
ob_end_flush ();  
}
if($mode == 'register') {
?>
<title>Registrierung - <? echo $sitename ?></title>
<form action="login.php?mode=register" method="post">
Benutzername: <input type="text" name="username" width="20"><br>
Passwort: <input type="password" name="password" width="20"><br>
<input type="submit" name="register" value="Registrieren">
</form>
<?php
if(isset($_POST['register'])) {
$user = $_POST['username'];
$pw = sha1($_POST['password']);
$sql = "Select username from accounts WHERE username = '".$user."'";
$mysql->query($sql, array());
$rows = mysql_num_rows($mysql->result);
if($rows == 1) {
echo "Der Benutzername wird bereits verwendet!";
}
if($rows == 0) {
$mysql->query("INSERT INTO accounts (username, password, admin) VALUES ('".$user."', '".$pw."', '0')", array()) or die ("Fehler beim erstellen des Benutzers!");
echo "User wurde erstellt!";
}
}
}
} 
echo "<hr>".$footer;
?>