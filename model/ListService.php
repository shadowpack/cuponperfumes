<?php
include("db_core.php");
header('Content-type: application/json');
$db = new db_core();
$consulta[0] = $db->db_query("SELECT * FROM productos AS p INNER JOIN imagenes_productos ON imagenes_productos.id_item = p.id_item WHERE p.estado=1");
$retorno = array();
while($consulta[1] = mysql_fetch_array($consulta[0])){
	$retorno[]=array(
		'ciudad'=>'Santiago',
		'titulo'=>$consulta[1]['descripcion_small'],
		'img'=>'http://www.cuponperfumes.cl/'.$consulta[1]['source'],
		'url'=>'http://www.cuponperfumes.cl/product.php?id='.$consulta[1]['id_item'],
		'originalprice'=>intval($consulta[1]['precio_real']),
		'finalprice'=>intval($consulta[1]['precio_descuento'])
	);
}
echo json_encode($retorno);
?>