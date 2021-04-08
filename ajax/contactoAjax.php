<?php
    $peticionAjax = true;
    require_once "../core/configGeneral.php";
    
    if(isset($_POST['nombre-reg'])){
        require_once "../controladores/contactoControlador.php";
        $insContacto = new contactoControlador();

        if(isset($_POST['nombre-reg']) && isset($_POST['email-reg']) && isset($_POST['asunto-reg'])){
            echo $insContacto->agregar_mensaje_controlador();
        }

    }else{
        session_start(['name'=>'IELG']);
        session_destroy();
        echo '<script> window.location.href="'.SERVERURL.'contacto/" </script>';
    }
    

        


   