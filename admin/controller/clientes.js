$(document).ready(function(){ 
	function setSlider(data,value){
		if(value.status == 0){
			var children = data.parent().children(".slider-track");
			children.children('.slider-handle').css({
				background: "#800000"
			});
			children.children(".slider-selection").css({
				background: "#800000"
			});
		}
		else{
			var children = data.parent().children(".slider-track");
			children.children('.slider-handle').css({
				background: "green"
			});
			children.children(".slider-selection").css({
				background: "green"
			});
		}
	}
	function loadClientesPassword(){
		$("#clientesPassword").empty();
		$.ajax({
			url: "controller/ajax/handler.php",
			type: "POST",
			data: {
				lib: "clientes",
				method: "listClientes",
				data: JSON.stringify({
				})
			},
			success: function(resultado){
			}
		});
	}
	function loadClientes(){
		$("#clientesTab").empty();
		$.ajax({
			url: "controller/ajax/handler.php",
			type: "POST",
			data: {
				lib: "clientes",
				method: "listClientes",
				data: JSON.stringify({
				})
			},
			success: function(resultado){
				var result = JSON.parse(resultado);
				if(result.length > 0){
					$.each(result, function(key,value){
						var row = $("<tr></tr>").data('int', value).on('contextmenu', function(e){
							var self = $(this);
							$(".menu-contextual").css({'display':'block', 'left':e.pageX, 'top':e.pageY});
							$(document).click(function(e){
			                    if(e.button == 0){
			                        $(".menu-contextual").css("display", "none");
			                    }
				            });
				            //si pulsamos escape, el menú desaparecerá
				            $(document).keydown(function(e){
				                if(e.keyCode == 27){
				                    $(".menu-contextual").css("display", "none");
				                }
				            });
				            //controlamos los botones del menú
				            $(".menu-contextual").unbind();
				            // SETEAMOS EL MENU menu-contextual
				            if(self.data('int').status == '1')
							{
								$("#desactivar").show();
								$("#activar").hide();
							}
							else
							{
								$("#desactivar").hide();
								$("#activar").show();
							}
							$(".menu-contextual").click(function(e){
			              // El switch utiliza los IDs de los <li> del menú
		                  switch(e.target.id){
		                  		//CASOS DEL MENU CONTEXTUAL
		                        case "modificar":
	                              	var data = self.data('int');
									$("#data_id_cliente").val(data.id_cliente);
									// DEFINIMOS LOS CAMPOS DE EDICION
									$("#data_name_cliente").val(data.nombre);
									$("#data_direccion_cliente").val(data.direccion);
									$("#data_latitud_cliente").val(data.lat);
									$("#data_longitud_cliente").val(data.lng);
									$("#data_cuenta_banco_cliente").val(data.cuenta_bancaria);
									$("#data_rut_cliente").val(data.rut);
									$("#data_razon_cliente").val(data.razon_social);
									$("#data_where_cliente").val(data.where);
									$("#data_contacto_cliente").val(data.contacto);
									$("#data_telefono_cliente").val(data.telefono);
									$("#data_email_cliente").val(data.email);
									$("#data_rut_contacto_cliente").val(data.rut_contacto);
									$("#data_descripcion_cliente").val(data.descripcion);
									$("#edit-cliente").modal('toggle');
									var imga = new $.images_product({
										core: $("#images_cliente_edit")
									});
									$.each(data.fotos, function(key, value){
										imga.publics.add_images(value);
									});
									$("#modal-edit-close").show();
									$("#modal-add-close").hide();
		                            break;      
		                        case "activar":
		                        	var value = self.data('int');
		                        	$.ajax({
										url: "controller/ajax/handler.php",
										type: "POST",
										data: {
											lib: "clientes",
											method: "activeCliente",
											data: JSON.stringify({
												id: $("#slider_category_"+value.id_cliente).attr('valueItem'),
												active: 1
											})
										},
										success: function(resultado){
											var result = JSON.parse(resultado);
											if(result.status != 1){
												alert("Existe un error al activar el producto");
											}
											else
											{
												$("#slider_category_"+value.id_cliente).slider('setValue', 1);
												var children = $("#slider_category_"+value.id_cliente).parent().children(".slider-track");
												children.children('.slider-handle').css({
													background: "green"
												});
												children.children(".slider-selection").css({
													background: "green"
												});
												$("#desactivar").show();
												$("#activar").hide();
												self.data('int').status = 1;
											}
										}
									});
									setSlider($("#slider_category_"+value.id_category),{
										status: 1
									});
		                            break;
		                        case "desactivar":
		                        	var value = self.data('int');
		                        	$.ajax({
										url: "controller/ajax/handler.php",
										type: "POST",
										data: {
											lib: "clientes",
											method: "activeCliente",
											data: JSON.stringify({
												id: $("#slider_category_"+value.id_cliente).attr('valueItem'),
												active: 0
											})
										},
										success: function(resultado){
											var result = JSON.parse(resultado);
											if(result.status != 1){
												alert("Existe un error al activar el producto");
											}
											else
											{
												$("#slider_category_"+value.id_cliente).slider('setValue', 0);
												var children = $("#slider_category_"+value.id_cliente).parent().children(".slider-track");
												children.children('.slider-handle').css({
													background: "#800000"
												});
												children.children(".slider-selection").css({
													background: "#800000"
												});
												$("#desactivar").show();
												$("#activar").hide();
												self.data('int').status = 0;
											}
										}
									});
									setSlider($("#slider_category_"+value.id_category),{
										status: 0
									});
									break;
		                        case "eliminar":
		                        	var data = self.data('int');
		                        	$("#confirm-modal .modal-confirm-title").html('Eliminar Cliente');
									$("#confirm-modal .modal-message").html("Se procedera a eliminar un cliente. ¿Esta seguro que desea efectuar la operación?");
									$("#confirm-modal .confirm-footer").html('<button type="button" id="modal-confirm-btn" class="btn btn-success">Confirmar</button><button type="button" id="modal-confirm-close" class="btn btn-danger" data-dismiss="modal">Cancelar</button>');
									$("#modal-confirm-btn").on('click', function(){
										$("#confirm-modal .modal-message").html('<center><img src="images/484.gif" /></center><p><br><center>Realizando operación. Espere por Favor...</center></p>');
										$.ajax({
											url: "controller/ajax/handler.php",
											type: "POST",
											data: {
												lib: "clientes",
												method: "delCliente",
												data: JSON.stringify({
													id:data.id_cliente
												})
											},
											success: function(resultado){
												var result = JSON.parse(resultado);
												if(result.status != 1){
													$("#confirm-modal .modal-confirm-title").html('Fracaso en eliminación');
													$("#confirm-modal .modal-message").html("Ha fallado la eliminación del cliente. Contacte con el administrador.");
													$("#confirm-modal .confirm-footer").html('<button type="button" id="modal-confirm-close" class="btn btn-danger" data-dismiss="modal">Cancelar</button>');
													loadClientes();
												}
												else{
													loadClientes();
													$("#confirm-modal").modal('hide');
												}
											}
										});
									});
									$("#confirm-modal").modal('toggle');
		                            break;
		                    }
			            });
							e.preventDefault();
							return false;
							
						});
						$("<td></td>").appendTo(row).html(value.nombre);
						$("<td></td>").appendTo(row).html(value.direccion);
						$("<td></td>").appendTo(row).html(value.activos);
						$("<td></td>").appendTo(row).html(value.total);
						$("<td></td>").appendTo(row).html(value.ventas);
						$("<td></td>").appendTo(row).html(value.rut);
						$("<td></td>").appendTo(row).html(value.razon_social);
						$("<td></td>").appendTo(row).html(value.cuenta_bancaria);
						$("<td></td>").appendTo(row).data('int', value).html('<center><i class="fa fa-pencil" style="cursor:pointer;"></i></center>').click(function(){
							var data = $(this).data('int');
							$("#data_id_cliente").val(data.id_cliente);
							// DEFINIMOS LOS CAMPOS DE EDICION
							$("#data_name_cliente").val(data.nombre);
							$("#data_direccion_cliente").val(data.direccion);
							$("#data_latitud_cliente").val(data.lat);
							$("#data_longitud_cliente").val(data.lng);
							$("#data_cuenta_banco_cliente").val(data.cuenta_bancaria);
							$("#data_rut_cliente").val(data.rut);
							$("#data_razon_cliente").val(data.razon_social);
							$("#data_where_cliente").val(data.where);
							$("#data_contacto_cliente").val(data.contacto);
							$("#data_telefono_cliente").val(data.telefono);
							$("#data_email_cliente").val(data.email);
							$("#data_rut_contacto_cliente").val(data.rut_contacto);
							$("#data_descripcion_cliente").val(data.descripcion);
							$("#edit-cliente").modal('toggle');
							var imga = new $.images_product({
								core: $("#images_cliente_edit")
							});
							$.each(data.fotos, function(key, value){
								imga.publics.add_images(value);
							});
							$("#modal-edit-close").show();
							$("#modal-add-close").hide();
						});
						var slider2 = $("<td></td>").appendTo(row);
						var centrado = $("<center></center>").appendTo(slider2);
						var myslider = $('<div></div>').attr({
							id: "slider_category_"+value.id_cliente,
							valueItem : value.id_cliente
						}).addClass("slider slider-horizontal").css({
							 width: "30px"				 
						}).appendTo(centrado).slider({
							min:0,
							max:1,
							value: value.estado,
							tooltip: "hidden"
						}).on('slide', function(ev){
							$.ajax({
								url: "controller/ajax/handler.php",
								type: "POST",
								data: {
									lib: "clientes",
									method: "activeCliente",
									data: JSON.stringify({
										id: $("#slider_category_"+value.id_cliente).attr('valueItem'),
										active: ev.value
									})
								},
								success: function(resultado){
									var result = JSON.parse(resultado);
									if(result.status != 1){
										alert("Existe un error al activar el producto");
									}
								}
							});
							setSlider($("#slider_category_"+value.id_cliente),{
								status: ev.value
							});
						});
						row.appendTo($("#clientesTab"));
						setSlider($("#slider_category_"+value.id_cliente),{
							status: value.estado
						});
					});
				}
				else
				{
					var row = $("<tr></tr>");
					$("<td colspan='13'>No existen items asociados a esta categoria.</td>").appendTo(row);
					row.appendTo("#clientesTab");
				}
				$("#waitingClientes").hide();
				$("#tablaClientes").show();
			}
		})
	}
	loadClientes();
	$("#addCliente").on('click', function(){
		$.ajax({
			url: "controller/ajax/handler.php",
			type: "POST",
			data: {
				lib: "clientes",
				method: "addCliente",
				data: JSON.stringify({
				})
			},
			success: function(resultado){
				var result = JSON.parse(resultado);
				$("#data_id_cliente").val(result.id);
			}
		});
		$("#edit-cliente").modal('toggle');
		var imga = new $.images_product({
			core: $("#images_cliente_edit")
		});
	});
	$("#modal-edit-btn").on('click', function(){
		$("#confirm-modal .modal-confirm-title").html('Agregar Clientes');
		$("#confirm-modal .modal-message").html("Se procedera a agregar un cliente. ¿Esta seguro que desea efectuar la operación?");
		$("#confirm-modal .confirm-footer").html('<button type="button" id="modal-confirm-btn" class="btn btn-success">Confirmar</button><button type="button" id="modal-confirm-close" class="btn btn-danger" data-dismiss="modal">Cancelar</button>');
		$("#modal-confirm-btn").on('click', function(){
			$.ajax({
				url: "controller/ajax/handler.php",
				type: "POST",
				data: {
					lib: "clientes",
					method: "modCliente",
					data: JSON.stringify({
						nombre: $("#data_name_cliente").val(),
						direccion: $("#data_direccion_cliente").val(),
						lat:$("#data_latitud_cliente").val(),
						lng:$("#data_longitud_cliente").val(),
						cuenta_bancaria:$("#data_cuenta_banco_cliente").val(),
						rut:$("#data_rut_cliente").val(),
						razon_social: $("#data_razon_cliente").val(),
						id_cliente: $("#data_id_cliente").val(),
						where: $("#data_where_cliente").val(),
						contacto: $("#data_contacto_cliente").val(),
						telefono: $("#data_telefono_cliente").val(),
						email: $("#data_email_cliente").val(),
						rut_contacto: $("#data_rut_contacto_cliente").val(),
						descripcion: $("#data_descripcion_cliente").val()
					})
				},
				success: function(resultado){
					var result = JSON.parse(resultado);
					if(result.status == 1){
						loadClientes();
						$("#confirm-modal").modal('hide');
					}
					else
					{
						$("#confirm-modal .modal-confirm-title").html('Fracaso al modificar cliente');
						$("#confirm-modal .modal-message").html("Ha fallado la modificación del cliente. Contacte con el administrador.");
						$("#confirm-modal .confirm-footer").html('<button type="button" id="modal-confirm-close" class="btn btn-danger" data-dismiss="modal">Cancelar</button>');
						loadClientes();
					}
				}
			});
		});
		$("#modal-confirm-close").on('click', function(){
			$("#confirm-modal").modal('hide');
			$("#edit-cliente").modal('toggle');
			$("#modal-confirm-close").unbind();
		})
		$("#confirm-modal").modal('toggle');
		$("#edit-cliente").modal('hide');
	});
});