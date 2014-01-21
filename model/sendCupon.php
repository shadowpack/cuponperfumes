<?php
	@session_start();
	@include_once('db_core.php');
	@include_once('saveCupon.php');
	@include_once("class.phpmailer.php");
	$dbo = new db_core();
	if($dbo->isExists('session_log', 'token', $_SESSION['token']))
	{
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
		function makeCupon($db,$transaccion)
		{
			$user = $db->reg_one("SELECT * FROM users INNER JOIN transacciones ON transacciones.id_user=users.id_user WHERE transacciones.id_transaccion = '".$transaccion."'");
			$producto = $db->reg_one("SELECT * FROM productos INNER JOIN transacciones ON transacciones.id_producto=productos.id_item INNER JOIN cupones ON transacciones.id_transaccion = cupones.id_transaccion WHERE transacciones.id_transaccion='".$transaccion."'");
			$para      = $user['email'];
			$asunto    = 'CuponPerfumes: '.$producto['nombre'].' - Codigo : '.$producto['codigo_cupon'];
			$mensaje   = 'Estimado(a) '.$user['nombre'].'<br><br>'.
			'Tu compra ha sido confirmada.'.'<br><br>'.
			'Oferta : '.$producto['nombre'].'<br><br>'.
			'Valido Hasta : '.$producto['expiracion'].'<br><br>'.
			'Destacado: <br><br>'.$producto['descripcion'].'<br><br>'.
			'Condiciones: <br><br>'.$producto['condiciones'].'<br><br>'.
			'Recuerda hacer efectivo tu cupon antes de la fecha de vencimiento<br><br>'.
			'Gracias por elegirnos<br><br><hr><br>'.
			'ATTE Equipo CuponPerfumes';
			$pdf = new RPDF();
			$pdf->PrintChapter($transaccion);
			$pdf->Output('uploads/'.$producto['codigo_cupon'].'.pdf', 'F');
			form_mail($para, $asunto, $mensaje, "noreply@cuponperfumes.cl", $producto['codigo_cupon'].'.pdf');
			echo "true";
		}
		makeCupon($dbo, $_POST['id']);
	}	
?>