<?php
@include_once("model/db_core.php");
@include_once("../model/db_core.php");
@include_once("db_core.php");
class sellResult{
	private $db;
	function sellResult(){
		$this->db = new db_core();
	}
	function getSellData($id){
		$consulta = $this->db->reg_one("SELECT * FROM transacciones_transbank AS t WHERE t.TBK_ORDEN_COMPRA='".$id."'");
		$name = $this->db->reg_one("SELECT * FROM users AS u WHERE u.id_user='".$_SESSION['id']."'");
		$product = $this->db->reg_one("SELECT category.`name`, productos.nombre, transacciones.fecha, productos.precio_descuento, transacciones.delivery, productos.precio_delivery FROM transacciones INNER JOIN productos ON id_item = id_producto INNER JOIN category ON category.id_category=productos.category_id WHERE transacciones.tbk_orden_compra='".$id."'");
		$consulta["name"] = $name["name"];
		if($product['delivery'] == 1)
		{
			$consulta["delivery"] = "$ ".number_format($product['precio_delivery'],0,",",".");
			$consulta['TBK_MONTO'] = $product["precio_descuento"] + $product['precio_delivery'];
			$consulta['unitario'] = $product["precio_descuento"];
		}
		else
		{
			$consulta["delivery"] = "No aplica";
			$consulta['TBK_MONTO'] = $product["precio_descuento"];
			$consulta['unitario'] = $product["precio_descuento"];
		}
		$consulta["product"] = utf8_encode($product["name"]." ".$product["nombre"]);
		$consulta['TBK_FECHA_TRANSACCION'] = date("d/m/Y h:i:s", $product["fecha"]);
		
		switch($consulta['TBK_RESPUESTA']){
			case 0:
				$consulta['TBK_VCI'] = "Transaccion Aprobada";
				break;
			case -1:
				$consulta['TBK_VCI'] = "Transaccion Rechazada";
				break;
			case -2:
				$consulta['TBK_VCI'] = "La transaccion debe reintentarse";
				break;
			case -3:
				$consulta['TBK_VCI'] = "Error en transaccion";
				break;
			case -4: 
				$consulta['TBK_VCI'] = "Rechazo de transaccion";
				break;
			case -5: 
				$consulta['TBK_VCI'] = "Rechazo por error de tasa";
				break;
			case -6:
				$consulta['TBK_VCI'] = "Excede cupo máximo mensual";
				break;
			case -7:
				$consulta['TBK_VCI'] = "Excede límite diario por transacción";
				break;
			case -8:
				$consulta['TBK_VCI'] = "Rubro no autorizado";
				break;
		}
		switch($consulta['TBK_TIPO_PAGO']){
			case "VD":
				$consulta['TBK_TIPO_PAGO'] = "Red Compra";
				$consulta['TBK-TIPO-CUOTA'] = "Venta Debito";
				$consulta['TBK_NUMERO_CUOTAS'] = "0";
				break;
			case "VN":
				$consulta['TBK_TIPO_PAGO'] = "Credito";
				$consulta['TBK-TIPO-CUOTA'] = "Sin Cuotas";
				break;
			case "VC":
				$consulta['TBK_TIPO_PAGO'] = "Credito";
				$consulta['TBK-TIPO-CUOTA'] = "Cuotas Normales";
				break;
			case "SI":
				$consulta['TBK_TIPO_PAGO'] = "Credito";
				$consulta['TBK-TIPO-CUOTA'] = "Sin Interes";
				break;
			case "S2":
				$consulta['TBK_TIPO_PAGO'] = "Credito";
				$consulta['TBK-TIPO-CUOTA'] = "Sin Interes";
				break;
			case "CI":
				$consulta['TBK_TIPO_PAGO'] = "Credito";
				$consulta['TBK-TIPO-CUOTA'] = "Cuotas Comercio";
				break;
		}
		return $consulta;
	}
}
?>