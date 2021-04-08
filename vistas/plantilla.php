<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <title>I.E. LEÓN DE GREIFF</title>

    <link rel="shortcut icon" href="<?php echo SERVERURL; ?>vistas/assets/images/leondegreiff.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="<?php echo SERVERURL; ?>vistas/css/Plugins/swiper.min.css">
 
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo SERVERURL; ?>vistas/css/Plugins/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo SERVERURL; ?>admin/vistas/css/font-awesome.min.css">

    <link rel="stylesheet" href="<?php echo SERVERURL; ?>vistas/css/estilos.css"> 

    <script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src="<?php echo SERVERURL; ?>vistas/js/Plugins/main.js"></script>
	<script src="<?php echo SERVERURL; ?>vistas/js/main.js"></script>
	<script src="<?php echo SERVERURL; ?>vistas/js/Plugins/bootstrap.min.js"></script>
</head>
<body>

		<?php  
		$peticionAjax = false;
		require_once "./controladores/vistasControlador.php";

		$vt = new vistasControlador();
		$vistasR=$vt->obtener_vistas_controlador();
		if($vistasR=="home" || $vistasR=="404"){
			if($vistasR=="home"){
				
				require_once "./vistas/contenidos/home-view.php";
			}else{
				require_once "./vistas/contenidos/404-view.php";
			}	}
			session_start(['name'=>'IELG']);
			if(!$_GET){header('Location:home/');}
		?> 

<header>
<?php  include "./vistas/modulos/encabezado.php"; ?>
<?php include "./vistas/modulos/menu.php"; ?>
</header>
<?php include "./vistas/modulos/redes.php"; ?>
		<!-- Content page -->
		<?php require_once $vistasR;?>


		<script>
		$.material.init();
	</script>
	

