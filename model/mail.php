<?php
class mail{
	function mail(){

	}
	function sendRegMail($email, $token){
		$para      = $email;
		$asunto    = 'Registro en CuponPerfumes - Activacion de Cuenta';
		$mensaje   = '<html>
		<body>
			<div id="container" style="padding:10px 25% 10px 25%; background:url(http://www.cuponperfumes.cl/img/binding_dark.png);; height:490px;">
				<img src="http://www.cuponperfumes.cl/images/plataform/logocp.png" height="120" />
				<div id="containerbody" style="background:white; height:310px; padding:10px 20px 10px 20px; font-family:Helvetica; font-size:14px;">
					<div style="position:relative; height:35px; font-size:16px;">Hola,</div>
					<div style="position:relative; color:#3ca9ec; height:45px; font-size:24px;">¡Bienvenido a CuponPerfumes!</div>
					<div style="position:relative;">Ya perteneces a la primera plataforma de descuentos exclusivos en perfumes. Para continuar tu registro debes seguir el siguiente link.</div>
					<div style="position:relative; height:50px; padding-top:20px; padding-bottom:20px;">
						<div id="boton" style="border: 1px #4AB0E1 solid; border-radius:5px; background:#4AB0E1; color:white; height:40px; line-height:40px; vertical-align:middle; width:200px; text-align:center;" ><a style="color:#FFF;" href="http://www.cuponperfumes.cl/controller/active.php?token='.$token.'">Confirma tu registro >></a></div></div>
					</div>
					<div style="height:100px; background:#EEE; font-family:Helvetica;">
						<div style="float:left; width:60px; padding: 35px 0px 0px 20px; font-size:12px; height:20px; line-height:20px; vertical-align:middle;"><a href="http://www.facebook.com/cuponperfumes"><img src="http://www.cuponperfumes.cl/images/plataform/facebook.png" height="30" /></a><a href="http://www.twitter.com/cuponperfumes"><img src="http://www.cuponperfumes.cl/images/plataform/twitter.png" height="30" /></a></div>
						<div style="float:left; width:50px; padding: 35px 20px 0px 5px; font-size:13px; height:30px; line-height:30px; vertical-align:middle;">Siguenos</div>
						<div style="float:right; width:250px; padding: 35px 20px 0px 0px; font-size:12px;">Si tienes alguna duda responde este correo o escríbenos a: <span style="color:#3ca9ec;">contacto@cuponperfumes.cl</span></div>
					</div>
				</div>
				<div link="#FFF" vlink="#FFF" alink="#FFF" style="position:relative; font-family:Helvetica; text-align:center; color:#FFF; height:30px; line-height:30px; vertical-align:middle; padding:15px 0px 0px 0px;"><a href="#" style="color:#FFF;">Terminos y Condiciones</a>&nbsp;&nbsp;<a href="#" style="color:#FFF;">Privacidad</a></div>
			</div>
		</body>
		</html>';
		$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
		$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$cabeceras .= 'From: contacto@cuponperfumes.cl' . "\r\n";
		if(mail($para, $asunto, $mensaje, $cabeceras))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function sendForgotMail($email, $token){
		$para      = $email;
		$asunto    = 'Ingresar a CuponPerfumes - Recuperar Contraseña';
		$mensaje   = '<html>
		<body>
			<div id="container" style="padding:10px 25% 10px 25%; background:url(http://www.cuponperfumes.cl/img/binding_dark.png);; height:490px;">
				<img src="http://www.cuponperfumes.cl/images/plataform/logocp.png" height="120" />
				<div id="containerbody" style="background:white; height:310px; padding:10px 20px 10px 20px; font-family:Helvetica; font-size:14px;">
					<div style="position:relative; height:35px; font-size:16px;">Hola,</div>
					<div style="position:relative; color:#3ca9ec; height:45px; font-size:24px;">Recupera tu Contraseña</div>
					<div style="position:relative;">Para este fin, haz click en el enlace a continuacion para de esta forma redefinir tu contraseña.</div>
					<div style="position:relative; height:50px; padding-top:20px; padding-bottom:20px;">
						<div id="boton" style="border: 1px #4AB0E1 solid; border-radius:5px; background:#4AB0E1; color:white; height:40px; line-height:40px; vertical-align:middle; width:200px; text-align:center;" ><a style="color:#FFF;" href="http://www.cuponperfumes.cl/index.php?recoverToken='.$token.'">Recupera tu Contraseña >></a></div>
					</div>
					<div style="height:100px; background:#EEE; font-family:Helvetica;">
						<div style="float:left; width:60px; padding: 35px 0px 0px 20px; font-size:12px; height:20px; line-height:20px; vertical-align:middle;"><a href="http://www.facebook.com/cuponperfumes"><img src="http://www.cuponperfumes.cl/images/plataform/facebook.png" height="30" /></a><a href="http://www.twitter.com/cuponperfumes"><img src="http://www.cuponperfumes.cl/images/plataform/twitter.png" height="30" /></a></div>
						<div style="float:left; width:50px; padding: 35px 20px 0px 5px; font-size:13px; height:30px; line-height:30px; vertical-align:middle;">Siguenos</div>
						<div style="float:right; width:250px; padding: 35px 20px 0px 0px; font-size:12px;">Si tienes alguna duda responde este correo o escríbenos a: <span style="color:#3ca9ec;">contacto@cuponperfumes.cl</span></div>
					</div>
				</div>
				<div link="#FFF" vlink="#FFF" alink="#FFF" style="position:relative; font-family:Helvetica; text-align:center; color:#FFF; height:30px; line-height:30px; vertical-align:middle; padding:15px 0px 0px 0px;"><a href="#" style="color:#FFF;">Terminos y Condiciones</a>&nbsp;&nbsp;<a href="#" style="color:#FFF;">Privacidad</a></div>
			</div>
		</body>
		</html>';
		$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
		$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$cabeceras .= 'From: contacto@eollice.com' . "\r\n";
		if(mail($para, $asunto, $mensaje, $cabeceras))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}
?>