<?php
	@session_start();
	require_once("../model/checkout.php");
	@include("../model/db_core.php");
	$checkout = new checkout();
	$db = new db_core();
	$db->db_query('INSERT INTO transacciones_transbank (TBK_MONTO) VALUES ("'.$checkout->getTotal().'")');
	$id = mysql_insert_id();
	$retorno = array();
	$retorno['id_transaccion'] = $id;
	$user = $db->reg_one("SELECT id_user FROM session_log WHERE token='".$_SESSION['token']."'");
	for($i=0; $i<$_SESSION["CuponPerfumes-Sell"]['number']; $i++) {
		if($_SESSION["CuponPerfumes-Sell"]['delivery'])
		{
			$db->db_query("INSERT INTO transacciones (id_producto,id_user,tbk_orden_compra,fecha,statusPay,cantidad,location,delivery,tipo_medio) VALUES ('".$_SESSION["CuponPerfumes-Sell"]['id']."','".$user[0]."','".$id."','".time()."','0','1','".$_POST['location']."','1', '".$_POST['medio']."')");
		}
		else
		{
			$db->db_query("INSERT INTO transacciones (id_producto,id_user,tbk_orden_compra,fecha,statusPay,cantidad,location,delivery,tipo_medio) VALUES ('".$_SESSION["CuponPerfumes-Sell"]['id']."','".$user[0]."','".$id."','".time()."','0','1','','0', '".$_POST['medio']."')");
		}
		
	}
	$retorno['monto'] = $checkout->getTotal().".00";
	echo json_encode((object)$retorno);

?>