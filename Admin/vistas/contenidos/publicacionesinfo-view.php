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

<!-- Panel mis datos -->
<div class="container-fluid">
	<?php
	$datos=explode("/",$_GET['views']);
		//Administrador
		if($datos[1]=="admin"):
			if($_SESSION['tipo_ielg']!="Administrador"){
				echo $lc->forzar_cierre_controlador();
			}
			require_once "./controladores/publicacionControlador.php";
			$classPub = new publicacionControlador();
			$filesA=$classPub->datos_publicacion_controlador($datos[2]);
				if($filesA->rowCount()==1){
					$campos=$filesA->fetch();				
	?>

<div class="panel panel-success">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="zmdi zmdi-refresh"></i> &nbsp; ACTUALIZAR PUBLICACIÓN</h3>
	</div>
	<div class="panel-body">
		<form action="<?php echo SERVERURL; ?>ajax/publicacionAjax.php" method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
		<input type="hidden" name="codigo-up" value="<?php echo $datos[2] ?>">
		<fieldset>
		<legend><i class="zmdi zmdi-compare"></i> &nbsp; Información de la Publicación</legend>
			<div class="container-fluid">
				<div class="row">
	    			<div class="col-xs-12 col-sm-6">
						<img src="data:<?php echo $campos['PubTipImg'] ?>;base64,<?php echo base64_encode(stripslashes($campos['PubImag']));?>" alt="publicacion" class="img-responsive">
	    			</div>
				</div>
			</div>
		</fieldset>
		<br>
		<fieldset>
			<div class="container-fluid">
				<div class="row">
				<div class="col-xs-12">
						<div class="form-group label-floating">
						<label class="control-label">Titulo *</label>
						<input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,60}" class="form-control" type="text" name="titulo-up" value="<?php echo $campos['PubTitulo'] ?>" required="" maxlength="100">
						</div>
					<div class="col-xs-12">
						<div class="form-group label-floating">
						<label class="control-label">Descripción *</label>
						<label class="control-label">Descripción... </label>
						<textarea name="descripcion-up" class="form-control" rows="14"  required=""><?php echo $campos['PubDescripcion'] ?></textarea>
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
				<span><small>Tamaño máximo de los archivos adjuntos 1MB. Tipos de archivos permitidos imágenes: PNG, JPEG y JPG</small></span>
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