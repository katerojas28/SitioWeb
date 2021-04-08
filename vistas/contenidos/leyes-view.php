<!--Contenido-->
<section class="normatividad">
        <div class="contenedor-sectio">
        Esta en : <a href="<?php echo SERVERURL; ?>normatividad/">NORMATIVIDAD > </a><a href="">LEYES </a>
        </div>
        <BR>
        <h2>LEYES</h2>


        <?php 
			require_once "./controladores/normatividadControlador.php";
			$insNorma = new normatividadControlador();
		?>


            <?php
      $pagina = explode("/",$_GET['views']);
      $codigo="Leyes";
      $referencia="leyes";
			echo $insNorma-> paginador_normatividad_controlador($pagina[1], 2,$codigo,$referencia);
			?>	


    </section>

    <!--footer-->
    <?php include "./vistas/modulos/footer.php"; ?>