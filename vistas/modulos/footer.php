<?php

require_once "./controladores/footerControlador.php";
$classFooter= new footerControlador();

$files=$classFooter->datos_footer_controlador();
$rows=$files->fetch();

?>
<!--Footer de pagina-->
<footer>

<div class="contenedor-footer">
    <div class="logo-footer">
        <div class="logo">
            <img src="<?php echo SERVERURL; ?>vistas/assets/images/logo.png" height="50" width="50" />
        </div>
        <div>INSTITUCIÓN EDUCATIVA <br>LEÓN DE GREIFF</div>
    </div>

    <div class="content-foo">
        <h4>Telefono</h4>
        <p><?php echo $rows['InfoTelefono']?></p>
    </div>

    <div class="content-foo">
        <h4>E-mail</h4>
        <p><?php echo $rows['InfoEmail']?></p>
    </div>

    <div class="content-foo">
        <h4>Dirección</h4>
        <p><?php echo $rows['InfoDireccion']?></p>
    </div>

</div>
<div class="final">
    <h2 class="titulo-final">&copy; 2020 IE. LEÓN DE GREIFF Todos los derechos reservados | Diseñado y
        Desarrollado por Dennys K. Rojas O. </h2>
</div>

</footer>
