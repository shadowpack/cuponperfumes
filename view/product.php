<link rel="stylesheet" href="css/product.css">
<script src="controller/slider/slider.js"></script>
<link rel="stylesheet" href="controller/slider/slider.css">
<script src="controller/product.js"></script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1&appId=150061965179618";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="container product">
	<div class="product_container">
		<div class="product_photo">
			<div class="product_slider">
				<div class="product_slider_images">
					<?php 
						include_once("model/db_core.php");
						include_once("model/clock.php");
						$dbo = new db_core();
						$producto = $dbo->reg_one("SELECT * FROM productos as p WHERE p.id_item ='".$_GET['id']."'");
						$vendidos = $dbo->reg_one("SELECT COUNT(*) FROM transacciones as p  WHERE p.id_producto ='".$_GET['id']."' AND p.statusPay='1'");
						$consulta[0] = $dbo->db_query("SELECT * FROM imagenes_productos as img  INNER JOIN productos as p ON p.id_item = img.id_item WHERE img.id_item ='".$_GET['id']."' ORDER BY img.portrait DESC");
						$fecha = new clock($producto['tiempoFinal']);
						$img = array();
						while ($consulta[1] = mysql_fetch_array($consulta[0])) {
							echo '<div class="product_slider_obj"><img src="'.$consulta[1]['source'].'" height="360"/></div>';
						}
					?>
				</div>
				<div class="btn_prev_product"><img src="controller/slider/img/btn_prev.png" /></div>
				<div class="btn_next_product"><img src="controller/slider/img/btn_next.png" /></div>
			</div>
		</div> 
		<div class="product_info">
			<div class="title">
				<div class="title_content"><?php echo $producto['nombre']; ?></div>
			</div>
			<div class="bajada"><?php echo $producto['descripcion_small']; ?></div>
			<div class="datos">
				<div class="precio">$ <?php echo $producto['precio_descuento']; ?></div>
				<div class="numero">
					<div class="descuento">Descuento : <?php echo number_format(((($producto['precio_real']-$producto['precio_descuento'])/$producto['precio_real'])*100),0); ?>%</div>
					<div class="precio_real">Antes : $<?php echo $producto['precio_real']; ?></div>
				</div>
				<div class="stock">
					<div class="stock_title">Quedan</div>
					<div class="stock_data"><?php echo ($producto['cantidad_total']-$vendidos[0]); ?></div>
				</div>
				<div class="tiempo">
					<span class="glyphicon glyphicon-time timeicon"></span>
					<div class="timevalue"><?php echo $fecha->getHoursDif(time())."h:".$fecha->getMinuteDif(time())."m:".$fecha->getSecondDif(time())."s"; ?></div>
					<div class="timehidden"><?php echo $fecha->getEpoch(); ?></div>
				</div>
				<div class="vendidos">Se han vendido : <?php echo $vendidos[0]; ?> Cuponperfumes de este producto.</div>
				<div class="btnSell" np="<?php echo $_GET['id']; ?>">Comprar</div>
				<div class="socialNetwork">
					<div class="fb-like" data-href="http://www.cuponperfumes.cl/product.php?id=<?php echo $_GET['id']; ?>" data-send="true" data-layout="button_count" data-width="200" data-show-faces="true" data-font="verdana"></div>
					<a href="https://twitter.com/share" class="twitter-share-button" data-lang="es" data-count="none">Twittear</a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
				</div>
			</div>
		</div> 
		<div class="product_tabs">
			<div class="tabs_info">
				<div class="container_tabs">
					<div class="tabs_header">
						<div class="btn_tabs_b" id="description_btn">Descripcion del Cupon</div>
						<div class="btn_tabs" id="conditions_btn">Condiciones</div>
						<div class="tabs_content" id="description"><?php echo utf8_encode($producto['descripcion']); ?></div>
						<div class="tabs_content" id="conditions"><?php echo utf8_encode($producto['condiciones']); ?></div>
					</div>
				</div>
			</div>
			<div class="tabs_mapa">
				<div class="container_map">
					<div class="tabs_header">
						<div class="btn_tabs">Donde nos Encontramos</div>
						<div class="map_tabs_content"><iframe width="445" height="415" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.cl/maps?f=q&source=s_q&hl=es&geocode=&q=+Luis+Tayer+Ojeda+183,+Of+304%3B+Providencia&sll=-33.668298,-70.363372&sspn=2.086992,4.22699&t=h&ie=UTF8&hq=&hnear=Luis+Thayer+Ojeda+183,+Providencia,+Santiago,+Regi%C3%B3n+Metropolitana&ll=-33.41912,-70.60544&spn=0.029731,0.038109&z=14&iwloc=A&output=embed"></iframe></div>
					</div>
				</div>
			</div>
		</div> 
	</div>
</div>