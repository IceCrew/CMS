<?php 
include "config.php"; 
if (!isset ($_COOKIE[$sitename."_admin_id"]))
{  
echo '<meta http-equiv="refresh" content="0; url=index.php?page=Index">';
}
?>