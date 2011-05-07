<?php
{ #Anderes Bereich
session_start();
include_once "lib/class.mysql.php";
$getpage = $_GET['page'];
$getid = $_GET['ID'];
if(file_exists("install")) {
echo "<title>Fehler - $sitename</title>";
echo '<center><h1><font color="#FF0000">Fehler! Du hast das Verzeichnis "install" nicht gelöscht oder das Script nocht nicht installiert!</font></h1></center>';
die;
}
else {
include "lib/config.php"; 
include "lib/header.php";
}
if(empty($_GET)) {
echo '<meta http-equiv="refresh" content="0; url=./index.php?page=Index">';
}
if($getpage == "Impressum") {
echo "<title>Impressum - $sitename</title>";
echo "Name: $impressum_name<br>
Land: $impressum_land<br>
Ort: $impressum_postleitzahl $impressum_stadt<br>
Straße: $impressum_straße $impressum_hausnummer<br>
E-Mail: $impressum_email<br>
Telefon: $impressum_telefon<hr>";
}
}
{ #Index Bereich
if($getpage == "Index") {
echo "<title>Index - $sitename</title>";
$mysql->query("select * from news", array());
while($sql = @mysql_fetch_array($mysql->result)) {
$views = $sql['views'] + 1;
echo '<a href="index.php?page=News&ID='.$sql["id"].'"><b><u>'.$sql["name"].' (von '.$sql['username'].', '.$views.' Aufrufe)</u></b></a><br><br>'.$sql["text"].'<hr>';
}
}
if($getpage == "Posts" and isset($getid)) {
$mysql->query("select * from posts where id='".$getid."'", array());
while($data = @mysql_fetch_array($mysql->result)) {
$views = $data['views'] + 1;
echo "<title>".$data['name']." - $sitename</title>";
echo "<b><u>".$data['name']." (von ".$data['username'].", $views Aufrufe)</u></b>";
echo "<br><br>";
echo $data['text'];
$mysql->query("UPDATE posts SET views = $views WHERE id = '".$data['id']."'", array());
echo "<br><br><i>Kommentare:</i><br>";
$mysql->query("select * from post_comments where position = '$getid'", array());
while($comment = @mysql_fetch_array($mysql->result)) {
echo "<br><b>".$comment['user'].":</b> ".$comment['msg'];
}
echo '<form action="" method="post">
<textarea type="text" name="pcmsg" style="width:50; height:10%"></textarea>
<input type="submit" name="pcsubmit" value="Kommentieren">
<form>';
if(isset($_POST['pcsubmit'])) {
$name = $_POST['name'];
$pretext = str_replace("\r\n", "\r\n<br>", $_POST['pcmsg']);
$text = str_replace("href=\"", "href=\"./index.php?page=Redirect&ID=", $pretext);
$mysql->query("INSERT INTO post_comments (user, msg, where) VALUES ('".$_SESSION[$sitename.'_all_user_username']."', '".$text."', '".$getid."')", array());

echo '<meta http-equiv="refresh" content="0; url=index.php?page=Posts&ID='.$getid.'">';
}
}
echo "<hr>";
}
if($getpage == "Posts" and empty($getid)) {
echo "<title>Alle Beiträge - $sitename</title>";
$mysql->query("select * from posts", array());
while($sql = @mysql_fetch_array($mysql->result)) {
echo "<a href=\"?page=Posts&ID=".$sql['id']."\">".$sql['name']."</a> (".$sql['views']." Aufrufe)<br>";
}
echo "<hr>";
}
if($getpage == "News" and isset($getid)) {
$mysql->query("select * from news where id='".$getid."'", array());
while($data = @mysql_fetch_array($mysql->result)) {
$views = $data['views'] + 1;
echo "<title>".$data['name']." - $sitename</title>";
echo "<b><u>".$data['name']." (von ".$data['username'].", $views Aufrufe)</u></b>";
echo "<br><br>";
echo $data['text'];
$mysql->query("UPDATE news SET views = $views WHERE id = '".$data['id']."'", array());
echo "<br><br><i>Kommentare:</i><br>";
$mysql->query("select * from post_comments where position = '$getid'", array());
while($comment = @mysql_fetch_array($mysql->result)) {
echo "<br><b>".$comment['user'].":</b> ".$comment['msg'];
}
echo '<form action="" method="post">
<textarea type="text" name="ncmsg" style="width:50; height:10%"></textarea>
<input type="submit" name="ncsubmit" value="Kommentieren">
<form>';
if(isset($_POST['ncsubmit'])) {
$pretext = str_replace("\r\n", "\r\n<br>", $_POST['ncmsg']);
$text = str_replace("href=\"", "href=\"./index.php?page=Redirect&ID=", $pretext);
$mysql->query("INSERT INTO news_comments (user, msg, where) VALUES ('".$_SESSION[$sitename.'_all_user_username']."', '".$text."', '".$getid."')", array());

echo '<meta http-equiv="refresh" content="0; url=index.php?page=Posts&ID='.$getid.'">';
}
}
echo "<hr>";
}
if($getpage == "News" and empty($getid)) {
?><title>Alle Beiträge - <? echo $sitename ?></title><?
$mysql->query("select * from news", array());
while($sql = @mysql_fetch_array($mysql->result)) {
echo "<a href=\"?page=News&ID=".$sql['id']."\">".$sql['name']."</a> (".$sql['views']." Aufrufe)<br>";
}
echo "<hr>";
}
if($getpage == "Hilfe") {
include "lib/help.php";
?>
<title>Hilfe - <? echo $sitename ?></title>
<?
echo '<a href="?page=Hilfe&ID=html#show">HTML-Hilfe</a>';
if($getpage == "Hilfe" and $getid == "html") {
?>
<title>HTML-Hilfe - <? echo $sitename ?></title>
<?
echo $help_html;
}
echo "<hr>";
}
if($getpage == "Downloads" and empty($getid)) {
echo "<title>Downloads - $sitename</title>";
$mysql->query("select * from downloads", array());
while($dl = @mysql_fetch_array($mysql->result)) {
echo "<a href='?page=Downloads&ID=".$dl['id']."'>".$dl['name']."</a> (".$dl['downloads']." Downloads)<br>";
}
echo "<hr>";
}
if($getpage == "Downloads" and isset($getid)) {
$mysql->query("select * from downloads where id = '".$getid."'", array());
while($dl = @@mysql_fetch_array($mysql->result)) {
$dlc = $dl['downloads'] + 1;
$mysql->query("UPDATE `downloads` SET `downloads`='$dlc' WHERE `id`='".$dl['id']."'", array());
@header('Content-type: application/octet-stream');
@header('Content-Disposition: attachment; filename="'.$dl['filename'].'"');
readfile('downloads/'.$dl['filename']);
}
echo "<hr>";
}
if($getpage == "Redirect") {
echo "<title>$sitename verlassen - $sitename</title>";
echo "Du bist dabei <b>$sitename</b> zu verlassen, möchtest du wirklich auf <u><b>$getid</b></u> gehen?<br>";
echo "- <a href='$getid'>Ja</a><br>";
echo "- <a href='./index.php?page=Index'>Doch nicht</a>";
echo "<hr>";
}
}
{ #Login Bereich
if($getpage == "Login" and $getid == "error")  
{  
  echo "Die Zugangsdaten waren ungültig.";  
}
if($getpage == "Login") {

echo "<title>Login - $sitename</title>";
echo '<form action="?page=Login" method="post">  
Benutzername: <input type="text" name="name" size="20"> 
Passwort: <input type="password" name="pwd" size="20"> 
<input type="submit" value="Login" name="postlogin">  
</form>'; 
echo "<hr>";
if($getpage == "Login" and isset($_POST['postlogin'])) {

$mysql->query("SELECT ".  
    "id, username, password ".  
  "FROM ".  
    "accounts ".  
  "WHERE ".  
    "(username like '".$_POST['name']."') AND ".  
    "(password = '".sha1($_POST['pwd'])."')", array());  

if (mysql_num_rows($mysql->result) > 0)  
{
$data = @mysql_fetch_array ($mysql->result);  
$mysql->query("Select admin from accounts WHERE username = '".$_POST['name']."' and admin = '1'", array());
$rows = mysql_num_rows($mysql->result);
if($rows == 1) { 
  $_SESSION[$sitename."_adm_user_id"] = $data["id"];  
  $_SESSION[$sitename."_adm_user_username"] = $data["username"];
  $_SESSION[$sitename."_all_user_id"] = $data["id"];
  $_SESSION[$sitename."_all_user_username"] = $data["username"];

echo '<meta http-equiv="refresh" content="0; url=index.php?page=Index">';
}
elseif($rows == 0) {
  $_SESSION[$sitename."_user_id"] = $data["id"];  
  $_SESSION[$sitename."_user_username"] = $data["username"];
  $_SESSION[$sitename."_all_user_id"] = $data["id"];
  $_SESSION[$sitename."_all_user_username"] = $data["username"];
  
echo '<meta http-equiv="refresh" content="0; url=index.php?page=Index">';
}
else  
{  
echo '<meta http-equiv="refresh" content="0; url=index.php?page=Login&ID=error">';
}
}
}
if($getpage == "Login" and $getid == "logout") {   
ob_start();  


session_unset();
session_destroy();
ob_end_flush();
echo '<meta http-equiv="refresh" content="0; url=index.php?page=Index">';
}
}
}
{ #Registrierungs Bereich
if($getpage == 'Register' and empty($getid)) {
echo '<title>Registrierung - '.$sitename.'</title>
<form action="?page=Register" method="post">
Benutzername: <input type="text" name="username" width="20"> 
Passwort: <input type="password" name="password" width="20"> 
<input type="submit" name="register" value="Registrieren">
</form>';
if(isset($_POST['register'])) {
$user = $_POST['username'];
$pw = sha1($_POST['password']);
$sql = "Select username from accounts WHERE username = '".$user."'";
$mysql->query($sql, array());
$rows = mysql_num_rows($mysql->result);
if($rows == 1) {
echo "Der Benutzername wird bereits verwendet!";
}
if($rows == 0) {
$mysql->query("INSERT INTO accounts (username, password, admin) VALUES ('".$user."', '".$pw."', '0')", array());
echo "User wurde erstellt!";
}
}
echo "<hr>";
}
}
{ #Admin Bereich
if($getpage == "Administration") {
include "lib/adm_session.php";
include "lib/menu.php";
include_once "lib/class.mysql.php";
echo "$menu_admin<hr>";
$getposts = $_GET['posts'];
$getnews = $_GET['news'];
$getusers = $_GET['users'];
$getsettings = $_GET['settings'];
$getdownloads = $_GET['downloads'];
$getforwarding = $_GET['forwarding'];
if($getpage == "Administration" and empty($getposts) and empty($getusers) and empty($getnews) and empty($getsettings) and empty($getdownloads) and empty($getforwarding) and empty($getid)) {
echo "<title>Adminpanel - $sitename</title>";
echo "Bitte wähle einer der oben genannten Optionen";
}
if($getpage == "Administration" and $getposts == 'create') {
echo "<title>Beitrag erstellen - $sitename</title>";
echo '<form action="" method="post">
Titel: <input type="text" name="name" size="80" maxlength="50"><br>
<textarea type="text" name="text" style="width:100%; height:72%"></textarea>
<input type="submit" name="submit" value="erstellen">
<form>';
}
if(isset($_POST['submit'])) {
$name = $_POST['name'];
$pretext = str_replace("\r\n", "\r\n<br>", $_POST['text']);
$text = str_replace("href=\"", "href=\"./index.php?page=Redirect&ID=", $pretext);
if(empty($name)) {
echo '<meta http-equiv="refresh" content="0; url=index.php?page=Administration&ID=error">';
}
else {
$mysql->query("INSERT INTO posts (name, text, username) VALUES ('".$name."', '".$text."', '".$_SESSION[$sitename.'_adm_user_username']."')", array());

echo '<meta http-equiv="refresh" content="0; url=index.php?page=Administration&ID=success">';
}
}
if($getpage == "Administration" and $getposts == 'delete') {
echo "<title>Beitrag löschen - $sitename</title>";
$mysql->query("select id,name,username from posts", array());
while($sql = @mysql_fetch_array($mysql->result)) {
echo '<form action="" method="post">
<input type="submit" value="'.$sql["name"].' von '.$sql["username"].' löschen" name="'.$sql["id"].'">
</form>';
if(isset($_POST[$sql['id']])) {
$mysql->query("DELETE FROM posts WHERE id = '".$sql['id']."'", array());

echo '<meta http-equiv="refresh" content="0; url=index.php?page=Administration&ID=success">';
}
}

}
if($getpage == "Administration" and $getid == "success") {
echo "<title>Erfolgreich - $sitename</title>";
echo 'Aktion erfolgreich ausgeführt!<br><a href="index.php?page=Administration">Weiter</a><meta http-equiv="refresh" content="3; url=index.php?page=Administration">';
}
if($getpage == "Administration" and $getid == "error") {
echo "<title>Fehler - $sitename</title>";
echo "Dir ist ein Fehler unterlaufen!<br><input type=\"button\" value=\"Zurück\" onclick=\"history.back(-1)\">";
}
if($getpage == "Administration" and $getusers == 'delete') {
echo "<title>Benutzer löschen - $sitename</title>";
$mysql->query("select id,username from accounts WHERE safe = '0'", array());
while($sql = @mysql_fetch_array($mysql->result)) {
echo '<form action="" method="post">
<input type="submit" value="'.$sql["username"].' löschen" name="'.$sql["id"].'">
</form>';
if(isset($_POST[$sql['id']])) {
$mysql->query("DELETE FROM accounts WHERE id = '".$sql['id']."' and safe = '0'", array());

echo '<meta http-equiv="refresh" content="0; url=index.php?page=Administration&ID=success">';
}
}

}
if($getpage == "Administration" and $getusers == 'list') {
echo "<title>Benutzerliste - $sitename</title>";
echo "<b><u>Administratoren:</u></b><br>";
$mysql->query("select username from accounts where admin = '1'", array());
while($sqladmin = @mysql_fetch_array($mysql->result)) {
echo $sqladmin['username']."<br>";
}
echo "<b><u>Benutzer:</u></b><br>";
$mysql->query("select username from accounts where admin = '0'", array());
while($sql = @mysql_fetch_array($mysql->result)) {
echo $sql['username']."<br>";
}

}
if($getpage == "Administration" and $getusers == 'manage') {
echo "<title>Benutzerverwaltung - $sitename</title>";
$mysql->query("select id,username from accounts WHERE admin = '1' AND safe = '0'", array());
while($sql = @mysql_fetch_array($mysql->result)) {
echo '<form action="" method="post">
<input type="submit" value="'.$sql["username"].' zum Benutzer degradieren" name="unset'.$sql["id"].'">
</form>';
if(isset($_POST["unset".$sql['id']])) {
$mysql->query("UPDATE accounts SET admin = '0' WHERE id = '".$sql['id']."'", array());

echo '<meta http-equiv="refresh" content="0; url=index.php?page=Administration&ID=success">';
}
}
$mysql->query("select id,username from accounts WHERE admin = '0'", array());
while($sql = @mysql_fetch_array($mysql->result)) {
echo '<form action="" method="post">
<input type="submit" value="'.$sql["username"].' zum Admin befördern" name="set'.$sql["id"].'">
</form>';
if(isset($_POST["set".$sql['id']])) {
$mysql->query("UPDATE accounts SET admin = '1' WHERE id = '".$sql['id']."'", array());

echo '<meta http-equiv="refresh" content="0; url=index.php?page=Administration&ID=success">';
}
}
}
if($getpage == "Administration" and $getnews == 'create') {
echo "<title>News erstellen - $sitename</title>";
echo '<form action="" method="post">
Titel: <input type="text" name="name" size="80" maxlength="50"><br>
<textarea type="text" name="text" style="width:100%; height:72%"></textarea>
<input type="submit" name="newssubmit" value="erstellen">
<form>';
}
if(isset($_POST['newssubmit'])) {
$name = $_POST['name'];
$pretext = str_replace("\r\n", "\r\n<br>", $_POST['text']);
$text = str_replace("href=\"", "href=\"./index.php?page=Redirect&ID=", $pretext);
if(empty($name)) {
echo '<meta http-equiv="refresh" content="0, url=index.php?page=Administration&ID=error">';
}
else {
$mysql->query("INSERT INTO news (name, text, username) VALUES ('".$name."', '".$text."', '".$_SESSION[$sitename.'_adm_user_username']."')", array());

echo '<meta http-equiv="refresh" content="0; url=index.php?page=Administration&ID=success">';
}
}
if($getpage == "Administration" and $getnews == 'delete') {
echo "<title>News löschen - $sitename</title>";
$mysql->query("select id,name,username from news", array());
while($sql = @mysql_fetch_array($mysql->result)) {
echo '<form action="" method="post">
<input type="submit" value="'.$sql["name"].' von '.$sql["username"].' löschen" name="'.$sql['id'].'">
</form>';
if(isset($_POST[$sql['id']])) {
$mysql->query("DELETE FROM news WHERE id = '".$sql['id']."'", array());

echo '<meta http-equiv="refresh" content="0; url=index.php?page=Administration&ID=success">';
}
}

}
if($getpage == "Administration" and $getsettings == "cms") {
$email = str_replace("[at]", "@", $impressum_email);
echo "<title>Einstellungen - $sitename</title>";
echo '<form action="" method="post">
<h3>Server-Konfiguration:</h3>
Seitenname: <input type="text" name="sitename" value='.$sitename.' maxlength="25"><br>
Datenbank-Host: <input type="text" name="dbhost" value='.$dbhost.' maxlength="50"><br>
Datenbank-Name: <input type="text" name="dbname" value='.$dbname.' maxlength="25"><br>
Datenbank-Benutzer: <input type="text" name="dbuser" value='.$dbuser.' maxlength="25"><br>
Datenbank-Passwort: <input type="password" name="dbpasswd" value='.$dbpasswd.' maxlength="50"><br>
<h3>Impressum-Konfiguration (optional)</h3>
Name: <input type="text" name="impressum_name" value="'.$impressum_name.'" maxlength="50"><br>
Land: <input type="text" name="impressum_land" value="'.$impressum_land.'" maxlength="50"><br>
Postleitzahl: <input type="text" name="impressum_postleitzahl" value="'.$impressum_postleitzahl.'" maxlength="50"><br>
Stadt: <input type="text" name="impressum_stadt" value="'.$impressum_stadt.'" maxlength="50"><br>
Straße: <input type="text" name="impressum_straße" value="'.$impressum_straße.'" maxlength="50"><br>
Hausnummer: <input type="text" name="impressum_hausnummer" value="'.$impressum_hausnummer.'" maxlength="50"><br>
E-Mail: <input type="text" name="impressum_email" value="'.$email.'" maxlength="50"><br>
Telefon: <input type="text" name="impressum_telefon" value="'.$impressum_telefon.'" maxlength="50"><br>
<input type="submit" name="configure" value="Weiter">
</form>';
if(isset($_POST['configure'])) {
$email = str_replace("@", "[at]", $_POST['impressum_email']);
$configfile = "lib/config.php";
$write = "<?php
\$sitename = \"".$_POST['sitename']."\";
\$dbhost = \"".$_POST['dbhost']."\";
\$dbuser = \"".$_POST['dbuser']."\";
\$dbpasswd = \"".$_POST['dbpasswd']."\";
\$dbname = \"".$_POST['dbname']."\";
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
\$version = \"".$version."\";
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
	echo '<meta http-equiv="refresh" content="0, url=index.php?page=Administration&ID=success">';

} else {
    print "Die Datei $configfile ist nicht schreibbar";
}
}
}
if($getpage == "Administration" and $getdownloads == 'create') {
echo "<title>Download erstellen - $sitename</title>";
echo '<h4>Please do just upload ZIP-Archives,RAR-Archives or Executables. Otherwise the File will be destroyed!</h4>
<form action="" method="post" enctype="multipart/form-data">
Name: <input type="text" name="name" size="50"><br>
Datei: <input type="file" name="datei" size="75"><br>
Hochladen: <input type="submit" value="Hochladen" name="add">
</form>';
if(isset($_POST['add'])) {
move_uploaded_file($_FILES['datei']['tmp_name'], "downloads/".$_FILES['datei']['name']);
$mysql->query("INSERT INTO downloads (name, filename, downloads) VALUES ('".$_POST['name']."', '".$_FILES['datei']['name']."', '0')", array());
echo "Datei hochgeladen";
}
}
if($getpage == "Administration" and $getdownloads == 'delete') {
echo "<title>Download löschen - $sitename</title>";
$mysql->query("select * from downloads", array());
while($sql = @mysql_fetch_array($mysql->result)) {
echo '<form action="" method="post">
<input type="submit" value="'.$sql["name"].' ('.$sql["downloads"].' Downloads) löschen" name="'.$sql["id"].'">
</form>';
if(isset($_POST[$sql['id']])) {
$mysql->query("DELETE FROM downloads WHERE id = '".$sql['id']."'", array());
unlink("downloads/".$sql['filename']);

echo '<meta http-equiv="refresh" content="0; url=index.php?page=Administration&ID=success">';
}
}
}
if($getpage == "Administration" and $getforwarding == 'create') { 
echo "<title>Weiterleitung erstellen - $sitename</title>";
echo '<form action="" method="post">
<h3>Achtung: Die Weiterleitung wird als Post erstellt!</h3>
Titel: <input type="text" name="name" size="80" maxlength="50"><br>
URL: <input type="text" name="url" size="150" maxlength="250"><br>
<input type="submit" name="forwardsubmit" value="erstellen">
</form>';
if(isset($_POST['forwardsubmit'])) {
$name = $_POST['name'];
$text = '<meta http-equiv="refresh" content="0; url=./index.php?page=Redirect&ID='.$_POST["url"].'">';
if(empty($name)) {
echo '<meta http-equiv="refresh" content="0, url=index.php?page=Administration&ID=error">';
}
else {
$mysql->query("INSERT INTO posts (name, text, username) VALUES ('".$name." (Weiterleitung)', '".$text."', '".$_SESSION[$sitename.'_adm_user_username']."')", array());
echo '<meta http-equiv="refresh" content="0; url=index.php?page=Administration&ID=success">';
}
}
}
if($getpage == "Administration" and $getposts == "edit" and empty($getid)) {
$mysql->query("select * from posts", array());
echo "<title>Beitrag editieren - $sitename</title>";
while($sql = @mysql_fetch_array($mysql->result)) {
echo "<a href='?page=Administration&posts=edit&ID=".$sql['id']."'>\"".$sql['name']."\" editieren</a><br>";
}
}
if($getpage == "Administration" and $getposts == "edit" and isset($getid)) {
$mysql->query("select * from posts where id = '$getid'", array());
while($sql = @mysql_fetch_array($mysql->result)) {
$text = str_replace("<br>", "", $sql['text']);
echo "<title>".$sql['name']." editieren (Beitrag) - $sitename</title>";
echo '<form action="" method="post">
Titel: <input type="text" name="name" size="80" maxlength="50" value="'.$sql["name"].'"><br>
<textarea type="text" name="text" style="width:100%; height:72%">'.$text.'</textarea><br>
<input type="submit" name="peditsubmit" value="editieren">';
}
}
if(isset($_POST['peditsubmit'])) {
echo "<title>".$_POST['name']." editieren (Beitrag) - $sitename</title>";
$text = str_replace("\r\n", "\r\n<br>", $_POST['text']);
$mysql->query("UPDATE `posts` SET `name` = '".$_POST['name']."' WHERE id = '$getid'", array());
$mysql->query("UPDATE `posts` SET `text` = '$text' WHERE id = '$getid'", array());
echo '<meta http-equiv="refresh" content="0, url=index.php?page=Administration&ID=success">';
}
if($getpage == "Administration" and $getnews == "edit" and empty($getid)) {
$mysql->query("select * from news", array());
echo "<title>News editieren - $sitename</title>";
while($sql = @mysql_fetch_array($mysql->result)) {
echo "<a href='?page=Administration&news=edit&ID=".$sql['id']."'>\"".$sql['name']."\" editieren</a><br>";
}
}
if($getpage == "Administration" and $getnews == "edit" and isset($getid)) {
$mysql->query("select * from news where id = '$getid'", array());
while($sql = @mysql_fetch_array($mysql->result)) {
echo "<title>".$sql['name']." editieren (News) - $sitename</title>";
$text = str_replace("<br>", "", $sql['text']);
echo '<form action="" method="post">
Titel: <input type="text" name="name" size="80" maxlength="50" value="'.$sql["name"].'"><br>
<textarea type="text" name="text" style="width:100%; height:72%">'.$text.'</textarea><br>
<input type="submit" name="neditsubmit" value="editieren">';
}
}
if(isset($_POST['neditsubmit'])) {
echo "<title>".$_POST['name']." editieren (News) - $sitename</title>";
$text = str_replace("\r\n", "\r\n<br>", $_POST['text']);
$mysql->query("UPDATE `news` SET `name` = '".$_POST['name']."' WHERE id = '$getid'", array());
$mysql->query("UPDATE `news` SET `text` = '$text' WHERE id = '$getid'", array());
echo '<meta http-equiv="refresh" content="0, url=index.php?page=Administration&ID=success">';
}
echo "<hr>";
}
}
echo $footer;
?>