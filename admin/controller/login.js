$(document).ready(function(){ 
	$("#login").on('click',function(){
		$.ajax({
			url: "controller/ajax/handler.php",
			type: "POST",
			data:{
				lib: "user",
				method: "login",
				data: JSON.stringify({
					user: $("#user").val(),
					password: $("#password").val()
				})
			},
			success: function(resultado){
				var result = JSON.parse(resultado);
				if(result.status == 0){
					location.href="index.php";
				}
				else
				{
					alert("El usuario y contraseña son incorrecto");	
				}
			}
		});
	});
	
});