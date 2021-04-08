<?php

require_once "./controladores/nosotrosControlador.php";
$classNosotros= new nosotrosControlador();
$codigo=mainModel::encryption("NC0226874982");
$files=$classNosotros->datos_nosotros_controlador($codigo);
$rows=$files->fetch();

?>
<!--Contenido-->
    <section class="nosotros">
        <div class="contenedor-section">
        Esta en : <a href="<?php echo SERVERURL; ?>nosotros/">NUESTRO COLEGIO > </a><a href="<?php echo SERVERURL; ?>mision/"><?php echo $rows['NosotrosTitulo']?></a>
        </div>
        <div class="contenedor-section-nosotros">
            <h2><?php echo $rows['NosotrosTitulo']?></h2>
            <img src="data:<?php echo $rows['NosotrosTipImg'] ?>;base64,<?php echo base64_encode(stripslashes($rows['NosotrosImg']));?>" alt="nosotros" class="img-responsive">
            <p>    
            <?php echo $rows['NosotrosDescripcion']?>
            </p>
        </div>
    </section>
    <!--footer-->
	<?php include "./vistas/modulos/footer.php"; ?>

