<?php
if($_SESSION['privilegio_ielg']!="1"){
	echo $lc->forzar_cierre_controlador();
}
?>
<div class="container-fluid">
	<div class="page-header">
		<h1 class="text-titles"><i class="zmdi zmdi-info-outline zmdi-hc-fw"></i> Configuraciones <small>INFORMACIÓN</small></h1>
	</div>
		<p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse voluptas reiciendis tempora voluptatum eius porro ipsa quae voluptates officiis sapiente sunt dolorem, velit quos a qui nobis sed, dignissimos possimus!</p>
</div>


		<?php 
			require_once "./controladores/informacionControlador.php";
			$insInfo = new informacionControlador();
		?>
		
		<!-- Panel listado de administradores -->
		<div class="container-fluid">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; INFORMACIÓN</h3>
				</div>
				<div class="panel-body">
					<?php
						echo $insInfo-> mostrar_informacion_controlador();
					?>						
				</div>
			</div>
		</div>