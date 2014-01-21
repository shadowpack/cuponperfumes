$(document).ready(function(){ 
	var slider = new $.slider3({
		object: $('.imagesSlider3'),
		images: $('.imagesMov'),
		img: '.imageItem',
		prev: $('.btn_prev'),
		next:$('.btn_next')
	});
	$(".imagelider").click(function(){
		var num = $(".listCategory"+$(this).attr('numCat')).offset().top;
		$(document).scrollTop(num);
	});
	// PARTE DONDE ESCODEMOS EL JUMBOTRON
	$("#destacados").click(function(){
		$(document).scrollTop(0);
		if($(".sliderscat").attr("active") == "true"){
			$(".sliderscat").fadeOut();
			$(".sliderscat").attr("active",false);
			$(this).parent().addClass("noactive");
			
		}
		else{
			$(".sliderscat").fadeIn();
			$(".sliderscat").attr("active",true);
			$(this).parent().removeClass("noactive");
		}
	});
	$("#belleza").click(function(){
		var num = $("#bellezatab").offset().top;
		$(document).scrollTop(num-20);
	});
	
});