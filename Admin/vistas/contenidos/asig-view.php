<?php
if($_SESSION['privilegio_ielg']!="1"){
	echo $lc->forzar_cierre_controlador();
}
?>
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

		<?php

require_once "./controladores/administradorControlador.php";
$classAdmin = new administradorControlador();

$filesA=$classAdmin->datos_Aadministrador_controlador("Conteo2");
$campos=$filesA->fetchAll();

?>
		<div class="container-fluid">

			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="zmdi zmdi-plus"></i> &nbsp; NUEVA MATERIA</h3>
				</div>
				<div class="panel-body">
				<form action="<?php echo SERVERURL; ?>ajax/asignacionAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
				<fieldset>
				<legend><i class="zmdi zmdi-border-color"></i> &nbsp; Información del la materia</legend>


					<div class="container-fluid">
						<div class="row">
							<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
									<label class="control-label">Nombre de la materia *</label>
									<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ-0-9]{1,90}" class="form-control" type="text" name="nombre1-reg" required="" maxlength="60">
								</div>
							</div>
							<div class="col-xs-12 col-sm-3">
								<div class="form-group label-floating">
								  	<select name="optionsAsig1" class="form-control" require="">
									  <option value="">Selecione un curso *</option>
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
							

							<div class="col-xs-12 col-sm-3">
								<div class="form-group label-floating">
								  	<select name="optionsDoc1" class="form-control" require="">
									  <option value="">Selecione un curso *</option>
										<?php
										foreach($campos as $rows):
										?>
										<option value="<?php echo $lc->encryption($rows['CuentaCodigo']) ?>"><?php echo $rows['AdminNombre'] ?> <?php echo $rows['AdminApellido'] ?></option>
										<?php endforeach ?>									
							        </select>
								</div>
		    				</div>							
						</div>



						<div class="row">
							<div class="col-xs-12 col-sm-6">
								<div class="form-group label-floating">
									<label class="control-label">Nombre de la materia *</label>
									<input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ-0-9]{1,90}" class="form-control" type="text" name="nombre2-reg"  maxlength="60">
								</div>
							</div>
							<div class="col-xs-12 col-sm-3">
								<div class="form-group label-floating">
								  	<select name="optionsAsig2" class="form-control" >
									  <option value="">Selecione un curso *</option>
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
							<div class="col-xs-12 col-sm-3">
								<div class="form-group label-floating">
								  	<select name="optionsDoc2" class="form-control" >
									  <option value="">Selecione un docente *</option>
										<?php
										foreach($campos as $rows):
										?>
										<option value="<?php echo $lc->encryption ($rows['CuentaCodigo']) ?>"><?php echo $rows['AdminNombre'] ?> <?php echo $rows['AdminApellido'] ?></option>
										<?php endforeach ?>									
							        </select>
								</div>
		    				</div>							
						</div>							
						</div>


					</div>
			</fieldset>

					    <p class="text-center" style="margin-top: 20px;">
					    	<button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i> Guardar</button>
						</p>
						<div class="RespuestaAjax"></div>
						<br>
				    </form>
				</div>
			</div>
		</div>