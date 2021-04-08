<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";
    }

    class cursoModelo extends mainModel{
        /*
        protected function agregar_norma_modelo($datos){
            $sql = mainModel::conectar()->prepare("INSERT INTO 
            normatividad (NormaCodigo, NormaTitulo, NormaDescripcion, NormaFecha, NormaHora,
            NormaNomArchivo, NormaTipArchivo, NormaTamArchivo, NormaCategoria) 
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

        protected function eliminar_norma_modelo($codigo){
            $query = mainModel::conectar()->prepare("DELETE FROM normatividad WHERE NormaCodigo=:Codigo");
            $query->bindParam(":Codigo",$codigo);
            $query->execute();
            return $query;
        }
*/
        protected function datos_norma_modelo($codigo){
            $query=mainModel::conectar()->prepare("SELECT * FROM normatividad WHERE NormaCodigo=:Codigo");
            $query->bindParam(":Codigo",$codigo);
            $query->execute();
            return $query;
        }

        protected function actualizar_norma_modelo($datos){
            $sql=mainModel::conectar()->prepare("UPDATE normatividad 
            SET NormaTitulo=:Titulo, NormaDescripcion=:Descripcion, NormaFecha=:Fecha, NormaHora=:Hora,
            NormaCategoria=:Categoria     	 
            WHERE NormaCodigo=:Codigo");
            $sql->bindParam(":Titulo",$datos['Titulo']);
            $sql->bindParam(":Descripcion",$datos['Descripcion']);
            $sql->bindParam(":Fecha",$datos['Fecha']);
            $sql->bindParam(":Hora",$datos['Hora']);
            $sql->bindParam(":Categoria",$datos['Categoria']);
            $sql->bindParam(":Codigo",$datos['Codigo']);
            $sql->execute();
            return $sql;
        }

       
    }