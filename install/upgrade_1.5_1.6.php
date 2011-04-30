<title>wCMS Upgrade</title>
<center>
<?
include '../lib/config.php';
$cmsversion = "1.6";
if(empty($_GET)) {
?>
<a href="upgrade_1.5_1.6.php?step=1">Mit dem Upgrade von <? echo $version." auf ".$cmsversion ?> beginnen</a>
</form>
<?
}
if(isset($_GET['step'])) {
if($_GET['step'] == 1) {
?>
<form action="upgrade_1.5_1.6.php?step=2" method="post">
Seitenname: <input type="text" name="sitename" value="<? echo $sitename ?>" maxlength="25"><br>
Datenbank-Host: <input type="text" name="dbhost" value="<? echo $dbhost ?>" maxlength="50"><br>
Datenbank-Name: <input type="text" name="dbname" value="<? echo $dbname ?>" maxlength="25"><br>
Datenbank-Benutzer: <input type="text" name="dbuser" value="<? echo $dbuser ?>" maxlength="25"><br>
Datenbank-Passwort: <input type="password" name="dbpasswd" value="<? echo $dbpasswd ?>" maxlength="50"><br>
<input type="submit" name="configure" value="Weiter">
<?
}
if($_GET['step'] == 2) {
$configfile = "../lib/config.php";
$write = "<?php\n\$sitename = \"".$_POST['sitename']."\";\n\$dbhost = \"".$_POST['dbhost']."\";\n\$dbuser = \"".$_POST['dbuser']."\";\n\$dbpasswd = \"".$_POST['dbpasswd']."\";\n\$dbname = \"".$_POST['dbname']."\";\n//do not touch following\n\$version = \"".$cmsversion."\";\n\$footer = \"Copyright by \".\$sitename.\" - <a href='http://www.w-cms.tk/' target='_blank'>wCMS \".\$version.\"</a> - <a href='#top'>Nach oben</a>\";\n?>";
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
	echo "<br><a href='upgrade_1.5_1.6.php?success'>Weiter</a>";
	echo '<meta http-equiv="refresh" content="0; url=upgrade_1.5_1.6.php?success">';

} else {
    print "Die Datei $configfile ist nicht schreibbar";
}
}
}
if(isset($_GET['success'])) {
echo "Upgrade erfolgreich";
?>
<form action="upgrade_1.5_1.6.php?success" method="post">
<input type="submit" name="complete" value="Upgrade abschließen">
</form>
<?
if(isset($_POST['complete'])) {
echo '<meta http-equiv="refresh" content="0; url=../index.php">';
echo "Wenn die automatische Weiterleitung nicht funktioniert, klicke bitte <a href=\"../index.php\">HIER</a>";
}
}
?>
</center>