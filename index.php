<body>
<?php
$domain = $_SERVER['SERVER_NAME'];
$path = str_replace("index.php", "", $_SERVER['SCRIPT_NAME']);
$getpage = $_GET['page'];
$getid = $_GET['ID'];
if(file_exists('includes/config.php') AND file_exists('includes/config.php.new')) {
echo '<meta http-equiv="refresh" content="0; URL=upgrade.php">';
}
elseif(!file_exists('includes/config.php') AND file_exists('includes/config.php.new')) {
echo '<meta http-equiv="refresh" content="0; URL=install.php">';
}
{ #Template Bereich
include_once "includes/class.mysql.php";
include "includes/config.php"; 
$mysql->query("SELECT template FROM cms_info", array());
$templates = mysql_fetch_array($mysql->result);
$template = "images/templates/".$templates['template'];
echo "<head><link rel=\"STYLESHEET\" type=\"text/CSS\" href=\"$template/style.css\"></head>";
}
{ #Header Bereich
echo '<a href="http://icecrew.sytes.net" target="_blank"><img frameborder="0" border="0" src="'.$template.'/site/logo.png"></img></a><br>';
echo '<a name="top"></a><ul id="Navigation"><li><a href="?page=Index"><img frameborder="0" border="0" src="'.$template.'/buttons/index.png" onmouseover="this.src=\''.$template.'/buttons/index_hover.png\';" onmouseout="this.src=\''.$template.'/buttons/index.png\';"></img></a></li><li><a href="?page=News"><img frameborder="0" border="0" src="'.$template.'/buttons/news.png" onmouseover="this.src=\''.$template.'/buttons/news_hover.png\';" onmouseout="this.src=\''.$template.'/buttons/news.png\';"></img></a></li><li><a href="?page=Posts"><img frameborder="0" border="0" src="'.$template.'/buttons/posts.png" onmouseover="this.src=\''.$template.'/buttons/posts_hover.png\';" onmouseout="this.src=\''.$template.'/buttons/posts.png\';"></img></a></li><li><a href="?page=Downloads"><img frameborder="0" border="0" src="'.$template.'/buttons/downloads.png" onmouseover="this.src=\''.$template.'/buttons/downloads_hover.png\';" onmouseout="this.src=\''.$template.'/buttons/downloads.png\';"></img></a></li>';
require('includes/config.php');
if(isset($_COOKIE[$cp.'_admin_id'])) { 
echo '<li><a href="?page=Administration"><img frameborder="0" border="0" src="'.$template.'/buttons/adminpanel.png" onmouseover="this.src=\''.$template.'/buttons/adminpanel_hover.png\';" onmouseout="this.src=\''.$template.'/buttons/adminpanel.png\';"></img></a></li>';
}
if(!isset($_COOKIE[$cp.'_user_id'])) {
echo '<li><a href="?page=Login"><img frameborder="0" border="0" src="'.$template.'/buttons/login.png" onmouseover="this.src=\''.$template.'/buttons/login_hover.png\';" onmouseout="this.src=\''.$template.'/buttons/login.png\';"></img></a></li><li><a href="?page=Register"><img frameborder="0" border="0" src="'.$template.'/buttons/register.png" onmouseover="this.src=\''.$template.'/buttons/register_hover.png\';" onmouseout="this.src=\''.$template.'/buttons/register.png\';"></img></a></li>';
}
else {
echo '<li><a href="?page=Hilfe"><img frameborder="0" border="0" src="'.$template.'/buttons/help.png" onmouseover="this.src=\''.$template.'/buttons/help_hover.png\';" onmouseout="this.src=\''.$template.'/buttons/help.png\';"></img></a></li><li><a href="?page=Login&ID=logout"><img frameborder="0" border="0" src="'.$template.'/buttons/logout.png" onmouseover="this.src=\''.$template.'/buttons/logout_hover.png\';" onmouseout="this.src=\''.$template.'/buttons/logout.png\';"></img></a></li><li>';
}
echo '<li><a href="?page=Impressum"><img frameborder="0" border="0" src="'.$template.'/buttons/impress.png" onmouseover="this.src=\''.$template.'/buttons/impress_hover.png\';" onmouseout="this.src=\''.$template.'/buttons/impress.png\';"></img></a></li></ul>';
}
{ #Anderes Bereich
if(isset($_POST["installdeletefiles"])) {
unlink("install.php");
unlink("upgrade.php");
}
if(empty($_GET)) {
echo '<meta http-equiv="refresh" content="0; url=./index.php?page=Index">';
}
if($getpage == "Impressum") {
echo "<title>Impressum - $sitename</title>";
echo "<div id='Inhalt'>Name: $impressum_name<br>
Land: $impressum_land<br>
Ort: $impressum_postleitzahl $impressum_stadt<br>
Straße: $impressum_straße $impressum_hausnummer<br>
E-Mail: $impressum_email<br>
Telefon: $impressum_telefon</div>";
}
}
{ #Index Bereich
if($getpage == "Index") {
echo "<title>Index - $sitename</title>";
$mysql->query("select * from news order by id desc", array());
while($sql = mysql_fetch_array($mysql->result)) {
$views = $sql['views'];
echo '<div><a href="?page=News&ID='.$sql["id"].'"><b><u>'.$sql["name"].' (von '.$sql['username'].', '.$views.' Aufrufe)</u></b></a><br><br>'.$sql["text"].'</div><br>';
}
}
if($getpage == "Posts" and isset($getid)) {
$mysql->query("select * from posts where id='".$getid."'", array());
while($data = mysql_fetch_array($mysql->result)) {
$views = $data['views'] + 1;
echo "<title>".$data['name']." - $sitename</title>";
echo "<div><b><u>".$data['name']." (von ".$data['username'].", $views Aufrufe)</u></b>";
if(isset($_COOKIE[$cp."_admin_id"])) {
echo " | <a href='?page=Administration&posts=edit&ID=$getid'>Beitrag editieren</a>";
}
echo "<br><br>";
echo $data['text'].'</div>';
$mysql->query("UPDATE posts SET views = $views WHERE id = '".$data['id']."'", array());
echo "<br><div><i>Kommentare:</i><br>";
$mysql->query("select * from post_comments where position = '$getid' order by id desc", array());
while($comment = mysql_fetch_array($mysql->result)) {
echo "<b>".$comment['user'].":</b> ".$comment['msg'];
if(isset($_COOKIE[$cp."_admin_id"])) {
echo '<form action="" method="post"><input type="submit" value="Kommentar löschen" name="pc'.$comment["id"].'"></form>';
if(isset($_POST["pc".$comment['id']])) {
$mysql->query("DELETE FROM post_comments WHERE id = '".$comment['id']."'", array());
echo '<meta http-equiv="refresh" content="0; url=?page=Posts&ID='.$getid.'">';
}
}
else {
echo "<br>";
}
}
echo "</div>";
if(isset($_COOKIE[$cp."_user_id"])) {
echo '<br><div><form action="" method="post">
<textarea type="text" name="pcmsg" style="width:500; height:75"></textarea>
<input type="submit" name="pcsubmit" value="Kommentieren">
<form></div>';
}
elseif($gastkommentar == "1") {
echo '<br><div><form action="" method="post">
Name: <input type="text" name="pcgname" size="50" maxlength="15"><br>
<textarea type="text" name="pcgmsg" style="width:500; height:75"></textarea>
<input type="submit" name="pcgsubmit" value="Kommentieren">
<form></div>';
}
else {
echo "<br><div><i>(Du musst dich einloggen um Kommentare schreiben zu können)</i></div>";
}
if(isset($_POST['pcsubmit'])) {
$name = $_POST['name'];
$pretext = str_replace("\r\n", "\r\n<br>", $_POST['pcmsg']);
$text = str_replace('href="', 'href="index.php?page=Redirect&ID=', $pretext);
$mysql->query("INSERT INTO post_comments (user, msg, position) VALUES ('".$_COOKIE[$cp.'_user_name']."', '".$text."', '".$getid."')", array());

echo '<meta http-equiv="refresh" content="0; url=?page=Posts&ID='.$getid.'">';
}
if(isset($_POST['pcgsubmit'])) {
if(empty($_POST['pcgname'])) {
echo "<br><div>Geben sie einen Namen ein!</div>";
}
else {
$name = $_POST['name'];
$pretext = str_replace("\r\n", "\r\n<br>", $_POST['pcgmsg']);
$text = str_replace('href="', 'href="index.php?page=Redirect&ID=', $pretext);
$mysql->query("INSERT INTO post_comments (user, msg, position) VALUES ('".$_POST['pcgname']." (Gast)', '".$text."', '".$getid."')", array());

echo '<meta http-equiv="refresh" content="0; url=?page=Posts&ID='.$getid.'">';
}
}
}
}
if($getpage == "Posts" and empty($getid)) {
echo "<title>Alle Beiträge - $sitename</title>";
$mysql->query("select * from posts order by id desc", array());
echo "<div>";
while($sql = mysql_fetch_array($mysql->result)) {
echo "<a href=\"?page=Posts&ID=".$sql['id']."\">".$sql['name']."</a> (".$sql['views']." Aufrufe)<br>";
}
echo "</div>";
}
if($getpage == "News" and isset($getid)) {
$mysql->query("select * from news where id='$getid'", array());
while($data = mysql_fetch_array($mysql->result)) {
$views = $data['views'] + 1;
echo "<title>".$data['name']." - $sitename</title>";
echo "<div><b><u>".$data['name']." (von ".$data['username'].", $views Aufrufe)</u></b>";
if(isset($_COOKIE[$cp."_admin_id"])) {
echo " | <a href='?page=Administration&news=edit&ID=$getid'>News editieren</a>";
}
echo "<br><br>";
echo $data['text'].'</div>';
$mysql->query("UPDATE news SET views = $views WHERE id = '".$data['id']."'", array());
echo "<br><div><i>Kommentare:</i><br>";
$mysql->query("select * from news_comments where position = '$getid' order by id desc", array());
while($comment = mysql_fetch_array($mysql->result)) {
echo "<b>".$comment['user'].":</b> ".$comment['msg'];
if(isset($_COOKIE[$cp."_admin_id"])) {
echo '<form action="" method="post"><input type="submit" value="Kommentar löschen" name="nc'.$comment["id"].'"></form>';
if(isset($_POST["nc".$comment['id']])) {
$mysql->query("DELETE FROM news_comments WHERE id = '".$comment['id']."'", array());
echo '<meta http-equiv="refresh" content="0; url=?page=News&ID='.$getid.'">';
}
}
else {
echo "<br>";
}
}
echo "</div>";
if(isset($_COOKIE[$cp."_user_id"])) {
echo '<br><div><form action="" method="post">
<textarea type="text" name="ncmsg" style="width:500; height:75"></textarea>
<input type="submit" name="ncsubmit" value="Kommentieren">
<form></div>';
}
elseif($gastkommentar == "1") {
echo '<br><div><form action="" method="post">
Name: <input type="text" name="ncgname" size="50" maxlength="15"><br>
<textarea type="text" name="ncgmsg" style="width:500; height:75"></textarea>
<input type="submit" name="ncgsubmit" value="Kommentieren">
<form></div>';
}
else {
echo "<br><div><i>(Du musst dich einloggen um Kommentare schreiben zu können)</i></div>";
}
if(isset($_POST['ncsubmit'])) {
$pretext = str_replace("\r\n", "\r\n<br>", $_POST['ncmsg']);
$text = str_replace('href="', 'href="index.php?page=Redirect&ID=', $pretext);
$mysql->query("INSERT INTO news_comments (user, msg, position) VALUES ('".$_COOKIE[$cp.'_user_name']."', '".$text."', '".$getid."')", array());

echo '<meta http-equiv="refresh" content="0; url=?page=News&ID='.$getid.'">';
}
if(isset($_POST['ncgsubmit'])) {
if(empty($_POST['ncgname'])) {
echo "<br><div>Geben sie einen Namen ein!</div>";
}
else {
$pretext = str_replace("\r\n", "\r\n<br>", $_POST['ncgmsg']);
$text = str_replace('href="', 'href="index.php?page=Redirect&ID=', $pretext);
$mysql->query("INSERT INTO news_comments (user, msg, position) VALUES ('".$_POST['ncgname']." (Gast)', '".$text."', '".$getid."')", array());

echo '<meta http-equiv="refresh" content="0; url=?page=News&ID='.$getid.'">';
}
}
}
}
if($getpage == "News" and empty($getid)) {
echo "<title>Alle News - $sitename</title>";
$mysql->query("select * from news order by id desc", array());
echo "<div>";
while($sql = mysql_fetch_array($mysql->result)) {
echo "<a href=\"?page=News&ID=".$sql['id']."\">".$sql['name']."</a> (".$sql['views']." Aufrufe)<br>";
}
echo "</div>";
}
if($getpage == "Hilfe") {
include "includes/help.php";
echo "<title>Hilfe - $sitename</title>";
echo '<div><a href="?page=Hilfe&ID=html#show">HTML-Hilfe</a>';
if($getpage == "Hilfe" and $getid == "html") {
echo "<title>HTML-Hilfe - $sitename</title>";
echo $help_html;
}
echo "</div>";
}
if($getpage == "Downloads" and empty($getid)) {
echo "<title>Downloads - $sitename</title>";
$mysql->query("select * from downloads order by id desc", array());
echo "<div>";
while($dl = mysql_fetch_array($mysql->result)) {
echo "<a href='?page=Downloads&ID=".$dl['id']."'>".$dl['name']."</a> (".$dl['downloads']." Downloads)<br>";
}
echo "</div>";
}
if($getpage == "Downloads" and isset($getid)) {
$mysql->query("select * from downloads where id = '$getid'", array());
while($dl = mysql_fetch_array($mysql->result)) {
$dlc = $dl['downloads'] + 1;
$dls = filesize($dl['filename']);
$mysql->query("UPDATE `downloads` SET `downloads`='$dlc' WHERE `id`='".$dl['id']."'", array());
header('Content-type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.$dl['filename'].'"');
header("Content-Length: $dls");
readfile('downloads/'.$dl['filename']);
}
}
if($getpage == "Redirect") {
echo "<title>$sitename verlassen - $sitename</title>";
echo "<div>Du bist dabei <b>$sitename</b> zu verlassen, möchtest du wirklich auf <u><b>$getid</b></u> gehen?<br>";
echo "- <a href='$getid'>Ja</a><br>";
echo "- <a href='./?page=Index'>Doch nicht</a></div>";
}
}
{ #Login Bereich
if($getpage == "Login" and $getid == "error")  
{  
  echo "<div>Die Zugangsdaten waren ungültig.</div>";  
}
if($getpage == "Login") {

echo "<title>Login - $sitename</title>";
echo '<div><form action="?page=Login" method="post">  
Benutzername:<br><input type="text" name="id" size="20"><br>
Passwort:<br><input type="password" name="pwd" size="20"><br>
<select name="cookietime">
<option value="1">1 Tag</option>
<option value="7">1 Woche</option>
<option value="30">1 Monat</option>
<option value="365">1 Jahr</option>
</select><br>
<input type="submit" value="Login" name="postlogin">  
</form></div>'; 
if($getpage == "Login" and isset($_POST['postlogin'])) {

$mysql->query("SELECT id, username, password FROM accounts WHERE username = '".$_POST['id']."' AND password = '".sha1($_POST['pwd'])."' AND active = '1'", array());  

if (mysql_num_rows($mysql->result) > 0)  
{
$data = mysql_fetch_array ($mysql->result);  
$mysql->query("Select admin from accounts WHERE username = '".$_POST['id']."' AND admin = '1'", array());
$rows = mysql_num_rows($mysql->result);
if($rows == 1) { 
  setcookie($cp."_admin_id", $data['id'], time()+60*60*24*$_POST['cookietime'], $path, $domain);
  setcookie($cp."_admin_name", $data['username'], time()+60*60*24*$_POST['cookietime'], $path, $domain);
  setcookie($cp."_user_id", $data['id'], time()+60*60*24*$_POST['cookietime'], $path, $domain);
  setcookie($cp."_user_name", $data['username'], time()+60*60*24*$_POST['cookietime'], $path, $domain);
  $mysql->query("UPDATE accounts SET remote_addr = '".$_SERVER['REMOTE_ADDR']."' WHERE username = '".$data['username']."'", array());
echo '<meta http-equiv="refresh" content="0; url=?page=Administration">';
}
elseif($rows == 0) {
  setcookie($cp."_user_id", $data['id'], time()+60*60*24*$_POST['cookietime'], $path, $domain);
  setcookie($cp."_user_name", $data['username'], time()+60*60*24*$_POST['cookietime'], $path, $domain);
  $mysql->query("UPDATE accounts SET remote_addr = '".$_SERVER['REMOTE_ADDR']."' WHERE username = '".$data['username']."'", array());
echo '<meta http-equiv="refresh" content="0; url=?page=Index">';
}
}
else {
echo '<meta http-equiv="refresh" content="0; url=?page=Login&ID=error">';
}
}
if($getpage == "Login" and $getid == "logout") { 
  setcookie($cp."_admin_id", "", time()-60*60*24*365, $path, $domain);
  setcookie($cp."_admin_name", "", time()-60*60*24*365, $path, $domain);
  setcookie($cp."_user_id", "", time()-60*60*24*365, $path, $domain);
  setcookie($cp."_user_name", "", time()-60*60*24*365, $path, $domain);
echo '<meta http-equiv="refresh" content="0; url=?page=Index">';
}
}
}
{ #Registrierungs Bereich
if($getpage == 'Register' and empty($getid)) {
echo '<title>Registrierung - '.$sitename.'</title>
<div><form action="?page=Register" method="post">
Benutzername:<br><input type="text" name="username"><br>
Email-Addresse:<br><input type="text" name="email"><br>
Passwort:<br><input type="password" name="password"><br>
<input type="submit" name="register" value="Registrieren">
</form></div>';
if(isset($_POST['register']) AND !empty($_POST['email']) AND !empty($_POST['username']) AND !empty($_POST['password'])) {
$user = $_POST['username'];
$pw = sha1($_POST['password']);
$sql = "Select username from accounts WHERE username = '".$user."'";
$mysql->query($sql, array());
$rows = mysql_num_rows($mysql->result);
if($rows == 1) {
echo "<div>Der Benutzername wird bereits verwendet!</div>";
}
if($rows == 0) {
$mysql->query("INSERT INTO accounts (username, password, admin, safe, active, email) VALUES ('".$user."', '".$pw."', '0', '0', '0', '".$_POST['email']."')", array());
$mysql->query("SELECT id, username, password FROM accounts WHERE username = '".$user."' AND password = '".$pw."'", array());
$data = mysql_fetch_array($mysql->result);
$rows2 = mysql_num_rows($mysql->result);
if($rows2 == 1) { 
$mailto = $_POST['email'];
$mailsubject = "Ihr Account bei $sitename";
$mailmessage = "Hallo $user!
Wir freuen uns, dass du dich bei $sitename angemeldet hast.

Um deinen Account zu aktivieren, klicke bitte auf folgenden Link: http://".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']."?page=Activate&ID=".$data['id']."
Wenn der Link nicht funktioniert, versuche es bitte später nocheinmal. Oder wende dich an $impressum_email.

Accountdaten:

Benutzername: $user
Passwort: ".$_POST['password']."

Dein $sitename-Team.
--------------------------------------------------
Dies ist eine automatisch generierte Email. Bitte antworten sie nicht darauf.";
mail($mailto, $mailsubject, $mailmessage);
echo "<div>Der User wurde erstellt. Es wurde eine Bestätigungsemail zum überprüfen der Gültigkeit der angegebenen Email-Addresse geschickt.</div>";
}
}
}
}
}
{ #Aktivierungs Bereich
if($getpage == "Activate")
{
	echo "<title>Aktivierung - $sitename</title>";
	$mysql->query("UPDATE accounts SET active = '1' WHERE id = '$getid'", array());
	$mysql->query("SELECT username FROM accounts WHERE id = '$getid'", array());
	while($sql = mysql_fetch_array($mysql->result))
	{
		echo "<div>Du hast deinen Account ".$sql['username']." erfolgreich aktiviert!</div>";
	}
}
}
{ #Admin Bereich
if($getpage == "Administration") {
include "includes/admin.php";
include "includes/menu.php";
include_once "includes/class.mysql.php";
echo "<div>$menu_admin</div><br>";
$getposts = $_GET['posts'];
$getnews = $_GET['news'];
$getusers = $_GET['users'];
$getsettings = $_GET['settings'];
$getdownloads = $_GET['downloads'];
if($getpage == "Administration" and empty($getposts) and empty($getusers) and empty($getnews) and empty($getsettings) and empty($getdownloads) and empty($getforwarding) and empty($getid)) {
echo "<title>Adminpanel - $sitename</title>";
echo "<div>Bitte wähle einer der oben genannten Optionen</div>";
}
if($getpage == "Administration" and $getposts == 'create') {
echo "<title>Beitrag erstellen - $sitename</title>";
echo '<div><form action="" method="post">
Titel: <input type="text" name="name" size="80" maxlength="50"><br>
<textarea type="text" name="text" style="width:100%; height:275"></textarea>
<input type="image" src="'.$template.'/buttons/next.png" onmouseover="this.src=\''.$template.'/buttons/next_hover.png\';" onmouseout="this.src=\''.$template.'/buttons/next.png\';" name="submit" alt="erstellen">
<form></div>';
}
if(isset($_POST['name'])) {
$name = $_POST['name'];
$pretext = str_replace("\r\n", "\r\n<br>", $_POST['text']);
$text = str_replace('href="', 'href="index.php?page=Redirect&ID=', $pretext);
if(empty($name)) {
echo '<meta http-equiv="refresh" content="0; url=?page=Administration&ID=error">';
}
else {
$mysql->query("INSERT INTO posts (name, text, username) VALUES ('".$name."', '".$text."', '".$_COOKIE[$cp.'_admin_name']."')", array());

echo '<meta http-equiv="refresh" content="0; url=?page=Administration&ID=success">';
}
}
if($getpage == "Administration" and $getposts == 'delete') {
echo "<title>Beitrag löschen - $sitename</title>";
$mysql->query("select id,name,username from posts", array());
echo "<div>";
while($sql = mysql_fetch_array($mysql->result)) {
echo '<form action="" method="post">
<input type="submit" value="'.$sql["name"].' von '.$sql["username"].' löschen" name="'.$sql["id"].'">
</form>';
if(isset($_POST[$sql['id']])) {
$mysql->query("DELETE FROM posts WHERE id = '".$sql['id']."'", array());

echo '<meta http-equiv="refresh" content="0; url=?page=Administration&ID=success">';
}
}
echo "</div>";
}
if($getpage == "Administration" and $getid == "success") {
echo "<title>Erfolgreich - $sitename</title>";
echo '<div>Aktion erfolgreich ausgeführt!<br><a href="?page=Administration">Weiter</a><meta http-equiv="refresh" content="3; url=?page=Administration"></div>';
}
if($getpage == "Administration" and $getid == "error") {
echo "<title>Fehler - $sitename</title>";
echo "<div>Dir ist ein Fehler unterlaufen!<br><input type=\"button\" value=\"Zurück\" onclick=\"history.back(-1)\"></div>";
}
if($getpage == "Administration" and $getusers == 'delete') {
echo "<title>Benutzer löschen - $sitename</title>";
$mysql->query("select id,username from accounts WHERE safe = '0'", array());
echo "<div>";
while($sql = mysql_fetch_array($mysql->result)) {
echo '<form action="" method="post">
<input type="submit" value="'.$sql["username"].' löschen" name="'.$sql["id"].'">
</form>';
if(isset($_POST[$sql['id']])) {
$mysql->query("DELETE FROM accounts WHERE id = '".$sql['id']."' and safe = '0'", array());

echo '<meta http-equiv="refresh" content="0; url=?page=Administration&ID=success">';
}
}
echo "</div>";
}
if($getpage == "Administration" and $getusers == 'list') {
echo "<title>Benutzerliste - $sitename</title>";
echo "<div><b><u>Administratoren:</u></b><br>";
$mysql->query("select username from accounts where admin = '1'", array());
while($sqladmin = mysql_fetch_array($mysql->result)) {
echo $sqladmin['username']."<br>";
}
echo "</div>";
echo "<div><b><u>Benutzer:</u></b><br>";
$mysql->query("select username from accounts where admin = '0'", array());
while($sql = mysql_fetch_array($mysql->result)) {
echo $sql['username']."<br>";
}
echo "</div>";
}
if($getpage == "Administration" and $getusers == 'manage') {
echo "<title>Benutzerverwaltung - $sitename</title>";
$mysql->query("select id,username from accounts WHERE admin = '1' AND safe = '0'", array());
echo "<div>";
while($sql = mysql_fetch_array($mysql->result)) {
echo '<form action="" method="post">
<input type="submit" value="'.$sql["username"].' zum Benutzer degradieren" name="unset'.$sql["id"].'">
</form>';
if(isset($_POST["unset".$sql['id']])) {
$mysql->query("UPDATE accounts SET admin = '0' WHERE id = '".$sql['id']."'", array());

echo '<meta http-equiv="refresh" content="0; url=?page=Administration&ID=success">';
}
}
echo "</div>";
$mysql->query("select id,username from accounts WHERE admin = '0'", array());
echo "<div>";
while($sql = mysql_fetch_array($mysql->result)) {
echo '<form action="" method="post">
<input type="submit" value="'.$sql["username"].' zum Admin befördern" name="set'.$sql["id"].'">
</form>';
if(isset($_POST["set".$sql['id']])) {
$mysql->query("UPDATE accounts SET admin = '1' WHERE id = '".$sql['id']."'", array());

echo '<meta http-equiv="refresh" content="0; url=?page=Administration&ID=success">';
}
}
echo "</div>";
}
if($getpage == "Administration" and $getnews == 'create') {
echo "<title>News erstellen - $sitename</title>";
echo '<div><form action="" method="post">
Titel: <input type="text" name="newsname" size="80" maxlength="50"><br>
<textarea type="text" name="text" style="width:100%; height:275"></textarea>
<input type="image" src="'.$template.'/buttons/next.png" onmouseover="this.src=\''.$template.'/buttons/next_hover.png\';" onmouseout="this.src=\''.$template.'/buttons/next.png\';" name="newssubmit" alt="erstellen">
<form></div>';
}
if(isset($_POST['newsname'])) {
$name = $_POST['newsname'];
$pretext = str_replace("\r\n", "\r\n<br>", $_POST['text']);
$text = str_replace('href="', 'href="index.php?page=Redirect&ID=', $pretext);
if(empty($name)) {
echo '<meta http-equiv="refresh" content="0, url=?page=Administration&ID=error">';
}
else {
$mysql->query("INSERT INTO news (name, text, username) VALUES ('".$name."', '".$text."', '".$_COOKIE[$cp.'_admin_name']."')", array());

echo '<meta http-equiv="refresh" content="0; url=?page=Administration&ID=success">';
}
}
if($getpage == "Administration" and $getnews == 'delete') {
echo "<title>News löschen - $sitename</title>";
$mysql->query("select id,name,username from news", array());
echo "<div>";
while($sql = mysql_fetch_array($mysql->result)) {
echo '<form action="" method="post">
<input type="submit" value="'.$sql["name"].' von '.$sql["username"].' löschen" name="'.$sql['id'].'">
</form>';
if(isset($_POST[$sql['id']])) {
$mysql->query("DELETE FROM news WHERE id = '".$sql['id']."'", array());

echo '<meta http-equiv="refresh" content="0; url=?page=Administration&ID=success">';
}
}
echo "</div>";
}
if($getpage == "Administration" and $getsettings == "cms") {
$email = str_replace("[at]", "", $impressum_email);
echo "<title>Einstellungen - $sitename</title>";
echo '<div><form action="" method="post">';
if($gastkommentar == 1) {
echo 'Gast Kommentare: <select name="gastkommentar"><option value="1">Erlauben</option><option value="0">Verbieten</option></select><br>';
}
else {
echo 'Gast Kommentare: <select name="gastkommentar"><option value="0">Verbieten</option><option value="1">Erlauben</option></select><br>';
}
echo '<h3>Server-Konfiguration:</h3>
Seitenname:<br><input type="text" name="sitename" value="'.$sitename.'" maxlength="25"><br>
Datenbank-Host:<br><input type="text" name="dbhost" value="'.$dbhost.'" maxlength="50"><br>
Datenbank-Name:<br><input type="text" name="dbname" value="'.$dbname.'" maxlength="25"><br>
Datenbank-Benutzer:<br><input type="text" name="dbuser" value="'.$dbuser.'" maxlength="25"><br>
Datenbank-Passwort:<br><input type="password" name="dbpasswd" value="'.$dbpasswd.'" maxlength="50"><br>
Cookie-Präfix:<br><input type="text" name="cp" value="'.$cp.'" maxlength="10">
<h3>Impressum-Konfiguration (optional)</h3>
Name:<br><input type="text" name="impressum_name" value="'.$impressum_name.'" maxlength="50"><br>
Land:<br><input type="text" name="impressum_land" value="'.$impressum_land.'" maxlength="50"><br>
Postleitzahl:<br><input type="text" name="impressum_postleitzahl" value="'.$impressum_postleitzahl.'" maxlength="50"><br>
Stadt:<br><input type="text" name="impressum_stadt" value="'.$impressum_stadt.'" maxlength="50"><br>
Straße:<br><input type="text" name="impressum_straße" value="'.$impressum_straße.'" maxlength="50"><br>
Hausnummer:<br><input type="text" name="impressum_hausnummer" value="'.$impressum_hausnummer.'" maxlength="50"><br>
E-Mail:<br><input type="text" name="impressum_email" value="'.$email.'" maxlength="50"><br>
Telefon:<br><input type="text" name="impressum_telefon" value="'.$impressum_telefon.'" maxlength="50">
<h3>CMS</h3>
Template:<br><input type="text" name="template" value="'.$templates["template"].'"><br>
<input type="image" src="'.$template.'/buttons/next.png" onmouseover="this.src=\''.$template.'/buttons/next_hover.png\';" onmouseout="this.src=\''.$template.'/buttons/next.png\';" name="configure" alt="Weiter">
</form></div>';
if(isset($_POST['sitename'])) {
$email = str_replace("", "[at]", $_POST['impressum_email']);
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
\$gastkommentar = \"".$_POST['gastkommentar']."\";
?>";
if (is_writable($configfile)) {

    if (!$handle = fopen($configfile, "w+")) {
         print "<div>Kann die Datei $configfile nicht öffnen</div>";
         exit;
    }
    if (!fwrite($handle, $write)) {
        print "<div>Kann in die Datei $configfile nicht schreiben</div>";
        exit;
    }

    print "<div>Konfiguration erfolgreich!</div>";

    fclose($handle);
	$mysql->query("UPDATE cms_info SET template = '".$_POST['template']."'", array());
	echo '<meta http-equiv="refresh" content="0, url=?page=Administration&ID=success">';

} else {
    print "<div>Die Datei $configfile ist nicht schreibbar</div>";
}
}
}
if($getpage == "Administration" and $getdownloads == 'create') {
echo "<title>Download erstellen - $sitename</title>";
echo '<div><h4>Please do just upload ZIP-Archives,RAR-Archives or Executables. Otherwise the File will be damaged!</h4>
<form action="" method="post" enctype="multipart/form-data">
Name: <input type="text" name="dlname" size="50"><br>
Datei: <input type="file" name="datei" size="75"><br>
Hochladen: <input type="image" src="'.$template.'/buttons/next.png" onmouseover="this.src=\''.$template.'/buttons/next_hover.png\';" onmouseout="this.src=\''.$template.'/buttons/next.png\';" alt="Hochladen" name="add">
</form></div>';
if(isset($_POST['dlname'])) {
move_uploaded_file($_FILES['datei']['tmp_name'], "downloads/".$_FILES['datei']['name']);
$mysql->query("INSERT INTO downloads (name, filename, downloads) VALUES ('".$_POST['dlname']."', '".$_FILES['datei']['name']."', '0')", array());
echo "<div>Datei hochgeladen</div>";
}
}
if($getpage == "Administration" and $getdownloads == 'delete') {
echo "<title>Download löschen - $sitename</title>";
$mysql->query("select * from downloads", array());
echo "<div>";
while($sql = mysql_fetch_array($mysql->result)) {
echo '<form action="" method="post">
<input type="submit" value="'.$sql["name"].' ('.$sql["downloads"].' Downloads) löschen" name="'.$sql["id"].'">
</form>';
if(isset($_POST[$sql['id']])) {
$mysql->query("DELETE FROM downloads WHERE id = '".$sql['id']."'", array());
unlink("downloads/".$sql['filename']);

echo '<meta http-equiv="refresh" content="0; url=?page=Administration&ID=success">';
}
}
echo "</div>";
}
if($getpage == "Administration" and $getposts == "edit" and empty($getid)) {
$mysql->query("select * from posts", array());
echo "<title>Beitrag editieren - $sitename</title>";
echo "<div>";
while($sql = mysql_fetch_array($mysql->result)) {
echo "<a href='?page=Administration&posts=edit&ID=".$sql['id']."'>\"".$sql['name']."\" editieren</a><br>";
}
echo "</div>";
}
if($getpage == "Administration" and $getposts == "edit" and isset($getid)) {
$mysql->query("select * from posts where id = '$getid'", array());
while($sql = mysql_fetch_array($mysql->result)) {
$text = str_replace("<br>", "", $sql['text']);
echo "<title>".$sql['name']." editieren (Beitrag) - $sitename</title>";
echo '<div><form action="" method="post">
Titel: <input type="text" name="pname" size="80" maxlength="50" value="'.$sql["name"].'"><br>
<textarea type="text" name="text" style="width:100%; height:275">'.$text.'</textarea><br>
<input type="image" src="'.$template.'/buttons/next.png" onmouseover="this.src=\''.$template.'/buttons/next_hover.png\';" onmouseout="this.src=\''.$template.'/buttons/next.png\';" name="peditsubmit" alt="editieren"></div>';
}
}
if(isset($_POST['pname'])) {
echo "<title>".$_POST['pname']." editieren (Beitrag) - $sitename</title>";
$text = str_replace("\r\n", "\r\n<br>", $_POST['text']);
$mysql->query("UPDATE `posts` SET `name` = '".$_POST['pname']."' WHERE id = '$getid'", array());
$mysql->query("UPDATE `posts` SET `text` = '$text' WHERE id = '$getid'", array());
echo '<meta http-equiv="refresh" content="0, url=?page=Posts&ID='.$getid.'">';
}
if($getpage == "Administration" and $getnews == "edit" and empty($getid)) {
$mysql->query("select * from news", array());
echo "<title>News editieren - $sitename</title>";
while($sql = mysql_fetch_array($mysql->result)) {
echo "<a href='?page=Administration&news=edit&ID=".$sql['id']."'>\"".$sql['name']."\" editieren</a><br>";
}
}
if($getpage == "Administration" and $getnews == "edit" and isset($getid)) {
$mysql->query("select * from news where id = '$getid'", array());
while($sql = mysql_fetch_array($mysql->result)) {
echo "<title>".$sql['name']." editieren (News) - $sitename</title>";
$text = str_replace("<br>", "", $sql['text']);
echo '<div><form action="" method="post">
Titel: <input type="text" name="nname" size="80" maxlength="50" value="'.$sql["name"].'"><br>
<textarea type="text" name="text" style="width:100%; height:275">'.$text.'</textarea><br>
<input type="image" src="'.$template.'/buttons/next.png" onmouseover="this.src=\''.$template.'/buttons/next_hover.png\';" onmouseout="this.src=\''.$template.'/buttons/next.png\';" name="neditsubmit" alt="editieren"></div>';
}
}
if(isset($_POST['nname'])) {
echo "<title>".$_POST['nname']." editieren (News) - $sitename</title>";
$text = str_replace("\r\n", "\r\n<br>", $_POST['text']);
$mysql->query("UPDATE `news` SET `name` = '".$_POST['nname']."' WHERE id = '$getid'", array());
$mysql->query("UPDATE `news` SET `text` = '$text' WHERE id = '$getid'", array());
echo '<meta http-equiv="refresh" content="0, url=?page=News&ID='.$getid.'">';
}
}
}
echo "<ul id=\"Copyright\">Copyright by $sitename ".date('Y')."</ul>";
?>
</body>