<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";
    }

    class galeriaModelo extends mainModel{

        protected function datos_galeria_modelo(){
            $query=mainModel::conectar()->prepare("SELECT * FROM galeria");
            $query->execute();
            return $query;
        }
    }