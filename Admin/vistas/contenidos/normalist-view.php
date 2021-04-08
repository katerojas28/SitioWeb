<?php
if($_SESSION['privilegio_ielg']!="1"){
	echo $lc->forzar_cierre_controlador();
}
?>
<div class="container-fluid">
			<div class="page-header">
			<h1 class="text-titles"><i class="zmdi zmdi-file-text zmdi-hc-fw"></i> Administración <small>NORMATIVIDAD</small></h1>
			</div>
			<p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse voluptas reiciendis tempora voluptatum eius porro ipsa quae voluptates officiis sapiente sunt dolorem, velit quos a qui nobis sed, dignissimos possimus!</p>
		</div>

		<div class="container-fluid">
			<ul class="breadcrumb breadcrumb-tabs">
				<li>
			  		<a href="<?php echo SERVERURL; ?>norma/" class="btn btn-info">
			  			<i class="zmdi zmdi-plus"></i> &nbsp; NUEVA NORMATIVIDAD
			  		</a>
			  	</li>
			  	<li>
			  		<a href="<?php echo SERVERURL; ?>normalist/" class="btn btn-success">
			  			<i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE NORMATIVIDADES
			  		</a>
			  	</li>
			  	<li>
			  		<a href="<?php echo SERVERURL; ?>normasearch/" class="btn btn-primary">
			  			<i class="zmdi zmdi-search"></i> &nbsp; BUSCAR NORMATIVIDAD
			  		</a>
			  	</li>
			</ul>
		</div>


		<?php 
			require_once "./controladores/normativaControlador.php";
			$insNorma = new normativaControlador();
		?>
		
		<!-- Panel listado de normas -->
		<div class="container-fluid">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE NORMATIVIDADES</h3>
				</div>
				<div class="panel-body">
					<?php
						$pagina = explode("/",$_GET['views']);
						echo $insNorma-> paginador_norma_controlador($pagina[1], 10,"");
					?>						
				</div>
			</div>
		</div>