<?php
    $peticionAjax = true;
    require_once "../core/configGeneral.php";
    if(isset($_POST['cargo-reg']) || isset($_POST['codigo-del']) || isset($_POST['codigo-up'])){
        require_once "../controladores/funcionarioControlador.php";
        $insFuncionario = new funcionarioControlador();

        if(isset($_POST['cargo-reg'])){
            echo $insFuncionario->agregar_funcionario_controlador();
        }

        if(isset($_POST['codigo-del'])){
            echo $insFuncionario->eliminar_funcionario_controlador();
        }
        if(isset($_POST['codigo-up']) || isset($_POST['descripcion-up'])){
            echo $insFuncionario->actualizar_funcionario_controlador();
        }
     
    }else{
        session_start(['name'=>'IELG']);
        session_destroy();
        echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
    }