// JavaScript Document
$(document).ready(function() {
	if(getUrlVars()['active'] == 0){
		$("#activeAsk").html('El token utilizado es invalido, ya expiro o su cuenta ya se encuentra activada.');
		$("#ActiveUser").modal('toggle');
	}
	else if(getUrlVars()['active'] == 1){
		$("#activeAsk").html(' Gracias por registrarte. <br>Tu cuenta se encuentra activada, ya puedes ingresar a tus Compras.');
		$("#ActiveUser").modal('toggle');
	}
	else if(getUrlVars()['active'] == 2){
		$("#activeAsk").html('Existe un error en la operacion con los registros de la base de datos <br> Contacte con el Staff de CuponPerfumes');
		$("#ActiveUser").modal('toggle');
	}
	function getUrlVars() {
		var vars = {};
		var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
			vars[key] = value;
		});
		return vars;
	}
});