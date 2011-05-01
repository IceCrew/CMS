<title>cFire Installation</title>
<center>
<?
$cmsversion = "2.0";
if(empty($_GET)) {
if(file_exists("../lib/config.php")) {
echo "<a href=\"upgrade.php\">Upgrade hier</a>";
echo '<meta http-equiv="refresh" content="0; url=upgrade.php">';
die;
}
else {
rename("../lib/config.php.new", "../lib/config.php");
mkdir("../downloads", 0777);
}
?>
<a href="index.php?step=1">Mit der Installation beginnen</a>
</form>
<?
}
if(isset($_GET['step'])) {
if($_GET['step'] == 1) {
?>
<form action="index.php?step=2" method="post">
Seitenname: <input type="text" name="sitename" maxlength="25"><br>
Datenbank-Host: <input type="text" name="dbhost" maxlength="50"><br>
Datenbank-Name: <input type="text" name="dbname" maxlength="25"><br>
Datenbank-Benutzer: <input type="text" name="dbuser" maxlength="25"><br>
Datenbank-Passwort: <input type="password" name="dbpasswd" maxlength="50"><br>
<input type="submit" name="configure" value="Weiter">
<?
}
if($_GET['step'] == 2) {
$configfile = "../lib/config.php";
$write = "<?php\n\$sitename = \"".$_POST['sitename']."\";\n\$dbhost = \"".$_POST['dbhost']."\";\n\$dbuser = \"".$_POST['dbuser']."\";\n\$dbpasswd = \"".$_POST['dbpasswd']."\";\n\$dbname = \"".$_POST['dbname']."\";\n//do not touch following\n\$version = \"".$cmsversion."\";\n\$footer = \"Copyright by \".\$sitename.\" - <a href='http://cfire-cms.cf.funpic.de/' target='_blank\'>cFire \".\$version.\"</a> - <a href='#top'>Nach oben</a>\";\n?>";
if (is_writable($configfile)) {

    if (!$handle = fopen($configfile, "w+")) {
         print "Kann die Datei $configfile nicht �ffnen";
         exit;
    }
    if (!fwrite($handle, $write)) {
        print "Kann in die Datei $configfile nicht schreiben";
        exit;
    }

    print "Konfiguration erfolgreich!";

    fclose($handle);
	echo "<br><a href='index.php?step=3'>Weiter</a>";
	echo '<meta http-equiv="refresh" content="0; url=index.php?step=3">';

} else {
    print "Die Datei $configfile ist nicht schreibbar";
}
}
if($_GET['step'] == 3) {
include '../lib/config.php';
include_once "../lib/class.mysql.php";
$mysql->query("CREATE TABLE `accounts` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `username` text COLLATE latin1_german1_ci NOT NULL,
  `password` text COLLATE latin1_german1_ci NOT NULL,
  `admin` int(1) unsigned zerofill NOT NULL,
  `safe` int(1) unsigned zerofill NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;", array()) or die (mysql_error());
$mysql->query("CREATE TABLE `posts` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `username` text COLLATE latin1_german1_ci NOT NULL,
  `name` text COLLATE latin1_german1_ci NOT NULL,
  `text` text COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;", array()) or die (mysql_error());
$mysql->query("CREATE TABLE `news` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `username` text COLLATE latin1_german1_ci NOT NULL,
  `name` text COLLATE latin1_german1_ci NOT NULL,
  `text` text COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;", array()) or die (mysql_error());
$mysql->query("CREATE TABLE `downloads` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE latin1_german1_ci NOT NULL,
  `filename` text COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;", array()) or die(mysql_error());
echo '<meta http-equiv="refresh" content="0; url=index.php?step=4">';
}
if($_GET['step'] == 4) {
?> <form action="index.php?step=4" method="post">
Benutzername: <input type="text" name="username" maxlength="25"><br>
Passwort: <input type="password" name="password" maxlength="25"><br>
<input type="submit" name="create" value="erstellen">
</form> <?
if(isset($_POST['create'])) {
include '../lib/config.php';
include_once "../lib/class.mysql.php";
$user = $_POST['username'];
$pw = sha1($_POST['password']);
$mysql->query("Select username from accounts WHERE username = '".$user."'", array());
$rows = $mysql->count;
$mysql->query("INSERT INTO accounts (username, password, admin, safe) VALUES ('".$user."', '".$pw."', '1', '1')", array()) or die ("Fehler beim erstellen des Administrators!");
$mysql->query("INSERT INTO news (username, name, text) VALUES ('".$user."', 'Gl�ckwunsch!', 'Gl�ckwunsch!\nDu hast erfolgreich wCMS ".$version." installiert!\nDu kannst diesen Newseintrag im Adminpanel l�schen!\n\nMit freundlichen Gr��en, dein wCMS Team')", array()) or die("Fehler beim erstellen der Erstnews!");
echo '<meta http-equiv="refresh" content="0; url=index.php?success">';
}
}
}
if(isset($_GET['success'])) {
echo "Installation erfolgreich";
?>
<form action="index.php?success" method="post">
<input type="submit" name="complete" value="Installation abschlie�en">
</form>
<?
if(isset($_POST['complete'])) {
echo '<meta http-equiv="refresh" content="0; url=../index.php">';
echo "Wenn die automatische Weiterleitung nicht funktioniert, klicke bitte <a href=\"../index.php\">HIER</a>";
}
}
?>
</center>