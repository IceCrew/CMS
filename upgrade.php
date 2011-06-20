<title>Upgrade</title>
<?php
$version = 2;
if(!file_exists("includes/config.php") AND file_exists("includes/config.php.new")) {
echo '<meta http-equiv="refresh" content="0; URL=install.php">';
die;
}
else {
@unlink('includes/config.php.new');
include 'includes/config.php';
include_once 'includes/class.mysql.php';
$mysql->query("SELECT version FROM cms_info", array());
$data = @mysql_fetch_array($mysql->result);
echo 'cFire wird von '.$data["version"].' auf '.$version.' aktuallisiert.
<form action="" method="post">
<input type="submit" name="update" value="Updaten">
</form>';
if(isset($_POST["update"]))
{
	
	$pversion = $data['version'];
	if($pversion == 1)
	{
		$mysql->query("ALTER TABLE accounts ADD remote_addr text AFTER password", array());
		$mysql->query("UPDATE cms_info SET version = $version", array());
		echo "Upgrade erfolgreich!";
	}
}
echo '<form action="index.php" method="post">
<input type="submit" name="installdeletefiles" value="Installations Dateien löschen">
</form>';
}
?>