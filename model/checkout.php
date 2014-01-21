<?php 
@session_start();
class checkout
{
	private $db;
	function checkout(){
		$this->db = new db_core();
	}
	public function newProduct($id){
		$_SESSION["CuponPerfumes-Sell"]['id'] = $id;
		$_SESSION["CuponPerfumes-Sell"]['delivery'] = false;
		$_SESSION["CuponPerfumes-Sell"]['number'] = 1;
	}
	public function reset(){
		$_SESSION["CuponPerfumes-Sell"]['delivery'] = false;
		$_SESSION["CuponPerfumes-Sell"]['number'] = 1;
	}
	public function addProduct(){
		$_SESSION["CuponPerfumes-Sell"]['number']++;
	}
	public function removeProduct(){
		$_SESSION["CuponPerfumes-Sell"]['number']--;
	}
	public function getTotal(){
		$con = $this->db->reg_one("SELECT precio_descuento FROM productos as p WHERE p.id_item='".$_SESSION["CuponPerfumes-Sell"]['id']."'");
		$total = $con[0]*$_SESSION["CuponPerfumes-Sell"]['number'];
		if($_SESSION["CuponPerfumes-Sell"]['delivery'])
		{
			$total += $this->getDelivery()*$_SESSION["CuponPerfumes-Sell"]['number'];
		}
		return $total;
	}
	public function printLocation(){
		$user = $this->db->reg_one("SELECT id_user FROM session_log WHERE token='".$_SESSION['token']."'");
		$con[0] = $this->db->db_query("SELECT * FROM locations as l WHERE l.id_user='".$user[0]."'");
		while($con[1] = mysql_fetch_array($con[0]))
		{
			echo '<option value="'.$con[1]['id_location'].'">'.$con[1]['direccion'].','.$con[1]['comuna'].','.$con[1]['city'].'</option>';
		}
	}
	public function setDelivery($valor){
		$_SESSION["CuponPerfumes-Sell"]['delivery'] = $valor;
	}
	public function getDelivery(){
		$con = $this->db->reg_one("SELECT precio_delivery FROM productos as p WHERE p.id_item='".$_SESSION["CuponPerfumes-Sell"]['id']."'");
		return $con[0];
	}
	public function printCheckout(){
		$con = $this->db->reg_one("SELECT * FROM productos as p INNER JOIN imagenes_productos ON imagenes_productos.id_item = p.id_item WHERE p.id_item='".$_SESSION["CuponPerfumes-Sell"]['id']."' AND imagenes_productos.portrait='1'");
		echo '<div class="checkoutItem">
				<div class="precioNombre"><img src="'.$con['source'].'" height="80" /></div>
				<div class="precioDescripcion">
					<div class="DescripcionTitle">Descripcion del producto</div>
					<div class="DescripcionContent">'.utf8_encode($con['descripcion_small']).'</div>
				</div>
				<div class="Cantidad">
					<div class="CantidadTitle">Cantidad</div>
					<div class="CantidadContent">
						<div class="amount">
							<div class="amountNumber">1</div>
							<div class="boton"><div class="amountUp">+</div></div>
							<div class="boton"><div class="amountDown">-</div></div>
						</div>
					</div>
				</div>
				<div class="Precio">
					<div class="PrecioTitle">Precio Unitario</div>
					<div class="PrecioDContent">$ <span class="precioDes">'.number_format($con['precio_descuento'],0,",",".").'<span></div>
					<div class="PrecioRContent">$ <span>'.number_format($con['precio_real'],0,",",".").'<span></div>
				</div>
				<div class="Total">
					<div class="TotalTitle">Sub Total</div>
					<div class="TotalContent">$ <span class="totalValor">'.number_format($con['precio_descuento'],0,",",".").'<span></div>
				</div>
			</div>';
	}
}
?>
