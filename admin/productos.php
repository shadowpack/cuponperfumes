<?php include("model/connection_alive.php"); ?>
<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Panel de Administración - CuponPerfumes</title>
     <!-- JavaScript -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <link href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet">
    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap-slider.js"></script>
    <script src="uploadify/jquery.uploadify.js"></script>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/icon-bootstrap.css" rel="stylesheet">
    <link href="uploadify/uploadify.css" rel="stylesheet">
    <!-- Add custom CSS here -->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link href="css/slider.css" rel="stylesheet">
    <link href="css/product.css" rel="stylesheet">
    <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <!-- Page Specific CSS -->
    <link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css">
  </head>

  <body>

    <div id="wrapper">

      <!-- INCLUIMOS LA CABECERA -->
      <?php include("view/head.php"); ?>

      <!-- INCLUIMOS EL RESUMEN -->
      <?php include("view/productos.php"); ?>

    </div><!-- /#wrapper -->

   

    <!-- Page Specific Plugins -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>
    
    <script src="js/tablesorter/jquery.tablesorter.js"></script>
    <script src="js/tablesorter/tables.js"></script>
    <script src="controller/images_product.js"></script>
    <?php $timestamp = time();?>
    <script>
    $(function() {
      $('#file_upload').uploadify({
        'buttonText': "AGREGAR IMAGEN",
        'formData'     : {
          'timestamp' : '<?php echo $timestamp;?>',
          'token'     : '<?php echo md5('unique_salt' . $timestamp);?>',
          'product' : $("#data_id").val()
        },
        'swf'      : 'uploadify/uploadify.swf',
        'uploader' : 'uploadify/uploadify.php',
        'onUploadSuccess' : function(file, data, response) {
            var result = JSON.parse(data);
            var images = $("#images_product_edit").data('images_product');
            result.source = result.src;
            images.publics.add_images(result);
        },
        'onSelect' : function(file) {
            $("#file_upload").uploadify("settings", 'formData', {
            'timestamp' : '<?php echo $timestamp;?>',
            'token'     : '<?php echo md5('unique_salt' . $timestamp);?>',
            'product' : $("#data_id").val()
          });
        }
      });
      $('#file_upload_category').uploadify({
        'buttonText': "AGREGAR IMAGEN",
        'formData'     : {
          'timestamp' : '<?php echo $timestamp;?>',
          'token'     : '<?php echo md5('unique_salt' . $timestamp);?>',
          'product' : $("#data_id_category").val()
        },
        'swf'      : 'uploadify/uploadify.swf',
        'uploader' : 'uploadify/uploadify_category.php',
        'onUploadSuccess' : function(file, data, response) {
            var result = JSON.parse(data);
            var images = $(".images_slider_category").data('images_product');
            result.source = result.src;
            var image = {
              source: result.source,
              id_item: result.id_category,
              portrait: false,
              id_image: null,
              size: 400,
              minisize:70
            }
            images.publics.clear();
            images.publics.add_images(image);
        },
        'onSelect' : function(file) {
            $("#file_upload_category").uploadify("settings", 'formData', {
            'timestamp' : '<?php echo $timestamp;?>',
            'token'     : '<?php echo md5('unique_salt' . $timestamp);?>',
            'product' : $("#data_id_category").val()
          });
        }
      });
    });
    </script>
  </body>
</html>
