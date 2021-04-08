<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";
    }

    class asignacionModelo extends mainModel{
        protected function agregar_asignacion_modelo($datos){
            $sql = mainModel::conectar()->prepare("INSERT INTO 
            asignacion (AsigCodigo, AsigNombreCurso, AsigNombreMateria, CuentaCodigo) 
            VALUES(:Codigo, :NombreCurso, :NombreMateria, :Cuenta)");
            $sql->bindParam(":Codigo",$datos['Codigo']);
            $sql->bindParam(":NombreCurso",$datos['NombreCurso']);
            $sql->bindParam(":NombreMateria",$datos['NombreMateria']);
            $sql->bindParam(":Cuenta",$datos['Cuenta']);
            $sql->execute();
            return $sql;
        }

        protected function eliminar_asignacion_modelo($codigo){
            $query = mainModel::conectar()->prepare("DELETE FROM asignacion WHERE AsigCodigo=:Codigo");
            $query->bindParam(":Codigo",$codigo);
            $query->execute();
            return $query;
        }

        protected function datos_asignacion_modelo($codigo){
            $query=mainModel::conectar()->prepare("SELECT * FROM asignacion, admin WHERE (AsigCodigo=:Codigo) AND (admin.CuentaCodigo = asignacion.CuentaCodigo)");
            $query->bindParam(":Codigo",$codigo);
            $query->execute();
            return $query;
        }

        protected function actualizar_asignacion_modelo($datos){
            $sql=mainModel::conectar()->prepare("UPDATE asignacion 
            SET AsigNombreCurso = :NombreCurso, AsigNombreMateria = :NombreMateria, CuentaCodigo = :Cuenta    	 
            WHERE AsigCodigo=:Codigo");
            $sql->bindParam(":NombreCurso",$datos['NombreCurso']);
            $sql->bindParam(":NombreMateria",$datos['NombreMateria']);
            $sql->bindParam(":Cuenta",$datos['Cuenta']);
            $sql->bindParam(":Codigo",$datos['Codigo']);
            $sql->execute();
            return $sql;
        }
    }