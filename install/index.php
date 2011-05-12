<title>cFire Installation</title>
<center>
<?
$cmsversion = "2.5";
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
echo '<form action="index.php?step=2" method="post">
<h3>Server-Konfiguration:</h3>
Seitenname: <input type="text" name="sitename" maxlength="25"><br>
Datenbank-Host: <input type="text" name="dbhost" maxlength="50"><br>
Datenbank-Name: <input type="text" name="dbname" maxlength="25"><br>
Datenbank-Benutzer: <input type="text" name="dbuser" maxlength="25"><br>
Datenbank-Passwort: <input type="password" name="dbpasswd" maxlength="50"><br>
Cookie-Präfix: <input type="text" name="cp" maxlength="10">
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
\$sitename = \"".$_POST['sitename']."\";
\$dbhost = \"".$_POST['dbhost']."\";
\$dbuser = \"".$_POST['dbuser']."\";
\$dbpasswd = \"".$_POST['dbpasswd']."\";
\$dbname = \"".$_POST['dbname']."\";
\$cp = \"".$_POST['cp']."\";
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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;", array());
$mysql->query("CREATE TABLE `posts` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `username` text COLLATE latin1_german1_ci NOT NULL,
  `name` text COLLATE latin1_german1_ci NOT NULL,
  `text` text COLLATE latin1_german1_ci NOT NULL,
  `views` int(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;", array());
$mysql->query("CREATE TABLE `news` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `username` text COLLATE latin1_german1_ci NOT NULL,
  `name` text COLLATE latin1_german1_ci NOT NULL,
  `text` text COLLATE latin1_german1_ci NOT NULL,
  `views` int(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;", array());
$mysql->query("CREATE TABLE `downloads` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE latin1_german1_ci NOT NULL,
  `filename` text COLLATE latin1_german1_ci NOT NULL,
  `downloads` int(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;", array());
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
$rows = mysql_num_rows($mysql->result);
$mysql->query("INSERT INTO accounts (username, password, admin, safe) VALUES ('".$user."', '".$pw."', '1', '1')", array());
$mysql->query("INSERT INTO news (username, name, text) VALUES ('".$user."', 'Glückwunsch!', 'Glückwunsch!\nDu hast erfolgreich cFire ".$version." installiert!\nDu kannst diesen Newseintrag im Adminpanel löschen!\n\nMit freundlichen Grüßen, dein wCMS Team')", array());
echo "Benutzer & News erfolgreich erstellt";
echo '<meta http-equiv="refresh" content="0; url=index.php?success">';
}
}
}
if(isset($_GET['success'])) {
echo "Installation erfolgreich";
?>
<form action="index.php?success" method="post">
<input type="submit" name="complete" value="Installation abschließen">
</form>
<?
if(isset($_POST['complete'])) {
echo '<meta http-equiv="refresh" content="0; url=../index.php">';
echo "Wenn die automatische Weiterleitung nicht funktioniert, klicke bitte <a href=\"../index.php\">HIER</a>";
}
}
?>
</center>