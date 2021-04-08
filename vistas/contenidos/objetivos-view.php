<?php

require_once "./controladores/nosotrosControlador.php";
$classNosotros= new nosotrosControlador();
$codigo=mainModel::encryption("NC0413017013");
$files=$classNosotros->datos_nosotros_controlador($codigo);
$rows=$files->fetch();

$codigo1=mainModel::encryption("NC0413017014");
$files1=$classNosotros->datos_nosotros_controlador($codigo1);
$rows1=$files1->fetch();

?>
<!--Contenido-->
    <section class="nosotros">
        <div class="contenedor-section">
        Esta en : <a href="<?php echo SERVERURL; ?>nosotros/">NUESTRO COLEGIO > </a><a href="<?php echo SERVERURL; ?>objetivos/">OBJETIVOS</a>
        </div>
        <div class="contenedor-section-nosotros">
            <h2>OBJETIVOS</h2>
            <img src="data:<?php echo $rows['NosotrosTipImg'] ?>;base64,<?php echo base64_encode(stripslashes($rows['NosotrosImg']));?>" alt="nosotros" class="img-responsive">
            <p>
            <h4><?php echo $rows['NosotrosTitulo']?></h4><br>    
            <?php echo $rows['NosotrosDescripcion']?>
            </p>
            <br>
            <p>
            <h4><?php echo $rows1['NosotrosTitulo']?></h4><br>    
            <?php echo $rows1['NosotrosDescripcion']?>
            </p>
        </div>
    </section>
    <!--footer-->
	<?php include "./vistas/modulos/footer.php"; ?>

