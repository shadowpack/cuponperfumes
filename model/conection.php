<?php
    include_once("db_core.php");
	session_start();
	if(isset($_SESSION['token'])){
		$db = new db_core();
		if($db->isExists('session_log', 'token', $_SESSION['token'])){
			echo "true";
		}
		else
		{
			echo "false";
		}
	}
	else
	{
		echo "false";
	}
?>