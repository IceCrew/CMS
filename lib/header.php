<?php
echo '<form action="?page=Login" method="post">';
echo '<a name="top"></a><a href="?page=Index"><font color=\"#0000FF\">Index</font></a> | <a href="?page=News"><font color=\"#0000FF\">Alle News</font></a> | <a href="?page=Posts"><font color=\"#0000FF\">Alle Posts</font></a> | <a href="?page=Downloads"><font color=\"#0000FF\">Alle Downloads</font></a>';
require('config.php');
if(isset($_COOKIE[$cp.'_admin_id'])) { 
echo " | <a href=\"?page=Administration\"><font color=\"#0000FF\">Adminpanel</font></a>";
}
if(!isset($_COOKIE[$cp.'_user_id'])) {
echo ' | ID: <input type="text" name="id" size="20"> 
Passwort: <input type="password" name="pwd" size="20">
<select name="cookietime">
<option value="1">1 Tag</option>
<option value="7">1 Woche</option>
<option value="30">1 Monat</option>
<option value="365">1 Jahr</option>
</select>
<input type="submit" value="Login" name="postlogin">  
<a href="?page=Register"><font color="#0000FF">Noch kein Konto?</font></a>';
}
else {
echo " | <a href=\"?page=Hilfe\"><font color=\"#0000FF\">Hilfe</font></a> | <a href=\"?page=Login&ID=logout\"><font color=\"#0000FF\">Ausloggen (".$_COOKIE[$cp.'_user_name'].")</font></a>";
}
echo " | <a href=\"?page=Impressum\"><font color=\"#0000FF\">Impressum</font></a><hr>";
echo "</form>";
?>