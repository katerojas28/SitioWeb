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

<!-- Panel mis datos -->
<div class="container-fluid">
	<?php
	$datos=explode("/",$_GET['views']);
		//Administrador
		if($datos[1]=="admin"):
			if($_SESSION['tipo_ielg']!="Administrador"){
				echo $lc->forzar_cierre_controlador();
			}
			require_once "./controladores/bannerControlador.php";
			$classBanner = new bannerControlador();
			$filesA=$classBanner->datos_banner_controlador($datos[2]);
				if($filesA->rowCount()==1){
					$campos=$filesA->fetch();				
	?>

<div class="panel panel-success">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="zmdi zmdi-refresh"></i> &nbsp; ACTUALIZAR BANNER</h3>
	</div>
	<div class="panel-body">
		<form action="<?php echo SERVERURL; ?>ajax/bannerAjax.php" method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
		<input type="hidden" name="codigo-up" value="<?php echo $datos[2] ?>">
		<fieldset>
		<legend><i class="zmdi zmdi-compare"></i> &nbsp; Información del banner</legend>
			<div class="container-fluid">
				<div class="row">
	    			<div class="col-xs-12 col-sm-12">
						<img src="data:<?php echo $campos['BannerTipImg'] ?>;base64,<?php echo base64_encode(stripslashes($campos['BannerImg']));?>" alt="banner" class="img-responsive">
	    			</div>
				</div>
			</div>
		</fieldset>
		<br>
		<fieldset>
		<legend><i class="zmdi zmdi-assignment-o"></i> &nbsp; Descripción del banner</legend>
			<div class="container-fluid">
				<div class="row">
					<div class="col-xs-12">
						<div class="form-group label-floating">
							<label class="control-label">Descripción maximo de 200 caracteres *</label>
							<textarea name="descripcion-up" class="form-control" rows="2" maxlength="245" required=""><?php echo $campos['BannerDescripcion'] ?></textarea>
						</div>
	    			</div>
				</div>
			</div>
		</fieldset>

		<fieldset>
		<div class="col-xs-12">
    		<div class="form-group">
				<input type="file" name="imagen-up" id="imagen-up" accept=".jpg, .png, .jpeg">
				<div class="input-group">
					<input type="text" name="nomImg-up" readonly="" class="form-control" placeholder="Elija la imágen...">
					<span class="input-group-btn input-group-sm">
					<button type="button" name="submit" class="btn btn-fab btn-fab-mini">
					<i class="zmdi zmdi-attachment-alt"></i>
					</button>
					</span>
				</div>
				<span><small>Tamaño máximo de los archivos adjuntos 2MB. Tipos de archivos permitidos imágenes: PNG, JPEG y JPG</small></span>
			</div>
    	</div>
		</fieldset>
		<p class="text-center" style="margin-top: 20px;">
		<button type="submit" class="btn btn-success btn-raised btn-sm"><i class="zmdi zmdi-refresh"></i> Actualizar</button>
		</p>
		<div class="RespuestaAjax"></div>
		</form>
	</div>
</div>
	<?php }else{ ?>
		

<div class="full-box cover container-404">
    <div>
        <p class="text-center"> <i class="zmdi zmdi-mood-bad zmdi-hc-5x"></i></p>
        <h1 class="text-center">LO SENTIMOS</h1>
        <p class="lead text-center">No podemos mostrar la información solicitada</p>
    </div>
</div>

	<?php }
		//Para usuario
		elseif($datos[1]=="user"):
		echo"user";
		//ERROR
		else:
	?>

<div class="full-box cover container-404">
    <div>
        <p class="text-center"> <i class="zmdi zmdi-mood-bad zmdi-hc-5x"></i></p>
        <h1 class="text-center">LO SENTIMOS</h1>
        <p class="lead text-center">No podemos mostrar la información solicitada</p>
    </div>
</div>
	<?php endif; ?>			
</div>