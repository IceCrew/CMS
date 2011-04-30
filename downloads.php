<?php
include "lib/config.php";
include "lib/header.php";
include_once "lib/class.mysql.php";
echo "<title>Downloads - $sitename</title>";
if(empty($_GET)) {
$dls = mysql_query("select * from downloads", array());
while($dl = mysql_fetch_array($dls)) {
echo "<a href='?dl=".$dl['id']."'>".$dl['name']."</a><br>";
}
}
if(isset($_GET['dl'])) {
$getdl = $_GET['dl'];
$mysql->query("select * from downloads where id = '".$getdl."'", array());
while($dl = mysql_fetch_array($mysql->result)) {
header('Content-type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.$dl['filename'].'"');
readfile('downloads/'.$dl['filename']);
}
}
echo "<hr>$footer";
?>