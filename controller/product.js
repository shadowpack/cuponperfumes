$(document).ready(function(){ 
	var slider = new $.slider({
		object: $('.product_slider'),
		images: $('.product_slider_images'),
		img: '.product_slider_obj',
		prev: $('.btn_prev_product'),
		next:$('.btn_next_product')
	});
	setInterval(function(){
		var d = new Date();
		var time = parseInt($(".timehidden").html())-(d.getTime()/1000);
		$(".timevalue").html(Math.floor(time/3600)+"h:"+Math.floor((time%3600)/60)+"m:"+Math.floor((time%3600)%60)+"s");
	},500);
	$("#description_btn").click(function(){
		$(".tabs_content").each(function(){
			$(this).fadeOut();
		});
		$("#description").fadeIn();
	});
	$("#conditions_btn").click(function(){
		$(".tabs_content").each(function(){
			$(this).fadeOut();
		});
		$("#conditions").fadeIn();
	});
	$(".btnSell").click(function(){
		$.ajax({
			url:"model/conection.php",
			type:"POST",
			success:function(resultado){
				if(resultado=="false"){
					$("#logForm").modal('toggle');
				}
				else
				{
					$.ajax({
						url:"controller/compraProcess.php",
						type: "POST",
						data: {
							action: 0,
							id: $(".btnSell").attr("np")
						},
						success: function(resultado){
							if(resultado == "true")
							{
								location.href="checkout.php"
							}
						}
					});					
				}
			}
		});
	});
});