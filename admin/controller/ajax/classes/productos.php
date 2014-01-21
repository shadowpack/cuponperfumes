<?php
if(!class_exists('webservice'))
{
	require_once('webservice.php');
}
class productos extends webservice{
	//METODO PUBLICO QUE INDICA LOS PRODUCTOS QUE EXISTEN
	public function listActiveProduct(){
		$db = new db_core();
		$datos = array();
		$consulta[0] = $db->db_query("SELECT productos.id_item, category.id_category, category.name AS categoria, productos.nombre, productos.cantidad_total, productos.descripcion_small, productos.descripcion, productos.precio_real, productos.precio_descuento, productos.precio_delivery, productos.tiempoFinal, productos.expiracion, productos.reglas, productos.condiciones, productos.where, productos.estado FROM productos INNER JOIN category ON category.id_category = productos.category_id WHERE tiempoFinal >= NOW()");
		while($consulta[1] = mysql_fetch_array($consulta[0],MYSQL_ASSOC)){
			$fotitos = array();
			$fotos[0] = $db->db_query("SELECT source, id_image, portrait FROM imagenes_productos WHERE id_item='".$consulta[1]['id_item']."'");
			while($fotos[1] = mysql_fetch_array($fotos[0],MYSQL_ASSOC)){
				$fotitos[] = (object)$fotos[1];
			}
			foreach ($consulta[1] as $key => $value) {
				$consulta[1][$key] = utf8_encode($value);
			}
			$consulta[1]['fotos'] = $fotitos;
			$datos[] = (object)$consulta[1];
		}
		echo json_encode($datos);
	}
	//METODOS OLD PRODUCT
	public function listActiveProductOld(){
		$db = new db_core();
		$datos = array();
		$consulta[0] = $db->db_query("SELECT productos.id_item, category.id_category, category.name AS categoria, productos.nombre, productos.descripcion_small, productos.descripcion, productos.precio_real, productos.precio_descuento, productos.precio_delivery, productos.tiempoFinal, productos.expiracion, productos.reglas, productos.condiciones, productos.where, productos.estado FROM productos INNER JOIN category ON category.id_category = productos.category_id WHERE tiempoFinal <= NOW()");
		while($consulta[1] = mysql_fetch_array($consulta[0],MYSQL_ASSOC)){
			foreach ($consulta[1] as $key => $value) {
				$consulta[1][$key] = utf8_encode($value);
			}
			$datos[] = (object)$consulta[1];
		}
		echo json_encode($datos);
	}
	public function activeProduct($data){
		$db = new db_core();
		$in['estado'] = $data->active;
		$where['id_item'] = $data->id;
		$db->update('productos', $in, $where);
		$this->returnData(array("status"=>1));
	}
	public function activeCategoria($data){
		$db = new db_core();
		$in['status'] = $data->active;
		$where['id_category'] = $data->id;
		$db->update('category', $in, $where);
		$this->returnData(array("status"=>1));
	}
	public function addProduct($data){
		$db = new db_core();
		$in['estado'] = 0;
		$in['oferta'] = 1;
		$in['id_admin'] = $this->get_admin_id();
		$where['category_id'] = "cate";
		$db->insert('productos', $in);
		$this->returnData(array(
			"status"=>1,
			"id"=>$db->last_id()
		));
	}
	public function getCategoria(){
		$db = new db_core();
		$datos = array();
		$consulta[0] = $db->db_query("SELECT * FROM category");
		while($consulta[1] = mysql_fetch_array($consulta[0], MYSQL_ASSOC)){
			$cantidad = $db->reg_one("SELECT COUNT(*) FROM productos WHERE category_id='".$consulta[1]['id_category']."' AND estado=1");
			foreach ($consulta[1] as $key => $value) {
				$consulta[1][$key] = utf8_encode($value);
			}
			$consulta[1]['cantidad'] = $cantidad[0];
			$datos[] = (object)$consulta[1];
		}
		echo json_encode($datos);
	}
	public function modProduct($data){
		$db = new db_core();
		$where['id_item'] = $data->id_item;
		$datos = (array)$data->datas;

		foreach ($datos as $key => $value) {
			$datos[$key] = utf8_decode($value);
		}
		$db->update('productos', $datos, $where);
		$this->returnData(array("status"=>1));
	}
	//CLONAR PRODUCTO
	public function clonar($data){
		sleep(2);
		$db = new db_core();
		$registro = $db->reg_one_assoc("SELECT * FROM productos WHERE id_item='".$data->codigo."'");
		$imagenes[0] = $db->db_query("SELECT * FROM imagenes_productos WHERE id_item='".$data->codigo."'");
		unset($registro['id_item']);
		foreach ($registro as $key => $value) {
			# code...
			$registro[$key] = utf8_decode($value);
		}
		$registro['tiempoFinal'] = $data->tiempofinal;
		$registro['expiracion'] = $data->expiracion;
		$registro['estado'] = 0;
		$db->insert('productos', $registro);
		$last_id = $db->last_id();
		while($imagenes[1] = mysql_fetch_array($imagenes[0], MYSQL_ASSOC)){
			$registros['id_item'] = $last_id;
			$registros['source'] = $imagenes[1]['source'];
			$registros['portrait'] = $imagenes[1]['portrait'];
			$db->insert('imagenes_productos', $registros);
		}
		$this->returnData(array("status"=>1));
	}
	// ELIMINAR PRODUCTO
	public function delProduct($data){
		sleep(1);
		$db = new db_core();
		$db->delete('productos','id_item', $data->id);
		$this->returnData(array("status"=>1));
	}
	//GET IMAGES
	public function getImages($data){
		$db = new db_core();
		$datos = array();
		$consulta[0] = $db->db_query("SELECT * FROM imagenes_productos WHERE id_item='".$data->codigo."'");
		while($consulta[1] = mysql_fetch_array($consulta[0],MYSQL_ASSOC)){
			$datos[] = (object)$consulta[1];
		}
		echo json_encode($datos);
	}
	public function setPortrait($data){
		$db = new db_core();
		$datos = array();
		$db->db_query("UPDATE imagenes_productos SET portrait='0' WHERE id_item='".$data->id_item."'");
		$in['portrait'] = 1;
		$where['id_item'] = $data->id_item;
		$where['source'] = $data->src;
		$consulta[0] = $db->update("imagenes_productos",$in,$where);
		$this->returnData(array("status"=>1));
	}
	public function deleteImage($data){
		$db = new db_core();
		$datos = array();
		$where['portrait'] = 1;
		$where['id_item'] = $data->id_item;
		$where['source'] = $data->src;
		if($db->isExists_multi('imagenes_productos', $where)){
			$this->returnData(array("status"=>2));
		}
		else
		{
			$db->db_query("DELETE FROM imagenes_productos WHERE id_image='".$data->id_image."'");
			@unlink('../../../'.$data->src);
			$this->returnData(array("status"=>1));
		}
		
	}
	public function deleteImageCategory($data){
		$db = new db_core();
		$datos = array();
		$in['source'] = "";
		$where['id_category'] = $data->id_item;
		$db->update('category',$in,$where);
		$this->returnData(array("status"=>1));
	}
	public function modCategory($data){
		$db = new db_core();
		$in['name'] = $data->name;
		$where['id_category'] = $data->id_category;
		$db->update('category',$in,$where);
		$this->returnData(array("status"=>1));
	}
	public function addCategory($data){
		$db = new db_core();
		$in['name'] = "";
		$in['source'] = "";
		$in['status'] = "1";
		$in['position'] = $db->reg_one("SELECT MAX(position) FROM category");
		$in['position'] = $in['position'][0];
		$db->insert('category',$in);
		$this->returnData(array(
			"status"=>1,
			"id"=>$db->last_id()
		));
	}
	public function removeCategory($data){
		$db = new db_core();
		$db->delete('category', 'id_category',$data->id);
		$this->returnData(array("status"=>1));
	}

}
?>