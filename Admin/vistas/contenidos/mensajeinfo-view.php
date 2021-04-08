<div class="container-fluid">
			<div class="page-header">
			<h1 class="text-titles"><i class="zmdi zmdi-email"></i></i> Mensajes</h1>
			</div>
			<p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse voluptas reiciendis tempora voluptatum eius porro ipsa quae voluptates officiis sapiente sunt dolorem, velit quos a qui nobis sed, dignissimos possimus!</p>
		</div>


		<div class="container-fluid">
			<ul class="breadcrumb breadcrumb-tabs">
			  	<li>
			  		<a href="<?php echo SERVERURL; ?>mensajelist/" class="btn btn-success">
			  			<i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE MENSAJES
			  		</a>
			  	</li>
			  	<li>
			  		<a href="<?php echo SERVERURL; ?>mensajesearch/" class="btn btn-primary">
			  			<i class="zmdi zmdi-search"></i> &nbsp; BUSCAR MENSAJES
			  		</a>
			  	</li>
			</ul>
		</div>

	
		<div class="container-fluid">

		<?php

			$datos=explode("/",$_GET['views']);

			
			//Administrador
			if($datos[1]=="admin"):
				require_once "./controladores/mensajeControlador.php";
				$classMensaje = new mensajeControlador();

				$filesA=$classMensaje->datos_mensaje_controlador($datos[2]);

				if($filesA->rowCount()==1){

					$campos=$filesA->fetch();

		?>


<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="zmdi zmdi-email-open"></i> &nbsp; INFORMACIÓN DEL MENSAJE</h3>
				</div>
				<div class="panel-body">
				<form>
					<input type="hidden" name="cuenta-up" value="<?php echo $datos[2] ?>">
				    	<fieldset>
							
				    		<div class="container-fluid">
				    			<div class="row">
				    				<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<label class="control-label">Nombre</label>
										  	<legend><?php echo $campos['MensajeNombre'] ?></legend>
										</div>
									</div>
									<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<label class="control-label">Asunto</label>
										  	<legend><?php echo $campos['MensajeAsunto'] ?></legend>
										</div>
									</div>
									<div class="col-xs-12 col-sm-6">
								    	<div class="form-group label-floating">
										  	<label class="control-label">E-mail *</label>
										  	<legend><?php echo $campos['MensajeEmail'] ?></legend>
										</div>
				    				</div>
				    				
				    				<div class="col-xs-12 col-sm-6">
										<div class="form-group label-floating">
										  	<label class="control-label">Teléfono</label>
											  <legend><?php echo $campos['MensajeTelefono'] ?></legend>
										</div>
				    				</div>
				    				<div class="col-xs-12">
										<div class="form-group label-floating">
										  	<label class="control-label">Mensaje</label>
										  	<textarea class="form-control" rows="8" readonly=""><?php echo $campos['MensajeDescripcion'] ?></textarea>
										</div>
									</div>
									<div class="col-xs-12">
										<div class="form-group label-floating">
										  <label class="control-label"><i class="zmdi zmdi-calendar"></i>&nbsp;&nbsp; <?php echo $campos['MensajeFecha'] ?></label>
										</div>
									</div>
									<div class="col-xs-12">
										<div class="form-group label-floating">
											  <label class="control-label"><i class="zmdi zmdi-time"></i>&nbsp;&nbsp;  <?php echo $campos['MensajeHora'] ?></label>
										</div>
				    				</div>
				    			</div>
				    		</div>
				    	</fieldset>
					    <p class="text-center" style="margin-top: 20px;">
					    	<button type="submit" class="btn btn-success btn-raised btn-sm"><b>  <a style="color:white; text-decoration: none;" href="<?php echo SERVERURL; ?>mensajelist/" > Volver <i class="zmdi zmdi-arrow-right"></i></a></b></button>
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