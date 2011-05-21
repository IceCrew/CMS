<title>cFire Upgrade</title>
<center>
<?
include '../lib/config.php';
$cmsversion = "2.1";
$pversion = $cmsversion - 0.1;
if(empty($_GET)) {
?>
<a href="upgrade_2.0<? echo "_".$cmsversion; ?>.php?step=1">Mit dem Upgrade von <? echo $version." auf ".$cmsversion ?> beginnen</a>
</form>
<?
}
if(isset($_GET['step'])) {
if($_GET['step'] == 1) {
$configfile = "../lib/config.php";
$write = "<?php\n\$sitename = \"".$sitename."\";\n\$dbhost = \"".$dbhost."\";\n\$dbuser = \"".$dbuser."\";\n\$dbpasswd = \"".$dbpasswd."\";\n\$dbname = \"".$dbname."\";\n//do not touch following\n\$version = \"".$cmsversion."\";\n\$footer = \"Copyright by \".\$sitename.\" - <a href='http://cfire-cms.cf.funpic.de/' target='_blank'>cFire \".\$version.\"</a> - <a href='#top'>Nach oben</a>\";\n?>";
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
	echo "<br><a href='upgrade_2.0_".$cmsversion.".php?step=2'>Weiter</a>";
	echo '<meta http-equiv="refresh" content="0; url=upgrade_2.0_'.$cmsversion.'.php?step=2">';

} else {
    print "Die Datei $configfile ist nicht schreibbar";
}
}
if($_GET['step'] == 2) {
include_once "../lib/class.mysql.php";
$mysql->query("ALTER TABLE `downloads` ADD COLUMN downloads int(100) AFTER `filename`;", array());
$mysql->query("UPDATE `downloads` SET `downloads`='0';", array());
echo '<meta http-equiv="refresh" content="0; url=upgrade_2.0_'.$cmsversion.'.php?success">';
}
}
if(isset($_GET['success'])) {
echo "Upgrade erfolgreich";
echo "<br><a href='../'>Abschließen</a>";
}
?>
</center>