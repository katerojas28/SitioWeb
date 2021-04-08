<?php require_once "./vistas/modulos/banner.php";?>
    <!--Contenido-->
    <section class="general">
        <div class="contenedor-section">
            Esta en : <a href="">GALERIA </a>
        </div>
        <div class="contenedor-section" style="text-align: center;">
            <p>
                <h2>GALERIA</h2><br>
                <i class="fa fa-caret-right" aria-hidden="true"></i><a href="<?php echo SERVERURL; ?>imagen/"> Imagenes</a><br><br>
                <i class="fa fa-caret-right" aria-hidden="true"></i><a href="<?php echo SERVERURL; ?>video/"> Videos</a><br><br>
                <i class="fa fa-caret-right" aria-hidden="true"></i><a href="<?php echo SERVERURL; ?>audio/"> Audios</a><br><br>
            </p>
        </div>
    </section>

    <?php require_once "./vistas/modulos/aside.php";?>
    <!--footer-->
	<?php include "./vistas/modulos/footer.php"; ?>