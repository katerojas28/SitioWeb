<?php
    $peticionAjax = true;
    require_once "../core/configGeneral.php";
    if(isset($_POST['codigo-del'])){
        require_once "../controladores/mensajeControlador.php";
        $insMensaje = new mensajeControlador();

        if(isset($_POST['codigo-del'])){
            echo $insMensaje->eliminar_mensaje_controlador();
        }
     
    }else{
        session_start(['name'=>'IELG']);
        session_destroy();
        echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
    }