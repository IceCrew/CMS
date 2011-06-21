<?php
echo '<title>IceCrew CMS Installation</title>
<body background="images/templates/default/site/background.png"></body>
<img src="images/templates/default/site/logo.png"></img><hr>';
$version = 3;
if(empty($_GET)) {
if(file_exists("includes/config.php") AND file_exists("includes/config.php.new")) {
echo 'IceCrew CMS ist bereits installiert!<br>
Klicken sie auf weiter, um ein Upgrade zu machen.<br>
<a href="upgrade.php"><img src="images/templates/default/buttons/next.png" onmouseover="this.src=\'images/templates/default/buttons/next_hover.png\';" onmouseout="this.src=\'images/templates/default/buttons/next.png\';"></img></a>';
die;
}
else {
echo 'Klicken sie auf weiter, um mit der Installation zu beginnen!<br>
<a href="?step=1"><img src="images/templates/default/buttons/next.png" onmouseover="this.src=\'images/templates/default/buttons/next_hover.png\';" onmouseout="this.src=\'images/templates/default/buttons/next.png\';"></img></a>';
}
}
if(isset($_GET['step'])) {
if($_GET['step'] == 1) {
rename("includes/config.php.new", "includes/config.php");
mkdir("downloads", 0777);
echo '<a href="./"><img src="images/templates/default/buttons/back.png" onmouseover="this.src=\'images/templates/default/buttons/back_hover.png\';" onmouseout="this.src=\'images/templates/default/buttons/back.png\';"></img></a><br>
<form action="?step=2" method="post">
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
<input type="image" src="images/templates/default/buttons/next.png" onmouseover="this.src=\'images/templates/default/buttons/next_hover.png\';" onmouseout="this.src=\'images/templates/default/buttons/next.png\';" name="Weiter" alt="Weiter">
</form>';
}
if($_GET['step'] == 2) {
$email = str_replace("@", "[at]", $_POST['impressum_email']);
$configfile = "includes/config.php";
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
	echo '<br><a href="?step=1"><img src="images/templates/default/buttons/back.png" onmouseover="this.src=\'images/templates/default/buttons/back_hover.png\';" onmouseout="this.src=\'images/templates/default/buttons/back.png\';"></img></a>
	<br><a href="?step=3"><img src="images/templates/default/buttons/next.png" onmouseover="this.src=\'images/templates/default/buttons/next_hover.png\';" onmouseout="this.src=\'images/templates/default/buttons/next.png\';"></img></a>';

} else {
    print "Die Datei $configfile ist nicht schreibbar";
}
}
if($_GET['step'] == 3) {
include 'includes/config.php';
echo '<a href="?step=2"><img src="images/templates/default/buttons/back.png" onmouseover="this.src=\'images/templates/default/buttons/back_hover.png\';" onmouseout="this.src=\'images/templates/default/buttons/back.png\';"></img></a>';
include_once "includes/class.mysql.php";
$mysql->query("CREATE TABLE `accounts` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `username` text COLLATE latin1_german1_ci NOT NULL,
  `email` text COLLATE latin1_german1_ci NOT NULL,
  `password` text COLLATE latin1_german1_ci NOT NULL,
  `remote_addr` text COLLATE latin1_german1_ci NOT NULL,
  `admin` int(1) unsigned zerofill NOT NULL,
  `safe` int(1) unsigned zerofill NOT NULL,
  `active` int(1) unsigned zerofill NOT NULL,
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
$mysql->query("CREATE TABLE `cms_info` (
  `version` int(100) NOT NULL,
  `template` text NOT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;", array());
$mysql->query("INSERT INTO `cms_info` (version, template) VALUES ('$version', 'default');", array());
echo '<br><a href="?step=4"><img src="images/templates/default/buttons/next.png" onmouseover="this.src=\'images/templates/default/buttons/next_hover.png\';" onmouseout="this.src=\'images/templates/default/buttons/next.png\';"></img></a>';
}
if($_GET['step'] == 4) {
echo '<a href="?step=3"><img src="images/templates/default/buttons/back.png" onmouseover="this.src=\'images/templates/default/buttons/back_hover.png\';" onmouseout="this.src=\'images/templates/default/buttons/back.png\';"></img></a>
<br><form action="?step=4" method="post">
Benutzername:<br><input type="text" name="username" maxlength="25"><br>
Passwort:<br><input type="password" name="password" maxlength="25"><br>
<input type="image" src="images/templates/default/buttons/next.png" onmouseover="this.src=\'images/templates/default/buttons/next_hover.png\';" onmouseout="this.src=\'images/templates/default/buttons/next.png\';" name="create" alt="create">
</form>';
if(isset($_POST['password']) AND isset($_POST['username'])) {
include 'includes/config.php';
include_once "includes/class.mysql.php";
$user = $_POST['username'];
$pw = sha1($_POST['password']);
$mysql->query("Select username from accounts WHERE username = '".$user."'", array());
$rows = @mysql_num_rows($mysql->result);
$mysql->query("INSERT INTO accounts (username, password, admin, safe, email, active) VALUES ('".$user."', '".$pw."', '1', '1', '$impressum_email', '1')", array());
$mysql->query("INSERT INTO news (username, name, text) VALUES ('".$user."', 'Glückwunsch!', 'Glückwunsch!<br>Du hast erfolgreich IceCrew CMS ".$version." installiert!<br>Du kannst diesen Newseintrag im Adminpanel löschen!<br><br>Mit freundlichen Grüßen, deine IceCrew')", array());
echo "Benutzer & News erfolgreich erstellt";
echo '<br><a href="?success"><img src="images/templates/default/buttons/next.png" onmouseover="this.src=\'images/templates/default/buttons/next_hover.png\';" onmouseout="this.src=\'images/templates/default/buttons/next.png\';"></img></a>';
}
}
}
if(isset($_GET['success'])) {
echo 'Installation erfolgreich beendet!
Um unsere Arbeit zu unterstützen, werben sie bitte für uns. Es ist nicht notwendig, wäre aber schön.
Helfen sie uns, bekannter zu werden.
<form action="index.php" method="post">
<input type="submit" name="installdeletefiles" value="Installations Dateien löschen">
</form>';
}
?>
</center>