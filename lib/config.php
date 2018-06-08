<?php
$host = "mysql.hostinger.es";
$dbuser = "u318729732_root";
$dbpwd = "F7ujPUX5kqoZ";
$db = "u318729732_based";

$connect = mysqli_connect ($host, $dbuser, $dbpwd);
	if(!$connect)
		echo ("No se ha conectado a la base de datos");
	else
		$select = mysqli_select_db ($connect, $db);
?>
