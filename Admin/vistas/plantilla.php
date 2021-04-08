<!DOCTYPE html>
<html lang="es">
<head>
	<title>	<?php echo COMPANY; ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="shortcut icon" href="<?php echo SERVERURL; ?>vistas/assets/img/leondegreiff.ico" type="image/x-icon">
	<link rel="stylesheet" href="<?php echo SERVERURL; ?>vistas/css/main.css">
	<link rel="stylesheet" href="<?php echo SERVERURL; ?>vistas/css/bootstrap-datetimepicker.min.css">
	<link rel="stylesheet" href="<?php echo SERVERURL; ?>vistas/css/calendar.css">
	<link rel="stylesheet" href="<?php echo SERVERURL; ?>vistas/css/font-awesome.min.css">
	<!--===== Scripts -->
	<?php include "./vistas/modulos/script.php"; ?>
</head>
<body>
		<?php  
		$peticionAjax = false;
		require_once "./controladores/vistasControlador.php";

		$vt = new vistasControlador();
		$vistasR=$vt->obtener_vistas_controlador();

		if($vistasR=="login" || $vistasR=="404"):
			if($vistasR=="login"){
				require_once "./vistas/contenidos/login-view.php";
			}else{
				require_once "./vistas/contenidos/404-view.php";
			}	
		else:
			session_start(['name'=>'IELG']);

			require_once "./controladores/loginControlador.php";

			$lc = new loginControlador();
			if(!isset($_SESSION['token_ielg']) || !isset ( $_SESSION['usuario_ielg']) ){
				$lc->forzar_cierre_controlador();
			}
		?> 

	<!-- SideBar -->
	<?php include "./vistas/modulos/navlateral.php"; ?>
	<!-- Content page-->
	<section class="full-box dashboard-contentPage">
		<!-- NavBar -->
		<?php include "./vistas/modulos/navbar.php"; ?>
		<!-- Content page -->
		<?php require_once $vistasR; ?>
	</section>
	<?php 
		include "./vistas/modulos/logoutScript.php"; 
		endif;
	?>
	<script>
		$.material.init();
	</script>

	</body>
</html>