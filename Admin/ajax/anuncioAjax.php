<?php
    $peticionAjax = true;
    require_once "../core/configGeneral.php";
    if(isset($_POST['titulo-reg']) || isset($_POST['codigo-del'])){
        require_once "../controladores/anuncioControlador.php";
        $insAnuncio = new anuncioControlador();

        if(isset($_POST['cuenta-reg']) && isset($_POST['titulo-reg']) && isset($_POST['descripcion-reg'])){
            echo $insAnuncio->agregar_anuncio_controlador();
        }
        if(isset($_POST['codigo-del']) || isset($_POST['privilegio-admin'])){
            echo $insAnuncio->eliminar_anuncio_controlador();
        }
    }else{
        session_start(['name'=>'IELG']);
        session_destroy();
        echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
    }