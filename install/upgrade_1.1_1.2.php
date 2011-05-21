<title>wCMS Upgrade</title>
<center>
<?
include '../lib/config.php';
$cmsversion = "1.2";
if(empty($_GET)) {
?>
<a href="upgrade_1.1_1.2.php?step=1">Mit dem Upgrade von <? echo $version." auf ".$cmsversion ?> beginnen</a>
</form>
<?
}
if(isset($_GET['step'])) {
$step = $_GET['step'];
if($step == 1) {
?>
<form action="upgrade_1.1_1.2.php?step=2" method="post">
Seitenname: <input type="text" name="sitename" value="<? echo $sitename ?>" maxlength="25"><br>
Datenbank-Host: <input type="text" name="dbhost" value="<? echo $dbhost ?>" maxlength="50"><br>
Datenbank-Name: <input type="text" name="dbname" value="<? echo $dbname ?>" maxlength="25"><br>
Datenbank-Benutzer: <input type="text" name="dbuser" value="<? echo $dbuser ?>" maxlength="25"><br>
Datenbank-Passwort: <input type="password" name="dbpasswd" value="<? echo $dbpasswd ?>" maxlength="50"><br>
<input type="submit" name="configure" value="Weiter">
<?
}
if($step == 2) {
$configfile = "../lib/config.php";
$write = "<?php\n\$sitename = \"".$_POST['sitename']."\";\n\$dbhost = \"".$_POST['dbhost']."\";\n\$dbuser = \"".$_POST['dbuser']."\";\n\$dbpasswd = \"".$_POST['dbpasswd']."\";\n\$dbname = \"".$_POST['dbname']."\";\n//do not touch following\n\$version = \"".$cmsversion."\";\n\$footer = \"Copyright by \".\$sitename.\" - wCMS \".\$version;\n?>";
if (is_writable($configfile)) {

    if (!$handle = fopen($configfile, "w+")) {
         print "Kann die Datei $configfile nicht öffnen";
         exit;
    }
    if (!fwrite($handle, $write)) {
        print "Kann in die Datei $configfile nicht schreiben";
        exit;
    }

    print "Konfiguration erfolgreich!";

    fclose($handle);
	echo "<br><a href='upgrade_1.1_1.2.php?step=3'>Weiter</a>";
	echo '<meta http-equiv="refresh" content="0; url=upgrade_1.1_1.2.php">';

} else {
    print "Die Datei $configfile ist nicht schreibbar";
}
}
if($step == 3) {
include_once '../lib/class.mysql.php';
$mysql->query("CREATE TABLE `news` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `username` text COLLATE latin1_german1_ci NOT NULL,
  `name` text COLLATE latin1_german1_ci NOT NULL,
  `text` text COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci", array()) or die (mysql_error());
echo '<meta http-equiv="refresh" content="0; url=upgrade_1.1_1.2.php?success">';
}
}
if(isset($_GET['success'])) {
echo "Upgrade erfolgreich";
?>
<form action="upgrade_1.1_1.2.php?success" method="post">
<input type="submit" name="complete" value="Upgrade abschließen">
</form>
<?
if(isset($_POST['complete'])) {
echo '<meta http-equiv="refresh" content="0; url=../">';
echo "Wenn die automatische Weiterleitung nicht funktioniert, klicke bitte <a href=\"../\">HIER</a>";
}
}
?>
</center>