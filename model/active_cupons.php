<?php
@session_start();
@include("db_core.php");
class cupones{
	var $db;	
	function cupones(){
		$this->db = new db_core();
	}
	function getCupones(){
		$user = $this->db->reg_one("SELECT id_user FROM session_log WHERE token='".$_SESSION['token']."'");
		$consulta[0] = $this->db->db_query("SELECT * FROM productos as p 
			LEFT JOIN transacciones ON transacciones.id_producto=p.id_item 
			INNER JOIN imagenes_productos ON imagenes_productos.id_item = p.id_item
			WHERE transacciones.id_user='".$user[0]."' AND transacciones.statusPay='1' AND p.expiracion >= '".date('Y-m-d h:i:s',time())."';");
		if(mysql_num_rows($consulta[0]) != 0)
		{
			while($consulta[1] = mysql_fetch_array($consulta[0]))
			{
				echo '<div class="row activecupons">
					<div class="lineProductImg"><img src="'.$consulta[1]['source'].'" height="100px" width="150px" /></div>
					<div class="desProductImg">
						<div class="TitleTab">Descripcion del Cupon</div>
						<div class="ContentTab">'.utf8_encode($consulta[1]['descripcion_small']).'</div>
					</div>
					<div class="expirationTime">
						<div class="TitleTab">Fecha de Expiracion</div>
						<div class="ContentTab">'.$consulta[1]['expiracion'].'</div>
					</div>
					<div class="seeMore">
						<div class="TitleTab">Ver Cupon</div>
						<div class="ContentTab"><span class="glyphicon glyphicon-file iconcupon pdfCupon" onClick="location.href=\'model/getCupon.php?id='.$consulta[1]['id_transaccion'].'\'" ></span></div>
					</div>
					<div class="mailCupon">
						<div class="TitleTab">Enviar a E-Mail</div>
						<div class="ContentTab"><span class="glyphicon glyphicon-envelope iconcupon mailCupon" numid="'.$consulta[1]['id_transaccion'].'" ></span></div>
					</div>
				</div>';
			}
		}
		else
		{
			echo '<div class="row">No se encuentran productos validos comprados a la fecha</div>';
			
		}
	}
	function getNumCupones()
	{
		$user = $this->db->reg_one("SELECT id_user FROM session_log WHERE token='".$_SESSION['token']."'");
		return $consulta[0] = $this->db->num_one("SELECT * FROM productos as p 
			LEFT JOIN transacciones ON transacciones.id_producto=p.id_item 
			INNER JOIN imagenes_productos ON imagenes_productos.id_item = p.id_item
			WHERE transacciones.id_user='".$user[0]."' AND transacciones.statusPay='1' AND p.expiracion < ".time().";");
	}
}
$cupones = new cupones();
$cupones->getCupones();
?>