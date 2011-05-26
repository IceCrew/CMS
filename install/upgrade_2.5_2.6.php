<title>cFire Upgrade</title>
<center>
<?
include '../lib/config.php';
$cmsversion = "2.6";
$pversion = $cmsversion - 0.1;
if(empty($_GET)) {
?>
<a href="?step=1">Mit dem Upgrade von <? echo $version." auf ".$cmsversion ?> beginnen</a>
</form>
<?
}
if(isset($_GET['step'])) {
if($_GET['step'] == 1) {
$configfile = "../lib/config.php";
$write = "<?php
\$sitename = \"".$sitename."\";
\$dbhost = \"".$dbhost."\";
\$dbuser = \"".$dbuser."\";
\$dbpasswd = \"".$dbpasswd."\";
\$dbname = \"".$dbname."\";
\$cp = \"cfire\";
//do not touch following
//impress
\$impressum_name = \"".$impressum_name."\";
\$impressum_land = \"".$impressum_land."\";
\$impressum_postleitzahl = \"".$impressum_postleitzahl."\";
\$impressum_stadt = \"".$impressum_stadt."\";
\$impressum_straße = \"".$impressum_straße."\";
\$impressum_hausnummer = \"".$impressum_hausnummer."\";
\$impressum_email = \"".$impressum_email."\";
\$impressum_telefon = \"".$impressum_telefon."\";
//cms
\$gastkommentar = \"0\";
\$version = \"".$cmsversion."\";
\$footer = \"Copyright by \".\$sitename.\" - <a href='http://cfire.sytes.net/' target='_blank\'><font color='#0000FF'>cFire \".\$version.\"</font></a> - <a href='#top'><font color='#0000FF'>Nach oben</font></a>\";
?>";
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
	echo "<br><a href='?step=2'>Weiter</a>";
	echo '<meta http-equiv="refresh" content="0; url=?step=2">';

} else {
    print "Die Datei $configfile ist nicht schreibbar";
}
}
if($_GET['step'] == 2) {
include_once "../lib/class.mysql.php";
$mysql->query("ALTER TABLE `accounts` ADD COLUMN userid text AFTER `username`", array());
echo '<meta http-equiv="refresh" content="0; url=?success">';
}
}
if(isset($_GET['success'])) {
echo "Upgrade erfolgreich";
echo "<br><a href='../'>Abschließen</a>";
}
?>
</center>