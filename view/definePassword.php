<script src="controller/definePassword.js"></script>
<!-- Modal -->
  <div class="modal fade" id="definePassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Escribe tu nueva contraseña</h4>
        </div>
        <div class="modal-body" id="define-body">
          <form role="form">
            <label class="messageInputDefine text-danger"></label>
            <div class="form-group">
              <label for="password">Contraseña</label>
              <div class="input-group">
                <span class="input-group-addon">Password</span>
                <input type="password" id="definePasswordInput" class="form-control" placeholder="Contraseña">
              </div>
            </div>
            <div class="form-group">
              <label for="repeatPassword">Repite tu Contraseña</label>
              <div class="input-group">
                <span class="input-group-addon">Password</span>
                <input type="password" id="repeatDefinePassword" class="form-control" placeholder="Repite Contraseña">
              </div>
            </div>
            <div class="checkbox">
              <label>
              <br>
                <input type="checkbox" id="aceptoDefinePass" value="1"> Acepto las politicas de privacidad y uso.
              </label>
            </div>
          </form>
        </div>
        <div class="modal-body" id="define-success">
          <div id="define-status0">Tu contraseña ha sido cambiada con exito<br> Ya puedes utilizarla en Cuponperfumes.</div>
          <div id="define-status2">Existe un error al modificar la base de datos<br> Contacte con el staff de Eollice.</div>
          <div id="define-status1">El cambio de contraseña es invalido o ya fue efectuado anteriormente <br> Si los problemas persisten, contacte con el staff de Eollice.</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="definePasswordBtn">Definir</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->