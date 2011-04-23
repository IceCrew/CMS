<title>Upgrade</title>
<?php
$cmsversion = "1.7";
if(!file_exists("../lib/config.php")) {
echo "Ist noch nicht installiert! <a href=\"index.php\">Klicke hier um es zu installieren</a>";
die;
}
else {
include '../lib/config.php';
if($version == $cmsversion) {
echo "Kein Upgrade möglich.<br>Es wird bereits die aktuelle Version genutzt oder es wurden keine Veränderungen an der Datenbank vorgenommen";
die;
}
elseif($version == 1.1) {
header("Location: upgrade_1.1_1.2.php");
}
elseif($version == 1.2) {
header("Location: upgrade_1.2_1.3.php");
}
elseif($version == 1.3) {
header("Location: upgrade_1.3_1.4.php");
}
elseif($version == 1.4) {
header("Location: upgrade_1.4_1.5.php");
}
elseif($version == 1.5) {
header("Location: upgrade_1.5_1.6.php");
}
elseif($version == 1.6) {
header("Location: upgrade_1.6_1.7.php");
}
}
?>