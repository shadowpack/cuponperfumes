$.slider = function(opt){
	var settings = {
		object:null,
		images: null,
		img: null,
		prev:null,
		next:null,
		index:0,
		total:0
	};	
	var slider = function(opt){
		settings = $.extend({},settings,opt);
		settings.total = settings.images.find(settings.img).size();
		settings.prev.unbind();
		settings.next.unbind();
		settings.prev.click(function(e){
			if((settings.index-1) < 0)
			{
				$(settings.images.find(settings.img)[settings.index]).fadeOut(500,function(){
					$.each(settings.images.children('.product_slider_obj'), function(key2,value2){
						$(value2).hide();
					});
					$(settings.images.find(settings.img)[settings.total-1]).fadeIn(500);
					settings.index = settings.total-1;
				});
			}
			else
			{
				$(settings.images.find(settings.img)[settings.index]).fadeOut(500,function(){
					$.each(settings.images.children('.product_slider_obj'), function(key2,value2){
						$(value2).hide();
					});
					$(settings.images.find(settings.img)[settings.index-1]).fadeIn(500);
					settings.index--;
				});
			}
			
		});
		settings.next.click(function(){
			if((settings.index+1) == settings.images.find(settings.img).size())
			{
				$(settings.images.find(settings.img)[settings.index]).fadeOut(500,function(){
					$.each(settings.images.children('.product_slider_obj'), function(key2,value2){
						$(value2).hide();
					});
					$(settings.images.find(settings.img)[0]).fadeIn(500);
					settings.index = 0;
				});
			}
			else
			{
				$(settings.images.find(settings.img)[settings.index]).fadeOut(500,function(){
					$.each(settings.images.children('.product_slider_obj'), function(key2,value2){
						$(value2).hide();
					});
					$(settings.images.find(settings.img)[settings.index+1]).fadeIn(500);
					settings.index++;
				});
			}
		});
		$.each(settings.images.children('.product_slider_obj'), function(key2,value2){
			$(value2).hide();
		});
		$(settings.images.find(settings.img)[0]).fadeIn(500);
		// settings.object.mouseenter(function(){
		// 	settings.prev.show();
		// 	settings.next.show();
		// }).mouseleave(function(){
		// 	settings.prev.hide();
		// 	settings.next.hide();
		// });

	};
	this.change = function(opt){
		$.each(settings.images.children('.product_slider_obj'), function(key,value){
			if($(value).children('img').attr('image-value') == opt.obj){
				$(settings.images.find(settings.img)[settings.index]).fadeOut(500,function(){
					$.each(settings.images.children('.product_slider_obj'), function(key2,value2){
						$(value2).hide();
					});
					var obj = $(settings.images.find(settings.img)[key]);
					obj.fadeIn(500);
					settings.index = key;
				});
			}
		})
	}
	this.upgrade = function(){
		settings.index++;
	}
	this.setFirst = function(){
		
	}
	slider(opt);
}