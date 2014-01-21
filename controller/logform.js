$(document).ready(function(){ 
// BOTON REGISTRATE
	$(".logForm").click(function(){
		$("#logForm").modal('toggle');
	});
	$("#logButton").click(function(){
		$(this).button('loading');
		var status = true;
		if($("#passwordLog").val() == "")
		{
			$("#passwordLog").parent().addClass('has-error');
			status = false;
		}
		if($("#emailLog").val() == "")
		{
			$("#emailLog").parent().addClass('has-error');
			status = false;
		}
		if(status)
		{
			var packet = {
				email: $("#emailLog").val(),
				password: $("#passwordLog").val()
			}
			$.ajax({
				url:"model/users.php",
				type:"POST",
				data:{
					method: "login",
					vars: JSON.stringify(packet)
				},
				success:function(resultado){
					$(".has-error").each(function(key,value){
						$(this).removeClass('has-error');
					});
					var result = JSON.parse(resultado);
					if(result.status == 0){
						location.reload();
					}
					else if(result.status == 1){
						$(".messageinput").show();
						$(".messageinput").html("El usuario o contraseña indicado no es correcto.");
					}
					else if(result.status == 2){
						$(".messageinput").show();
						$(".messageinput").html("El usuario no se encuentra activado.");
					}
					$("#logButton").button('reset');
				}
			});
		}	
		else{
			$("#logButton").button('reset');
		}
	});
// EVENTO QUE CONTROLA EL CLICK EN NO TIENES CUENTA
	// CON ESTE EVENTO LIMPIAMOS EL FOMR DE TODO
	$("#logForm").on('show.bs.modal',function(){
		$("#modal-log").show();
		$("#modal-success").hide();
		$("#modal-status2").hide();
		$(".messageinput").hide();
		$("#modal-status3").hide();
		$("#logButton").show();
		$(".has-error").each(function(key,value){
			$(this).removeClass('has-error');
		});
		$(".form-control").each(function(key,value){
			$(this).val('');
		});
	});
	$("#registerLink").click(function(){
		$("#logForm").modal('hide');
		$("#regForm").modal('toggle');
	});
	$("#forgotPasswordLink").click(function(){
		$("#logForm").modal('hide');
		$("#forgotPassword").modal('toggle');
	});
	
});