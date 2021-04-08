<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";
    }

    class nosotrosModelo extends mainModel{

        protected function datos_nosotros_modelo($codigo){
            $query=mainModel::conectar()->prepare("SELECT * FROM nosotros WHERE NosotrosCodigo=:Codigo ");
            $query->bindParam(":Codigo",$codigo);
            $query->execute();
            return $query;
        }
    }