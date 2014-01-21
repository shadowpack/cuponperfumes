$(document).ready(function(){ 
// BOTON REGISTRATE
	$(".regForm").click(function(){
		$("#regForm").modal('toggle');
	});
	$("#regButton").click(function(){
		$(this).button('loading');
		if(($("#passwordReg").val() == $("#repeatPassword").val()) && $("#acepto").is(':checked'))
		{
			$(".has-error").each(function(key,value){
				$(this).removeClass('has-error');
			});
			var status = true;
			if($("#emailReg").val() == "")
			{
				$("#emailReg").parent().addClass('has-error');
				status = false;
			}
			if($("#passwordReg").val() == "")
			{
				$("#passwordReg").parent().addClass('has-error');
				status = false;
			}
			if($("#repeatPassword").val() == "")
			{
				$("#repeatPassword").parent().addClass('has-error');
				status = false;
			}
			if($("#name").val() == "")
			{
				$("#name").parent().addClass('has-error');
				status = false;
			}
			if($("#location").val() == "")
			{
				$("#location").parent().addClass('has-error');
				status = false;
			}
			if($("#city").val() == "")
			{
				$("#city").parent().addClass('has-error');
				status = false;
			}
			if($("#comuna").val() == "")
			{
				$("#comuna").parent().addClass('has-error');
				status = false;
			}
			if(status)
			{
				var packet = {
					name: $("#name").val(),
					email: $("#emailReg").val(),
					location: $("#location").val(),
					city: $("#city").val(),
					comuna: $("#comuna").val(),
					password: $("#passwordReg").val()
				}
				$.ajax({
					url:"model/users.php",
					type:"POST",
					data:{
						method: "regUser",
						vars: JSON.stringify(packet)
					},
					success:function(resultado){
						$(".has-error").each(function(key,value){
							$(this).removeClass('has-error');
						});
						var result = JSON.parse(resultado);
						if(result.status == 0){
							$("#modal-reg").hide();
							$("#modal-success").show();
							$("#regButton").hide();
						}
						else if(result.status == 1){
							$(".messageinput").show();
							$(".messageinput").html("El E-mail indicado ya exite en nuestros registros.");
							$("#email").parent().addClass('has-error');
						}
						else if(result.status == 2){
							$("#modal-reg").hide();
							$("#modal-status2").show();
							$("#regButton").hide();
						}
						else if(result.status == 3){
							$("#modal-reg").hide();
							$("#modal-status3").show();
							$("#regButton").hide();
						}
						else if(result.status == 4){
							$(".messageinput").show();
							$(".messageinput").html("La dirección indicada es invalida.");
							$("#location").parent().addClass('has-error');
							$("#city").parent().addClass('has-error');
							$("#comuna").parent().addClass('has-error');
						}
						$("#regButton").button('reset');
					}
				});
			}
			else{
				$(this).button('reset');
			}
		}
		else if(($("#password").val() != $("#repeatPassword").val()))
		{
			$(".messageinput").show();
			$(".messageinput").html("Las contraseñas indicadas no coinciden.");
			$("#passwordReg").parent().addClass('has-error');
			$("#repeatPassword").parent().addClass('has-error');
			$(this).button('reset');
		}
		else if(!$("#acepto").is(':checked')){
			$(".messageinput").show();
			$(".messageinput").html("Debe aceptar las condiciones y terminos de uso.");
			$("#acepto").parent().addClass('has-error');
			$(this).button('reset');
		}
	});
	// EVENTO QUE CONTROLA EL CLICK EN NO TIENES CUENTA
	// CON ESTE EVENTO LIMPIAMOS EL FOMR DE TODO
	$("#regForm").on('show.bs.modal',function(){
		$("#modal-reg").show();
		$("#modal-success").hide();
		$("#modal-status2").hide();
		$(".messageinput").hide();
		$("#modal-status3").hide();
		$("#regButton").show();
		$(".has-error").each(function(key,value){
			$(this).removeClass('has-error');
		});
		$(".form-control").each(function(key,value){
			$(this).val('');
		});
	});
});