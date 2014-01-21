<link rel="stylesheet" href="css/checkout.css">
<script src="controller/checkout.js"></script>
<?php
	@require_once('model/checkout.php');
	$total = new checkout();
	$total->reset();
?>
<div class="container checkout">
	<div class="headerTop">
		<div class="figura">1</div>
		<div class="title">Tu compra</div>
	</div>
	<?php $total->printCheckout(); ?>
	<div class="headerTop">
		<div class="figura">2</div>
		<div class="title">Otras Opciones</div>
	</div>
	<div id="locationsSelect">
		<div class="radioDelivery" value="false">
			<input type="radio" name="delivery" id="NoDelivery" value="false" checked>Sin Despacho
			<input type="radio" name="delivery" id="Delivery" value="true">Con Despacho
		</div>
		<div class="locationsRadio">
			<div class="LocationTitle">Seleccione la direccion de Despacho</div>
			<div class="LocationContent">
				<select class="direccionDelivery" disabled="disabled">
					<?php $total->printLocation(); ?>
				</select>
			</div>
		</div>
		<div class="unitarioDespacho">
			<div class="unitarioDespachoTitle">Precio Unitario</div>
			<div class="unitarioDespachoContent">$ <span class="despachoUnita"><?php echo $total->getDelivery(); ?></span></div>
		</div>
		<div class="precioDelivery" id="precioDelivery">
			<div class="DeliveryTitle">Costo de Despacho</div>
			<div class="DeliveryContent">$ <span class="pagoDespacho">0</span></div>
		</div>
	</div>
	<div class="headerTop">
		<div class="figura">3</div>
		<div class="title">Elige un medio de pago</div>
	</div>
	<div class="FormaPagoSelect">
		<div class="SelectPago">
			<div class="credito">
				<div class="webpayCreditoImg"><img src="images/plataform/tarjeta_credito.jpg" height="100"/></div>
				<div class="Pdescription">
					<div class="titleMethod">Tarjetas de Credito</div>
					<div class="contentMethod">Paga con tus tarjetas de credito favorita. Aceptamos Visa, MasterCard, Magna, American Express o Dinners.</div>
				</div>
			</div>
			<div class="transbank">
				<div class="webpayRedCompraImg"><img src="images/plataform/red_compra.gif" height="100"/></div>
				<div class="Pdescription">
					<div class="titleMethod">Tarjetas de Debito</div>
					<div class="contentMethod">Paga con tu tarjea de debito RedCompra.</div>
				</div>
			</div>
		</div>
		<div class="PagoTotal">
			<div class="PagoTitle">Total a Pagar</div>
			<div class="PagoContent">$ <span class="pagoTotal"><?php echo number_format($total->getTotal(),0,",","."); ?></span></div>
		</div>
	</div>
</div>