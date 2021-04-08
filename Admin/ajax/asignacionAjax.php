<?php
    $peticionAjax = true;
    require_once "../core/configGeneral.php";
    if(isset($_POST['nombre1-reg']) || isset($_POST['codigo-del'])  || isset($_POST['codigo-up'])){
        require_once "../controladores/asignacionControlador.php";
        $insAsig = new asignacionControlador();

        if(isset($_POST['nombre1-reg'])){
            echo $insAsig->agregar_asignacion_controlador();
        }
          if(isset($_POST['codigo-del'])){
            echo $insAsig->eliminar_asignacion_controlador();
        }
        if(isset($_POST['codigo-up']) || isset($_POST['titulo-up'])){
            echo $insAsig->actualizar_asignacion_controlador();
        }
     
    }else{
        session_start(['name'=>'IELG']);
        session_destroy();
        echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
    }