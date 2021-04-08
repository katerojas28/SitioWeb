<?php
    $peticionAjax = true;
    require_once "../core/configGeneral.php";
    if(isset($_POST['descripcion-banner']) || isset($_POST['codigo-del'])  || isset($_POST['codigo-up'])){
        require_once "../controladores/bannerControlador.php";
        $insBanner = new bannerControlador();

        if(isset($_POST['descripcion-banner'])){
            echo $insBanner->agregar_banner_controlador();
        }
        if(isset($_POST['codigo-del'])){
            echo $insBanner->eliminar_banner_controlador();
        }

        if(isset($_POST['codigo-up']) || isset($_POST['descripcion-up'])){
            echo $insBanner->actualizar_banner_controlador();
        }
     
    }else{
        session_start(['name'=>'IELG']);
        session_destroy();
        echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
    }