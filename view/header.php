<link rel="stylesheet" href="css/header.css">
<script src="controller/header.js"></script>
<nav class="navbar navbar-inverse navbar-top header-navbar no-shadow" role="navigation" style="margin-bottom:0px;">
	<div class="container" style="border-bottom: none;">
		<a class="navbar-brand" href="#"><img class="float-logo" src="images/plataform/logocp.png" height="100"/></a>
		<ul class="nav navbar-nav menu-navbar">
            <li><a href="#"> <span class="glyphicon glyphicon-star"></span> Luis Thayer Ojeda 183, Of 304; Providencia</a></li>
            <li><a href="#about"><span class="glyphicon glyphicon-phone-alt"></span> (02) 23333 218</a></li>
            <li><a href="#contact"><span class="glyphicon glyphicon-envelope"></span> contacto@cuponperfumes.cl</a></li>
        </ul>
        <ul class="nav navbar-nav menu-navbar navbar-right">
        	<?php
          if(isset($_SESSION['token'])){
            echo '<li id="fat-menu" class="dropdown">
                <a href="#" id="drop3" role="button" class="dropdown-toggle" data-toggle="dropdown">Mi cuenta<b class="caret"></b></a>
                <ul id="menu1" class="dropdown-menu" role="menu" >
                  <li role="presentation"><a role="menuitem" tabindex="-1" id="misCupones"><span class="glyphicon glyphicon-barcode"></span>&nbsp;&nbsp;&nbsp;&nbsp;Mis Cupones</a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1"  id="cambiarPassword"><span class="glyphicon glyphicon-link"></span>&nbsp;&nbsp;&nbsp;&nbsp;Cambiar Contraseña</a></li>
                  <li role="presentation" class="divider"></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" id="logout"><span class="glyphicon glyphicon-off"></span>&nbsp;&nbsp;&nbsp;&nbsp;Cerrar Sesion</a></li>
                </ul>
            </li>';
          }
          else{
            echo '<li id="fat-menu" class="dropdown">
              <a href="#" id="drop3" role="button" class="dropdown-toggle regForm" data-toggle="dropdown">Registrate</b></a>
            </li>
            <li id="fat-menu" class="dropdown">
                <a href="#" id="drop3" role="button" class="dropdown-toggle logForm" data-toggle="dropdown">Ingresa</b></a>
            </li>';
          }
          ?>
        </ul>
	</div>
	<div class="container">
    <div class="row tabs-top" >
    <div class="container tabs-no-border" >
      <ul class="nav nav-tabs tabs-no-border" style="margin-left:150px;">
        <li class="active"><a style="border:none;" href="#home" data-toggle="tab" id="destacados"><img class="float_left" src="images/plataform/perfumes-header.png" height="18"/><span style="font-size:17px">&nbsp;&nbsp;Perfumes</span></a></li>
        <li><a  style="border:none;" href="#profile" data-toggle="tab" id="belleza"><img class="float_left" src="images/plataform/icono-yoga-header.png" height="18"/><span style="font-size:17px">&nbsp;&nbsp;Belleza</span></a></li>
        <form class="navbar-form navbar-right form-suscribe">
              <div class="form-group header-navbar">
                <input type="text" placeholder="Ingresa tu Email y recibe novedades" class="form-control" style="width:400px;">
              </div>
              <button type="submit" class="btn btn-primary  ">Suscribete</button>
            </form>
      </ul>
    </div>
  </div>

  </div>
</nav>
</div>