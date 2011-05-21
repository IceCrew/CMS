<title>cFire Upgrade</title>
<center>
<?
include '../lib/config.php';
$cmsversion = "2.2";
$pversion = $cmsversion - 0.1;
if(empty($_GET)) {
?>
<a href="upgrade_<? echo $pversion."_".$cmsversion; ?>.php?step=1">Mit dem Upgrade von <? echo $version." auf ".$cmsversion ?> beginnen</a>
</form>
<?
}
if(isset($_GET['step'])) {
if($_GET['step'] == 1) {
echo '<form action="?step=2" method="post">
<h3>Impressum-Konfiguration (optional)</h3>
Name: <input type="text" name="impressum_name" maxlength="50"><br>
Land: <input type="text" name="impressum_land" maxlength="50"><br>
Postleitzahl: <input type="text" name="impressum_postleitzahl" maxlength="50"><br>
Stadt: <input type="text" name="impressum_stadt" maxlength="50"><br>
Straße: <input type="text" name="impressum_straße" maxlength="50"><br>
Hausnummer: <input type="text" name="impressum_hausnummer" maxlength="50"><br>
E-Mail: <input type="text" name="impressum_email" maxlength="50"><br>
Telefon: <input type="text" name="impressum_telefon" maxlength="50"><br>
<input type="submit" name="configure" value="Weiter">
</form>';
}
if($_GET['step'] == 2) {
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
\$impressum_name = \"".$_POST['impressum_name']."\";
\$impressum_land = \"".$_POST['impressum_land']."\";
\$impressum_postleitzahl = \"".$_POST['impressum_postleitzahl']."\";
\$impressum_stadt = \"".$_POST['impressum_stadt']."\";
\$impressum_straße = \"".$_POST['impressum_straße']."\";
\$impressum_hausnummer = \"".$_POST['impressum_hausnummer']."\";
\$impressum_email = \"".$email."\";
\$impressum_telefon = \"".$_POST['impressum_telefon']."\";
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
	echo "<br><a href='upgrade_".$pversion."_".$cmsversion.".php?step=3'>Weiter</a>";
	echo '<meta http-equiv="refresh" content="0; url=upgrade_'.$pversion.'_'.$cmsversion.'.php?step=3">';

} else {
    print "Die Datei $configfile ist nicht schreibbar";
}
}
if($_GET['step'] == 3) {
include_once "../lib/class.mysql.php";
$mysql->query("ALTER TABLE `posts` ADD COLUMN views int(100) AFTER `text`;", array());
$mysql->query("ALTER TABLE `news` ADD COLUMN views int(100) AFTER `text`;", array());
$mysql->query("UPDATE `posts` SET `views` = 0", array());
$mysql->query("UPDATE `news` SET `views` = 0", array());
echo '<meta http-equiv="refresh" content="0, url=upgrade_'.$pversion.'_'.$cmsversion.'.php?success">';
}
}
if(isset($_GET['success'])) {
echo "Upgrade erfolgreich";
echo "<br><a href='../'>Abschließen</a>";
}
?>
</center>