$(document).ready(function(){ 
	$(".containerCat").click(function(){
		location.href="product.php?id="+$(this).attr("numproducto");
	});
	$(".slider-catalog").each(function(key,value){
		var slider = new $.slider3({
			object: $(value),
			images: $(value).children('.slider-catalog-images'),
			img: '.bigCatalog',
			prev: $(value).children('.btn_prev_catalog'),
			next:$(value).children('.btn_next_catalog')
		});
	});
});