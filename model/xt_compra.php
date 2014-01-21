<?php
@session_start();
@include_once('db_core.php');
@include_once('saveCupon.php');
@include_once("class.phpmailer.php");
function form_mail($sPara, $sAsunto, $sTexto, $sDe,$file)
{
	$mail = new PHPMailer();
	$mail->IsSMTP();  // telling the class to use SMTP
	$mail->Host = "cuponperfumes.cl"; // SMTP server
	$mail->Helo = "www.cuponperfumes.cl";
	$mail->FromName = "CuponPerfumes - Email Service";
	$mail->From = $sDe;
	$mail->IsHTML(true);
	$mail->AddAddress($sPara);
	$mail->Subject = $sAsunto;
	$mail->Body = $sTexto;
	$mail->AddAttachment('/home/cuponperfumes/public_html/model/uploads/'.$file);
	if($mail->Send()) {
		unlink('/home/cuponperfumes/public_html/model/uploads/'.$file);
		return true;
	}
	else
	{
		unlink('/home/cuponperfumes/public_html/model/uploads/'.$file);
		return false;	
	}
}
//rescate de datos de POST.
$TBK_RESPUESTA=$_POST["TBK_RESPUESTA"];
$TBK_ORDEN_COMPRA=$_POST["TBK_ORDEN_COMPRA"];
$TBK_MONTO=$_POST["TBK_MONTO"];
$TBK_ID_SESION=$_POST["TBK_ID_SESION"];
/****************** CONFIGURAR AQUI *******************/
//GENERA ARCHIVO PARA MAC
$filename_txt = "/home/cuponperfumes/public_html/comun/MAC01Normal".$TBK_ID_SESION.".txt";
// Ruta Checkmac
$cmdline = "/home/cuponperfumes/public_html/cgi-bin/tbk_check_mac.cgi $filename_txt";
/****************** FIN CONFIGURACION *****************/
$acepta=false;
//guarda los datos del post uno a uno en archivo para la ejecución del MAC
$fp=fopen($filename_txt,"w+");
while(list($key, $val)=each($_POST)){
fwrite($fp, "$key=$val&");
}
fclose($fp);
//Validación de respuesta de Transbank, solo si es 0 continua con la pagina de cierre
if($TBK_RESPUESTA=="0"){ $acepta=true; } else { $acepta=false; }
//validación de monto y Orden de compra
//RESCATAMOS LOS DATOS DE LA DB
$db = new db_core();
reglog("PASA LA CREACION DE ARCHIVOS");
$consulta = $db->reg_one("SELECT * FROM transacciones_transbank as t WHERE t.TBK_ORDEN_COMPRA = '".$_POST["TBK_ORDEN_COMPRA"]."'");
if ($TBK_MONTO==$consulta['TBK_MONTO']."00" && $TBK_ORDEN_COMPRA==$consulta['TBK_ORDEN_COMPRA'] && $acepta==true)
{ 
	reglog("PASA EL IF DE COMPROBACION");
	exec ($cmdline, $result, $retint);
	reglog("ANALIZAMOS LA MAC Y SU RESPUESTA ES: ".$result[0]);
	if ($result[0] =="CORRECTO") 
	{
		reglog("FUE CORRECTA LA COMPROBACION DE MAC");
		$db->db_query("UPDATE transacciones_transbank SET
		TBK_CODIGO_AUTORIZACION = '".$_POST['TBK_CODIGO_AUTORIZACION']."',
		TBK_FECHA_CONTABLE = '".$_POST['TBK_FECHA_CONTABLE']."',
		TBK_FECHA_TRANSACCION = '".$_POST['TBK_FECHA_TRANSACCION']."',
		TBK_FINAL_NUMERO_TARJETA = '".$_POST['TBK_FINAL_NUMERO_TARJETA']."',
		TBK_HORA_TRANSACCION = '".$_POST['TBK_HORA_TRANSACCION']."',
		TBK_ID_SESION = '".$_POST['TBK_ID_SESION']."',
		TBK_ID_TRANSACCION = '".$_POST['TBK_ID_TRANSACCION']."',
		TBK_MAC = '".$_POST['TBK_MAC']."',
		TBK_MONTO = '".$_POST['TBK_MONTO']."',
		TBK_NUMERO_CUOTAS = '".$_POST['TBK_NUMERO_CUOTAS']."',
		TBK_RESPUESTA = '".$_POST['TBK_RESPUESTA']."',
		TBK_TASA_INTERES_MAX = '".$_POST['TBK_TASA_INTERES_MAX']."',
		TBK_TIPO_PAGO = '".$_POST['TBK_TIPO_PAGO']."',
		TBK_TIPO_TRANSACCION = '".$_POST['TBK_TIPO_TRANSACCION']."',
		TBK_VCI = '".$_POST['TBK_VCI']."'
		WHERE TBK_ORDEN_COMPRA = '".$TBK_ORDEN_COMPRA."'");
		reglog("ACTUALIZAMOS EL ESTADO DE LAS TRANSACCION TRANSBANK");
		$db->db_query("UPDATE transacciones SET transacciones.statusPay=1 WHERE transacciones.tbk_orden_compra='".$TBK_ORDEN_COMPRA."'");
		reglog("ACTUALIZAMOS EL ESTADO DE LAS TRANSACCIONES");
		$cupon[0] = $db->db_query("SELECT * FROM transacciones WHERE transacciones.tbk_orden_compra='".$TBK_ORDEN_COMPRA."' AND transacciones.statusPay=1");
		while($cupon[1] = mysql_fetch_array($cupon[0]))
		{
			for($i=0;$i<$cupon[1]['cantidad'];$i++)
			{
				makeCupon($db,$cupon[1]['id_transaccion']);
			}
		}
		//BORRAMOS EL ARCHIVO
		unlink($filename_txt);
		reglog("BORRAMOS EL ARCHIVO");
		echo "ACEPTADO";
	} 
	else
	{ 
		unlink($filename_txt);
		echo "RECHAZADO";
	}
}
elseif (!$acepta) {
	echo "ACEPTADO";
}
else
{ 
	echo "RECHAZADO";
}
function reglog($reg1 = '',$reg2 = '',$reg3 = ''){
	$reg = true;
	if($reg)
	{
		$db = new db_core();
		$db->db_query("INSERT INTO registro (reg1,reg2,reg3) VALUES ('".$reg1."','".$reg2."','".$reg3."')");
	}
}
function makeCupon($db,$transaccion)
{
	$codigo = makeCode(12);
	$db->db_query("INSERT INTO cupones (id_transaccion,codigo_cupon,fecha_compra,estado) VALUES ('".$transaccion."','".$codigo."', '".time()."','0')");
	$user = $db->reg_one("SELECT * FROM users INNER JOIN transacciones ON transacciones.id_user=users.id_user WHERE transacciones.id_transaccion = '".$transaccion."'");
	$producto = $db->reg_one("SELECT * FROM productos INNER JOIN transacciones ON transacciones.id_producto=productos.id_item WHERE transacciones.id_transaccion='".$transaccion."'");
	$para      = $user['email'];
	$asunto    = 'CuponPerfumes: '.$producto['nombre'].' - Codigo : '.$codigo;
	$mensaje   = 'Estimado(a) '.$user['nombre'].'<br><br>'.
	'Tu compra ha sido confirmada.'.'<br><br>'.
	'Oferta : '.$producto['nombre'].'<br><br>'.
	'Valido Hasta : '.$producto['expiracion'].'<br><br>'.
	'Destacado: <br><br>'.$producto['descripcion'].'<br><br>'.
	'Condiciones: <br><br>'.$producto['condiciones'].'<br><br>'.
	'Recuerda hacer efectivo tu cupon antes de la fecha de venncimiento<br><br>'.
	'Gracias por elegirnos<br><br><hr><br>'.
	'ATTE Equipo CuponPerfumes';
	$pdf = new RPDF();
	$pdf->PrintChapter($transaccion);
	$pdf->Output('uploads/'.$codigo.'.pdf', 'F');
	form_mail($para, $asunto, $mensaje, "noreply@cuponperfumes.cl", $codigo.'.pdf');
}
function makeCode($long){
	$patron = "0123456789";
	$d = new db_core();
	while(true)
	{
		$code = "";
		for($i=0; $i<$long; $i++)
		{
			$code .= $patron[rand(0,(strlen($patron)-1))];
		}
		if(mysql_num_rows($d->db_query("SELECT * FROM cupones AS c WHERE c.codigo_cupon='".$code."'")) == 0)
		{
			return $code;
		}
	}
}
?>