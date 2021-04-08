<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";
    }

    class publicacionModelo extends mainModel{
        protected function agregar_publicacion_modelo($datos){
            $sql = mainModel::conectar()->prepare("INSERT INTO 
            publicacion ( PubCodigo,PubTitulo,PubDescripcion,PubFecha,PubHora,PubImag, PubNomImg, PubTipImg) 
            VALUES(:Codigo,:Titulo,:Descripcion,:Fecha,:Hora,:Foto,:NomFoto,:TipFoto)");
            $sql->bindParam(":Codigo",$datos['Codigo']);
            $sql->bindParam(":Titulo",$datos['Titulo']);
            $sql->bindParam(":Descripcion",$datos['Descripcion']);
            $sql->bindParam(":Fecha",$datos['Fecha']);
            $sql->bindParam(":Hora",$datos['Hora']);
            $sql->bindParam(":Foto",$datos['Foto']);
            $sql->bindParam(":NomFoto",$datos['NomFoto']);
            $sql->bindParam(":TipFoto",$datos['TipFoto']);
            $sql->execute();
            return $sql;
        }

        protected function eliminar_publicacion_modelo($codigo){
            $query = mainModel::conectar()->prepare("DELETE FROM publicacion WHERE PubCodigo=:Codigo");
            $query->bindParam(":Codigo",$codigo);
            $query->execute();
            return $query;
        }

        protected function datos_publicacion_modelo($codigo){
            $query=mainModel::conectar()->prepare("SELECT * FROM publicacion WHERE PubCodigo=:Codigo");
            $query->bindParam(":Codigo",$codigo);
            $query->execute();
            return $query;
        }

        protected function actualizar_publicacion_modelo($datos){
            $query=mainModel::conectar()->prepare("UPDATE publicacion SET PubTitulo=:Titulo, PubDescripcion=:Descripcion,
            PubFecha=:Fecha,PubHora=:Hora,PubImag=:Foto, PubNomImg=:NomFoto, PubTipImg=:TipFoto WHERE PubCodigo=:Codigo");
           $query->bindParam(":Codigo",$datos['Codigo']);
           $query->bindParam(":Titulo",$datos['Titulo']);
           $query->bindParam(":Descripcion",$datos['Descripcion']);
           $query->bindParam(":Fecha",$datos['Fecha']);
           $query->bindParam(":Hora",$datos['Hora']);
           $query->bindParam(":Foto",$datos['Foto']);
           $query->bindParam(":NomFoto",$datos['NomFoto']);
           $query->bindParam(":TipFoto",$datos['TipFoto']);
           $query->execute();
           return $query;
        }
    }