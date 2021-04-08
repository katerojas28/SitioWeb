    <?php 
        require_once "./vistas/modulos/banner.php";
    ?>
 
  
    <!--Contenido-->
    <section class="general">
        <div class="contenedor-section">
        Esta en : <a href="">Inicio </a>
        </div>
        <?php 
			require_once "./controladores/homeControlador.php";
			$insHome = new homeControlador();
		?>


            <?php
            $pagina = explode("/",$_GET['views']);
                echo $insHome-> paginador_home_controlador($pagina[1], 2,);
         
			
			
			?>	


    </section>

    <?php 
        require_once "./vistas/modulos/aside.php";
    ?>
    
<!--footer-->

	<?php include "./vistas/modulos/footer.php"; ?>

