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

		<!-- Panel nuevo banner -->
		<div class="container-fluid">

			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="zmdi zmdi-plus"></i> &nbsp; NUEVO BANNER</h3>
				</div>
				<div class="panel-body">
				<form action="<?php echo SERVERURL; ?>ajax/bannerAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
				<fieldset>
				<legend><i class="zmdi zmdi-border-color"></i> &nbsp; Información del Banner</legend>
					<div class="container-fluid">
						<div class="row">
							<div class="col-xs-12">
								<div class="form-group label-floating">
								  	<label class="control-label">Descripción maximo de 200 caracteres *</label>
								  	<textarea name="descripcion-banner" class="form-control" rows="2" maxlength="245" required=""></textarea>
								</div>
		    				</div>
						</div>
					</div>
					<div class="col-xs-12">
    					<div class="form-group">
							<input type="file" name="imagen-banner" id="imagen-banner" accept=".jpg, .png, .jpeg" required="">
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