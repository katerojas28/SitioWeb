<?php require_once "./vistas/modulos/banner.php";?>
<?php
	require_once "./controladores/documentosControlador.php";
	$classDoc = new documentosControlador();
	$filesA=$classDoc->datos_documentos_controlador();
	$campos=$filesA->fetchAll();				
	?>

<!--Contenido-->
<section class="general">
   <div class="contenedor-section">
       Esta en : <a href="<?php echo SERVERURL; ?>documentos/">DOCUMENTOS </a>
   </div>
   <div class="contenedor-section"  >
       <p align="center">
       <h2>DOCUMENTOS</h2><br>
            <?php foreach($campos as $campo):?>
           
           <h3 style="text-align: center;"><i class="fa fa-caret-right" aria-hidden="true"></i><?php echo $campo['DocTitulo'] ?></h3><br>

             <embed src="<?php echo  SERVERURL; ?>Admin/vistas/assets/documentos/<?php echo $campo['DocNomArchivo'] ?>" type="application/pdf" width="100%" height="400px" />
             <br><br><br><br>
            </div>
           <?php endforeach ?>
       </p>
   </div>
</section>

<?php require_once "./vistas/modulos/aside.php";?>
    <!--footer-->
	<?php include "./vistas/modulos/footer.php"; ?>

