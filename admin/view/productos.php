<?php
if(!class_exists('db_core'))
{
  require_once('db_core.php');
}
$db = new db_core();
$consulta[0] = $db->db_query("SELECT category.name AS categoria, productos.nombre, productos.descripcion_small, productos.precio_real, productos.precio_descuento, productos.precio_delivery, productos.tiempoFinal, productos.expiracion, productos.reglas, productos.condiciones FROM productos INNER JOIN category ON category.id_category = productos.category_id WHERE tiempoFinal <= NOW()");
$consultaOld[0] = $db->db_query("SELECT category.name AS categoria, productos.nombre, productos.descripcion_small, productos.precio_real, productos.precio_descuento, productos.precio_delivery, productos.tiempoFinal, productos.expiracion, productos.reglas, productos.condiciones FROM productos INNER JOIN category ON category.id_category = productos.category_id WHERE tiempoFinal >= NOW()");
$usuarios = $db->reg_one("SELECT COUNT(*) FROM users");
?>
<script src="../controller/slider/slider.js"></script>
<link rel="stylesheet" href="../controller/slider/slider.css">
<script src="controller/productos.js"></script>
<script src="js/bootstrap-datetimepicker.min.js"></script>
<script src="controller/jquery.ajaxupload.js"></script>

<div id="page-wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h1>Productos <small>Crear y Modificar</small></h1>
            <ol class="breadcrumb">
              <li class="active"><i class="fa fa-dashboard"></i> Productos</li>
            </ol>
            
          </div>
        </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-12">
              <!-- Nav tabs -->
              <ul class="nav nav-tabs">
                <li class="active"><a href="#home" data-toggle="tab">Lista Productos</a></li>
                <li><a href="#clonar" data-toggle="tab">Clonar Producto y Ver Caducos</a></li>
                <li><a href="#categorias" data-toggle="tab">Gestionador de Categorias</a></li>
              </ul>

              <!-- Tab panes -->
              <div class="tab-content">
                <div class="tab-pane active" id="home">
                    <br>
                    <div class="col-lg-12">
                      <div class="panel panel-primary">
                        <div class="panel-heading">
                          <div class="panel-title text-right">
                            <a href="#" id="addProduct" style="color:#FFF;">Agregar Producto &nbsp;<i class="fa fa-plus fa-lg"></i></a>
                          </div>
                          <h3 class="panel-title"><i class="fa fa-suitcase"></i> Productos Activos</h3>

                        </div>
                        <div class="panel-body">
                          <div class="table-responsive">
                            <div id="waiting">
                              <center><img src="images/484.gif" /></center>
                            </div>
                            <table class="table table-bordered table-hover table-striped tablesorter" id="tablaProductos" style="display:none;">
                              <thead>
                                <tr>
                                  <th width="150">Categoria</td>
                                  <th width="200">Producto</td>
                                  <th width="200">Descripción Small</td>
                                  <th width="100">Precio Real</td>
                                  <th width="100">Precio Descuento</td>
                                  <th width="100">Precio Delivery</td>
                                  <th width="150">Tiempo Publicacion</td>
                                  <th width="150">Tiempo Expiración</td>
                                  <th width="50">Reglas</td>
                                  <th width="50">Condiciones</td>
                                  <th width="50">Donde</td>
                                  <th width="50">Editar</td>
                                  <th width="70">Activo</td>
                                </tr>
                              </thead>
                              <tbody id="productos">
                              </tbody>
                            </table>
                          </div>
                          <div class="text-right">
                            <a href="#" id="addProduct">Agregar Producto &nbsp;<i class="fa fa-plus fa-lg"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>

                </div>
                <div class="tab-pane" id="clonar">
                    <br>
                    <div class="col-lg-12">
                      <div class="panel panel-primary">
                        <div class="panel-heading">
                          <h3 class="panel-title"><i class="fa fa-suitcase"></i> Productos Caducados</h3>
                        </div>
                        <div class="panel-body">
                          <div class="table-responsive">
                            <div id="waitingOld">
                              <center><img src="images/484.gif" /></center>
                            </div>
                            <table class="table table-bordered table-hover table-striped tablesorter" id="tablaProductosOld" style="display:none;">
                              <thead>
                                <tr>
                                  <th width="150">Categoria</td>
                                  <th width="200">Producto</td>
                                  <th width="200">Descripción Small</td>
                                  <th width="100">Precio Real</td>
                                  <th width="100">Precio Descuento</td>
                                  <th width="100">Precio Delivery</td>
                                  <th width="150">Tiempo Publicacion</td>
                                  <th width="150">Tiempo Expiración</td>
                                  <th width="50">Reglas</td>
                                  <th width="50">Condiciones</td>
                                  <th width="50">Donde</td>
                                  <th width="70">Clonar</td>
                                </tr>
                              </thead>
                              <tbody id="productosOld">
                              </tbody>
                            </table>
                          </div>
                          <div class="text-right">
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="tab-pane" id="categorias">
                <br>
                  <div class="panel panel-primary">
                      <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-suitcase"></i> Categorias Activas</h3>
                        <div class="text-right">
                          <a href="#" id="addProduct">Agregar Producto &nbsp;<i class="fa fa-plus fa-lg"></i></a>
                        </div>
                      </div>
                      <div class="panel-body">
                        <div class="table-responsive">
                          <div id="waitingCat">
                            <center><img src="images/484.gif" /></center>
                          </div>
                          <table class="table table-bordered table-hover table-striped tablesorter" id="tablaCategorias" style="display:none;">
                            <thead>
                              <tr>
                                <th width="300">Nombre</td>
                                <th width="200">Cantidad Productos</td>
                                <th width="200">Posicion</td>
                                <th width="100">Editar</td>
                                <th width="100">Estado</td>
                              </tr>
                            </thead>
                            <tbody id="data-categorias">
                            </tbody>
                          </table>
                        </div>
                        <div class="text-right">
                          <a href="#" id="addCategory">Agregar Categoria &nbsp;<i class="fa fa-plus fa-lg"></i></a>
                        </div>
                      </div>
                    </div>
                </div>
              </div>
          </div>
        </div><!-- /.row -->

      </div><!-- /#page-wrapper -->

  <!-- EDITAR PRODUCTO - Modal -->
  <div class="modal fade" id="edit-product" tabindex="10" role="modal" aria-labelledby="edit-product" aria-hidden="true">
    <div class="modal-dialog edit-content">
      <div class="modal-content ">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Modificar Producto</h4>
        </div>
        <div class="modal-body edit-product-message">
            <div class="col-lg-8">
            <input type="hidden" id="data_id">
            <div class="input-group">
              <span class="input-group-addon">Categoria</span>
              <select class="form-control" id="data_categoria">
                <option value="cate">Categoria</option>
              </select>
            </div>
            <br>
            <div class="input-group">
              <span class="input-group-addon">Proveedor</span>
              <select class="form-control" id="data_cliente">
                <option value="cate">Seleccionar Proveedor</option>
              </select>
            </div>
            <br>
            <div class="input-group">
              <span class="input-group-addon">Nombre</span>
              <input type="text" class="form-control" placeholder="Nombre" id="data_name">
            </div>  
            <br>
            <div class="input-group">
              <span class="input-group-addon">Micro Descripcion</span>
              <textarea class="form-control" rows="3" id="data_descripcion_small"></textarea>
            </div> 
            <br>
            <div class="input-group">
              <span class="input-group-addon">Descripcion</span>
              <textarea class="form-control" rows="4" id="data_descripcion"></textarea>
            </div>
            <br>
            <div class="input-group">
              <span class="input-group-addon">Precio Real</span>
              <input type="text" class="form-control" placeholder="Precio Real" id="data_precio_real">
            </div>  
            <br>
            <div class="input-group">
              <span class="input-group-addon">Precio Desc.</span>
              <input type="text" class="form-control" placeholder="Precio Descuento" id="data_precio_descuento">
            </div>  
            <br>
            <div class="input-group">
              <span class="input-group-addon">Precio Delivery</span>
              <input type="text" class="form-control" placeholder="Precio Delivery" id="data_precio_delivery">
            </div>
            <br>
            <div class="input-group">
              <span class="input-group-addon">Cantidad</span>
              <input type="text" class="form-control" placeholder="Cantidad" id="data_amount">
            </div>
            <br>
             <div id="data_tiempofinal_picker" class="input-append date input-group">
              <span class="input-group-addon">Tiempo Publicacion</span>
              <input data-format="dd/MM/yyyy hh:mm:ss"  type="text" class="form-control" id="data_tiempofinal">
              <span class="input-group-addon add-on">
                <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                </i>
              </span>
            </div>
            <br>
            <div id="data_expiracion_picker" class="input-append date input-group">
              <span class="input-group-addon">Tiempo Expiracion Cupon</span>
              <input data-format="dd/MM/yyyy hh:mm:ss" type="text" class="form-control" id="data_expiracion">
              <span class="input-group-addon add-on">
                <i class="icon-calendar" data-time-icon="icon-time" data-date-icon="icon-calendar">
                </i>
              </span>
            </div>  
            <br>
            <div class="input-group">
              <span class="input-group-addon">Reglas</span>
              <textarea class="form-control" rows="3" id="data_reglas"></textarea>
            </div> 
            <br>
            <div class="input-group">
              <span class="input-group-addon">Condiciones</span>
              <textarea class="form-control" rows="3" id="data_condiciones"></textarea>
            </div> 
            <br>  
            </div>
            <div class="col-lg-4">
              <h4 class="modal-title">&nbsp;Imagenes</h4>
              <br>
              <div id="images_product_edit">
                
              </div>
              <div class="uploadimagemod">
                <div id="queue"></div>
               <input id="file_upload" name="file_upload" type="file" multiple="true">
              </div>
          </div>

            
        </div>
        <div class="modal-footer">
          <button type="button" id="modal-edit-btn" class="btn btn-success">Confirmar</button>
          <button type="button" id="modal-add-close" class="btn btn-danger" style="display:none;" data-dismiss="modal">Cancelar</button>
          <button type="button" id="modal-edit-close" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <!-- CLONAR PRODUCTO - Modal -->
  <div class="modal fade" id="clonar-product" tabindex="5" role="modal" aria-labelledby="edit-product" aria-hidden="true">
    <div class="modal-dialog clonar-content">
      <div class="modal-content ">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title clonar-title">Clonar Producto</h4>
        </div>
        <div class="modal-body clonar-product-message">
            <input type="hidden" id="data_id">
             <div class="input-append date input-group data_picker">
              <input data-format="yyyy/MM/dd hh:mm:ss"  type="text" class="form-control" id="data_tiempofinal_clonar" placeholder="Fecha de Publicacion">
              <span class="input-group-addon add-on">
                <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                </i>
              </span>
            </div>
            <br>
            <div class="input-append date input-group data_picker">
              <input data-format="yyyy/MM/dd hh:mm:ss" type="text" class="form-control" id="data_expiracion_clonar" placeholder="Fecha de Expiración Cupon">
              <span class="input-group-addon add-on">
                <i class="icon-calendar" data-time-icon="icon-time" data-date-icon="icon-calendar">
                </i>
              </span>
            </div>  
        </div>
        <div class="modal-footer">
          <button type="button" id="modal-clonar-btn" class="btn btn-success">Confirmar</button>
          <button type="button" id="modal-clonar-close" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <!-- MODAL DE MENU -->
  <ul class="dropdown-menu  menu-contextual" role="menu" aria-labelledby="dropdownMenu1">
    <li role="presentation" ><a id="modificar" role="menuitem" tabindex="-1" href="#">Modificar</a></li>
    <li role="presentation" ><a id="activar" role="menuitem" tabindex="-1" href="#">Activar</a></li>
    <li role="presentation" ><a id="desactivar" role="menuitem" tabindex="-1" href="#">Desactivar</a></li>
    <li role="presentation" class="divider"></li>
    <li role="presentation" ><a id="eliminar" role="menuitem" tabindex="-1" href="#">Eliminar</a></li>
  </ul>
    <!-- MODAL DE MENU -->
  <!-- EDITAR CATEGORIA -->
  <div class="modal fade" id="edit-category" tabindex="10" role="modal" aria-labelledby="edit-product" aria-hidden="true">
    <div class="modal-dialog edit-category-content">
      <div class="modal-content ">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Editar Categoria</h4>
        </div>
        <div class="modal-body edit-category-message">
          <div class="row">
            <div class="col-lg-10 ">
              <br>
              <input type="hidden" id="data_id_category">
              <div class="input-group">
                <span class="input-group-addon">Nombre Categoria</span>
                <input type="text" class="form-control" placeholder="Nombre Categoria" id="add_name_category">
              </div> 
            </div>

            <div class="col-lg-10">
              <br>
              <div class="images_slider_category"></div>
              <br>
            </div>
            <div class="col-lg-9">
              <div class="uploadimagecategory">
                <div id="queue"></div>
               <input id="file_upload_category" name="file_upload_category" type="file" multiple="true">
              </div>
            </div>  
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" id="modal-category-mod-btn" class="btn btn-success">Confirmar</button>
          <button type="button" id="modal-category-add-close" class="btn btn-danger" data-dismiss="modal" style="display:none;">Cancelar</button>
          <button type="button" id="modal-category-mod-close" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  