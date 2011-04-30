<?php
include "config.php";
session_start ();  
if (!isset ($_SESSION[$sitename."_all_user_id"]))
{  
  header ("Location: login.php");  
}
?>