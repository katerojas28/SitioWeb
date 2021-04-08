<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";
    }

    class funcionarioModelo extends mainModel{

        protected function datos_funcionario_modelo(){
            $query=mainModel::conectar()->prepare("SELECT * FROM funcionario");
            $query->execute();
            return $query;
        }
    }