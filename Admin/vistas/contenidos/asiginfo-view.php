<div class="container-fluid">
	<div class="page-header">
	<h1 class="text-titles"><i class="zmdi zmdi-book zmdi-hc-fw"></i> Configuraciones <small>MATERIAS</small></h1>
			</div>
			<p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse voluptas reiciendis tempora voluptatum eius porro ipsa quae voluptates officiis sapiente sunt dolorem, velit quos a qui nobis sed, dignissimos possimus!</p>
		</div>

		<div class="container-fluid">
			<ul class="breadcrumb breadcrumb-tabs">
				<li>
			  		<a href="<?php echo SERVERURL; ?>asig/" class="btn btn-info">
			  			<i class="zmdi zmdi-plus"></i> &nbsp; NUEVA MATERIA
			  		</a>
			  	</li>
			  	<li>
			  		<a href="<?php echo SERVERURL; ?>asiglist/" class="btn btn-success">
			  			<i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE MATERIAS
			  		</a>
			  	</li>
			  	<li>
			  		<a href="<?php echo SERVERURL; ?>asigsearch/" class="btn btn-primary">
			  			<i class="zmdi zmdi-search"></i> &nbsp; BUSCAR MATERIA
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
			require_once "./controladores/asignacionControlador.php";
			$classAsig = new asignacionControlador();
			$filesA=$classAsig->datos_asignacion_controlador($datos[2]);
				if($filesA->rowCount()==1){
					$campos=$filesA->fetch();	
								
	?>


<div class="panel panel-success">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="zmdi zmdi-refresh"></i> &nbsp; ACTUALIZAR MATERIA</h3>
	</div>
	<div class="panel-body">
		<form action="<?php echo SERVERURL; ?>ajax/asignacionAjax.php" method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
		<input type="hidden" name="codigo-up" value="<?php echo $datos[2] ?>">
		<fieldset>
		<div class="container-fluid">
						<div class="row">
							<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
									<label class="control-label">Nombre de la materia *</label>
									<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ-0-9]{1,90}" class="form-control" type="text" name="nombre-up" value="<?php echo $campos['AsigNombreMateria'] ?>" required="" maxlength="60">
								</div>
							</div>
							<div class="col-xs-12 col-sm-3">
								<div class="form-group label-floating">
								<label class="control-label">Curso</label>
								<select name="optionsAsig-up" class="form-control" require="">
										<option value="<?php echo ($campos['AsigNombreCurso']) ?>"><?php echo $campos['AsigNombreCurso'] ?> (Actual)</option>							
										<option value="Kinder">Kinder</option>
										  <option value="Primero">Primero</option>
										  <option value="Segundo">Segundo</option>
										  <option value="Tercero">Tercero</option>
										  <option value="Cuarto">Cuarto</option>
										  <option value="Quinto">Quinto</option>
										  <option value="Sexto">Sexto</option>
										  <option value="Septimo">Septimo</option>
										  <option value="Octavo">Octavo</option>
										  <option value="Noveno">Noveno</option>
										  <option value="Decimo">Decimo</option>
										  <option value="Once">Once</option>
									</select>
								</div>
							</div>	
							
							<?php

require_once "./controladores/administradorControlador.php";
$classAdmin = new administradorControlador();

$files=$classAdmin->datos_Aadministrador_controlador("Conteo2");
$res=$files->fetchAll();

?>
							<div class="col-xs-12 col-sm-3">
								<div class="form-group label-floating">
								  	<select name="optionsDoc-up" class="form-control" require="">
										<option value="<?php echo $lc->encryption($campos['CuentaCodigo']) ?>"><?php echo $campos['AdminNombre'] ?> <?php echo $campos['AdminApellido'] ?> (Actual)</option>							
										<?php
										foreach($res as $rows):
										?>
										<option value="<?php echo $lc->encryption($rows['CuentaCodigo']) ?>"><?php echo $rows['AdminNombre'] ?> <?php echo $rows['AdminApellido'] ?></option>
										<?php endforeach ?>	
									</select>
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
        <p class="lead text-center">No podemos usted no tiene permiso ára visualizar esta información</p>
    </div>
</div>
	<?php endif; ?>			
</div>