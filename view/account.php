<?php
	include('capaControlador/accountControler.php');
	$cupones = new account();
?>
<link rel="stylesheet" type="text/css" media="all" href="css/account.css"> 
<div class="row account">
	<div class="col12 accountAll">
		<div class="accountChar">
			
			<div class="headerbtn">
				<div class="btn" id="cupones">Mis Cupones</div>
				<div class="btn" id="changepass">Cambiar Contraseña</div>
			</div>
			<div class="tab-cupones tabsA">
				<div class="botonUp"><img src="img/1downarrow.png" /></div>
				<div class="botonDown"><img src="img/1downarrow1.png" /></div>
				<div class="productAccount" num="<?php echo $cupones->getNumCupones(); ?>" numA="5">
					<?php echo $cupones->getCupones(); ?>
				</div>
			</div>
			<div class="tab-changepass tabsA">
				<div class="lineDataUp"></div>
				<div class="lineData">Realiza un cambio de tu contraseña de acceso. Se recomienda efectuar cada cierto tiempo</div>
				<div class="lineData"><input class="inputText" id="oldpass" placeholder="Contraseña Actual"/></div>
				<div class="lineData"><input class="inputText" id="newpass" placeholder="Nueva Contraseña"/></div>
				<div class="lineData"><input class="inputText" id="repeatnewpass" placeholder="Repite Nueva Contraseña"/></div>
				<div class="lineMessage"></div>
				<div class="lineProduct"><div class="butonChange">Cambiar Contraseña</div></div>
				
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	if(getUrlVars()["section"] == "password"){
		$(".tabsA").each(function(key,value){
			$(value).hide();
		});
		$(".tab-changepass").show();
	}
	else
	{
		$(".tabsA").each(function(key,value){
			$(value).hide();
		});
		$(".tab-cupones").show();
	};
	function getUrlVars() {
		var vars = {};
		var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
			vars[key] = value;
		});
		return vars;
	};
	$.fn.pop = function() {
	    var top = this.get(-1);
	    this.splice(this.length-1,1);
	    return top;
	};

	$.fn.shift = function() {
	    var bottom = this.get(0);
	    this.splice(0,1);
	    return bottom;
	};
	$('#cupones').click(function(){
		$(".tabsA").each(function(key,value){
			$(value).hide();
		});
		$(".tab-cupones").show();
	});
	$('#changepass').click(function(){
		$(".tabsA").each(function(key,value){
			$(value).hide();
		});
		$(".tab-changepass").show();
	});
	$('.botonUp').click(function(){
			if(parseInt($('.productAccount').attr('numA')) > 5)
			{
				var element = $('.productAccount').find('.lineProduct').shift();
				$(element).detach();
				$(element).appendTo($('.productAccount'));
				$('.productAccount').attr('numA', (parseInt($('.productAccount').attr('numA')) - 1));
			}
	}); 
	$('.botonDown').click(function(){
			if(parseInt($('.productAccount').attr('numA')) < parseInt($('.productAccount').attr('num')))
			{
				var element = $('.productAccount').find('.lineProduct').pop();
				$(element).detach();
				$(element).prependTo($('.productAccount'));
				$('.productAccount').attr('numA',(parseInt($('.productAccount').attr('numA')) + 1));
			}
	});  
	$('.butonChange').click(function(){
		if($("#oldpass").val() != "" && $("#newpass").val() != "" && $("#repeatnewpass").val() != "")
		{
			$.ajax({
				url: "capaAjax/changePassword.php",
				type: "POST",
				data:{
					password: $("#oldpass").val(),
					newpassword: $("#newpass").val()
				},
				success: function(resultado){
					if(resultado == "true")
					{
						$(".lineMessage").html("La contraseña fue cambiada con Exito.").show();
					}
					else if(resultado == "ErrorPassword")
					{
						$(".lineMessage").html("La contraseña ingresada no es valida, por favor intente otra vez").show();
					}
				}
			});
		}
		else
		{
			$(".lineMessage").html("Debe completar todos los campos antes de continuar.").show();
		}
	});                       
});
</script>