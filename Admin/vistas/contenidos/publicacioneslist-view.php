<?php
if($_SESSION['privilegio_ielg']!="1"){
	echo $lc->forzar_cierre_controlador();
}
?>
<div class="container-fluid">
			<div class="page-header">
			  <h1 class="text-titles"><i class="zmdi zmdi-balance zmdi-hc-fw"></i> Administración <small>PUBLICACIONES</small></h1>
			</div>
			<p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse voluptas reiciendis tempora voluptatum eius porro ipsa quae voluptates officiis sapiente sunt dolorem, velit quos a qui nobis sed, dignissimos possimus!</p>
		</div>

		<div class="container-fluid">
			<ul class="breadcrumb breadcrumb-tabs">
			  	<li>
			  		<a href="<?php echo SERVERURL; ?>publicaciones/" class="btn btn-info">
			  			<i class="zmdi zmdi-plus"></i> &nbsp; NUEVA PUBLICACIÓN
			  		</a>
			  	</li>
			  	<li>
			  		<a href="<?php echo SERVERURL; ?>publicacioneslist/" class="btn btn-success">
			  			<i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE PUBLICACIONES
			  		</a>
				  </li>
				  <li>
					<a href="<?php echo SERVERURL; ?>publicacionessearch/" class="btn btn-primary">
						<i class="zmdi zmdi-search"></i> &nbsp; BUSCAR PUBLICACIONES
					</a>
				</li>
			</ul>
		</div>


		<?php 
			require_once "./controladores/publicacionControlador.php";
			$insPub = new publicacionControlador();
		?>
		
		<!-- Panel listado de publicaciones -->
		<div class="container-fluid">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE PUBLICACIONES</h3>
				</div>
				<div class="panel-body">
					<?php
						$pagina = explode("/",$_GET['views']);
						echo $insPub->paginador_publicacion_controlador($pagina[1], 2,"");
					?>						
				</div>
			</div>
		</div>