<?php 
include "config.php";
if (!isset ($_COOKIE[$sitename."_user_id"]))  
{  
echo '<meta http-equiv="refresh" content="0; url=index.php?page=Login">';
}
?>