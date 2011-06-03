<title>wCMS Upgrade</title>
<center>
<?
include '../includes/config.php';
$cmsversion = "1.8";
$pversion = $cmsversion - 0.1;
if(empty($_GET)) {
?>
<a href="upgrade_<? echo $pversion."_".$cmsversion; ?>.php?step=1">Mit dem Upgrade von <? echo $version." auf ".$cmsversion ?> beginnen</a>
</form>
<?
}
if(isset($_GET['step'])) {
if($_GET['step'] == 1) {
$configfile = "../includes/config.php";
$write = "<?php\n\$sitename = \"".$sitename."\";\n\$dbhost = \"".$dbhost."\";\n\$dbuser = \"".$dbuser."\";\n\$dbpasswd = \"".$dbpasswd."\";\n\$dbname = \"".$dbname."\";\n//do not touch following\n\$version = \"".$cmsversion."\";\n\$footer = \"Copyright by \".\$sitename.\" - <a href='http://www.c-fire.tk/' target='_blank'>cFire \".\$version.\"</a> - <a href='#top'>Nach oben</a>\";\n?>";
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
	echo "<br><a href='upgrade_".$pversion."_".$cmsversion.".php?success'>Weiter</a>";
	echo '<meta http-equiv="refresh" content="0; url=upgrade_'.$pversion.'_'.$cmsversion.'.php?success">';

} else {
    print "Die Datei $configfile ist nicht schreibbar";
}
}
}
if(isset($_GET['success'])) {
echo "Upgrade erfolgreich";
echo "<br><a href='../'>Abschließen</a>";
}
?>
</center>