<?php
	include_once("db_core.php");
	$db = new db_core();
	$consulta[0] = $db->db_query("SELECT productos.nombre,  users.nombre, cupones.fecha_compra, IF(transacciones.delivery=1,'Si','No'), users.location, users.comuna, users.city, cupones.codigo_cupon, users.direccion_original FROM cupones INNER JOIN transacciones ON cupones.id_transaccion = transacciones.id_transaccion INNER JOIN productos ON transacciones.id_producto = productos.id_item INNER JOIN users ON transacciones.id_user = users.id_user WHERE cupones.estado='0'");
	echo '<table border="1"><tr>
	<th width="200">Producto</td>
	<th width="200">Nombre</td>
	<th width="200">Fecha de Compra</td>
	<th width="100">Delivery</td>
	<th width="400">Direccion</td>
	<th width="300">Direccion Original</td>
	<th width="150">Codigo Cupon</td>
	</tr>';
	while($consulta[1] = mysql_fetch_array($consulta[0]))
	{
		echo "<tr>
		<td>".$consulta[1][0]."</td>
		<td>".$consulta[1][1]."</td>
		<td>".date("d-m-Y h:i:s",$consulta[1][2])."</td>
		<td>".$consulta[1][3]."</td>
		<td>".$consulta[1][4].", ".$consulta[1][5].", ".$consulta[1][6]."</td>
		<td>".$consulta[1][8].", ".$consulta[1][5].", ".$consulta[1][6]."</td>
		<td>".$consulta[1][7]."</td>
		</tr>";
	}
	echo "</table>";
?>