<?php  
if(!file_exists("lib/config.php")) {
echo "<center>Das Script ist nicht installiert! Jetzt installieren? <a href=\"install/index.php\">Ja</a> oder <a href=\"index.php\">Nein</a></center>";
die;
}
else {
include "lib/config.php"; 
include_once "lib/class.mysql.php";
include "lib/header.php";
}
if(empty($_GET)) {
?>  
<html>  
<head>  
  <title><? echo $sitename ?></title>  
</head>  
<body>
<?
$mysql->query("select id,name,text,username from news", array());
while($sql = mysql_fetch_array($mysql->result)) {
$text = $sql['text'];
echo 'Titel: <a href="index.php?newsID='.$sql["id"].'">'.$sql['name'].'</a><br><br>'.$text.'<br><br>Von '.$sql['username'].' geschrieben<hr>';
}
}
if(isset($_GET['postID'])) {
$id = $_GET['postID'];
$mysql->query("select name,text,username from posts where id='".$id."'", array());
while($data = mysql_fetch_array($mysql->result)) {
?><title><? echo $data['name']." - ".$sitename ?></title><?
echo "Post: ".$data['name'];
echo "<br><br>";
echo $data['text'];
echo "<br><br>";
echo "Von ".$data['username']." geschrieben";
}
echo "<hr>";
}
if(isset($_GET['posts'])) {
?><title>Alle Beiträge - <? echo $sitename ?></title><?
$mysql->query("select id, name from posts", array());
while($sql = mysql_fetch_array($mysql->result)) {
echo "<a href=\"?postID=".$sql['id']."\">".$sql['name']."</a><br>";
}
echo "<hr>";
}
if(isset($_GET['newsID'])) {
$id = $_GET['newsID'];
$mysql->query("select name,text,username from news where id='".$id."'", array());
while($data = mysql_fetch_array($mysql->result)) {
?><title><? echo $data['name']." - ".$sitename ?></title><?
echo "News: ".$data['name'];
echo "<br><br>";
echo $data['text'];
echo "<br><br>";
echo "Von ".$data['username']." geschrieben";
}
echo "<hr>";
}
if(isset($_GET['news'])) {
?><title>Alle Beiträge - <? echo $sitename ?></title><?
$mysql->query("select id, name from news", array());
while($sql = mysql_fetch_array($mysql->result)) {
echo "<a href=\"?newsID=".$sql['id']."\">".$sql['name']."</a><br>";
}
echo "<hr>";
}
$gethelp = $_GET['help'];
if(isset($gethelp)) {
include "lib/help.php";
?>
<title>Hilfe - <? echo $sitename ?></title>
<?
echo '<a href="?help=html#html">HTML-Hilfe</a>';
if($gethelp == 'html') {
?>
<title>HTML-Hilfe - <? echo $sitename ?></title>
<?
echo $help_html;
}
echo "<hr>";
}
?>  
<? echo $footer ?>  
</body>  
</html>