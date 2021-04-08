<?php require_once "./vistas/modulos/banner.php";?>

<!--Contenido-->
<section class="general">
   <div class="contenedor-section">
       Esta en : <a href="<?php echo SERVERURL; ?>normatividad/">NORMATIVIDAD </a>
   </div>
   <div class="contenedor-section" style="text-align: center;">
       <p align="center">
       <h2>NORMATIVIDAD</h2><br>
                <i class="fa fa-caret-right" aria-hidden="true"></i><a href="<?php echo SERVERURL; ?>circular/"> Circulares</a><br><br>
                <i class="fa fa-caret-right" aria-hidden="true"></i><a href="<?php echo SERVERURL; ?>leyes/"> Leyes</a><br><br>
                <i class="fa fa-caret-right" aria-hidden="true"></i><a href="<?php echo SERVERURL; ?>resolucion/"> Resoluciones</a><br><br>
                <i class="fa fa-caret-right" aria-hidden="true"></i><a href="<?php echo SERVERURL; ?>decreto/"> Decretos</a><br><br>
            </p>
        </div>
    </section>
    <?php require_once "./vistas/modulos/aside.php";?>
   <!--footer-->
   <?php include "./vistas/modulos/footer.php"; ?>