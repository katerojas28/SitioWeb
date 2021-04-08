<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";
    }

    class galeriaModelo extends mainModel{
        protected function agregar_galeria_modelo($datos){
            $sql = mainModel::conectar()->prepare("INSERT INTO 
            galeria (GaleriaCodigo, GaleriaTitulo, GaleriaDescripcion, GaleriaFecha, GaleriaHora,
             GaleriaNomArchivo, GaleriaTipArchivo, GaleriaTamArchivo,GaleriaCategoria) 
            VALUES(:Codigo,:Titulo,:Descripcion,:Fecha,:Hora,:NomArchivo,:TipArchivo,:TamArchivo,:Categoria)");
            $sql->bindParam(":Codigo",$datos['Codigo']);
            $sql->bindParam(":Titulo",$datos['Titulo']);
            $sql->bindParam(":Descripcion",$datos['Descripcion']);
            $sql->bindParam(":Fecha",$datos['Fecha']);
            $sql->bindParam(":Hora",$datos['Hora']);
            $sql->bindParam(":NomArchivo",$datos['NomArchivo']);
            $sql->bindParam(":TipArchivo",$datos['TipArchivo']);
            $sql->bindParam(":TamArchivo",$datos['TamArchivo']);
            $sql->bindParam(":Categoria",$datos['Categoria']);
            $sql->execute();
            return $sql;
        }

        protected function eliminar_galeria_modelo($codigo){
            $query = mainModel::conectar()->prepare("DELETE FROM galeria WHERE GaleriaCodigo=:Codigo");
            $query->bindParam(":Codigo",$codigo);
            $query->execute();
            return $query;
        }

        protected function datos_galeria_modelo($codigo){
            $query=mainModel::conectar()->prepare("SELECT * FROM galeria WHERE GaleriaCodigo=:Codigo");
            $query->bindParam(":Codigo",$codigo);
            $query->execute();
            return $query;
        }

        protected function actualizar_galeria_modelo($datos){
            $sql=mainModel::conectar()->prepare("UPDATE galeria 
            SET GaleriaTitulo=:Titulo, GaleriaDescripcion=:Descripcion, GaleriaFecha=:Fecha, GaleriaHora=:Hora,
            GaleriaNomArchivo=:NomArchivo, GaleriaTipArchivo=:TipArchivo, GaleriaTamArchivo=:TamArchivo,
             GaleriaCategoria=:Categoria     	 
            WHERE GaleriaCodigo=:Codigo");
            $sql->bindParam(":Titulo",$datos['Titulo']);
            $sql->bindParam(":Descripcion",$datos['Descripcion']);
            $sql->bindParam(":Fecha",$datos['Fecha']);
            $sql->bindParam(":Hora",$datos['Hora']);
            $sql->bindParam(":NomArchivo",$datos['NomArchivo']);
            $sql->bindParam(":TipArchivo",$datos['TipArchivo']);
            $sql->bindParam(":TamArchivo",$datos['TamArchivo']);
            $sql->bindParam(":Categoria",$datos['Categoria']);
            $sql->bindParam(":Codigo",$datos['Codigo']);
            $sql->execute();
            return $sql;
        }
    }