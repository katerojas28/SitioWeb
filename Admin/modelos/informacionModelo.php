<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";
    }

    class informacionModelo extends mainModel{
        protected function actualizar_informacion_modelo($datos){
            $query=mainModel::conectar()->prepare("UPDATE informacion SET InfoFacebook=:Facebook, InfoTwitter=:Twitter,
            InfoEmail=:Email, InfoTelefono=:Telefono, InfoDireccion=:Direccion WHERE id=:Codigo");
            $query->bindParam(":Facebook",$datos['Facebook']);
            $query->bindParam(":Twitter",$datos['Twitter']);
            $query->bindParam(":Email",$datos['Email']);
            $query->bindParam(":Telefono",$datos['Telefono']);
            $query->bindParam(":Direccion",$datos['Direccion']);
            $query->bindParam(":Codigo",$datos['Codigo']);
            $query->execute();
           return $query;      
        }

        protected function datos_informacion_modelo($codigo){
            $query=mainModel::conectar()->prepare("SELECT * FROM informacion WHERE id=:Codigo");
            $query->bindParam(":Codigo",$codigo);
            $query->execute();
            return $query;
        }
    }