<link rel="stylesheet" type="text/css" media="all" href="css/loginreg.css">
<div class="row loginreg">
	<div class="col12 loginregAll">
		<div class="loginregChar">
			<!-- FORMULARIO MODAL DE INGRESO O REGISTRO DE USUARIO -->
			<div class="logcap">
				<div class="TitleTab">
					<div class="figura">1</div>
					<div class="titleBody">Ingresa a CuponPerfumes</div>	
				</div>
				<div class="lineDataUp"></div>
				<div class="lineData"><input type="text"  class="inputReg" placeholder="E-Mail" id="userform"/></div>
				<div class="lineData"><input type="password" class="inputReg" placeholder="Password" id="passwordform"/></div>
				<div class="lineDatatxt"><div id="regforgotPassword">¿Has olvidado tu password?</div></div>
				<div class="lineDataUp"></div>
				<div class="lineDatabtn"><input type="button" id="loginform" class="btnRegLog" value="Ingresar"/></div>
			</div>
			
			<!-- FORMULARIO MODAL DE REGISTRO -->
			<div class="regcap">
				<div class="TitleTab">
					<div class="figura">2</div>
					<div class="titleBody">Eres un Cliente Nuevo</div>
				</div>
				<div class="lineDataUp"></div>
				<div class="lineData"><input type="text" placeholder="Nombre Completo" class="inputReg" id="regName"/></div>
				<div class="lineData"><input type="text" placeholder="Direccion" class="inputReg" id="regLocation"/></div>
				<div class="lineData"><input type="text" placeholder="Comuna" class="inputReg" id="regComuna"/></div>
				<div class="lineData"><input type="text" placeholder="Ciudad" class="inputReg" id="regCity"/></div>
				<div class="lineData">
					<select class="optionReg" id="regGenero"/>
						<option value="0">Genero</option>
						<option value="1">Masculino</option>
						<option value="2">Femenino</option>
					</select>
				</div>
				<div class="lineData"><input type="text" placeholder="E-Mail" class="inputReg" id="regEmail"/></div>
				<div class="lineData"><input type="password" placeholder="Contraseña" class="inputReg" id="regPassword"/></div>
				<div class="lineData"><input type="password" placeholder="Repite tu Contraseña" class="inputReg" id="regRePassword"/></div>
				<div class="lineData"><input type="checkbox" id="checkReg"/><div id="reg-checkReg">Acepto las condiciones y la política de privacidad</div></div>
				<div class="lineDatabtn"><input type="button" id="btnReg" class="btnRegLog" value="Registrar"/></div>
				<div class="lineData"></div>
			</div>
		
		</div>
	</div>
</div>
<div id="ModalRegLog">
	<div class="backCap"></div>
	<div class="postDatum">
		<div class="TitleTab">
			<div class="figura">3</div>
			<div class="titleBody">Pasos Siguientes</div>
			<div class="close" id="closeBtnReg"></div>
		</div>
		<div class="lineDataUp"></div>
		<div class="lineData">
			Felicitaciones, te has registrado con exito en CuponPerfumes.cl</br></br>
				Como ultimo paso te hemos enviado un correo con instrucciones para activar tu cuenta.</br>
				</br> 
				Equipo CuponPerfumes.cl
		</div>
	</div>
</div>
<!-- SCRIPTS -->
<script type="text/javascript">
$(document).ready(function(){
	$("#loginform").click(function(){
        if(($("#userform").val() != '' && $("#passwordform").val() != '') && ($("#userform").val() != 'E-Mail' && $("#passwordform").val() != 'Password'))
        {
            $.ajax({
                url: 'capaAjax/loginUser.php',
                type: 'POST',
                data: {
                	user: $("#userform").val(),
                	password: $("#passwordform").val()
                },
                success: function(resultado){
                	var result = JSON.parse(resultado);
                	if(result.status)
                	{
                		if(typeof getUrlVars()["next"] != "undefined" || getUrlVars()["next"] != "")
						{
							location.href=getUrlVars()["next"];
						}
						else
						{
							location.href="catalog.php";
						}	
                	}
                	else
                	{
                		alert('El usuario y la coontraseña no coinciden');
                	}
                }
            });
    	}
    	else
    	{
    		alert('Debe indicar un nombre de usuario y contraseña');
    	}
    });
    $('#btnReg').click(function(){
		if($('#regName').val() != '' && $('#regLocation').val() != '' && $('#regCity').val() != '' && $('#regGenero').val() != '' && $('#regEmail').val() != '' && $('#regPassword').val() != '' && $('#regRePassword').val() != '' && $('#checkReg').attr('checked'))
		{
			if(validarEmail($('#regEmail').val()))
			{
				if($('#regPassword').val() == $('#regRePassword').val())
				{
					$.ajax({
		                url: 'capaAjax/regUser.php',
		                type: 'POST',
		                data: {
		                	name: $('#regName').val(),
		                	comuna: $('#regComuna').val(),
		                	location: $('#regLocation').val(),
		                	city: $('#regCity').val(),
		                	genero: $('#regGenero').val(),
		                	email: $('#regEmail').val(),
		                	password: $("#regPassword").val()
		                },
		                success: function(resultado){
		                	var result = JSON.parse(resultado);
		                	if(result.status == 1)
		                	{
							    $("#ModalRegLog").show();
		                	}
		                	else if(result.status == 2)
		                	{

		                	}
		                	else if(result.status == 3)
		                	{

		                	}
		                	else if(result.status == 4)
		                	{

		                	}
		                	else
		                	{

		                	}
		                }
		            });
				}
				else
				{
					alert('Las contraseñas indicadas no coinciden.');
				}
			}
			else
			{
				alert('Debe indicar un E-Mail valido.')
			}
		}
		else
		{
			alert('Debes Completar los datos y aceptar las condiciones y terminos de uso');
		}
		function validarEmail(email) {
		    var expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		    if (expr.test(email))
		    {
		        return true;
			}
			else
			{
				return false;
			}
		}
	});
	$("#closeBtnReg").click(function(){
		$("#ModalRegLog").hide();
		if(getUrlVars()["next"] != "")
		{
			location.href=getUrlVars()["next"];
		}
		else
		{
			location.href="catalog.php";
		}		
		
	});
	$("#regforgotPassword").click(function(){
			var action = new $.esential();
            action.modalWindows($(".recoverPassword"), $("#recoverClose"));
            $("#recoverDatum").show();
    		$("#postRecoverDatum").hide();
		});
	function getUrlVars() {
			var vars = {};
			var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
				vars[key] = value;
			});
			return vars;
		}
});
</script>