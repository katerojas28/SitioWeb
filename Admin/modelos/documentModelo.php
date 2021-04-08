<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";
    }

    class documentModelo extends mainModel{
        protected function agregar_document_modelo($datos){
            $sql = mainModel::conectar()->prepare("INSERT INTO 
            documento (DocCodigo, DocTitulo, DocNomArchivo, DocTipArchivo,DocFecha) 
            VALUES(:Codigo,:Titulo,:NomArchivo,:TipArchivo,:Fecha)");
            $sql->bindParam(":Codigo",$datos['Codigo']);
            $sql->bindParam(":Titulo",$datos['Titulo']);
            $sql->bindParam(":NomArchivo",$datos['NomArchivo']);
            $sql->bindParam(":TipArchivo",$datos['TipArchivo']);
            $sql->bindParam(":Fecha",$datos['Fecha']);
            $sql->execute();
            return $sql;
        }

        protected function eliminar_document_modelo($codigo){
            $query = mainModel::conectar()->prepare("DELETE FROM documento WHERE DocCodigo=:Codigo");
            $query->bindParam(":Codigo",$codigo);
            $query->execute();
            return $query;
        }

        protected function datos_document_modelo($codigo){
            $query=mainModel::conectar()->prepare("SELECT * FROM documento WHERE DocCodigo=:Codigo");
            $query->bindParam(":Codigo",$codigo);
            $query->execute();
            return $query;
        }

        protected function actualizar_document_modelo($datos){
            $sql=mainModel::conectar()->prepare("UPDATE documento 
            SET DocTitulo=:Titulo, DocNomArchivo=:NomArchivo, DocTipArchivo=:TipArchivo, DocFecha=:Fecha 
            WHERE DocCodigo=:Codigo");
            $sql->bindParam(":Titulo",$datos['Titulo']);
            $sql->bindParam(":NomArchivo",$datos['NomArchivo']);
            $sql->bindParam(":TipArchivo",$datos['TipArchivo']);
            $sql->bindParam(":Fecha",$datos['Fecha']);
            $sql->bindParam(":Codigo",$datos['Codigo']);
            $sql->execute();
            return $sql;
        }
    }