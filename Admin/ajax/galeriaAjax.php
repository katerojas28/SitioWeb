<?php
    $peticionAjax = true;
    require_once "../core/configGeneral.php";
    if(isset($_POST['titulo-reg']) || isset($_POST['codigo-del'])  || isset($_POST['codigo-up'])){
        require_once "../controladores/galeriaControlador.php";
        $insGaleria = new galeriaControlador();

        if(isset($_POST['titulo-reg'])){
            echo $insGaleria->agregar_galeria_controlador();
        }
          if(isset($_POST['codigo-del'])){
            echo $insGaleria->eliminar_galeria_controlador();
        }
            if(isset($_POST['codigo-up']) || isset($_POST['titulo-up'])){
            echo $insGaleria->actualizar_galeria_controlador();
        }
     
    }else{
        session_start(['name'=>'IELG']);
        session_destroy();
        echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
    }