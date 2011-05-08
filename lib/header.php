<?php
echo '<a name="top"></a><a href="index.php?page=Index"><font color=\"#0000FF\">Index</font></a> | <a href="index.php?page=News"><font color=\"#0000FF\">Alle News</font></a> | <a href="index.php?page=Posts"><font color=\"#0000FF\">Alle Posts</font></a> | <a href="index.php?page=Downloads"><font color=\"#0000FF\">Alle Downloads</font></a>';
require('config.php');
if(isset($_COOKIE[$cp.'_admin_id'])) { 
echo " | <a href=\"index.php?page=Administration\"><font color=\"#0000FF\">Adminpanel</font></a>";
}
if(!isset($_COOKIE[$cp.'_user_id'])) {
echo " | <a href=\"index.php?page=Login\"><font color=\"#0000FF\">Einloggen</font></a> oder <a href=\"index.php?page=Register\"><font color=\"#0000FF\">Registrieren</font></a>";
}
else {
echo " | <a href=\"index.php?page=Hilfe\"><font color=\"#0000FF\">Hilfe</font></a> | <a href=\"index.php?page=Login&ID=logout\"><font color=\"#0000FF\">Ausloggen (".$_COOKIE[$sitename.'_user_name'].")</font></a>";
}
echo " | <a href=\"index.php?page=Impressum\"><font color=\"#0000FF\">Impressum</font></a><hr>";
?>