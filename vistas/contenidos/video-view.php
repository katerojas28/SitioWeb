
  <section class="galeria">
    <div class="contenedor-sectio">
    Esta en : <a href="<?php echo SERVERURL; ?>galeria/">GALERIA > </a><a href="">VIDEOS </a>
    </div>
    <br>
    <h2>VIDEOS</h2>

    <?php 
			require_once "./controladores/galeriaControlador.php";
			$insGaleria = new galeriaControlador();
		?>


            <?php
      $pagina = explode("/",$_GET['views']);
      $codigo="Videos";
      $referencia="video";
			echo $insGaleria-> paginador_video_controlador($pagina[1], 9,$codigo,$referencia);
			?>	
  </section>

     <!--footer-->
     <?php include "./vistas/modulos/footer.php"; ?>