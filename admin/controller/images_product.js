$(function() {
  $.images_product = function(data){
    var self = this;
    var settings = {

    };
    var defaults = {
      carrousel: null,
      slider: null,
      images: {},
      carrousel_imagen: {},
      core: null,
      menu: null,
      slider_plug: null,
      category:null
    };
    var methods = {
      constructor: function(opt){
        settings = $.extend({},defaults,opt);
        // CONSTRUIR LAS CAPAS VISUALES
        settings.core.empty();
        settings.slider = {
          core: $('<div class="product_slider_edit"></div>').appendTo(settings.core)
        }
        settings.slider = $.extend({},settings.slider,{
          cap: $('<div class="product_slider"></div>').appendTo(settings.slider.core)
        });
        settings.slider = $.extend({},settings.slider,{
          container: $('<div class="product_slider_images"></div>').appendTo(settings.slider.cap),
          btn_next: $('<div class="btn_prev_product"><img src="../controller/slider/img/btn_prev.png" /></div>').appendTo(settings.slider.cap),
          btn_prev: $('<div class="btn_next_product"><img src="../controller/slider/img/btn_next.png" /></div>').appendTo(settings.slider.cap)
        });
        settings.carrousel = {
          core: $('<div class="carrousel"></div>').appendTo(settings.core)
        }
        settings.carrousel = $.extend({},settings.carrousel,{
          container: $('<div class="carrousel_container"></div>').appendTo(settings.carrousel.core)
        });
        methods.make_contextual();
        methods.load_slider();
        self.publics.load_carrousel();
        methods.save_settings();
        // save_settings();
        // settings.upload = {
        //   core: $('<div class="uploadimagemod">').appendTo(settings.core),
        //   queue: $('<div id="queue"></div>').appendTo(settings.upload.core),
        //   file: $('<input id="file_upload" name="file_upload" type="file" multiple="true">').appendTo(settings.upload.core)
        // };

      },
      save_settings: function(){
        settings.core.data('images_product', self);
      },
      make_contextual: function(){
        $("#context-image").unbind();
        $("#context-image").remove();
        settings.menu = $('<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1" id="context-image"></ul>').appendTo(document.body);
        $('<li role="presentation" ><a id="portrait-image" role="menuitem" tabindex="-1" href="#">Portrait</a></li>').appendTo(settings.menu);
        $('<li role="presentation" ><a id="eliminar-image" role="menuitem" tabindex="-1" href="#">Eliminar</a></li>').appendTo(settings.menu);
      },
      load_slider: function(){
        settings.slider_plug = new $.slider({
          object: settings.slider.cap,
          images: settings.slider.container,
          img: '.product_slider_obj',
          prev: settings.slider.btn_next,
          next: settings.slider.btn_prev
        });
      }
    };
    this.publics = {
      refresh_menu: function(datas){
        methods.make_contextual();
        $.each(settings.images, function(key,value){
          value.on('contextmenu', function(e){
              var self = $(this);
              e.preventDefault();
            settings.menu.css({'display':'block', 'left':e.pageX, 'top':e.pageY, "z-index":5000});
            //ACCIONES DEL MENU CONTEXT
            $(document).click(function(e){
              if(e.button == 0){
                settings.menu.css("display", "none");
              }
            }).keydown(function(e){
              if(e.keyCode == 27){
                settings.menu.css("display", "none");
              }
            });
            //LIMPIAMOS LOS EVENTO DEL MENU
            settings.menu.unbind();
            //AGREGAMOS LOS NUEVOS EVENTOS
            if(!datas.portrait){
              $("#portrait-image").parent().hide();
            }
            settings.menu.click(function(e){
              // El switch utiliza los IDs de los <li> del menú
              switch(e.target.id){
                case "portrait-image":
                  $.ajax({
                    url: "controller/ajax/handler.php",
                    type: "POST",
                    data: {
                      lib: "productos",
                      method: "setPortrait",
                      data: JSON.stringify({
                        id_item: self.children('img').attr('id-product'),
                        src: self.children('img').attr('src').substring(3)
                      })
                    },
                    success: function(resultado){
                      var result = JSON.parse(resultado);
                      if(result.status == 1)
                      {
                        $(".portrait").each(function(key,value){
                          $(this).remove();
                        });
                        self.append('<div class="portrait"><img src="images/portrait.png"/ width="300"></div>');
                      }
                      else
                      {
                        alert("Existio un error al intentar setear la imagen a portrait. Contacte con el administrador...");
                      }
                    }
                  });
                  break;
                case "eliminar-image":
                  if(settings.category){
                    $.ajax({
                      url: "controller/ajax/handler.php",
                      type: "POST",
                      data: {
                        lib: "productos",
                        method: "deleteImageCategory",
                        data: JSON.stringify({
                          id_item: self.children('img').attr('id-product'),
                          src: self.children('img').attr('src').substring(3),
                          id_image: self.children('img').attr('id-image')
                        })
                      },
                      success: function(resultado){
                        var result = JSON.parse(resultado);
                        if(result.status == 1)
                        {
                          var direction =  self.children('img').attr('src');
                          var par = self.parent();
                          self.fadeOut(500, function(){
                            self.remove();
                            methods.load_slider();
                            par.first().fadeIn(500);
                            $.each(settings.carrousel.container.children(), function(key,value){
                              if($(value).children('img').attr('src') == direction){
                                $(value).fadeOut(500, function(){
                                  value.remove();
                                    $(value).unbind();
                                    $(value).on('click',function(){
                                      var image = $(this).children('img').attr('image-value');
                                      slider.change({
                                        obj: image
                                      });
                                    });
                                    settings.images.each(function(key2,value2){
                                      $(value2).hide();
                                    });
                                    $(settings.images.find(settings.img)[0]).fadeIn(500);
                                });
                              }
                            });
                          });
                        }
                        else if(result.status == 2){
                          alert("La imagen actualmente es un portrait. Por favor asigne otro portrait y proceda a eliminarla.")
                        }
                        else
                        {
                          alert("Existio un error al intentar borrar la imagen a portrait. Contacte con el administrador...");
                        }
                      }
                    });
                  }
                  else
                  {
                    $.ajax({
                      url: "controller/ajax/handler.php",
                      type: "POST",
                      data: {
                        lib: "productos",
                        method: "deleteImage",
                        data: JSON.stringify({
                          id_item: self.children('img').attr('id-product'),
                          src: self.children('img').attr('src').substring(3),
                          id_image: self.children('img').attr('id-image')
                        })
                      },
                      success: function(resultado){
                        var result = JSON.parse(resultado);
                        if(result.status == 1)
                        {
                          var direction =  self.children('img').attr('src');
                          var par = self.parent();
                          self.fadeOut(500, function(){
                            self.remove();
                            methods.load_slider();
                            par.first().fadeIn(500);
                            $.each(settings.carrousel.container.children(), function(key,value){
                              if($(value).children('img').attr('src') == direction){
                                $(value).fadeOut(500, function(){
                                  value.remove();
                                    $(value).unbind();
                                    $(value).on('click',function(){
                                      var image = $(this).children('img').attr('image-value');
                                      slider.change({
                                        obj: image
                                      });
                                    });
                                    settings.images.each(function(key2,value2){
                                      $(value2).hide();
                                    });
                                    $(settings.images.find(settings.img)[0]).fadeIn(500);
                                });
                              }
                            });
                          });
                        }
                        else if(result.status == 2){
                          alert("La imagen actualmente es un portrait. Por favor asigne otro portrait y proceda a eliminarla.")
                        }
                        else
                        {
                          alert("Existio un error al intentar borrar la imagen a portrait. Contacte con el administrador...");
                        }
                      }
                    });
                  }
                  break;
              }
            
            return false;
          });
          });
        });
      },
      load_carrousel: function(){
          settings.carrousel.container.unbind();
          $.each(settings.carrousel_imagen,function(key,value){
            value.unbind();
          });
          $.each(settings.carrousel_imagen,function(key,value){
            value.on('click',function(){
              var image = $(this).children('img').attr('image-value');
              slider.change({
                obj: image
              });
            });
          });
          var stop = 0;
          function movescrollright(){
            if(stop == 1){
              var scroll = settings.carrousel.core.scrollLeft();
              scroll += 3;
              settings.carrousel.core.animate({
                scrollLeft : scroll
              },20,function(){
                movescrollright();
                // stop--;
              });
            }
            else
            {
              return;
            }
          }
          function movescrollleft(){
            if(stop == 1){
              var scroll = settings.carrousel.core.scrollLeft();
              scroll -= 3;
              settings.carrousel.core.animate({
                scrollLeft : scroll
              },20,function(){
                movescrollleft();
                // stop--;
              });
            }
            else
            {
              return;
            }
          }
          settings.carrousel.container.on('mousemove', function(e){
            if(stop == 0){
              var left = e.pageX- settings.carrousel.core.offset().left;
              var top = e.pageY- settings.carrousel.core.offset().top;
              if(left > 300 && top > -2 && top < 80 && left < 340){
                stop = 1;
                $(document).mousemove(function(e){
                  var leftN = e.pageX- settings.carrousel.core.offset().left;
                  var topN = e.pageY- settings.carrousel.core.offset().top;
                  if(!(leftN > 300 && topN > -2 && topN < 80 && leftN < 340)){
                    stop = 0;
                    $(document).unbind("mousemove");
                  }
                });
                movescrollright();
              }
              if(left > 0 && top > -2 && top < 80 && left < 40){
                stop = 1;
                $(document).mousemove(function(e){
                  var leftN = e.pageX- settings.carrousel.core.offset().left;
                  var topN = e.pageY- settings.carrousel.core.offset().top;
                  if(!(leftN > 0 && topN > -2 && topN < 80 && leftN < 40)){
                    stop = 0;
                    $(document).unbind("mousemove");
                  }
                });
                movescrollleft();
              }
            }      
        });
      },
      add_images: function(image){
        if(typeof(image.size) == "undefined"){
          image.size = 300;
          image.minisize = 70;
        }
        if(image.portrait == 1){
          var img_slider = $('<div class="product_slider_obj"><img src="../'+image.source+'" width="'+image.size+'" image-value="../'+image.source+'" id-product="'+image.id_item+'" id-image="'+image.id_image+'"/><div class="portrait"><img src="images/portrait.png"/ width="300"></div></div>');
          settings.slider.container.append(img_slider);
        }
        else{
          var img_slider = $('<div class="product_slider_obj"><img src="../'+image.source+'" width="'+image.size+'" image-value="../'+image.source+'" id-product="'+image.id_item+'" id-image="'+image.id_image+'"/></div>');
          settings.slider.container.append(img_slider);
        }
        settings.carrousel.container.css({width: "+=88px"});
        var img_carrousel = $('<div class="carrousel_item"><img src="../'+image.source+'" width="'+image.minisize+'" image-value="../'+image.source+'"/></div>');
        settings.carrousel.container.append(img_carrousel);
        settings.carrousel_imagen[settings.carrousel_imagen.length] = img_carrousel;
        settings.images[settings.images.length] = img_slider;

        methods.load_slider();
        self.publics.load_carrousel();
        $.each(settings.carrousel_imagen,function(key,value){
          value.unbind();
        });
        $.each(settings.carrousel_imagen,function(key,value){
          value.on('click',function(){
            var image = $(this).children('img').attr('image-value');
            settings.slider_plug.change({
              obj: image
            });
          });
        });
        $.each(settings.images,function(key,value){
          value.unbind();
        });
        if(image.portrait == false){
          self.publics.refresh_menu(false);
        }
        else{
          self.publics.refresh_menu(true);
        }
           
        methods.save_settings();    
      },
      refresh: function(){
        self.publics.load_carrousel();
        methods.load_slider();
      },
      clear: function(){
         settings.slider.container.empty();
         settings.carrousel.container.empty();

      }
    }
    methods.constructor(data);
  }
});