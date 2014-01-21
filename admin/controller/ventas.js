$(document).ready(function(){ 
	$("#quemarboton").on('click',function(){
		$("#confirm-modal .modal-confirm-title").html('Confirmar Operación');
		$("#confirm-modal .modal-message").html("Se procedera a utilizar un cupon. ¿Esta seguro que desea efectuar la operación?");
		$("#confirm-modal .confirm-footer").html('<button type="button" id="modal-confirm-btn" class="btn btn-success">Confirmar</button><button type="button" id="modal-confirm-close" class="btn btn-danger" data-dismiss="modal">Cancelar</button>');
		$("#modal-confirm-btn").on('click', function(){
			$("#confirm-modal .modal-message").html('<center><img src="images/484.gif" /></center><p><br><center>Realizando operación. Espere por Favor...</center></p>');
			$.ajax({
				url: "controller/ajax/handler.php",
				type: "POST",
				data: {
					lib: "ventas",
					method: "burnCupon",
					async: false,
					data: JSON.stringify(
					{
						codigo: $("#burncupon").val()
					})
				},
				success: function(resultado){
					var result = JSON.parse(resultado);
					if(result.status == 0){
						$("#itemVentas").empty();
						$.each(result.data, function(key,value){
							$("#itemVentas").append('<tr class="selectedCupon" codigo="'+value.codigo_cupon+'"><td>'+value.nombre+'</td><td>'+value.cliente+'</td><td>'+value.fecha_compra+'</td><td>'+value.delivery+'</td><td>'+value.location+', '+value.comuna+', '+value.city+'</td><td>'+value.direccion_original+', '+value.comuna+', '+value.city+'</td><td>'+value.codigo_cupon+'</td></tr>');
						});
						$(".selectedCupon").on('click', function(){
							$("#burncupon").val($(this).attr('codigo'));
						});
						$("#confirm-modal .modal-confirm-title").html('Codigo Invalido');
						$("#confirm-modal .modal-message").html("Cupon quemado con exito. Se han actualizado los datos.");
						$("#confirm-modal .confirm-footer").html('<button type="button" id="modal-confirm-close" class="btn btn-danger" data-dismiss="modal">Cerrar</button>');
						$("#burncupon").val('');
					}
					else
					{
						$("#confirm-modal .modal-confirm-title").html('Codigo Invalido');
						$("#confirm-modal .modal-message").html("El codigo indicado es invalido o ya se utilizo anteriormente.");
						$("#confirm-modal .confirm-footer").html('<button type="button" id="modal-confirm-close" class="btn btn-danger" data-dismiss="modal">Cerrar</button>');
					}
				}
				
			});
		})
		$("#confirm-modal").modal('toggle');
	});
	$(".selectedCupon").on('click', function(){
		$("#burncupon").val($(this).attr('codigo'));
	});
});