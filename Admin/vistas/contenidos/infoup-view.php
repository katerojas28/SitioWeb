<div class="container-fluid">
			<div class="page-header">
			  <h1 class="text-titles"><i class="zmdi zmdi-info-outline zmdi-hc-fw"></i> INFORMACIÓN IELG</small></h1>
			</div>
			<p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse voluptas reiciendis tempora voluptatum eius porro ipsa quae voluptates officiis sapiente sunt dolorem, velit quos a qui nobis sed, dignissimos possimus!</p>
		</div>

		<!-- Panel mis datos -->
		<div class="container-fluid">

		<?php

			$datos=explode("/",$_GET['views']);

			
			//Administrador
			if($datos[1]=="admin"):
				require_once "./controladores/informacionControlador.php";
				$classInfo = new informacionControlador();

				$filesA=$classInfo->mostrar_datos_informacion_controlador($datos[2]);

				if($filesA->rowCount()==1){

					$campos=$filesA->fetch();

		?>


<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="zmdi zmdi-refresh"></i> &nbsp; ACTUALIZAR INFORMACIÓN</h3>
				</div>
				<div class="panel-body">
				<form action="<?php echo SERVERURL; ?>ajax/informacionAjax.php" method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
					<input type="hidden" name="cuenta-up" value="<?php echo $datos[2] ?>">
				    	<fieldset>
							<legend><i class="zmdi zmdi-facebook"></i>&nbsp;&nbsp;<i class="zmdi zmdi-twitter"></i>&nbsp;&nbsp;
							<i class="zmdi zmdi-email"></i>&nbsp;&nbsp;<i class="zmdi zmdi-phone"></i>&nbsp;&nbsp;<i class="zmdi zmdi-pin"></i></legend>
				    		<div class="container-fluid">
				    			<div class="row">
				    				<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<label class="control-label">Facebook *</label>
										  	<input class="form-control" type="text" name="facebook-up" value="<?php echo $campos['InfoFacebook'] ?>" required="" maxlength="100">
										</div>
									</div>
									<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<label class="control-label">Twitter *</label>
										  	<input class="form-control" type="text" name="twitter-up" value="<?php echo $campos['InfoTwitter'] ?>" required="" maxlength="100">
										</div>
									</div>
									<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<label class="control-label">E-mail *</label>
										  	<input class="form-control" type="text" name="email-up" value="<?php echo $campos['InfoEmail'] ?>" required="" maxlength="100">
										</div>
				    				</div>
				    				
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Teléfono</label>
										  	<input pattern="[0-9+]{1,15}" class="form-control" type="text" name="telefono-up" value="<?php echo $campos['InfoTelefono'] ?>" maxlength="15">
										</div>
				    				</div>
				    				<div class="col-xs-12">
										<div class="form-group label-floating">
										  	<label class="control-label">Dirección</label>
										  	<textarea name="direccion-up" class="form-control" rows="2" maxlength="100"><?php echo $campos['InfoDireccion'] ?></textarea>
										</div>
				    				</div>
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