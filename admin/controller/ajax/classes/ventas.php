<?php
	if(!class_exists('webservice'))
	{
		require_once('webservice.php');
	}
	class ventas extends webservice{
		public function ventas(){

		}
		//CREAMOS LOS METODOS QUE ENTREGAN LOS GRAFICOS
		public function grafico($data){
			$db = new db_core();
			$date = array();
			$consulta[0] = $db->db_query("SELECT DISTINCT FROM_UNIXTIME(fecha_compra,'%Y-%m-%d') AS fecha from cupones WHERE fecha_compra > (UNIX_TIMESTAMP(CURRENT_DATE())-(3600*24*30))");
			while($consulta[1] = mysql_fetch_array($consulta[0], MYSQL_ASSOC)){
				$fecha = $db->reg_one("SELECT COUNT(*) FROM cupones WHERE FROM_UNIXTIME(fecha_compra,'%Y-%m-%d') = '".$consulta[1]['fecha']."'");
				$date[] = (object)array(
					"d"=>$consulta[1]['fecha'],
					"ventas"=>$fecha[0]
				);
			}
			echo json_encode($date);
		}
		// CREAMOS LA FUNCION DE QUEMA DE CUPON
		public function burnCupon($data){
			sleep(2);
			$db = new db_core();
			$verify['codigo_cupon'] = $data->codigo;
			$verify['estado'] = 0;
			if($db->isExists_multi('cupones', $verify)){
				$in['estado'] = 1;
				$where['codigo_cupon'] = $data->codigo;
				$db->update('cupones', $in, $where);
				$datos = array();
				$consulta[0] = $db->db_query("SELECT productos.nombre,  users.nombre AS cliente, cupones.fecha_compra, IF(transacciones.delivery=1,'Si','No'), users.location, users.comuna, users.city, cupones.codigo_cupon, users.direccion_original FROM cupones INNER JOIN transacciones ON cupones.id_transaccion = transacciones.id_transaccion INNER JOIN productos ON transacciones.id_producto = productos.id_item INNER JOIN users ON transacciones.id_user = users.id_user WHERE cupones.estado='0'");
				while($consulta[1] = mysql_fetch_array($consulta[0],MYSQL_ASSOC))
				{
					foreach ($consulta[1] as $key => $value) {
						# code...
						if($key == "fecha_compra"){
							$consulta[1][$key] = date("d-m-Y h:i:s",$value);
						}
						else
						{
							$consulta[1][$key] = utf8_decode($value);
						}
						
					}
					$datos[] = (object)$consulta[1];
				}
				$this->returnData(
					array(
						"status"=>0,
						"data"=> $datos
					)
				);
			}
			else
			{
				$this->returnData(array("status"=>1));
			}
		}
	}
?>