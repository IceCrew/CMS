<?php
include "lib/config.php";
include "lib/header.php";
?>
<title>Weiterleiten - <? echo $sitename ?></title>
Du wirst in 3 Sekunden weitergeleitet
<head><meta http-equiv="refresh" content="3; <? echo $_SERVER['QUERY_STRING'] ?>"></head>
<?
echo "<hr>".$footer;
?>