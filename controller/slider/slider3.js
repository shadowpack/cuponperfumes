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
$.slider3 = function(opt){
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
		settings.prev.click(function(){
			for(i=0; i<3; i++)
			{
				var element = settings.images.find(settings.img).shift();
				$(element).detach();
				$(element).appendTo(settings.images);
			}
		});
		settings.next.click(function(){
			for(i=0; i<3; i++)
			{
				var element = settings.images.find(settings.img).pop();
				$(element).detach();
				$(element).prependTo(settings.images);
			}
		});
		// settings.object.mouseenter(function(){
		// 	settings.prev.show();
		// 	settings.next.show();
		// }).mouseleave(function(){
		// 	settings.prev.hide();
		// 	settings.next.hide();
		// });

	};
	slider(opt);
}