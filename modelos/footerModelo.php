<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";
    }

    class footerModelo extends mainModel{

        protected function datos_footer_modelo(){
            $query=mainModel::conectar()->prepare("SELECT * FROM informacion");
            $query->execute();
            return $query;
        }
    }