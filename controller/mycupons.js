// JavaScript Document
$(document).ready(function() {
	if(getUrlVars()['cupons'] == 'show'){
		$.ajax({
			url:"model/conection.php",
			type:"POST",
			success:function(resultado){
				if(resultado == "true"){
					$.ajax({
						url:"model/active_cupons.php",
						async: false,
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
		});
	}
	function getUrlVars() {
		var vars = {};
		var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
			vars[key] = value;
		});
		return vars;
	}
});