<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";
    }

    class documentosModelo extends mainModel{

        protected function datos_documentos_modelo(){
            $query=mainModel::conectar()->prepare("SELECT * FROM documento");
            $query->execute();
            return $query;
        }
    }