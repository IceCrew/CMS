<?php 
include "config.php";
@session_start ();  
if (!isset ($_SESSION[$sitename."_adm_user_id"]))
{  
echo '<meta http-equiv="refresh" content="0; url=index.php?page=Login">';
}
?>