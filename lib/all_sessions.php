<?php
include "config.php";
@session_start ();  
if (!isset ($_SESSION[$sitename."_all_user_id"]))
{  
echo '<meta http-equiv="refresh" content="0; url=index.php?page=Login">';
}
?>