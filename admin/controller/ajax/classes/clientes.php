<?php
if(!class_exists('webservice'))
{
	require_once('webservice.php');
}
class clientes extends webservice{
	public function listClientes($data){
		$db = new db_core();
		$datos = array();
		$consulta[0] = $db->db_query("SELECT * FROM clientes");
		while($consulta[1] = mysql_fetch_array($consulta[0], MYSQL_ASSOC)){
			$fotitos = array();
			$fotos[0] = $db->db_query("SELECT source, id_image_cliente, portrait FROM imagenes_clientes WHERE id_cliente='".$consulta[1]['id_cliente']."'");
			$activos =$db->reg_one("SELECT COUNT(*) FROM productos AS p WHERE p.id_cliente='".$consulta[1]['id_cliente']."' AND p.estado='1'");
			$total =$db->reg_one("SELECT COUNT(*) FROM productos AS p WHERE p.id_cliente='".$consulta[1]['id_cliente']."'");
			$ventas =$db->reg_one('SELECT COUNT(*) FROM transacciones INNER JOIN productos ON productos.id_item = transacciones.id_producto WHERE productos.id_cliente="'.$consulta[1]['id_cliente'].'" AND transacciones.statusPay="1"');
			while($fotos[1] = mysql_fetch_array($fotos[0],MYSQL_ASSOC)){
				$fotitos[] = (object)$fotos[1];
			}
			foreach ($consulta[1] as $key => $value) {
				$consulta[1][$key] = utf8_encode($value);
			}
			$consulta[1]['fotos'] = $fotitos;
			$consulta[1]['activos'] = $activos[0];
			$consulta[1]['total'] = $total[0];
			$consulta[1]['ventas'] = $ventas[0];
			$datos[] = (object)$consulta[1];
		}
		echo json_encode($datos);
	}
	public function ListClientePassword($data){
		$consulta[0] = $db->db_query("SELECT * FROM clientes");
		while($consulta[1] = mysql_fetch_array($consulta[0], MYSQL_ASSOC)){
			foreach ($consulta[1] as $key => $value) {
				$consulta[1][$key] = utf8_encode($value);
			}
			$consulta[1]['fotos'] = $fotitos;
			$consulta[1]['activos'] = $activos[0];
			$consulta[1]['total'] = $total[0];
			$consulta[1]['ventas'] = $ventas[0];
			$datos[] = (object)$consulta[1];
		}
		echo json_encode($datos);
	}
	public function addCliente($data){
		$db = new db_core();
		$in['nombre'] = "NEW ENTERPRISE";
		$db->insert('clientes', $in);
		$this->returnData(array(
			"status"=>1,
			"id"=>$db->last_id()
		));
	}
	public function modCliente($data){
		$db = new db_core();
		$in['nombre'] = $data->nombre;
		$in['direccion'] = $data->direccion;
		$in['lat'] = $data->lat;
		$in['lng'] = $data->lng;
		$in['cuenta_bancaria'] = $data->cuenta_bancaria;
		$in['rut'] = $data->rut;
		$in['razon_social'] = $data->razon_social;
		$in['where'] = $data->where;
		$in['contacto'] = $data->contacto;
		$in['telefono'] = $data->telefono;
		$in['email'] = $data->email;
		$in['rut_contacto'] = $data->rut_contacto;
		$in['descripcion'] = $data->descripcion;
		$where['id_cliente'] = $data->id_cliente;
		$db->update('clientes', $in, $where);
		$this->returnData(array(
			"status"=>1
		));
	}
	public function activeCliente($data){
		$db = new db_core();
		$in['estado'] = $data->active;
		$where['id_cliente'] = $data->id;
		$db->update('clientes', $in, $where);
		$this->returnData(array("status"=>1));
	}
	public function delCliente($data){
		$db = new db_core();
		$db->delete('clientes', 'id_cliente',$data->id);
		$db->delete('imagenes_clientes', 'id_cliente',$data->id);
		$this->returnData(array("status"=>1));
	}
}
?>