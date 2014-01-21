$(document).ready(function(){ 
	//OCULTAR MENU EN PAGINA
	$("#menuRight").hide();
	//CARGAR CATEGORIAS
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
	function loadCategoria(){
		$("#data-categorias").empty();
		$.ajax({
			url: "controller/ajax/handler.php",
			type: "POST",
			data: {
				lib: "productos",
				method: "getCategoria",
				data: JSON.stringify({
				})
			},
			success: function(resultado){
				var result = JSON.parse(resultado);
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
									$("#data_id_category").val(data.id_category);
									$("#add_name_category").val(data.name);
									$("#edit-category").modal('toggle');
									var imga = new $.images_product({
										core: $(".images_slider_category"),
										category:true
									});
									if(data.source != null && data.source != ""){
										var image = {
											source: data.source,
											id_item: data.id_category,
											portrait: false,
											id_image: null,
											size: 400,
											minisize:70
										}
										imga.publics.add_images(image);
									}
									$("#modal-category-mod-close").show();
									$("#modal-category-add-close").hide();
		                            break;      
		                        case "activar":
		                        	var value = self.data('int');
		                            $.ajax({
										url: "controller/ajax/handler.php",
										type: "POST",
										data: {
											lib: "productos",
											method: "activeCategoria",
											data: JSON.stringify({
												id: $("#slider_category_"+value.id_category).attr('valueItem'),
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
												$("#slider_category_"+value.id_category).slider('setValue', 1);
												var children = $("#slider_category_"+value.id_category).parent().children(".slider-track");
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
											lib: "productos",
											method: "activeCategoria",
											data: JSON.stringify({
												id: $("#slider_category_"+value.id_category).attr('valueItem'),
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
												$("#slider_category_"+value.id_category).slider('setValue', 0);
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
		                        	$("#confirm-modal .modal-confirm-title").html('Eliminar Categoria');
									$("#confirm-modal .modal-message").html("Se procedera a eliminar una categoria. ¿Esta seguro que desea efectuar la operación?");
									$("#confirm-modal .confirm-footer").html('<button type="button" id="modal-confirm-btn" class="btn btn-success">Confirmar</button><button type="button" id="modal-confirm-close" class="btn btn-danger" data-dismiss="modal">Cancelar</button>');
									$("#modal-confirm-btn").on('click', function(){
										$("#confirm-modal .modal-message").html('<center><img src="images/484.gif" /></center><p><br><center>Realizando operación. Espere por Favor...</center></p>');
										$.ajax({
											url: "controller/ajax/handler.php",
											type: "POST",
											data: {
												lib: "productos",
												method: "removeCategory",
												data: JSON.stringify({
													id:data.id_category
												})
											},
											success: function(resultado){
												var result = JSON.parse(resultado);
												if(result.status != 1){
													$("#confirm-modal .modal-confirm-title").html('Fracaso eliminación');
													$("#confirm-modal .modal-message").html("Ha fallado la eliminación de la categoria. Contacte con el administrador.");
													$("#confirm-modal .confirm-footer").html('<button type="button" id="modal-confirm-close" class="btn btn-danger" data-dismiss="modal">Cancelar</button>');
													loadCategoria();
												}
												else{
													loadCategoria();
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
					$("<td></td>").appendTo(row).html(value.name);
					$("<td></td>").appendTo(row).html(value.cantidad);
					$("<td></td>").appendTo(row).html(value.position);
					$("<td></td>").appendTo(row).data('int', value).html('<center><i class="fa fa-pencil" style="cursor:pointer;"></i></center>').click(function(){
						var data = $(this).data('int');
						$("#data_id_category").val(data.id_category);
						$("#add_name_category").val(data.name);
						$("#edit-category").modal('toggle');
						var imga = new $.images_product({
							core: $(".images_slider_category"),
							category:true
						});
						if(data.source != null && data.source != ""){
							var image = {
								source: data.source,
								id_item: data.id_category,
								portrait: false,
								id_image: null,
								size: 400,
								minisize:70
							}
							imga.publics.add_images(image);
						}
						$("#modal-category-mod-close").show();
						$("#modal-category-add-close").hide();
					});
					var slider2 = $("<td></td>").appendTo(row);
					var centrado = $("<center></center>").appendTo(slider2);
					var myslider = $('<div></div>').attr({
						id: "slider_category_"+value.id_category,
						valueItem : value.id_category
					}).addClass("slider slider-horizontal").css({
						 width: "30px"				 
					}).appendTo(centrado).slider({
						min:0,
						max:1,
						value: value.status,
						tooltip: "hidden"
					}).on('slide', function(ev){
						$.ajax({
							url: "controller/ajax/handler.php",
							type: "POST",
							data: {
								lib: "productos",
								method: "activeCategoria",
								data: JSON.stringify({
									id: $("#slider_category_"+value.id_category).attr('valueItem'),
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
						
						setSlider($("#slider_category_"+value.id_category),{
							status: ev.value
						});
					});
					row.appendTo("#data-categorias");
					setSlider($("#slider_category_"+value.id_category),value);
					$("#waitingCat").hide();
					$("#tablaCategorias").show();
				});
				$("#modal-category-mod-btn").unbind();
				$("#modal-category-mod-btn").on('click', function(){
					$("#confirm-modal .modal-confirm-title").html('Confirmar modificación');
					$("#confirm-modal .modal-message").html("Se procedera a modificar una categoria. ¿Esta seguro que desea efectuar la operación?");
					$("#confirm-modal .confirm-footer").html('<button type="button" id="modal-confirm-btn" class="btn btn-success">Confirmar</button><button type="button" id="modal-confirm-close" class="btn btn-danger" data-dismiss="modal">Cancelar</button>');
					$("#modal-confirm-btn").on('click', function(){
						$("#confirm-modal .modal-message").html('<center><img src="images/484.gif" /></center><p><br><center>Realizando operación. Espere por Favor...</center></p>');
						$.ajax({
							url: "controller/ajax/handler.php",
							type: "POST",
							data: {
								lib: "productos",
								method: "modCategory",
								data: JSON.stringify({
									id_category: $("#data_id_category").val(),
									name: $("#add_name_category").val()
								})
							},
							success: function(resultado){
								var result = JSON.parse(resultado);
								if(result.status != 1){
									$("#confirm-modal .modal-confirm-title").html('Fracaso modificación');
									$("#confirm-modal .modal-message").html("Ha fallado la modificación de la categoria. Contacte con el administrador.");
									$("#confirm-modal .confirm-footer").html('<button type="button" id="modal-confirm-close" class="btn btn-danger" data-dismiss="modal">Cancelar</button>');
									loadCategoria();
								}
								else{
									loadCategoria();
									$("#confirm-modal").modal('hide');
								}
							}
						});
					});
					$("#confirm-modal").modal('toggle');
					$("#edit-category").modal('hide');
				});
			}
		});
		$("#addCategory").on('click', function(){
			$.ajax({
				url: "controller/ajax/handler.php",
				type: "POST",
				data: {
					lib: "productos",
					method: "addCategory",
					data: JSON.stringify({
					})
				},
				success: function(resultado){
					var result = JSON.parse(resultado);
					if(result.status != 1){
						$("#confirm-modal .modal-confirm-title").html('Fracaso agregar categoria');
						$("#confirm-modal .modal-message").html("Ha fallado agregar un producto. Contacte con el administrador.");
						$("#confirm-modal .confirm-footer").html('<button type="button" id="modal-confirm-close" class="btn btn-danger" data-dismiss="modal">Cancelar</button>');
						$("#confirm-modal").modal('toggle');
					}
					else{
						$("#data_id_category").val(result.id);
						$("#modal-category-mod-close").hide();
						$("#modal-category-add-close").unbind().show().on('click', function(){
							$.ajax({
								url: "controller/ajax/handler.php",
								type: "POST",
								data: {
									lib: "productos",
									method: "removeCategory",
									data: JSON.stringify({
										id:$("#data_id_category").val()
									})
								},
								success: function(resultado){

								}
							});
						});
						var imga = new $.images_product({
							core: $(".images_slider_category"),
							category:true
						});
						$("#edit-category").modal('toggle');
					}
				}
			});
			
		});
	}
	loadCategoria();
	//FUNCION PRODUCTO
	function loadProduct(){
		$("#waiting").show();
		$("#productos").empty();
		$("#tablaProductos").hide();
		// CARGAMOS LOS PRODUCTOS
		$.ajax({
			url: "controller/ajax/handler.php",
			type: "POST",
			data: {
				lib: "productos",
				method: "listActiveProduct",
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
			            if(self.data('int').estado == '1')
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
										$("#data_categoria option[value="+value.id_category+"]").attr("selected",true);
										$("#data_id").val(data.id_item);
										$("#data_name").val(data.nombre);
										$("#data_descripcion_small").val(data.descripcion_small);
										$("#data_descripcion").val(data.descripcion);
										$("#data_precio_real").val(data.precio_real);
										$("#data_precio_descuento").val(data.precio_descuento);
										$("#data_precio_delivery").val(data.precio_delivery);
										$("#data_amount").val(data.cantidad_total);
										$("#data_tiempofinal").val(data.tiempoFinal);
										$("#data_expiracion").val(data.expiracion);
										$("#data_reglas").val(data.reglas);
										$("#data_condiciones").val(data.condiciones);
										$("#data_where").val(data.where);
										$("#edit-product").modal('toggle');
										$("#modal-edit-close").show();
										$("#modal-add-close").hide();
			                            break;      
			                        case "activar":
			                        	var data = self.data('int');
			                            $.ajax({
											url: "controller/ajax/handler.php",
											type: "POST",
											data: {
												lib: "productos",
												method: "activeProduct",
												data: JSON.stringify({
													id: $("#slider_"+data.id_item).attr('valueItem'),
													active: 1
												})
											},
											success: function(resultado){
												var result = JSON.parse(resultado);
												if(result.status != 1){
													alert("Existe un error al activar el producto");
												}
												else{
													$("#slider_"+data.id_item).slider('setValue', 1);
												}
												var children = $("#slider_"+data.id_item).parent().children(".slider-track");
												children.children('.slider-handle').css({
													background: "green"
												});
												children.children(".slider-selection").css({
													background: "green"
												});
												$("#desactivar").show();
												$("#activar").hide();
												self.data('int').estado = 1;
											}
										});
			                              break;
			                        case "desactivar":
			                        	var data = self.data('int');
			                            $.ajax({
											url: "controller/ajax/handler.php",
											type: "POST",
											data: {
												lib: "productos",
												method: "activeProduct",
												data: JSON.stringify({
													id: $("#slider_"+data.id_item).attr('valueItem'),
													active: 0
												})
											},
											success: function(resultado){
												var result = JSON.parse(resultado);
												if(result.status != 1){
													alert("Existe un error al activar el producto");
												}
												else{
													$("#slider_"+data.id_item).slider('setValue', 0);
												}
												var children = $("#slider_"+data.id_item).parent().children(".slider-track");
												children.children('.slider-handle').css({
													background: "#800000"
												});
												children.children(".slider-selection").css({
													background: "#800000"
												});
												$("#desactivar").hide();
												$("#activar").show();
												self.data('int').estado = 0;
											}
										});
			                              break;
			                        case "eliminar":
			                        	$("#confirm-modal .modal-confirm-title").html('Confirmar eliminación');
										$("#confirm-modal .modal-message").html("Se procedera a eliminar un producto. ¿Esta seguro que desea efectuar la operación?");
										$("#confirm-modal .confirm-footer").html('<button type="button" id="modal-confirm-btn" class="btn btn-success">Confirmar</button><button type="button" id="modal-confirm-close" class="btn btn-danger" data-dismiss="modal">Cancelar</button>');
			                            $("#modal-confirm-btn").on('click', function(){
											$("#confirm-modal .modal-message").html('<center><img src="images/484.gif" /></center><p><br><center>Realizando operación. Espere por Favor...</center></p>');
			                            	$("#confirm-modal .confirm-footer").html('');
			                            	$.ajax({
												url: "controller/ajax/handler.php",
												type: "POST",
												data: {
													lib: "productos",
													method: "delProduct",
													data: JSON.stringify({
														id: self.data('int').id_item,
													})
												},
												success: function(resultado){
													var result = JSON.parse(resultado);
													if(result.status != 1){
														$("#confirm-modal .modal-confirm-title").html('Fracaso eliminación');
														$("#confirm-modal .modal-message").html("Ha fallado la eliminación del producto. Contacte con el administrador.");
														$("#confirm-modal .confirm-footer").html('<button type="button" id="modal-confirm-close" class="btn btn-danger" data-dismiss="modal">Cancelar</button>');
														loadProduct();
													}
													else{
														loadProduct();
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
						$("<td></td>").appendTo(row).html(value.categoria);
						$("<td></td>").appendTo(row).html(value.nombre);
						var des = $("<td></td>").appendTo(row);
						$("<div></div>").appendTo(des).html(value.descripcion_small.substring(0,40)+"...").attr({
							"data-toggle":"tooltip",
							"data-placement":"top",
							"title":value.descripcion_small
						}).tooltip();
						$("<td></td>").appendTo(row).html("$ "+value.precio_real);
						$("<td></td>").appendTo(row).html("$ "+value.precio_descuento);
						$("<td></td>").appendTo(row).html("$ "+value.precio_delivery);
						$("<td></td>").appendTo(row).html(value.tiempoFinal);
						$("<td></td>").appendTo(row).html(value.expiracion);
						var reglas = $("<td></td>").appendTo(row);
						$("<div></div>").appendTo(reglas).html(value.reglas.substring(0,40)+"...").attr({
							"data-toggle":"tooltip",
							"data-placement":"bottom",
							"title":value.reglas
						}).tooltip();
						var condiciones = $("<td></td>").appendTo(row);
						$("<div></div>").appendTo(condiciones).html(value.condiciones.substring(0,20)+"...").attr({
							"data-toggle":"tooltip",
							"data-placement":"bottom",
							"title":value.condiciones
						}).tooltip();
						var where = $("<td></td>").appendTo(row);
						$("<div></div>").appendTo(where).html(value.where.substring(0,20)+"...").attr({
							"data-toggle":"tooltip",
							"data-placement":"bottom",
							"title":value.where
						}).tooltip();
							// MANEJAMOS LAS EDICIONES
						$("<td></td>").appendTo(row).data('int', value).html('<center><i class="fa fa-pencil" style="cursor:pointer;"></i></center>').click(function(){
						var data = $(this).data('int');
						$("#data_categoria option[value="+value.id_category+"]").attr("selected",true);
						$("#data_id").val(data.id_item);
						$("#data_name").val(data.nombre);
						$("#data_descripcion_small").val(data.descripcion_small);
						$("#data_descripcion").val(data.descripcion);
						$("#data_precio_real").val(data.precio_real);
						$("#data_precio_descuento").val(data.precio_descuento);
						$("#data_precio_delivery").val(data.precio_delivery);
						$("#data_tiempofinal").val(data.tiempoFinal);
						$("#data_expiracion").val(data.expiracion);
						$("#data_reglas").val(data.reglas);
						$("#data_amount").val(data.cantidad_total);
						$("#data_condiciones").val(data.condiciones);
						$("#data_where").val(data.where);
						$("#edit-product").modal('toggle');
						$("#mod_slider_images").empty();
						$(".carrousel_container").empty();
						var img = new $.images_product({
							core: $("#images_product_edit")
						});
						$.each(data.fotos, function(key, value){
							img.publics.add_images(value);
						});
						$("#modal-edit-close").show();
						$("#modal-add-close").hide();
						
					});
						var slider2 = $("<td></td>").appendTo(row);
						var centrado = $("<center></center>").appendTo(slider2);
						var myslider = $('<div></div>').attr({
							id: "slider_"+value.id_item,
							valueItem : value.id_item
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
									lib: "productos",
									method: "activeProduct",
									data: JSON.stringify({
										id: $("#slider_"+value.id_item).attr('valueItem'),
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
							if(ev.value == 1){
								var children = $("#slider_"+value.id_item).parent().children(".slider-track");
								children.children('.slider-handle').css({
									background: "green"
								});
								children.children(".slider-selection").css({
									background: "green"
								});
								
							}
							else
							{
								var children = $("#slider_"+value.id_item).parent().children(".slider-track");
								children.children('.slider-handle').css({
									background: "#800000"
								});
								children.children(".slider-selection").css({
									background: "#800000"
								});
							}
						});
						row.appendTo("#productos");
						if(value.estado == 0){
							var children = $("#slider_"+value.id_item).parent().children(".slider-track");
							children.children('.slider-handle').css({
								background: "#800000"
							});
							children.children(".slider-selection").css({
								background: "#800000"
							});
						}
						else{
							var children = $("#slider_"+value.id_item).parent().children(".slider-track");
							children.children('.slider-handle').css({
								background: "green"
							});
							children.children(".slider-selection").css({
								background: "green"
							});
						}			
					});
				}
				else
				{
					var row = $("<tr></tr>");
					$("<td colspan='13'>No existen productos asociados a esta categoria.</td>").appendTo(row);
					row.appendTo("#productos");
				}
				$("#waiting").hide();
				$("#tablaProductos").show();
			}
		});
	}
	// CARGAMOS LOS PRODUCTOS ANTIGUOS
	function loadProductOld(){
		$("#waitingOld").show();
		$("#productosOld").empty();
		$("#tablaProductosOld").hide();
		// CARGAMOS LOS PRODUCTOS
		$.ajax({
			url: "controller/ajax/handler.php",
			type: "POST",
			data: {
				lib: "productos",
				method: "listActiveProductOld",
				data: JSON.stringify({
				})
			},
			success: function(resultado){
				var result = JSON.parse(resultado);
				if(result.length > 0){
					$.each(result, function(key,value){
						var row = $("<tr></tr>");
						$("<td></td>").appendTo(row).html(value.categoria);
						$("<td></td>").appendTo(row).html(value.nombre);
						var des = $("<td></td>").appendTo(row);
						$("<div></div>").appendTo(des).html(value.descripcion_small.substring(0,40)+"...").attr({
							"data-toggle":"tooltip",
							"data-placement":"top",
							"title":value.descripcion_small
						}).tooltip();
						$("<td></td>").appendTo(row).html("$ "+value.precio_real);
						$("<td></td>").appendTo(row).html("$ "+value.precio_descuento);
						$("<td></td>").appendTo(row).html("$ "+value.precio_delivery);
						$("<td></td>").appendTo(row).html(value.tiempoFinal);
						$("<td></td>").appendTo(row).html(value.expiracion);
						var reglas = $("<td></td>").appendTo(row);
						$("<div></div>").appendTo(reglas).html(value.reglas.substring(0,40)+"...").attr({
							"data-toggle":"tooltip",
							"data-placement":"bottom",
							"title":value.reglas
						}).tooltip();
						var condiciones = $("<td></td>").appendTo(row);
						$("<div></div>").appendTo(condiciones).html(value.condiciones.substring(0,20)+"...").attr({
							"data-toggle":"tooltip",
							"data-placement":"bottom",
							"title":value.condiciones
						}).tooltip();
						var where = $("<td></td>").appendTo(row);
						$("<div></div>").appendTo(where).html(value.where.substring(0,20)+"...").attr({
							"data-toggle":"tooltip",
							"data-placement":"bottom",
							"title":value.where
						}).tooltip();
						var slider2 = $("<td></td>").appendTo(row);
						var centrado = $("<center></center>").appendTo(slider2);
						var clonar = $('<button codigo="'+value.id_item+'" type="button" id="modal-confirm-clone" class="btn btn-warning" data-dismiss="modal">Clonar</button>').appendTo(centrado)
						.on('click',function(){
							var self = $(this);
							$("#clonar-product").modal('toggle');
							$("#modal-clonar-btn").unbind();
							$("#modal-clonar-btn").on('click',function(){
								$("#clonar-product").modal('hide');
								$("#confirm-modal .modal-confirm-title").html('Confirmar clonación');
								$("#confirm-modal .modal-message").html("Se procedera a clonar un producto. ¿Esta seguro que desea efectuar la operación?");
								$("#confirm-modal .confirm-footer").html('<button type="button" id="modal-confirm-btn" class="btn btn-success">Confirmar</button><button type="button" id="modal-confirm-close" class="btn btn-danger" data-dismiss="modal">Cancelar</button>');
								$("#modal-confirm-btn").on('click', function(){
									$("#confirm-modal .modal-message").html('<center><img src="images/484.gif" /></center><p><br><center>Realizando operación. Espere por Favor...</center></p>');
									$.ajax({
										url: "controller/ajax/handler.php",
										type: "POST",
										data: {
											lib: "productos",
											method: "clonar",
											async: false,
											data: JSON.stringify(
											{
												codigo: self.attr('codigo'),
												tiempofinal: $("#data_tiempofinal_clonar").val(),
												expiracion: $("#data_expiracion_clonar").val()
											})
										},
										success: function(resultado){
											var result = JSON.parse(resultado);
											if(result.status == 1){
												$("#data_tiempofinal_clonar").val('');
												$("#data_expiracion_clonar").val('');
												loadProduct();
												$("#confirm-modal").modal('hide');
											}
											else
											{
												$("#confirm-modal .modal-confirm-title").html('Fracaso clonación');
												$("#confirm-modal .modal-message").html("Ha fallado la clonación del producto. Contacte con el administrador.");
												$("#confirm-modal .confirm-footer").html('<button type="button" id="modal-confirm-close" class="btn btn-danger" data-dismiss="modal">Cancelar</button>');
												loadProduct();
											}
										}
										
									});
								});
								$("#confirm-modal").modal('toggle');
							});
						});
						row.appendTo("#productosOld");
						if(value.estado == 0){
							var children = $("#slider_"+value.id_item).parent().children(".slider-track");
							children.children('.slider-handle').css({
								background: "#800000"
							});
							children.children(".slider-selection").css({
								background: "#800000"
							});
						}
						else{
							var children = $("#slider_"+value.id_item).parent().children(".slider-track");
							children.children('.slider-handle').css({
								background: "green"
							});
							children.children(".slider-selection").css({
								background: "green"
							});
						}
					});
				}
				else
				{
					var row = $("<tr></tr>");
					$("<td colspan='13'>No existen productos asociados a esta categoria.</td>").appendTo(row);
					row.appendTo("#productosOld");
				}
				$("#waitingOld").hide();
				$("#tablaProductosOld").show();
			}
		});
	}
	//CARGAMOS AMBAS CATEGORIAS
	loadProduct();
	loadProductOld();
	//CARGAMOS LAS CATEGORIAS
	$.ajax({
		url: "controller/ajax/handler.php",
		type: "POST",
		data: {
			lib: "productos",
			method: "getCategoria",
			data: JSON.stringify({
			})
		},
		success: function(resultado){
			var result = JSON.parse(resultado);
			$.each(result, function(key,value){
				$("#data_categoria").append(new Option(value.name, value.id_category, true, true));
				$("#data_categoria_add").append(new Option(value.name, value.id_category, true, true));
			});
			$("#data_categoria_add").val('cate');
		}
	});
	function getClientes(){
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
				$.each(result, function(key,value){
					$("#data_cliente").append(new Option(value.nombre, value.id_cliente, true, true));
				});
				$("#data_cliente").val('cate');
			}
		});
	}
	//CALENDARIOS
	$("#data_expiracion_picker").datetimepicker({
      language: 'en',
      pick12HourFormat: true,
      pickDate: true,            // disables the date picker
  	  pickTime: true,
    });
    $("#data_tiempofinal_picker").datetimepicker({
      language: 'en',
      pick12HourFormat: true,
      pickDate: true,            // disables the date picker
  	  pickTime: true,
    });
    $(".data_picker").datetimepicker({
      language: 'en',
      pick12HourFormat: true,
      pickDate: true,            // disables the date picker
  	  pickTime: true,
    });
    //MANEJAMOS EL EVENTO DE EDICION
    $("#modal-edit-btn").on('click',function(){
		$.ajax({
			url: "controller/ajax/handler.php",
			type: "POST",
			data: {
				lib: "productos",
				method: "modProduct",
				data: JSON.stringify(
				{
					id_item: $("#data_id").val(),
					datas: {
						category_id: $("#data_categoria").val(),
						nombre: $("#data_name").val(),
						descripcion_small: $("#data_descripcion_small").val(),
						descripcion: $("#data_descripcion").val(),
						precio_real: $("#data_precio_real").val(),
						precio_descuento: $("#data_precio_descuento").val(),
						precio_delivery: $("#data_precio_delivery").val(),
						cantidad_total: $("#data_amount").val(),
						tiempoFinal: $("#data_tiempofinal").val(),
						expiracion: $("#data_expiracion").val(),
						reglas: $("#data_reglas").val(),
						condiciones: $("#data_condiciones").val(),
						where: $("#data_where").val(),
						id_cliente: $("#data_cliente").val()
					}
				})
			},
			success: function(resultado){
				var result = JSON.parse(resultado);
				if(result.status == 1){
					loadProduct();
					$("#edit-product").modal('hide');
				}
				else{
					alert("Existio un error: "+resultado);
				}
			}
		});
    });
	//MANEJAMOS EL EVENTO DE AGREGAR PRODUCTO
	$("#addProduct").on('click', function(){
		$.ajax({
				url: "controller/ajax/handler.php",
				type: "POST",
				data: {
					lib: "productos",
					method: "addProduct",
					data: JSON.stringify({
					})
				},
				success: function(resultado){
					var result = JSON.parse(resultado);
					if(result.status != 1){
						$("#confirm-modal .modal-confirm-title").html('Fracaso agregar producto');
						$("#confirm-modal .modal-message").html("Ha fallado agregar un producto. Contacte con el administrador.");
						$("#confirm-modal .confirm-footer").html('<button type="button" id="modal-confirm-close" class="btn btn-danger" data-dismiss="modal">Cancelar</button>');
						$("#confirm-modal").modal('toggle');
					}
					else{
						$("#data_id").val(result.id);
						$("#modal-edit-close").hide();
						$("#modal-add-close").unbind().show().on('click', function(){
							$.ajax({
								url: "controller/ajax/handler.php",
								type: "POST",
								data: {
									lib: "productos",
									method: "delProduct",
									data: JSON.stringify({
										id:$("#data_id").val()
									})
								},
								success: function(resultado){

								}
							});
						});
						var imga = new $.images_product({
							core: $("#images_product_edit")
						});
						$("#edit-product").modal('toggle');
					}
				}
			});
		
	});
	// ARCHIVOS UP
	var date = new Date().getTime();
	getClientes();
	
});