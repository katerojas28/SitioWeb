<?php
if($_SESSION['privilegio_ielg']!="1"){
	echo $lc->forzar_cierre_controlador();
}
?>
<div class="container-fluid">
			<div class="page-header">
			<h1 class="text-titles"><i class="zmdi zmdi-collection-image-o zmdi-hc-fw"></i> Administración <small>GALERIA</small></h1>
			</div>
			<p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse voluptas reiciendis tempora voluptatum eius porro ipsa quae voluptates officiis sapiente sunt dolorem, velit quos a qui nobis sed, dignissimos possimus!</p>
		</div>

		<div class="container-fluid">
			<ul class="breadcrumb breadcrumb-tabs">
				<li>
			  		<a href="<?php echo SERVERURL; ?>galeria/" class="btn btn-info">
			  			<i class="zmdi zmdi-plus"></i> &nbsp; NUEVA GALERIA
			  		</a>
			  	</li>
			  	<li>
			  		<a href="<?php echo SERVERURL; ?>galerialist/" class="btn btn-success">
			  			<i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE GALERIA
			  		</a>
			  	</li>
			  	<li>
			  		<a href="<?php echo SERVERURL; ?>galeriasearch/" class="btn btn-primary">
			  			<i class="zmdi zmdi-search"></i> &nbsp; BUSCAR GALERIA
			  		</a>
			  	</li>
			</ul>
		</div>


		<?php 
			require_once "./controladores/galeriaControlador.php";
			$insGaleria = new galeriaControlador();
		?>
		

		<div class="container-fluid">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE GALERIA</h3>
				</div>
				<div class="panel-body">
					<?php
						$pagina = explode("/",$_GET['views']);
						echo $insGaleria-> paginador_galeria_controlador($pagina[1],5,"");
					?>						
				</div>
			</div>
		</div>