<?php
if($_SESSION['privilegio_ielg']!="1"){
	echo $lc->forzar_cierre_controlador();
}
?>
<div class="container-fluid">
			<div class="page-header">
			  <h1 class="text-titles"><i class="zmdi zmdi-labels zmdi-hc-fw"></i> Administración <small>NOSOTROS</small></h1>
			</div>
			<p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse voluptas reiciendis tempora voluptatum eius porro ipsa quae voluptates officiis sapiente sunt dolorem, velit quos a qui nobis sed, dignissimos possimus!</p>
		</div>

		<div class="container-fluid">
			<ul class="breadcrumb breadcrumb-tabs">
			  	<li>
			  		<a href="<?php echo SERVERURL; ?>nosotros/" class="btn btn-info">
			  			<i class="zmdi zmdi-plus"></i> &nbsp; NUEVA 
			  		</a>
			  	</li>
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

		<!-- Panel nuevo nosotros -->
		<div class="container-fluid">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="zmdi zmdi-plus"></i> &nbsp; NUEVA </h3>
				</div>
				<div class="panel-body">
				<form action="<?php echo SERVERURL; ?>ajax/nosotrosAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
				    	<fieldset>
				    		<legend><i class="zmdi zmdi-assignment-o"></i> &nbsp; Información sobre nosotros</legend>
				    		<div class="container-fluid">
				    			<div class="row">
				    				<div class="col-xs-12 col-sm-6">
									<div class="form-group label-floating">
										  	<label class="control-label">categoria *</label>
										  	<input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,60}" class="form-control" type="text" name="categoria-pub" required="" maxlength="100">
										</div>
								    	<div class="form-group label-floating">
										  	<label class="control-label">Titulo *</label>
										  	<input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,60}" class="form-control" type="text" name="titulo-pub"  maxlength="100">
										</div>
									</div>
									<div class="container-fluid">
								<div class="row">
									<div class="col-xs-12">
										<div class="form-group label-floating">
											<label class="control-label">Descripción *</label>
										  	<textarea name="descripcion-pub" class="form-control" rows="6" ></textarea>
										</div>
				    				</div>
								</div>
							</div>
							<div class="col-xs-12">
		    					<div class="form-group">
									<span class="control-label">Imágen *</span>
									<input type="file" name="imagen-pub" accept=".jpg, .png, .jpeg" required="">
									<div class="input-group">
										<input type="text" readonly="" class="form-control" placeholder="Elija la imágen..." >
										<span class="input-group-btn input-group-sm">
											<button type="button" class="btn btn-fab btn-fab-mini">
												<i class="zmdi zmdi-attachment-alt"></i>
											</button>
										</span>
									</div>
									<span><small>Tamaño máximo de los archivos adjuntos 1MB. Tipos de archivos permitidos imágenes: PNG, JPEG y JPG</small></span>
								</div>
		    				</div>
						</fieldset>
						
						<br>
						
					    <p class="text-center" style="margin-top: 20px;">
					    	<button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i> Guardar</button>
						</p>
						<div class="RespuestaAjax"></div>
				    </form>
				</div>
			</div>
		</div>