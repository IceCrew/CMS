<?php 
include "config.php";
session_start ();  
if (!isset ($_SESSION[$sitename."_user_id"]))  
{  
echo '<meta http-equiv="refresh" content="0; url=login.php">';
}
?>