<?php
include "lib/config.php";
include "lib/adm_session.php";
include "lib/header.php";
include "lib/menu.php";
include_once "lib/class.mysql.php";
echo "$menu_admin<hr>";
$getposts = $_GET['posts'];
$getnews = $_GET['news'];
$getusers = $_GET['users'];
$getsettings = $_GET['settings'];
$getdownloads = $_GET['downloads'];
if($getposts == 'create') { ?>
<title>Beitrag erstellen - <? echo $sitename ?></title>
<form action="" method="post">
Titel: <input type="text" name="name" size="80" maxlength="50"><br>
<textarea type="text" name="text" style="width:100%; height:72%"></textarea>
<input type="submit" name="submit" value="erstellen"
<form>
<?

}
if(isset($_POST['submit'])) {
$name = $_POST['name'];
$pretext = str_replace("\r\n", "\r\n<br>", $_POST['text']);
$text = str_replace("href=\"", "href=\"./redirect.php?url=", $pretext);
if(empty($name)) {
echo '<meta http-equiv="refresh" content="0; url=admin.php?error">';
}
else {
$mysql->query("INSERT INTO posts (name, text, username) VALUES ('".$name."', '".$text."', '".$_SESSION[$sitename.'adm_user_username']."')", array());

echo '<meta http-equiv="refresh" content="0; url=admin.php?success">';
}
}
if($getposts == 'delete') {
?> <title>Beitrag löschen - <? echo $sitename ?></title> <?
$mysql->query("select id,name,username from posts", array());
while($sql = mysql_fetch_array($mysql->result)) {
?>
<form action="" method="post">
<input type="submit" value="<? echo $sql['name']." von ".$sql['username']." löschen"; ?>" name="<? echo $sql['id']; ?>">
</form>
<?
if(isset($_POST[$sql['id']])) {
$mysql->query("DELETE FROM posts WHERE id = '".$sql['id']."'", array());

echo '<meta http-equiv="refresh" content="0; url=admin.php?success">';
}
}

}
if(isset($_GET['success'])) {
?> <title>Erfolgreich - <? echo $sitename ?></title> <?
echo 'Aktion erfolgreich ausgeführt!<br><a href="admin.php">Weiter</a><meta http-equiv="refresh" content="3; url=admin.php">';
}
if(isset($_GET['error'])) {
?> <title>Fehler - <? echo $sitename ?></title> <?
echo "Dir ist ein Fehler unterlaufen!<br><input type=\"button\" value=\"Zurück\" onclick=\"history.back(-1)\">";
}
if($getusers == 'delete') {
?> <title>Benutzer löschen - <? echo $sitename ?></title> <?
$mysql->query("select id,username from accounts WHERE safe = '0'", array());
while($sql = mysql_fetch_array($mysql->result)) {
?>
<form action="" method="post">
<input type="submit" value="<? echo $sql['username']." löschen"; ?>" name="<? echo $sql['id']; ?>">
</form>
<?
if(isset($_POST[$sql['id']])) {
$mysql->query("DELETE FROM accounts WHERE id = '".$sql['id']."' and safe = '0'", array());

echo '<meta http-equiv="refresh" content="0; url=admin.php?success">';
}
}

}
if($getusers == 'list') {
?> <title>Benutzerliste - <? echo $sitename ?></title> <?
echo "<b><u>Administratoren:</u></b><br>";
$mysql->query("select username from accounts where admin = '1'", array());
while($sqladmin = mysql_fetch_array($mysql->result)) {
echo $sqladmin['username']."<br>";
}
echo "<b><u>Benutzer:</u></b><br>";
$mysql->query("select username from accounts where admin = '0'", array());
while($sql = mysql_fetch_array($mysql->result)) {
echo $sql['username']."<br>";
}

}
if($getusers == 'manage') {
?> <title>Benutzerverwaltung - <? echo $sitename ?></title> <?
$mysql->query("select id,username from accounts WHERE admin = '1' AND safe = '0'", array());
while($sql = mysql_fetch_array($mysql->result)) {
?>
<form action="" method="post">
<input type="submit" value="<? echo $sql['username']." zum Benutzer degradieren"; ?>" name="unset<? echo $sql['id']; ?>">
</form>
<?
if(isset($_POST["unset".$sql['id']])) {
$mysql->query("UPDATE accounts SET admin = '0' WHERE id = '".$sql['id']."'", array());

echo '<meta http-equiv="refresh" content="0; url=admin.php?success">';
}
}
$mysql->query("select id,username from accounts WHERE admin = '0'", array());
while($sql = mysql_fetch_array($mysql->result)) {
?>
<form action="" method="post">
<input type="submit" value="<? echo $sql['username']." zum Admin befördern"; ?>" name="set<? echo $sql['id']; ?>">
</form>
<?
if(isset($_POST["set".$sql['id']])) {
$mysql->query("UPDATE accounts SET admin = '1' WHERE id = '".$sql['id']."'", array());

echo '<meta http-equiv="refresh" content="0; url=admin.php?success">';
}
}
}
if($getnews == 'create') { ?>
<title>News erstellen - <? echo $sitename ?></title>
<form action="" method="post">
Titel: <input type="text" name="name" size="80" maxlength="50"><br>
<textarea type="text" name="text" style="width:100%; height:72%"></textarea>
<input type="submit" name="newssubmit" value="erstellen"
<form>
<?

}
if(isset($_POST['newssubmit'])) {
$name = $_POST['name'];
$pretext = str_replace("\r\n", "\r\n<br>", $_POST['text']);
$text = str_replace("href=\"", "href=\"./redirect.php?url=", $pretext);
if(empty($name)) {
header ("Location: admin.php?titleerror");
}
else {
$mysql->query("INSERT INTO news (name, text, username) VALUES ('".$name."', '".$text."', '".$_SESSION[$sitename.'adm_user_username']."')", array());

echo '<meta http-equiv="refresh" content="0; url=admin.php?success">';
}
}
if($getnews == 'delete') {
?> <title>News löschen - <? echo $sitename ?></title> <?
$mysql->query("select id,name,username from news", array());
while($sql33 = mysql_fetch_array($mysql->result)) {
?>
<form action="" method="post">
<input type="submit" value="<? echo $sql33['name']." von ".$sql33['username']." löschen"; ?>" name="<? echo $sql33['id']; ?>">
</form>
<?
if(isset($_POST[$sql33['id']])) {
$mysql->query("DELETE FROM news WHERE id = '".$sql33['id']."'", array());

echo '<meta http-equiv="refresh" content="0; url=admin.php?success">';
}
}

}
if(empty($_GET)) {
?> <title>Adminpanel - <? echo $sitename ?></title><?
echo "Bitte wähle einer der oben genannten Optionen";

}
if($getposts == 'edit') {
?> <title>Beitrag editieren - <? echo $sitename ?></title> <?
$mysql->query("select id,name from posts", array());
while($sql = mysql_fetch_array($mysql->result)) {
?>
<form action="?posts=edit" method="post">
<input type="submit" value="<? echo $sql['name']." editieren"; ?>" name="edit<? echo $sql['id']; ?>">
</form>
<?
}
if(isset($_POST["edit".$sql['id']])) {
$id = $_POST["edit".$sql['id']];
$mysql->query("select name,text from posts where id = '".$id."'", array());
while($sql = mysql_fetch_array($mysql->result)) {
$pretext = str_replace("<br>", "\r\n", $sql['text']);
?>
<form action="" method="post">
Titel: <input type="text" name="name" size="80" maxlength="50" value="<? echo $sql['name']; ?>"><br>
<textarea type="text" name="text" style="width:100%; height:72%"><? echo $pretext; ?></textarea>
<input type="submit" name="postedit" value="editieren"
<form>
<?
}
if(isset($_POST['postedit'])) {
$text = str_replace("\r\n", "\r\n<br>", $_POST['text']);
$mysql->query("update posts set text='".$text."' where id = '".$id."'", array());
$mysql->query("update posts set name='".$_POST['name']."' where id = '".$id."'", array());

echo '<meta http-equiv="refresh" content="0; url=admin.php?success">';
}
}
}
if($getsettings == "cms") {
?>
<title>Einstellungen - <? echo $sitename ?></title>
<form action="" method="post">
Seitenname: <input type="text" name="sitename" readonly="true" value="<? echo $sitename ?>" maxlength="25"><br>
Datenbank-Host: <input type="password" name="dbhost" readonly="true" value="<? echo $dbhost ?>" maxlength="50"><br>
Datenbank-Name: <input type="password" name="dbname" readonly="true" value="<? echo $dbname ?>" maxlength="25"><br>
Datenbank-Benutzer: <input type="password" name="dbuser" readonly="true" value="<? echo $dbuser ?>" maxlength="25"><br>
Datenbank-Passwort: <input type="password" name="dbpasswd" readonly="true" value="<? echo $dbpasswd ?>" maxlength="50"><br>
<input type="submit" name="configure" value="Weiter">
</form>
<?
if(isset($_POST['configure'])) {
$configfile = "lib/config.php";
$write = "<?php\n\$sitename = \"".$_POST['sitename']."\";\n\$dbhost = \"".$_POST['dbhost']."\";\n\$dbuser = \"".$_POST['dbuser']."\";\n\$dbpasswd = \"".$_POST['dbpasswd']."\";\n\$dbname = \"".$_POST['dbname']."\";\n//do not touch following\n\$version = \"".$version."\";\n\$footer = \"Copyright by \".\$sitename.\" - <a href='http://www.c-fire.tk/' target='_blank'>cFire \".\$version.\"</a> - <a href='#top'>Nach oben</a>\";\n?>";
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
	header("Location: admin.php?success");

} else {
    print "Die Datei $configfile ist nicht schreibbar";
}
}
}
if($getdownloads == 'create') {
?> <title>Download erstellen - <? echo $sitename ?></title>
<h4>Please do just upload ZIP-Archives,RAR-Archives or Executables. Otherwise the File will be destroyed!</h4>
<form action="" method="post" enctype="multipart/form-data">
Name: <input type="text" name="name" size="50"><br>
Datei: <input type="file" name="datei" size="75"><br>
Hochladen: <input type="submit" value="Hochladen" name="add">
</form>
<?
if(isset($_POST['add'])) {
move_uploaded_file($_FILES['datei']['tmp_name'], "downloads/".$_FILES['datei']['name']);
$mysql->query("INSERT INTO downloads (name, filename) VALUES ('".$_POST['name']."', '".$_FILES['datei']['name']."')", array());
echo "Datei hochgeladen";
}
}
if($getdownloads == 'delete') {
?> <title>Download löschen - <? echo $sitename ?></title> <?
$mysql->query("select id,name,filename from downloads", array());
while($sql = mysql_fetch_array($mysql->result)) {
?>
<form action="" method="post">
<input type="submit" value="<? echo $sql['name']." löschen"; ?>" name="<? echo $sql['id']; ?>">
</form>
<?
if(isset($_POST[$sql['id']])) {
$mysql->query("DELETE FROM downloads WHERE id = '".$sql['id']."'", array());
unlink("downloads/".$sql['filename']);

echo '<meta http-equiv="refresh" content="0; url=admin.php?success">';
}
}
}
echo "<hr>$footer";
?>