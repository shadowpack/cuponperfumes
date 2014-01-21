$(document).ready(function(){ 
	$("#logout").click(function(){
		$.ajax({
			url:"model/users.php",
			type:"POST",
			data:{
				method: "logout"
			},
			success:function(resultado){
				var result = JSON.parse(resultado);
				if(result.status == 0){
					location.href="index.php";
				}
			}
		});
	});
	$("#cambiarPassword").click(function(){
		$.ajax({
			url: "model/users.php",
			type:"POST",
			data:{
				method: "changePassword"
			},
			success: function(resultado){
				var result = JSON.parse(resultado);
				if(result.status==0){
					location.href="http://www.cuponperfumes.cl/index.php?recoverToken="+result.token;
				}
				else
				{
					alert("Existe un error interno al internar cambiar tu contraseña, por favor contacta con el staff de Cuponperfumes");
				}
			}
		})
	});
	$("#misCupones").click(function(){
		$.ajax({
			url: "model/conection.php",
			type:"POST",
			success: function(resultado){
				if(resultado == "true"){
					$.ajax({
						url:"model/active_cupons.php",
						type:"POST",
						success:function(resultado){
							$("#activecupons").html(resultado);
							$(".mailCupon").click(function(e){
								var self = $(this);
								$.ajax({
									url:"model/sendCupon.php",
									type:"POST",
									data:{
										id: self.attr('numid')
									},
									success:function(resultado){
										alert('E-Mail enviado con exito a su casilla');
									}
								})
								e.stopPropagation();
							});
						}
					});
					$("#mycupons").modal('toggle');
				}
				else
				{
					alert("Existe un error al verificar identidad, pruebe otra vez. Si el problema persiste contacte con el staff de Cuponperfumes");
				}
			}
		})
	});
});