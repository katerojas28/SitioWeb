<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";
    }

    class bannerModelo extends mainModel{

        protected function datos_banner_modelo(){
            $query=mainModel::conectar()->prepare("SELECT * FROM banner");
            $query->execute();
            return $query;
        }
    }