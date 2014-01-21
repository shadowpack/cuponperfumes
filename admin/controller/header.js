$(document).ready(function(){
	//FRAGMENTO CARGA USUARIO
	$(".modal-confirm-title").html("Cerrado Sesion...");
	$(".modal-message").html('<center><img src="images/484.gif" /></center><p><br><center>Estamos cargando tu panel de administración. Espere por Favor...</center></p>');
	$(".confirm-footer").html("");
	$("#confirm-modal").modal('toggle');
	$.ajax({
		url: "controller/ajax/handler.php",
		type: "POST",
		data: {
			lib: "user",
			method: "getinfo",
			data: JSON.stringify({
			})
		},
		success: function(resultado){
			var result = JSON.parse(resultado);
			$("#userlogin").html('<i class="fa fa-user">&nbsp;</i>'+result.nombre+'<b class="caret"></b>');
			$("#confirm-modal").modal('hide');
		}
	});
	//BOTON DE LOGOUT
	$("#logout").on('click',function(){
		$(".modal-title").html("Cerrado Sesion...");
		$(".modal-body").html('<center><img src="images/484.gif" /></center><p><br><center>Estamos cerrando la sesion. Espere por Favor...</center></p>');
		$(".modal-footer").html("");
		$("#confirm-modal").modal('toggle');
		function verificar(){
			location.href="login.php";
		}
		$.ajax({
			url: "controller/ajax/handler.php",
			type: "POST",
			data:{
				lib: "user",
				method: "logout",
				data: JSON.stringify({
				})
			},
			success: function(resultado){
				setTimeout(function(){verificar()},3000);
			}
		});
	});
});
