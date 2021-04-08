<?php
    $peticionAjax = true;
    require_once "../core/configGeneral.php";
    if(isset($_POST['facebook-up'])){
        require_once "../controladores/informacionControlador.php";
        $insInformacion = new informacionControlador();

        if(isset($_POST['facebook-up'])){
            echo $insInformacion->actualizar_informacion_controlador();
        }
     
    }else{
        session_start(['name'=>'IELG']);
        session_destroy();
        echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
    }