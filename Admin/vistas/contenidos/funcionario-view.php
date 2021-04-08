<?php
if($_SESSION['privilegio_ielg']!="1"){
	echo $lc->forzar_cierre_controlador();
}
?>
<div class="container-fluid">
			<div class="page-header">
			<h1 class="text-titles"><i class="zmdi zmdi-account-box zmdi-hc-fw"></i> Administración <small>FUNCIONARIOS</small></h1>
			</div>
			<p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse voluptas reiciendis tempora voluptatum eius porro ipsa quae voluptates officiis sapiente sunt dolorem, velit quos a qui nobis sed, dignissimos possimus!</p>
		</div>

		<div class="container-fluid">
			<ul class="breadcrumb breadcrumb-tabs">
			  	<li>
			  		<a href="<?php echo SERVERURL; ?>funcionario/" class="btn btn-info">
			  			<i class="zmdi zmdi-plus"></i> &nbsp; NUEVA FUNCIONARIO
			  		</a>
			  	</li>
			  	<li>
			  		<a href="<?php echo SERVERURL; ?>funcionariolist/" class="btn btn-success">
			  			<i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE FUNCIONARIOS
			  		</a>
				  </li>
				  <li>
					<a href="<?php echo SERVERURL; ?>funcionariosearch/" class="btn btn-primary">
						<i class="zmdi zmdi-search"></i> &nbsp; BUSCAR FUNCIONARIOS
					</a>
				</li>
			</ul>
		</div>

		<!-- Panel nuevo funcionario -->
		<div class="container-fluid">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="zmdi zmdi-plus"></i> &nbsp; NUEVO FUNCIONARIO</h3>
				</div>
				<div class="panel-body">
				<form action="<?php echo SERVERURL; ?>ajax/funcionarioAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
				    	<fieldset>
				    		<legend><i class="zmdi zmdi-assignment-o"></i> &nbsp; Información del funcionario</legend>
							<div class="container-fluid">
				    			<div class="row">
				    				<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<label class="control-label">Cargo *</label>
										  	<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="cargo-reg" required="" maxlength="30">
										</div>
				    				</div>
				    			</div>
				    		</div>
							<div class="container-fluid">
				    			<div class="row">
				    				<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<label class="control-label">Nombres *</label>
										  	<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="nombre-reg" required="" maxlength="30">
										</div>
				    				</div>
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Apellidos *</label>
										  	<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="apellido-reg" required="" maxlength="30">
										</div>
				    				</div>
				    			</div>
				    		</div>
							<div class="container-fluid">
								<div class="row">
									<div class="col-xs-12">
										<div class="form-group label-floating">
											<label class="control-label">Descripción de 500 caracterers (con espacios) *</label>
										  	<textarea name="descripcion-reg" class="form-control" rows="4" required="" maxlength="500"></textarea>
										</div>
				    				</div>
								</div>
							</div>
							<div class="col-xs-12">
		    					<div class="form-group">
									<span class="control-label">Imágen *</span>
									<input type="file" name="imagen-reg" accept=".jpg, .png, .jpeg" required="">
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