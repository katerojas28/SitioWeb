<?php
    $peticionAjax = true;
    require_once "../core/configGeneral.php";
    if(isset($_POST['codigo-up'])){
        require_once "../controladores/nosotrosControlador.php";
        $insNosotros= new nosotrosControlador();

        if(isset($_POST['codigo-up']) || isset($_POST['descripcion-up'])){
            echo $insNosotros->actualizar_nosotros_controlador();
        }
     
    }else{
        session_start(['name'=>'IELG']);
        session_destroy();
        echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
    }