<?php
if($_SESSION['privilegio_ielg']!="1"){
	echo $lc->forzar_cierre_controlador();
}
?>
<div class="container-fluid">
	<div class="page-header">
			  <h1 class="text-titles"><i class="zmdi zmdi-email"></i></i> Mensajes</h1>
			</div>
			<p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse voluptas reiciendis tempora voluptatum eius porro ipsa quae voluptates officiis sapiente sunt dolorem, velit quos a qui nobis sed, dignissimos possimus!</p>
		</div>


		<div class="container-fluid">
			<ul class="breadcrumb breadcrumb-tabs">
			  	<li>
			  		<a href="<?php echo SERVERURL; ?>mensajelist/" class="btn btn-success">
			  			<i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE MENSAJES
			  		</a>
			  	</li>
			  	<li>
			  		<a href="<?php echo SERVERURL; ?>mensajesearch/" class="btn btn-primary">
			  			<i class="zmdi zmdi-search"></i> &nbsp; BUSCAR MENSAJES
			  		</a>
			  	</li>
			</ul>
		</div>


		<?php 
			require_once "./controladores/mensajeControlador.php";
			$insMensaje = new mensajeControlador();
		?>
		
		<!-- Panel listado de mensajes -->
		<div class="container-fluid">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE MENSAJES</h3>
				</div>
				<div class="panel-body">
					<?php
						$pagina = explode("/",$_GET['views']);
						echo $insMensaje-> paginador_mensaje_controlador($pagina[1], 5,"");
					?>						
				</div>
			</div>
		</div>