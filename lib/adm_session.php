<?php 
include "config.php";
session_start ();  
if (!isset ($_SESSION[$sitename."_adm_user_id"]))
{  
  header ("Location: login.php");  
}
?>