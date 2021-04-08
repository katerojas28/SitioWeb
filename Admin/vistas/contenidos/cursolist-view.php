<div class="container-fluid">
			<div class="page-header">
			<h1 class="text-titles"><i class="zmdi zmdi-graduation-cap zmdi-hc-fw"></i> Administración <small>GRADOS</small></h1>
			</div>
			<p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse voluptas reiciendis tempora voluptatum eius porro ipsa quae voluptates officiis sapiente sunt dolorem, velit quos a qui nobis sed, dignissimos possimus!</p>
		</div>

		<div class="container-fluid">
			<ul class="breadcrumb breadcrumb-tabs">
			<li>
			  		<a href="<?php echo SERVERURL; ?>materia/" class="btn btn-info">
			  			<i class="zmdi zmdi-graduation-cap"></i> &nbsp; MATERIAS
			  		</a>
				  </li>
				  <li>
			  		<a href="<?php echo SERVERURL; ?>curso/" class="btn btn-primary">
			  			<i class="zmdi zmdi-plus"></i> &nbsp; NUEVO CONTENIDO
			  		</a>
			  	</li>
			  	<li>
			  		<a href="<?php echo SERVERURL; ?>cursolist/" class="btn btn-success">
			  			<i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE CONTENIDOS
			  		</a>
			  	</li>
			  	<li>
			  		<a href="<?php echo SERVERURL; ?>cursosearch/" class="btn btn-primary">
			  			<i class="zmdi zmdi-search"></i> &nbsp; BUSCAR CONTENIDOS
			  		</a>
			  	</li>
			</ul>
		</div> 


		<?php 
			require_once "./controladores/cursoControlador.php";
			$insCurso = new cursoControlador();
		?>
		
		<div class="container-fluid">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE CONTENIDOS</h3>
				</div>
				<div class="panel-body">
					<?php
						$pagina = explode("/",$_GET['views']);
						echo $insCurso-> paginador_curso_controlador($pagina[1], 10, $pagina[2],"");
					?>						
				</div>
			</div>
		</div>