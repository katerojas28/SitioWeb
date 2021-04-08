<?php
    $peticionAjax = true;
    require_once "../core/configGeneral.php";
    if(isset($_POST['titulo-pub']) || isset($_POST['codigo-del']) || isset($_POST['codigo-up'])){
        require_once "../controladores/publicacionControlador.php";
        $insPublicacion = new publicacionControlador();

        if(isset($_POST['titulo-pub'])){
            echo $insPublicacion->agregar_publicacion_controlador();
        }

        if(isset($_POST['codigo-del'])){
            echo $insPublicacion->eliminar_publicacion_controlador();
        }
        if(isset($_POST['codigo-up']) || isset($_POST['descripcion-up'])){
            echo $insPublicacion->actualizar_publicacion_controlador();
        }
     
    }else{
        session_start(['name'=>'IELG']);
        session_destroy();
        echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
    }