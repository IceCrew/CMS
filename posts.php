<?php
include "lib/config.php";
include "lib/mysql.php";
include "lib/header.php";
if(isset($_GET['show'])) {
$id = $_GET['show'];
$datas = mysql_query("select name,text,username from posts where id='".$id."'");
while($data = mysql_fetch_array($datas)) {
?><title><? echo $data['name']." - ".$sitename ?></title><?
echo "Titel: ".$data['name'];
echo "<br><br>";
echo $data['text'];
echo "<br><br>";
echo "Von ".$data['username']." geschrieben";
}
}
if(empty($_GET)) {
?><title>Alle Beitr�ge - <? echo $sitename ?></title><?
$sqls = mysql_query("select id, name from posts");
while($sql = mysql_fetch_array($sqls)) {
echo "<a href=\"links.php?show=".$sql['id']."\">".$sql['name']."</a><br>";
}
}
echo "<hr>".$footer;
?>