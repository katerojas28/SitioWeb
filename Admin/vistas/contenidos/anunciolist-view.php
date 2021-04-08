<?php
if($_SESSION['privilegio_ielg']!="1"){
	echo $lc->forzar_cierre_controlador();
}
?>
<div class="container-fluid">
	<div class="page-header">
			  <h1 class="text-titles"><i class="zmdi zmdi-comment-edit zmdi-hc-fw"></i> Configuraciones <small>ANUNCIOS</small></h1>
			</div>
			<p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse voluptas reiciendis tempora voluptatum eius porro ipsa quae voluptates officiis sapiente sunt dolorem, velit quos a qui nobis sed, dignissimos possimus!</p>
		</div>

		<div class="container-fluid">
			<ul class="breadcrumb breadcrumb-tabs">
				<li>
			  		<a href="<?php echo SERVERURL; ?>anuncio/<?php echo $tipo."/".$lc->encryption($_SESSION['codigo_cuenta_ielg']); ?>/" class="btn btn-info">
			  			<i class="zmdi zmdi-plus"></i> &nbsp; NUEVO ANUNCIO INTERNO
			  		</a>
			  	</li>
			  	<li>
			  		<a href="<?php echo SERVERURL; ?>anunciolist/" class="btn btn-success">
			  			<i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE ANUNCIOS INTERNOS
			  		</a>
			  	</li>
			  	<li>
			  		<a href="<?php echo SERVERURL; ?>anunciosearch/" class="btn btn-primary">
			  			<i class="zmdi zmdi-search"></i> &nbsp; BUSCAR ANUNCIO
			  		</a>
			  	</li>
			</ul>
		</div>


		<?php 
			require_once "./controladores/anuncioControlador.php";
			$insAdmin = new anuncioControlador();
		?>
		
		<!-- Panel listado de administradores -->
		<div class="container-fluid">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE ANUNCIOS INTERNOS</h3>
				</div>
				<div class="panel-body">
					<?php
						$pagina = explode("/",$_GET['views']);
						echo $insAdmin-> paginador_anuncio_controlador($pagina[1], 5,  $_SESSION['privilegio_ielg'],$_SESSION['codigo_cuenta_ielg'],"");
					?>
								
				
						
				</div>
			</div>
		</div>