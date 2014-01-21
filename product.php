<?php session_start(); ?>
<!-- DECLARAMOS QUE CONSISTE EN UN DOCUMENTO HTML5 -->
<!DOCTYPE html>
<html>
<head>
	<title>Cuponperfumes - Descuentos En Perfumes</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="//code.jquery.com/jquery.js"></script>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
	<!-- CSS DEL DOCUMENTO -->
	<link rel="stylesheet" href="css/esential.css">
	<link rel="stylesheet" href="css/forms.css">
  <link rel="stylesheet" href="css/index.css">
	<!-- Latest compiled and minified JavaScript -->
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<link rel="shortcut icon" href="images/plataform/logoicon.ico" type="image/png">

</head>
<body>
	<!-- INCLUIMOS EL HEADER -->
	<?php require_once("view/header.php"); ?>
	<!-- INCLUIMOS EL PREBODY -->
	<?php require_once("view/prebody.php"); ?>
	<!-- INCLUIMOS EL BODY -->
	<?php require_once("view/product.php"); ?>
	<!-- INCLUIMOS EL FOOTER -->
	<?php require_once("view/footer.php"); ?>
	<!-- CAPAS MODALES -->
	<?php require_once("view/logform.php"); ?>
	<?php require_once("view/activeForm.php"); ?>
	<?php require_once("view/definePassword.php"); ?>
	<?php require_once("view/regform.php"); ?>
	<?php require_once("view/forgotPassword.php"); ?>
</body>
</html>