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
			$insAnuncio = new anuncioControlador();

			if(isset($_POST['busqueda_inicial_Anuncio'])){
				$_SESSION['busqueda_anuncio']=$_POST['busqueda_inicial_Anuncio'];
			}

			if(isset($_POST['eliminar_busqueda_anuncio'])){
				unset($_SESSION['busqueda_anuncio']);
			}

			if(!isset($_SESSION['busqueda_anuncio']) && empty($_SESSION['busqueda_anuncio'])):
		?>

		<div class="container-fluid">
			<form class="well" method="POST" action="">
				<div class="row">
					<div class="col-xs-12 col-md-8 col-md-offset-2">
						<div class="form-group label-floating">
							<span class="control-label">¿A quién estas buscando?</span>
							<input class="form-control" type="text" name="busqueda_inicial_Anuncio" required="" autocomplete="off">
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
				<p class="lead text-center">Su última búsqueda  fue <strong>"<?php echo $_SESSION['busqueda_anuncio'];?>"</strong></p>
				<div class="row">
					<input class="form-control" type="hidden" name="eliminar_busqueda_anuncio" value="1">
					<div class="col-xs-12">
						<p class="text-center">
							<button type="submit" class="btn btn-danger btn-raised btn-sm"><i class="zmdi zmdi-delete"></i> &nbsp; Eliminar búsqueda</button>
						</p>
					</div>
				</div>
			</form>
		</div>
		
		
		<!-- Panel listado de busqueda de administradores -->
		<div class="container-fluid">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="zmdi zmdi-search"></i> &nbsp; BUSCAR ANUNCIO</h3>
				</div>
				<div class="panel-body">
				<?php
						$pagina = explode("/",$_GET['views']);
						echo $insAnuncio-> paginador_anuncio_controlador($pagina[1], 5,  
						$_SESSION['privilegio_ielg'],
						$_SESSION['codigo_cuenta_ielg'],
						$_SESSION['busqueda_anuncio']);
					?>
				</div>
			</div>
		</div>
			<?php endif; ?>