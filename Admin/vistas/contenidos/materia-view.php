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
				<?php if($_SESSION['privilegio_ielg']=="1"){ ?>
				<li>
			  		<a href="<?php echo SERVERURL; ?>cursossearch/" class="btn btn-warning">
			  			<i class="zmdi zmdi-search"></i> &nbsp; BUSCAR MATERIA
			  		</a>
				  </li>
				<?php }?>
			  
			</ul>
		</div>  

<?php 
			require_once "./controladores/cursoControlador.php";
			$insCur= new cursoControlador();
		?>

			

	<div class="container-fluid">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; MATERIAS</h3>
				</div>
				<div class="panel-body">
					<?php
					if($_SESSION['privilegio_ielg']=="1"){
						$pagina = explode("/",$_GET['views']);
						echo $insCur-> paginador_materias_controlador($pagina[1], 12,"Unico");
					}else{
						$pagina = explode("/",$_GET['views']);
						echo $insCur-> paginador_materias_controlador($pagina[1], 12,$_SESSION['codigo_cuenta_ielg']);
					}
						
					?>						
				</div>
			</div>
		</div>