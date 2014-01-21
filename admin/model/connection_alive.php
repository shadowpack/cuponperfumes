<?php 
session_start();
header("Expires: Thu, 27 Mar 1980 23:59:00 GMT"); //la pagina expira en una fecha pasadaheader 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
header("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
header("Pragma: no-cache");
if(!class_exists('db_core'))
{
	require_once('db_core.php');
}
if(isset($_SESSION['token_admin'])){
	$db = new db_core();
	if(!$db->isExists('admin_log', 'token', $_SESSION['token_admin'])){
		header("location:login.php");
	}
}
else
{
	header("location:login.php");
}
?>