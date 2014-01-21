<link rel="stylesheet" href="css/prebody.css">
<link rel="stylesheet" href="controller/slider/slider3.css">
<script src="controller/slider/slider3.js"></script>
<script src="controller/prebody.js"></script>
<div class="jumbotron sliderscat" active="true">
  	<div class="container">
		<div class="imagesSlider3">
			<div class="imagesMov">
				<?php
					@require_once('model/db_core.php');
					$db = new db_core();
					$consulta[0] = $db->db_query("SELECT * FROM category as c ORDER BY c.position");
					while($consulta[1] = mysql_fetch_array($consulta[0]))
					{
						echo '<div class="imageItem"><img src="'.$consulta[1][2].'" class="imagelider" position="'.$consulta[1][3].'" numCat="'.$consulta[1][3].'" width="370"/></div>'; //de ser un directorio lo envolvemos entre corchetes
					}
				?>
			</div>
			<div class="btn_prev"><img src="images/plataform/prev.png" /></div>
			<div class="btn_next"><img src="images/plataform/next.png" /></div>
		</div>
	</div>
</div>