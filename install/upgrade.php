<title>Upgrade</title>
<?php
if(!file_exists("../includes/config.php")) {
echo "Ist noch nicht installiert! <a href=\"\">Klicke hier um es zu installieren</a>";
die;
}
else {
include '../includes/config.php';
echo "Das neue Updatesystem befindet sich in Arbeit. Bitte nutzen sie derzeit nur die Installation. Die Versionen können aus der Config gelöscht werden!";
}
?>