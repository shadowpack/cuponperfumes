<script src="../controller/slider/slider.js"></script>
<link rel="stylesheet" href="../controller/slider/slider.css">
<script src="controller/clientes.js"></script>
<script src="js/bootstrap-datetimepicker.min.js"></script>
<script src="controller/jquery.ajaxupload.js"></script>
<div id="page-wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h1>Administrador <small>Proveedores</small></h1>
            <ol class="breadcrumb">
              <li class="active"><i class="fa fa-dashboard"></i> Proveedores Activos</li>
            </ol>
          </div>
        </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-12">
              <!-- Nav tabs -->
              <ul class="nav nav-tabs">
                <li class="active"><a href="#home" data-toggle="tab">Clientes</a></li>
                <li><a href="#acceso" data-toggle="tab">Asignar Accesos</a></li>
              </ul>

              <!-- Tab panes -->
              <div class="tab-content">
                <div class="tab-pane active" id="home">
                    <br>
                    <br>
                    <div class="col-lg-12">
                      <div class="panel panel-primary">
                        <div class="panel-heading">
                          <h3 class="panel-title"><i class="fa fa-suitcase"></i> Clientes</h3>
                        </div>
                        <div class="panel-body">
                          <div class="table-responsive">
                            <div id="waitingClientes">
                              <center><img src="images/484.gif" /></center>
                            </div>
                            <table class="table table-bordered table-hover table-striped tablesorter" id="tablaClientes" >
                              <thead>
                                <tr>
                                  <th width="250">Nombre</td>
                                  <th width="200">Direccion</td>
                                  <th width="200">Productos Activos</td>
                                  <th width="200">Productos Total</td>
                                  <th width="100">Ventas</td>
                                  <th width="200">Rut</td>
                                  <th width="200">Razon Social</td>
                                  <th width="200">Cuenta Bancaria</td>
                                  <th width="100">Editar</td>
                                  <th width="100">Activo</td>
                                </tr>
                              </thead>
                              <tbody id="clientesTab">
                              </tbody>
                            </table>
                          </div>
                          <div class="text-right">
                          <a href="#" id="addCliente">Agregar Cliente &nbsp;<i class="fa fa-plus fa-lg"></i></a>
                        </div>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="tab-pane" id="acceso">
                    <br>
                    <br>
                    <div class="col-lg-12">
                      <div class="panel panel-primary">
                        <div class="panel-heading">
                          <h3 class="panel-title"><i class="fa fa-suitcase"></i> Clientes</h3>
                        </div>
                        <div class="panel-body">
                          <div class="table-responsive">
                            <div id="waitingClientes">
                              <center><img src="images/484.gif" /></center>
                            </div>
                            <table class="table table-bordered table-hover table-striped tablesorter" id="tablaClientesPassword" style="display:none;">
                              <thead>
                                <tr>
                                  <th width="250">Nombre</td>
                                  <th width="250">Email</th>
                                  <th width="300">Password Asignado</th>
                                  <th width="100">Activo</td>
                                </tr>
                              </thead>
                              <tbody id="clientesPassword">
                              </tbody>
                            </table>
                          </div>
                          <div class="text-right">
                        </div>
                        </div>
                      </div>
                    </div>
                </div>
              </div>
          </div>
        </div><!-- /.row -->

      </div><!-- /#page-wrapper -->
      <!-- MODAL DE MENU -->
  <ul class="dropdown-menu  menu-contextual" role="menu" aria-labelledby="dropdownMenu1">
    <li role="presentation" ><a id="modificar" role="menuitem" tabindex="-1" href="#">Modificar</a></li>
    <li role="presentation" ><a id="activar" role="menuitem" tabindex="-1" href="#">Activar</a></li>
    <li role="presentation" ><a id="desactivar" role="menuitem" tabindex="-1" href="#">Desactivar</a></li>
    <li role="presentation" class="divider"></li>
    <li role="presentation" ><a id="eliminar" role="menuitem" tabindex="-1" href="#">Eliminar</a></li>
  </ul>
      <!-- CLIENTES MOD Y AGREGAR -->
      <div class="modal fade" id="edit-cliente" tabindex="10" role="modal" aria-labelledby="edit-product" aria-hidden="true">
    <div class="modal-dialog edit-content">
      <div class="modal-content ">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Editar Proveedor</h4>
        </div>
        <div class="modal-body edit-product-message">
            <div class="col-lg-8">
            <input type="hidden" id="data_id_cliente">
            <br>
            <div class="input-group">
              <span class="input-group-addon">Nombre</span>
              <input type="text" class="form-control" placeholder="Nombre" id="data_name_cliente">
            </div>  
            <br>
            <div class="input-group">
              <span class="input-group-addon">Direccion</span>
              <input type="text" class="form-control" placeholder="Dirección" id="data_direccion_cliente">
            </div> 
            <br>
            <div class="input-group">
              <span class="input-group-addon">Latitud</span>
              <input type="text" class="form-control" placeholder="Latitud" id="data_latitud_cliente">
            </div>
            <br>
            <div class="input-group">
              <span class="input-group-addon">Longitud</span>
              <input type="text" class="form-control" placeholder="Longitud" id="data_longitud_cliente">
            </div>  
            <br>
            <div class="input-group">
              <span class="input-group-addon">Cuenta Bancaria</span>
              <input type="text" class="form-control" placeholder="Cuenta Bancaria" id="data_cuenta_banco_cliente">
            </div>  
            <br>
            <div class="input-group">
              <span class="input-group-addon">Rut</span>
              <input type="text" class="form-control" placeholder="Rut" id="data_rut_cliente">
            </div>
            <br>
            <div class="input-group">
              <span class="input-group-addon">Razon Social</span>
              <input type="text" class="form-control" placeholder="Razon Social" id="data_razon_cliente">
            </div>
            <br>
            <div class="input-group">
              <span class="input-group-addon">Contacto Proveedor</span>
              <input type="text" class="form-control" placeholder="Contacto Proveedor" id="data_contacto_cliente"></textarea>
            </div>
            <br>
            <div class="input-group">
              <span class="input-group-addon">Telefono</span>
              <input type="text" class="form-control" placeholder="Telefono" id="data_telefono_cliente"></textarea>
            </div>
            <br>
            <div class="input-group">
              <span class="input-group-addon">Email</span>
              <input type="text" class="form-control" placeholder="Email" id="data_email_cliente"></textarea>
            </div>
            <br>
            <div class="input-group">
              <span class="input-group-addon">Rut Contacto</span>
              <input type="text" class="form-control" placeholder="Rut Contacto" id="data_rut_contacto_cliente"></textarea>
            </div>
            <br>
            <div class="input-group">
              <span class="input-group-addon">Descripción</span>
              <textarea class="form-control" rows="3" id="data_descripcion_cliente"></textarea>
            </div>
            <br>
            <div class="input-group">
              <span class="input-group-addon">¿Donde Esta?</span>
              <textarea class="form-control" rows="3" id="data_where_cliente"></textarea>
            </div>
            <br>
            </div>
            <div class="col-lg-4">
              <h4 class="modal-title">&nbsp;Imagenes</h4>
              <br>
              <div id="images_cliente_edit">
                
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
