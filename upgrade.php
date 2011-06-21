<title>IceCrew CMS Upgrade</title>
<?php
echo '<body background="images/templates/default/site/background.png"></body>
<img src="images/templates/default/site/logo.png"></img><hr>';
$version = 3;
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
echo 'IceCrew CMS wird von '.$data["version"].' auf '.$version.' aktuallisiert.
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
		$mysql->query("ALTER TABLE cms_info ADD template text", array());
		$mysql->query("UPDATE cms_info SET template = 'default'", array());
		unlink("includes/header.php");
		echo "Upgrade erfolgreich!";
	}
	if($pversion == 2)
	{
		$mysql->query("ALTER TABLE cms_info ADD template text", array());
		$mysql->query("UPDATE cms_info SET template = 'default'", array());
		$mysql->query("UPDATE cms_info SET version = 3", array());
		unlink("includes/header.php");
		echo "Update erfolgreich!";
	}
}
echo '<form action="index.php" method="post">
<input type="submit" name="installdeletefiles" value="Installations Dateien löschen">
</form>';
}
?>