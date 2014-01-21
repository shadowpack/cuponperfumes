<link rel="stylesheet" href="css/sellSuccess.css">
<script src="controller/sellSuccess.js"></script>
<?php 
	include("model/SellResult.php");
	$data = new SellResult();
	$data_info = $data->getSellData($_POST['TBK_ORDEN_COMPRA']);
?>
<div class="container sellSuccess">
	<div class="sellInforme">
		<div class="Sellheader">
			Operacion Exitosa
		</div>
		<div class="SellBody">
			<span class="textLineheader">Estos son los datos de su operacion con Transbank y CuponPerfumes</span>
			<span class="textLine">Fecha y Hora de Transaccion : <?php echo $data_info['TBK_FECHA_TRANSACCION']; ?></span>
			<span class="textLine">Tipo de Transacción : Venta</span>
			<span class="textLine">Nombre del Cliente : <?php echo $data_info['name']; ?></span>
			<span class="textLine">Bienes y Servicio adquiridos :</span>
			<div class="detailProduct">
				<div class="rowDetail1">
					<div class="detailProductName">Nombre del Producto</div>
					<div class="detailProductOther">Cantidad</div>
					<div class="detailProductOther">Precio Unitario</div>
					<div class="detailProductOther">Precio Delivery</div>
					<div class="detailProductOther">Total</div>
				</div>
				<div class="rowDetail2">
					<div class="detailProductName"> <?php echo $data_info['product']; ?></div>
					<div class="detailProductOther">1</div>
					<div class="detailProductOther">$ <?php echo number_format(($data_info['unitario']),0,",",".");; ?></div>
					<div class="detailProductOther"> <?php echo $data_info['delivery']; ?></div>
					<div class="detailProductOther">$ <?php echo number_format(($data_info['TBK_MONTO']),0,",","."); ?></div>
				</div>
			</div>
			<span class="textLine">Numero Orden de Compra : <?php echo $data_info['TBK_ORDEN_COMPRA']; ?></span>
			<span class="textLine">Nombre del Comercio : 2K Spa.</span>
			<span class="textLine">Url del Comercio : http://www.cuponperfumes.cl</span>
			<span class="textLine">Monto de Transaccion : $ <?php echo number_format($data_info['TBK_MONTO'],0,",","."); ?></span>
			<span class="textLine">Codigo Autorizacion Transbank : <?php echo $data_info['TBK_CODIGO_AUTORIZACION']; ?></span>
			<span class="textLine">4 Ultimos numeros de la tarjeta : <?php echo $data_info['TBK_FINAL_NUMERO_TARJETA']; ?></span>
			<span class="textLine">ID Transaccion Transbank : <?php echo $data_info['TBK_ID_TRANSACCION']; ?></span>
			<span class="textLine">Tipo de Pago : <?php echo $data_info['TBK_TIPO_PAGO']; ?></span>
			<span class="textLine">Tipo de Cuotas : <?php echo $data_info['TBK-TIPO-CUOTA']; ?></span>
			<span class="textLine">Numero de Cuotas : <?php echo $data_info['TBK_NUMERO_CUOTAS']; ?></span>
			<span class="textLine">Resultado de Transaccion : <?php echo $data_info['TBK_VCI']; ?></span>
			<span class="textLineFinal"><div class="textLineFinalContent"><b>Importante :</b> <br>No se realizan devoluciones, ni reembolsos. <br>En caso de tener alguna duda favor de contactar al teléfono (02-23333 218) o al mail ventas@cuponperfumes.cl.</div></span>
		
			<div class="backButonDiv">
				<div class="ButonDiv">Volver a CuponPerfumes</div>
			</div>
		</div>
	</div>
</div>