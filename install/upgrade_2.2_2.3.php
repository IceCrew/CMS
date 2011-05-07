<title>cFire Upgrade</title>
<center>
<?
include '../lib/config.php';
$cmsversion = "2.3";
$pversion = $cmsversion - 0.1;
if(empty($_GET)) {
?>
<a href="upgrade_<? echo $pversion."_".$cmsversion; ?>.php?step=1">Mit dem Upgrade von <? echo $version." auf ".$cmsversion ?> beginnen</a>
</form>
<?
}
if(isset($_GET['step'])) {
if($_GET['step'] == 1) {
$email = str_replace("@", "[at]", $_POST['impressum_email']);
$configfile = "../lib/config.php";
$write = "<?php
\$sitename = \"".$sitename."\";
\$dbhost = \"".$dbhost."\";
\$dbuser = \"".$dbuser."\";
\$dbpasswd = \"".$dbpasswd."\";
\$dbname = \"".$dbname."\";
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
\$version = \"".$cmsversion."\";
\$footer = \"Copyright by \".\$sitename.\" - <a href='http://cfire-cms.cf.funpic.de/' target='_blank\'>cFire \".\$version.\"</a> - <a href='#top'>Nach oben</a>\";
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
	echo "<br><a href='upgrade_".$pversion."_".$cmsversion.".php?step=2'>Weiter</a>";
	echo '<meta http-equiv="refresh" content="0; url=upgrade_'.$pversion.'_'.$cmsversion.'.php?step=2">';

} else {
    print "Die Datei $configfile ist nicht schreibbar";
}
}
if($_GET['step'] == 2) {
include_once "../lib/class.mysql.php";
$mysql->query("CREATE TABLE `post_comments` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `user` text COLLATE latin1_german1_ci NOT NULL,
  `msg` text COLLATE latin1_german1_ci NOT NULL,
  `position` int(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;", array());
$mysql->query("CREATE TABLE `news_comments` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `user` text COLLATE latin1_german1_ci NOT NULL,
  `msg` text COLLATE latin1_german1_ci NOT NULL,
  `position` int(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;", array());
echo '<meta http-equiv="refresh" content="0, url=upgrade_'.$pversion.'_'.$cmsversion.'.php?success">';
}
}
if(isset($_GET['success'])) {
echo "Upgrade erfolgreich";
echo "<br><a href='../index.php'>Abschließen</a>";
}
?>
</center>