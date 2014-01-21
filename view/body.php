<link rel="stylesheet" href="css/body.css">
<link rel="stylesheet" href="css/catalog.css">
<script src="controller/body.js"></script>
<br>
<div class="container">
	<div class="row">
		<ol class="breadcrumb">
          <li class="active"><h3><img class="float_left" src="images/plataform/perfumes.png" height="25"/><div class="icontexth3">&nbsp;&nbsp;Perfumes</div></h3></li>
        </ol>
	</div>
</div>
<div class="container catalog">
<?php
	include_once('model/db_core.php');
	$db = new db_core();
	$preconsulta[0] = $db->db_query("SELECT id_category,position FROM category as c WHERE c.status=1 AND c.id_admin='0' ORDER BY c.position");
	while($preconsulta[1] = mysql_fetch_array($preconsulta[0]))
	{
		$position = $preconsulta[1][1];
		$consulta[0] = $db->db_query("SELECT * FROM productos INNER JOIN imagenes_productos ON productos.id_item = imagenes_productos.id_item  WHERE productos.estado = 1 AND imagenes_productos.portrait = 1 AND productos.category_id='".$preconsulta[1][0]."' AND id_cliente='0' AND tiempoFinal >= NOW()");
		if(mysql_num_rows($consulta[0]) > 0)
		{
			echo '<div class="slider-catalog"><div class="slider-catalog-images">';
			while($consulta[1] = mysql_fetch_array($consulta[0], MYSQL_BOTH))
			{
				echo '<div class="bigCatalog listCategory'.$position.'">
					<div class="containerCat" numproducto="'.$consulta[1]['id_item'].'">
					<div class="header">
						<div class="title">'.utf8_encode($consulta[1]['nombre']).'</div>
						<div class="social"><div class="fb-like" data-href="http://www.cuponperfumes.cl/product?id='.$consulta[1]['id_item'].'" data-send="true" data-layout="button_count" data-width="450" data-show-faces="true"></div></div>
					</div>
					<div class="image"><img src="'.$consulta[1]['source'].'" class="img"/></div>
					<div class="footerCatag">
						<div class="footerLeft">
							<div class="microTitle">'.utf8_encode($consulta[1]['descripcion_small']).'</div>
						</div>
						<div class="footerRight">
							<div class="info">
								<div class="text">
									<div class="descuento">'.floor(100-(($consulta[1]['precio_descuento']/$consulta[1]['precio_real'])*100)).' %</div>
									<div class="hora"> 4:45:32</div>
									<div class="precioReal">$ '.$consulta[1]['precio_real'].'</div>
								</div>
								<div class="precioDescuento">$ '.$consulta[1]['precio_descuento'].'</div>
								<div class="boton">Ver Mas</div>
							</div>
						</div>
					</div>
					</div>
				</div>';
			}
			echo '</div>
			<div class="btn_prev_catalog"><img src="images/plataform/prev.png" /></div>
			<div class="btn_next_catalog"><img src="images/plataform/next.png" /></div>';
			echo '</div>';
		}
	}
?>
</div>
<div class="container" id="bellezatab">
	<div class="row">
		<ol class="breadcrumb">
          <li class="active"><h3><img class="float_left" src="images/plataform/icono-yoga.png" height="25"/><div class="icontexth3">&nbsp;&nbsp;Belleza</div></h3></li>
        </ol>
	</div>
</div>
<div class="container">
	<?php
	$preconsulta[0] = $db->db_query("SELECT id_category,position FROM category as c WHERE c.status=1 AND c.id_admin='0' ORDER BY c.position");
	while($preconsulta[1] = mysql_fetch_array($preconsulta[0]))
	{
		$position = $preconsulta[1][1];
		$consulta[0] = $db->db_query("SELECT * FROM productos INNER JOIN imagenes_productos ON productos.id_item = imagenes_productos.id_item  WHERE productos.estado = 1 AND imagenes_productos.portrait = 1 AND productos.category_id='".$preconsulta[1][0]."'");
		while($consulta[1] = mysql_fetch_array($consulta[0], MYSQL_BOTH))
		{
			echo '<div class="bigCatalog listCategory'.$position.'">
				<div class="containerCat" numproducto="'.$consulta[1]['id_item'].'">
				<div class="header">
					<div class="title">'.utf8_encode($consulta[1]['nombre']).'</div>
					<div class="social"><div class="fb-like" data-href="http://www.cuponperfumes.cl/product?id='.$consulta[1]['id_item'].'" data-send="true" data-layout="button_count" data-width="450" data-show-faces="true"></div></div>
				</div>
				<div class="image"><img src="'.$consulta[1]['source'].'" class="img"/></div>
				<div class="footerCatag">
					<div class="footerLeft">
						<div class="microTitle">'.utf8_encode($consulta[1]['descripcion_small']).'</div>
					</div>
					<div class="footerRight">
						<div class="info">
							<div class="text">
								<div class="descuento">'.floor(100-(($consulta[1]['precio_descuento']/$consulta[1]['precio_real'])*100)).' %</div>
								<div class="hora"> 4:45:32</div>
								<div class="precioReal">$ '.$consulta[1]['precio_real'].'</div>
							</div>
							<div class="precioDescuento">$ '.$consulta[1]['precio_descuento'].'</div>
							<div class="boton">Ver Mas</div>
						</div>
					</div>
				</div>
				</div>
			</div>';
		}
	}
	?>
</div>