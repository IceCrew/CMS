<?php
require('config.php');

class mysql
{
	private $dbhost;
	private $dbuser;
	private $dbpasswd;
	private $dbname;
	private $args = array();
	private $sql;
	public $result;
	public $rows;

	public function __construct($dbuser, $dbpasswd, $dbhost, $dbname)
	{
		$this->user = $dbuser;
		$this->pass = $dbpasswd;
		$this->host = $dbhost;
		$this->name = $dbname;
		mysql_connect($this->host, $this->user, $this->pass) or die("Connection failed");
		mysql_select_db($this->name) or die ("Database not found");
	}
	
	public function query($sql,array $args)
	{
		$this->args = array();
		foreach($args as $key)
		{
			array_push($this->args, mysql_real_escape_string($key));
		}
		array_unshift($this->args, $sql);
		$this->sql = call_user_func_array('sprintf',$this->args);
		$this->result = mysql_query($this->sql);
		$this->rows = mysql_affected_rows();
	}
	
	public function destruct()
	{
		@mysql_free_result($this->lastResult);
		mysql_close();
	}
}

$mysql = new mysql($dbuser, $dbpasswd, $dbhost, $dbname);