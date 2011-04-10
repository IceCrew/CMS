<?php
include "lib/header.php";
include "lib/config.php";
include "lib/mysql.php";
if(empty($_GET)) {
$files = mysql_query("select id,name from downloads");
while($file = mysql_fetch_array($files)) {
echo "<a href='?dl=".$file['id']."'>".$file['name']."</a><br>";
}
}
if(isset($_GET['dl')) {
$download = $_GET['dl'];
$basedir = "./downloads";
$downloads = mysql_fetch_array(mysql_query("select id,filename from downloads"));
$filelist = array(
    $downloads['id'] => $downloads['filename'],
);
if (!isset($filelist[$download]))
  die("Download ID $download nicht vorhanden.");
$filename = sprintf("%s/%s", $basedir, $filelist[$download]);
header("Content-Type: application/octet-stream");
$save_as_name = basename($filelist[$download]);
header("Content-Disposition: attachment; filename=\"$save_as_name\"");
readfile($filename);
}
?>