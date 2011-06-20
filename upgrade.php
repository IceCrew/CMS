<title>Upgrade</title>
<?php
if(!file_exists("includes/config.php")) {
echo "Ist noch nicht installiert! <a href=\"\">Klicke hier um es zu installieren</a>";
die;
}
else {
include 'includes/config.php';
include_once 'includes/class.mysql.php';
$mysql->query("SELECT version FROM cms_info", array());
$data = @mysql_fetch_array($mysql->result);
echo 'Bitte wähle deine Version aus: '.$data["version"].'
<form action="" method="post">
<select name="version">
<option value="0">Bitte wähle eine Version</option>
<option value="1">Version 1</option>
</select>
<input type="submit" name="select" value="Version bestätigen">
</form>';
if(isset($_POST["select"]))
{
	$pversion = $_POST["version"];
	if($pversion == 1)
	{
		$mysql->query("ALTER TABLE accounts ADD remote_addr text AFTER password", array());
		$mysql->query("UPDATE cms_info SET version = 2", array());
		echo "Upgrade erfolgreich!";
	}
}
}
?>