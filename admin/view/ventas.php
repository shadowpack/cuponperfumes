<?php
if(!class_exists('db_core'))
{
  require_once('db_core.php');
}
$db = new db_core();
$consulta[0] = $db->db_query("SELECT productos.nombre,  users.nombre, cupones.fecha_compra, IF(transacciones.delivery=1,'Si','No'), users.location, users.comuna, users.city, cupones.codigo_cupon, users.direccion_original FROM cupones INNER JOIN transacciones ON cupones.id_transaccion = transacciones.id_transaccion INNER JOIN productos ON transacciones.id_producto = productos.id_item INNER JOIN users ON transacciones.id_user = users.id_user WHERE cupones.estado='0'");
$usuarios = $db->reg_one("SELECT COUNT(*) FROM users");
?>

<script src="controller/ventas.js"></script>
<div id="page-wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h1>Ventas</small></h1>
            <ol class="breadcrumb">
              <li class="active"><i class="fa fa-dashboard"></i> Resumen</li>
            </ol>
          </div>
        </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-5">
            <div class="panel panel-info">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-3">
                    <i class="fa fa-money fa-5x"></i>
                  </div>
                  <div class="col-xs-9 text-right">
                    <p class="announcement-heading"><h2 style="text-align:left;">Quemar Cupon</h2></p>
                    <p class="announcement-text"><br><input type="text" class="form-control" id="burncupon" /><br><button type="button" id="quemarboton" class="btn btn-success">Quemar Cupon <span class="fa fa-barcode"></span></button></p>
                  </div>
                </div>
              </div>
              <a href="#">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-6">
                    </div>
                    <div class="col-xs-6 text-right">
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div><!-- /.row -->
        <div class="row">
          <div class="col-lg-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-money"></i> Recent Transactions</h3>
              </div>
              <div class="panel-body">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover table-striped tablesorter">
                    <thead>
                      <tr>
                        <th width="200">Producto</td>
                        <th width="200">Nombre</td>
                        <th width="200">Fecha de Compra</td>
                        <th width="100">Delivery</td>
                        <th width="400">Direccion</td>
                        <th width="300">Direccion Original</td>
                        <th width="150">Codigo Cupon</td>
                      </tr>
                    </thead>
                    <tbody id="itemVentas">
                      <?php
                        while($consulta[1] = mysql_fetch_array($consulta[0]))
                        {
                          echo "<tr class='selectedCupon' codigo='".$consulta[1][7]."'>
                          <td>".$consulta[1][0]."</td>
                          <td>".$consulta[1][1]."</td>
                          <td>".date("d-m-Y h:i:s",$consulta[1][2])."</td>
                          <td>".$consulta[1][3]."</td>
                          <td>".$consulta[1][4].", ".$consulta[1][5].", ".$consulta[1][6]."</td>
                          <td>".$consulta[1][8].", ".$consulta[1][5].", ".$consulta[1][6]."</td>
                          <td>".$consulta[1][7]."</td>
                          </tr>";
                        }
                      ?>
                    </tbody>
                  </table>
                </div>
                <div class="text-right">
                </div>
              </div>
            </div>
          </div>
        </div><!-- /.row -->

      </div><!-- /#page-wrapper -->