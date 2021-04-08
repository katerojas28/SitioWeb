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


		<div class="container-fluid">

		<?php
	$datos=explode("/",$_GET['views']);
		//Administrador
		if($datos[1]=="admin"):
			if($_SESSION['tipo_ielg']!="Administrador"){
				echo $lc->forzar_cierre_controlador();
			}
			require_once "./controladores/galeriaControlador.php";
			$classGaleria = new galeriaControlador();
			$filesA=$classGaleria->datos_galeria_controlador($datos[2]);
				if($filesA->rowCount()==1){
					$campos=$filesA->fetch();				
	?>


		<div class="panel panel-success">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="zmdi zmdi-refresh"></i> &nbsp; ACTUALIZAR GALERIA</h3>
	</div>
	<div class="panel-body">
		<form action="<?php echo SERVERURL; ?>ajax/galeriaAjax.php" method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
		<input type="hidden" name="codigo-up" value="<?php echo $datos[2] ?>">
		<input type="hidden" name="tipo-up" value="<?php echo $campos['GaleriaTipArchivo'] ?>">
		<input type="hidden" name="tamaño-up" value="<?php echo $campos['GaleriaTamArchivo'] ?>">
		<fieldset>
				<legend><i class="zmdi zmdi-border-color"></i> &nbsp; Información</legend>
					<div class="container-fluid">
						<div class="row">
							<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
									<label class="control-label">Nombre *</label>
									<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ-0-9]{1,90}" class="form-control" type="text" name="titulo-up" value="<?php echo $campos['GaleriaTitulo'] ?>" required="" maxlength="60">
								</div>
							</div>
							<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
									<label class="control-label">Nombre del Archivo *</label>
									<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ-0-9]{1,90}" class="form-control" type="text" name="nombreArchivo-up" value="<?php echo $campos['GaleriaNomArchivo'] ?>" required="" maxlength="60">
								</div>
							</div>
							
							<div class="col-xs-12">
								<div class="form-group label-floating">
								  	<label class="control-label">Descripción maximo de 200 caracteres *</label>
								  	<textarea name="descripcion-up" class="form-control" rows="2" maxlength="245" required=""><?php echo $campos['GaleriaDescripcion'] ?></textarea>
								</div>
		    				</div>
						</div>
					</div>
					<div class="col-xs-12">
    					<div class="form-group">
							<input type="file" name="file-up"  accept=".jpg, .png, .jpeg, .mp4, ,mp3" >
							<div class="input-group">
								<input type="text" name="nomFile-reg" readonly="" class="form-control" placeholder="Elija el documento...">
								<span class="input-group-btn input-group-sm">
									<button type="button" name="submit" class="btn btn-fab btn-fab-mini">
										<i class="zmdi zmdi-attachment-alt"></i>
									</button>
								</span>
							</div>
							<span><small>Tamaño máximo de los archivos adjuntos 2MB. Tipos de archivo permitido .jpg, .png, .jpeg, .mp4, .mp3 </small></span>
						</div>
					</div>
					<div class="col-xs-12 col-sm-6">
									<div class="form-group">
										<label class="control-label">Categoria</label>
										<div class="radio radio-primary">
											<label>
											<input type="radio" name="optionsGaleria" id="optionsRadios1" <?php if($campos['GaleriaCategoria']=="Imagenes"){ echo 'checked=""';} ?> value="Imagenes" checked="">
											 &nbsp; Imagenes
											</label>
										</div>
										<div class="radio radio-primary">
											<label>
											<input type="radio" name="optionsGaleria" id="optionsRadios2" <?php if($campos['GaleriaCategoria']=="Videos"){ echo 'checked=""';} ?> value="Videos">
											 &nbsp; Videos
											</label>
										</div>
										<div class="radio radio-primary">
											<label>
											<input type="radio" name="optionsGaleria" id="optionsRadios3" <?php if($campos['GaleriaCategoria']=="Audios"){ echo 'checked=""';} ?> value="Audios" >
											&nbsp; Audios
											</label>
										</div>
									</div>

							</div>
			</fieldset>

					    <p class="text-center" style="margin-top: 20px;">
					    	<button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i> Actualizar</button>
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