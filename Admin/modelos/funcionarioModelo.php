<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";
    }

    class funcionarioModelo extends mainModel{
        protected function agregar_funcionario_modelo($datos){
            $sql = mainModel::conectar()->prepare("INSERT INTO 
            funcionario (FunCodigo, FunCargo, FunNombre, FunApellido, 
            FunDescripcion, FunFoto, FunNomFoto, FunTipFoto) 
            VALUES(:Codigo,:Cargo,:Nombre,:Apellido,:Descripcion,
            :Foto,:NomFoto,:TipFoto)");
            $sql->bindParam(":Codigo",$datos['Codigo']);
            $sql->bindParam(":Cargo",$datos['Cargo']);
            $sql->bindParam(":Nombre",$datos['Nombre']);
            $sql->bindParam(":Apellido",$datos['Apellido']);
            $sql->bindParam(":Descripcion",$datos['Descripcion']);            
            $sql->bindParam(":Foto",$datos['Foto']);
            $sql->bindParam(":NomFoto",$datos['NomFoto']);
            $sql->bindParam(":TipFoto",$datos['TipFoto']);
            $sql->execute();
            return $sql;
        }

        protected function eliminar_funcionario_modelo($codigo){
            $query = mainModel::conectar()->prepare("DELETE FROM funcionario WHERE FunCodigo=:Codigo");
            $query->bindParam(":Codigo",$codigo);
            $query->execute();
            return $query;
        }

        protected function datos_funcionario_modelo($codigo){
            $query=mainModel::conectar()->prepare("SELECT * FROM funcionario WHERE FunCodigo=:Codigo");
            $query->bindParam(":Codigo",$codigo);
            $query->execute();
            return $query;
        }

        protected function actualizar_funcionario_modelo($datos){
            $sql=mainModel::conectar()->prepare("UPDATE funcionario SET FunCodigo=:Codigo,
            FunCargo=:Cargo,FunNombre=:Nombre,FunApellido=:Apellido,
            FunDescripcion=:Descripcion,FunFoto=:Foto,FunNomFoto=:NomFoto,
            FunTipFoto=:TipFoto WHERE FunCodigo=:Codigo");
           $sql->bindParam(":Codigo",$datos['Codigo']);
           $sql->bindParam(":Cargo",$datos['Cargo']);
           $sql->bindParam(":Nombre",$datos['Nombre']);
           $sql->bindParam(":Apellido",$datos['Apellido']);
           $sql->bindParam(":Descripcion",$datos['Descripcion']);            
           $sql->bindParam(":Foto",$datos['Foto']);
           $sql->bindParam(":NomFoto",$datos['NomFoto']);
           $sql->bindParam(":TipFoto",$datos['TipFoto']);
           $sql->execute();
           return $sql;
        }
    }