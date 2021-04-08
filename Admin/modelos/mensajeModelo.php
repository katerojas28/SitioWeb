<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";
    }

    class mensajeModelo extends mainModel{
        protected function eliminar_mensaje_modelo($codigo){
            $query = mainModel::conectar()->prepare("DELETE FROM mensaje WHERE MensajeCodigo=:Codigo");
            $query->bindParam(":Codigo",$codigo);
            $query->execute();
            return $query;
        }

        protected function datos_mensaje_modelo($codigo){
            $query=mainModel::conectar()->prepare("SELECT * FROM mensaje WHERE MensajeCodigo=:Codigo");
            $query->bindParam(":Codigo",$codigo);
            $query->execute();
            return $query;
        }
    }