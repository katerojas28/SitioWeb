<?php
if($_SESSION['privilegio_ielg']!="1"){
	echo $lc->forzar_cierre_controlador();
}
?>
<div class="container-fluid">
			<div class="page-header">
			<h1 class="text-titles"><i class="zmdi zmdi-comment-edit zmdi-hc-fw"></i> Configuraciones <small>BANNER</small></h1>
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

			if(isset($_POST['busqueda_inicial_banner'])){
				$_SESSION['busqueda_banner']=$_POST['busqueda_inicial_banner'];
			}

			if(isset($_POST['eliminar_busqueda_banner'])){
				unset($_SESSION['busqueda_banner']);

			}

			if(!isset($_SESSION['busqueda_banner']) && empty($_SESSION['busqueda_banner'])):
		?>

		<div class="container-fluid">
			<form class="well" method="POST" action="">
				<div class="row">
					<div class="col-xs-12 col-md-8 col-md-offset-2">
						<div class="form-group label-floating">
							<span class="control-label">¿Qué estas buscando?</span>
							<input class="form-control" type="text" name="busqueda_inicial_banner" required="" autocomplete="off">
						</div>
					</div>
					<div class="col-xs-12">
						<p class="text-center">
							<button type="submit" class="btn btn-primary btn-raised btn-sm"><i class="zmdi zmdi-search"></i> &nbsp; Buscar</button>
						</p>
					</div>
				</div>
			</form>
		</div>
			<?php else: ?>

		<div class="container-fluid">
			<form class="well" method="POST" action="">
				<p class="lead text-center">Su última búsqueda  fue <strong>"<?php echo $_SESSION['busqueda_banner'];?>"</strong></p>
				<div class="row">
					<input class="form-control" type="hidden" name="eliminar_busqueda_banner" value="1">
					<div class="col-xs-12">
						<p class="text-center">
							<button type="submit" class="btn btn-danger btn-raised btn-sm"><i class="zmdi zmdi-delete"></i> &nbsp; Eliminar búsqueda</button>
						</p>
					</div>
				</div>
			</form>
		</div>

		<!-- Panel listado de banners -->
		<div class="container-fluid">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; BUSCAR BANNER</h3>
				</div>
				<div class="panel-body">
					<?php
						$pagina = explode("/",$_GET['views']);
						echo $insBanner-> paginador_banner_controlador($pagina[1], 1,$_SESSION['busqueda_banner']);
					?>						
				</div>
			</div>
		</div>
	<?php endif; ?>