<?php
    $peticionAjax = true;
    require_once "../core/configGeneral.php";
    if(isset($_POST['titulo-reg']) || isset($_POST['codigo-del'])  || isset($_POST['codigo-up'])){
        require_once "../controladores/normativaControlador.php";
        $insNorma = new normativaControlador();

        if(isset($_POST['titulo-reg'])){
            echo $insNorma->agregar_norma_controlador();
        }
          if(isset($_POST['codigo-del'])){
            echo $insNorma->eliminar_norma_controlador();
        }
            if(isset($_POST['codigo-up']) || isset($_POST['titulo-up'])){
            echo $insNorma->actualizar_norma_controlador();
        }
     
    }else{
        session_start(['name'=>'IELG']);
        session_destroy();
        echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
    }