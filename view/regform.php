<script src="controller/regForm.js"></script>
<link rel="stylesheet" href="css/regForm.css">
<!-- Modal -->
  <div class="modal fade" id="regForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Registrate en Cuponperfumes</h4>
        </div>
        <div class="modal-body" id="modal-reg" style="overflow:hidden;">
          <form role="form">
            <label class="messageinput text-danger"></label>
            <div class="form-group">
              <label for="emailInput">E-Mail</label>
              <div class="input-group">
                <span class="input-group-addon">@</span>
                <input type="text" id="emailReg" class="form-control" placeholder="E-Mail">
              </div>
            </div>
            <div class="form-group">
              <label for="nameInput">Nombre Completo</label>
              <div class="input-group">
                <span class="input-group-addon">Name</span>
                <input type="text" id="name" class="form-control" placeholder="Nombre Completo">
              </div>
            </div>
            <div class="form-group">
              <label for="nameInput">Direccion</label>
              <div class="input-group">
                <span class="input-group-addon">Direccion</span>
                <input type="text" id="location" class="form-control" placeholder="Calle N° ">
              </div>
            </div>
            <div class="form-group">
              <label for="nameInput">Comuna</label>
              <div class="input-group">
                <span class="input-group-addon">Comuna</span>
                <input type="text" id="comuna" class="form-control" placeholder="Ciudad">
              </div>
            </div>
            <div class="form-group">
              <label for="nameInput">Ciudad</label>
              <div class="input-group">
                <span class="input-group-addon">Ciudad</span>
                <input type="text" id="city" class="form-control" placeholder="Ciudad">
              </div>
            </div>
            <div class="form-group">
              <label for="password">Contraseña</label>
              <div class="input-group">
                <span class="input-group-addon">Password</span>
                <input type="password" id="passwordReg" class="form-control" placeholder="Contraseña">
              </div>
            </div>
            <div class="form-group">
              <label for="repeatPassword">Repite tu Contraseña</label>
              <div class="input-group">
                <span class="input-group-addon">Password</span>
                <input type="password" id="repeatPassword" class="form-control" placeholder="Repite Contraseña">
              </div>
            </div>
            <div class="checkbox">
              <label>
              <br>
                <input type="checkbox" id="acepto" value="1"><div class="user_terms" style="cursor:pointer;">Acepto los terminos y condiciones de uso de Cuponperfumes.</div>
              </label>
            </div>
          </form>
        </div>
        <div class="modal-body" id="modal-success">
          Gracias por registrate. <br>Te hemos enviado un e-mail con los datos de activación.
        </div>
        <div class="modal-footer">
          <button type="button" id="regButton" data-loading-text="Cargando..." class="btn btn-primary">Registrarse</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->