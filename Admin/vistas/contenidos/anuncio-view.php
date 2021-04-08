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

		<!-- Panel nuevo administrador -->
		<div class="container-fluid">
		<?php

		$datos=explode("/",$_GET['views']);


?>
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="zmdi zmdi-plus"></i> &nbsp; NUEVO ANUNCIO</h3>
				</div>
				<div class="panel-body">
				<form action="<?php echo SERVERURL; ?>ajax/anuncioAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
				<input type="hidden" name="cuenta-reg" value="<?php echo $datos[2] ?>">
				<fieldset>
					<legend><i class="zmdi zmdi-border-color"></i> &nbsp; Información del Anuncio</legend>

							<div class="col-xs-12 ">
						    	<div class="form-group label-floating">
								  	<label class="control-label">Título *</label>
								  	<input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="titulo-reg" required="" maxlength="30">
								</div>
							</div>

							<div class="container-fluid">
						<div class="row">
							<div class="col-xs-12">
								<div class="form-group label-floating">
								  	<label class="control-label">Descripción *</label>
								  	<textarea name="descripcion-reg" class="form-control" rows="5" required=""></textarea>
								</div>
		    				</div>
						</div>
					</div>

					<div class="col-xs-12">
    					<div class="form-group">
							<input type="file" name="imagen-reg" id="imagen-reg" accept=".jpg, .png, .jpeg" required="">
							<div class="input-group">
								<input type="text" name="nomImg-reg" readonly="" class="form-control" placeholder="Elija la imágen...">
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
					    	<button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i> Guardar</button>
						</p>
						<div class="RespuestaAjax"></div>
				    </form>
				</div>
			</div>
		</div>