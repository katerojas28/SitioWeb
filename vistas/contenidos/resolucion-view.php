<!--Contenido-->
<section class="normatividad">
        <div class="contenedor-sectio">
        Esta en : <a href="<?php echo SERVERURL; ?>normatividad/">NORMATIVIDAD > </a><a href="">RESOLUCIONES </a>
        </div>
        <BR>
        <h2>RESOLUCIONES</h2>


      <?php 
	      require_once "./controladores/normatividadControlador.php";
		$insNorma = new normatividadControlador();
	?>


      <?php
      $pagina = explode("/",$_GET['views']);
      $codigo="Resoluciones";
      $referencia="resolucion";
      echo $insNorma-> paginador_normatividad_controlador($pagina[1], 2,$codigo,$referencia);
      		
      ?>



</section>



    <!--footer-->
    <?php include "./vistas/modulos/footer.php"; ?>