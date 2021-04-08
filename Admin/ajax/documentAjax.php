<?php
    $peticionAjax = true;
    require_once "../core/configGeneral.php";
    if(isset($_POST['nombre-reg']) || isset($_POST['codigo-del'])  || isset($_POST['codigo-up'])){
        require_once "../controladores/documentControlador.php";
        $insDoc = new documentControlador();

        if(isset($_POST['nombre-reg'])){
            echo $insDoc->agregar_document_controlador();
        }
          if(isset($_POST['codigo-del'])){
            echo $insDoc->eliminar_document_controlador();
        }
    /*    if(isset($_POST['codigo-up']) || isset($_POST['nombre-up'])){
            echo $insDoc->actualizar_document_controlador();
        }
     */
    }else{
        session_start(['name'=>'IELG']);
        session_destroy();
        echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
    }