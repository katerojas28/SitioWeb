<?php
if($_SESSION['privilegio_ielg']!="1"){
	echo $lc->forzar_cierre_controlador();
}
?>
<div class="container-fluid">
	<div class="page-header">
			  <h1 class="text-titles"><i class="zmdi zmdi-image-alt zmdi-hc-fw"></i> Configuraciones <small>BANNER</small></h1>
			</div>
			<p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse voluptas reiciendis tempora voluptatum eius porro ipsa quae voluptates officiis sapiente sunt dolorem, velit quos a qui nobis sed, dignissimos possimus!</p>
		</div>


		<div class="container-fluid">
			<ul class="breadcrumb breadcrumb-tabs">
				<li>
			  		<a href="<?php echo SERVERURL; ?>banner/" class="btn btn-info">
			  			<i class="zmdi zmdi-plus"></i> &nbsp; NUEVO BANNER
			  		</a>
			  	</li>
			  	<li>
			  		<a href="<?php echo SERVERURL; ?>bannerlist/" class="btn btn-success">
			  			<i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE BANNERS
			  		</a>
			  	</li>
			  	<li>
			  		<a href="<?php echo SERVERURL; ?>bannersearch/" class="btn btn-primary">
			  			<i class="zmdi zmdi-search"></i> &nbsp; BUSCAR BANNER
			  		</a>
			  	</li>
			</ul>
		</div>


		<?php 
			require_once "./controladores/bannerControlador.php";
			$insBanner = new bannerControlador();
		?>
		
		<!-- Panel listado de banners -->
		<div class="container-fluid">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE BANNERS</h3>
				</div>
				<div class="panel-body">
					<?php
						$pagina = explode("/",$_GET['views']);
						echo $insBanner-> paginador_banner_controlador($pagina[1], 2,"");
					?>						
				</div>
			</div>
		</div>