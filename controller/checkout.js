$(document).ready(function(){
	// FUNCIONES DE AGREGAR PRODUCTOS
	$(".amountUp").click(function(){
		$.ajax({
			url: "controller/compraProcess.php",
			type: "POST",
			data: { 
				action:1
			},
			success: function(resultado){
				var result = JSON.parse(resultado);
				if(result.status)
				{
					$(".amountNumber").html(parseInt($(".amountNumber").html())+1);
					$(".totalValor").html(num_format(parseInt($(".precioDes").html().replace('.',''))*parseInt($(".amountNumber").html())));
					if($('.radioDelivery').val() == "true")
					{
						$('.pagoDespacho').html(num_format(parseInt($(".despachoUnita").html().replace('.',''))*parseInt($(".amountNumber").html())));
						$('.pagoTotal').html(num_format(result.total));
					}
					else
					{
						$('.pagoDespacho').html('0');
						$('.pagoTotal').html(num_format(result.total));
					}
				}
				else
				{
					alert("Existe un error al procesar la solicitud, Por favor contacte con el soporte tecnico");
				}
			}
		});
	});
	$(".amountDown").click(function(){
		if(parseInt($(".amountNumber").html()) > 1)
		{
			$.ajax({
				url: "controller/compraProcess.php",
				type: "POST",
				data: { 
					action:2
				},
				success: function(resultado){
					var result = JSON.parse(resultado);
					if(result.status)
					{
						$(".amountNumber").html(parseInt($(".amountNumber").html())-1);
						$(".totalValor").html(num_format(parseInt($(".precioDes").html().replace('.',''))*parseInt($(".amountNumber").html())));
						if($('.radioDelivery').val() == "true")
						{
							$('.pagoDespacho').html(num_format(parseInt($(".despachoUnita").html().replace('.',''))*parseInt($(".amountNumber").html())));
							$('.pagoTotal').html(num_format(result.total));
						}
						else
						{
							$('.pagoDespacho').html('0');
							$('.pagoTotal').html(num_format(result.total));
						}
					}
					else
					{
						alert("Existe un error al procesar la solicitud, Por favor contacte con el soporte tecnico");
					}
				}
			});
		}
	});
	$("#Delivery").click(function(){
		$(".direccionDelivery").removeAttr('disabled');
		$.ajax({
			url: "controller/compraProcess.php",
			type: "POST",
			data: {
				action:3,
				delivery: true
			},
			success: function(resultado){
				var result = JSON.parse(resultado);
				if(result.status)
				{
					$('.pagoDespacho').html(num_format(parseInt($(".despachoUnita").html().replace('.',''))*parseInt($(".amountNumber").html())));
					$('.radioDelivery').val("true");
					$('.pagoTotal').html(num_format(result.total));
				}
				else
				{
					alert("Existe un error al procesar la solicitud, Por favor contacte con el soporte tecnico");
				}
			}
		});
	});
	$("#NoDelivery").click(function(){
		$(".direccionDelivery").attr('disabled','disabled');
		$.ajax({
			url: "controller/compraProcess.php",
			type: "POST",
			data: { 
				action:3,
				delivery: false
			},
			success: function(resultado){
				var result = JSON.parse(resultado);
				if(result.status)
				{
					$('.pagoDespacho').html('0');
					$('.radioDelivery').val("false");
					$('.pagoTotal').html(num_format(result.total));
				}
				else
				{
					alert("Existe un error al procesar la solicitud, Por favor contacte con el soporte tecnico");
				}
			}
		});
	});
	$(".webpayCreditoImg").click(function(){
		$.ajax({
			url: "controller/processSell.php",
			type: "POST",
			data:{
				delivery: ($('.radioDelivery').val() == "true")?true:false,
				location: $(".direccionDelivery").val(),
				medio: 0
			},
			success: function(resultado){
				var method = JSON.parse(resultado);
				var form = $("<form></form>").attr({
					"name": "frm",
					"id": "payForm",
					"action":"cgi-bin/tbk_bp_pago.cgi",
					"method":"post" 
				}).appendTo($('body'));
				// Creamos los inputs para enviar el valor
				$('<input type="hidden" name="TBK_TIPO_TRANSACCION" value="TR_NORMAL"  />').appendTo(form);
				$('<input type="hidden" name="TBK_MONTO" value="'+method.monto+'" />').appendTo(form);
				$('<input type="hidden" name="TBK_ORDEN_COMPRA" value="'+method.id_transaccion+'" />').appendTo(form);
				$('<input type="hidden" name="TBK_ID_SESION" value="'+method.id_transaccion+'" />').appendTo(form);
				$('<input type="hidden" name="TBK_URL_EXITO" value="http://www.cuponperfumes.cl/SellSuccess.php" />').appendTo(form);
				$('<input type="hidden" name="TBK_URL_FRACASO" value="http://www.cuponperfumes.cl/SellFail.php" />').appendTo(form);
				//AÑADIMOS EL FORM AL BODY
				form.submit();
			}
		});
		
	});
	$(".webpayRedCompraImg").click(function(){
		$.ajax({
			url: "controller/processSell.php",
			type: "POST",
			data:{
				delivery: ($('.radioDelivery').val() == "true")?true:false,
				location: $(".direccionDelivery").val(),
				medio: 1
			},
			success: function(resultado){
				var method = JSON.parse(resultado);
				var form = $("<form></form>").attr({
					"name": "frm",
					"id": "payForm",
					"action":"cgi-bin/tbk_bp_pago.cgi",
					"method":"post" 
				}).appendTo($('body'));
				// Creamos los inputs para enviar el valor
				$('<input type="hidden" name="TBK_TIPO_TRANSACCION" value="TR_NORMAL"  />').appendTo(form);
				$('<input type="hidden" name="TBK_MONTO" value="'+method.monto+'" />').appendTo(form);
				$('<input type="hidden" name="TBK_ORDEN_COMPRA" value="'+method.id_transaccion+'" />').appendTo(form);
				$('<input type="hidden" name="TBK_ID_SESION" value="'+method.id_transaccion+'" />').appendTo(form);
				$('<input type="hidden" name="TBK_URL_EXITO" value="http://www.cuponperfumes.cl/SellSuccess.php?idT=" />').appendTo(form);
				$('<input type="hidden" name="TBK_URL_FRACASO" value="http://www.cuponperfumes.cl/SellFail.php" />').appendTo(form);
				//AÑADIMOS EL FORM AL BODY
				form.submit();
			}
		});
		
	});
	var num_format = function(num){
		var cadena = ""; var aux;  
		var cont = 1,m,k;  
		if(num<0) aux=1; else aux=0;  
		num=num.toString();  
		for(m=num.length-1; m>=0; m--){  
		 cadena = num.charAt(m) + cadena;  
		 if(cont%3 == 0 && m >aux)  cadena = "." + cadena; else cadena = cadena;  
		 if(cont== 3) cont = 1; else cont++;  
		}  
		cadena = cadena.replace(/.,/,",");  
		return cadena;
	}
});