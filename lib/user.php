<?php 
include "config.php";
if (!isset ($_COOKIE[$cp."_user_id"]))  
{  
echo '<meta http-equiv="refresh" content="0; url=index.php?page=Login">';
}
?>