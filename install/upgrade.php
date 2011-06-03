<title>Upgrade</title>
<?php
$cmsversion = "2.8";
if(!file_exists("../includes/config.php")) {
echo "Ist noch nicht installiert! <a href=\"\">Klicke hier um es zu installieren</a>";
die;
}
else {
include '../includes/config.php';
if($version == $cmsversion) {
echo "Kein Upgrade möglich.<br>Es wird bereits die aktuelle Version genutzt oder es wurden keine Veränderungen an der Datenbank vorgenommen";
die;
}
elseif($version == 1.1) {
echo '<meta http-equiv="refresh" content="0; url=upgrade_1.1_1.2.php">';
}
elseif($version == 1.2) {
echo '<meta http-equiv="refresh" content="0; url=upgrade_1.2_1.3.php">';
}
elseif($version == 1.3) {
echo '<meta http-equiv="refresh" content="0; url=upgrade_1.3_1.4.php">';
}
elseif($version == 1.4) {
echo '<meta http-equiv="refresh" content="0; url=upgrade_1.4_1.5.php">';
}
elseif($version == 1.5) {
echo '<meta http-equiv="refresh" content="0; url=upgrade_1.5_1.6.php">';
}
elseif($version == 1.6) {
echo '<meta http-equiv="refresh" content="0; url=upgrade_1.6_1.7.php">';
}
elseif($version == 1.7) {
echo '<meta http-equiv="refresh" content="0; url=upgrade_1.7_1.8.php">';
}
elseif($version == 1.8) {
echo '<meta http-equiv="refresh" content="0; url=upgrade_1.8_1.9.php">';
}
elseif($version == 1.9) {
echo '<meta http-equiv="refresh" content="0; url=upgrade_1.9_2.0.php">';
}
elseif($version == 2.0) {
echo '<meta http-equiv="refresh" content="0; url=upgrade_2.0_2.1.php">';
}
elseif($version == 2.1) {
echo '<meta http-equiv="refresh" content="0; url=upgrade_2.1_2.2.php">';
}
elseif($version == 2.2) {
echo '<meta http-equiv="refresh" content="0; url=upgrade_2.2_2.3.php">';
}
elseif($version == 2.3) {
echo '<meta http-equiv="refresh" content="0; url=upgrade_2.3_2.4.php">';
}
elseif($version == 2.4) {
echo '<meta http-equiv="refresh" content="0; url=upgrade_2.4_2.5.php">';
}
elseif($version == 2.5) {
echo '<meta http-equiv="refresh" content="0; url=upgrade_2.5_2.6.php">';
}
elseif($version == 2.6) {
echo '<meta http-equiv="refresh" content="0; url=upgrade_2.6_2.7.php">';
}
elseif($version == 2.7) {
echo '<meta http-equiv="refresh" content="0; url=upgrade_2.7_2.8.php">';
}
}
?>