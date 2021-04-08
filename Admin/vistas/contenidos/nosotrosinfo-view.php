<div class="container-fluid">
	<div class="page-header">
	<h1 class="text-titles"><i class="zmdi zmdi-labels zmdi-hc-fw"></i> Administración <small>NOSOTROS</small></h1>
			</div>
			<p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse voluptas reiciendis tempora voluptatum eius porro ipsa quae voluptates officiis sapiente sunt dolorem, velit quos a qui nobis sed, dignissimos possimus!</p>
		</div>

		<div class="container-fluid">
			<ul class="breadcrumb breadcrumb-tabs">
			  	<li>
			  		<a href="<?php echo SERVERURL; ?>nosotroslist/" class="btn btn-success">
			  			<i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE ITEMS SOBRE NUESTRO COLEGIO
			  		</a>
				  </li>
				  <li>
					<a href="<?php echo SERVERURL; ?>nosotrossearch/" class="btn btn-primary">
						<i class="zmdi zmdi-search"></i> &nbsp; BUSCAR ITEMS SOBRE NUESTRO COLEGIO
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
			require_once "./controladores/nosotrosControlador.php";
			$classNos = new nosotrosControlador();
			$filesA=$classNos->datos_nosotros_controlador($datos[2]);
				if($filesA->rowCount()==1){
					$campos=$filesA->fetch();				
	?>

<div class="panel panel-success">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="zmdi zmdi-refresh"></i> &nbsp; ACTUALIZAR ITEM SOBRE NOSOTROS</h3>
	</div>
	<div class="panel-body">
		<form action="<?php echo SERVERURL; ?>ajax/nosotrosAjax.php" method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
		<input type="hidden" name="codigo-up" value="<?php echo $datos[2] ?>">
		<input type="hidden" name="titulo-up" value="<?php echo $campos['NosotrosTitulo'] ?>">
		<fieldset>
		<legend><i class="zmdi zmdi-compare"></i> &nbsp; <?php echo $campos['NosotrosTitulo'] ?></legend>
			<div class="container-fluid">
				<div class="row">
				
	    			<div class="col-xs-12 col-sm-6">
						<img src="data:<?php echo $campos['NosotrosTipImg'] ?>;base64,<?php echo base64_encode(stripslashes($campos['NosotrosImg']));?>" alt="nosotros" class="img-responsive">
	    			</div>
				</div>
			</div>
		</fieldset>
		<br>
		<fieldset>
			<div class="container-fluid">
				<div class="row">
				<div class="col-xs-12">
					<div class="col-xs-12">
						<div class="form-group label-floating">
						<label class="control-label">Descripción *</label>
						<label class="control-label">Descripción... </label>
						<textarea name="descripcion-up" class="form-control" rows="7"  ><?php echo $campos['NosotrosDescripcion'] ?></textarea>
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
        <p class="lead text-center">No podemos usted no tiene permiso ára visualizar esta información</p>
    </div>
</div>
	<?php endif; ?>			
</div>