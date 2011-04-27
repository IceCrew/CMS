<?php
include "lib/config.php";
include "lib/header.php";
include "lib/mysql.php";
if(empty($_GET)) {
while($dl = mysql_fetch_array(mysql_query("select * from downloads"))) {
echo "<a href='downloads/".$dl['filename']."'>".$dl['name']."</a><br>";
}
}
if(isset($_GET['dl'])) {
$getdl = $_GET['dl'];
while($dl = mysql_fetch_array(mysql_query("select * from downloads where id = '".$getdl."'"))) {
header('Content-type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.$dl['filename'].'"');
readfile('downloads/'.$dl['filename']);
}
}
echo "<hr>$footer";
?>