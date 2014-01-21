<link rel="stylesheet" href="css/sellSuccess.css">
<script src="controller/sellFail.js"></script>
<?php 
	include("model/SellResult.php");
	$data = new SellResult();
	$data_info = $data->getSellData($_POST['TBK_ORDEN_COMPRA']);
?>
<div class="container sellSuccess">
	<div class="sellInforme">
		<div class="Sellheader">
			Operacion Fallida
		</div>
		<div class="SellBody">
			<span class="textLineheader">Estos son los datos de la transaccion Transbank y CuponPerfumes</span>
			<span class="textLine">Fecha de Transaccion : <?php echo $data_info['TBK_FECHA_TRANSACCION']; ?></span>
			<span class="textLine">Tipo de Transacción : Venta</span>
			<span class="textLine">Nombre del Cliente : <?php echo $data_info['name']; ?></span>
			<span class="textLine">Numero Orden de Compra : <?php echo $data_info['TBK_ORDEN_COMPRA']; ?></span>
			<span class="textLineFinal"><br><br><b>Importante:</b><br><br>Las posibles causas de este rechazo son:<br><br>·         Error en el ingreso de los datos de su tarjeta de crédito o Debito (fecha y/o código de seguridad).<br>·         Su tarjeta de crédito o debito no cuenta con el cupo necesario para cancelar la compra.<br>·         Tarjeta aún no habilitada en el sistema financiero. <br>·         Si el problema persiste favor comunicarse con su Banco emisor.<br></span>
			<div class="backButonDiv">
				<div class="ButonDiv">Volver a CuponPerfumes</div>
			</div>
		</div>
	</div>
</div>
