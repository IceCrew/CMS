<?php 
include "config.php"; 
if (!isset ($_COOKIE[$cp."_admin_id"]))
{  
echo '<meta http-equiv="refresh" content="0; url=?page=Index">';
die;
}
?>