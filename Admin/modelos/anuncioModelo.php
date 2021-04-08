<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";
    }

    class anuncioModelo extends mainModel{
        protected function agregar_anuncio_modelo($datos){
            $sql = mainModel::conectar()->prepare("INSERT INTO 
            anuncio (AnuncioCodigo, AnuncioFecha, AnuncioHora, AnuncioTitulo, AnuncioDescripcion, AnuncioFoto, AnuncioNomFoto, AnuncioTipFoto, CuentaCodigo) 
            VALUES(:Codigo, :Fecha, :Hora, :Titulo, :Descripcion, :Foto, :NomFoto, :TipFoto, :Cuenta)");
            $sql->bindParam(":Codigo",$datos['Codigo']);
            $sql->bindParam(":Fecha",$datos['Fecha']);
            $sql->bindParam(":Hora",$datos['Hora']);
            $sql->bindParam(":Titulo",$datos['Titulo']);
            $sql->bindParam(":Descripcion",$datos['Descripcion']);
            $sql->bindParam(":Foto",$datos['Foto']);
            $sql->bindParam(":NomFoto",$datos['NomFoto']);
            $sql->bindParam(":TipFoto",$datos['TipFoto']);
            $sql->bindParam(":Cuenta",$datos['Cuenta']);
            $sql->execute();
            return $sql;
        }

        protected function eliminar_anuncio_modelo($codigo){
            $query = mainModel::conectar()->prepare("DELETE FROM anuncio WHERE AnuncioCodigo=:Codigo");
            $query->bindParam(":Codigo",$codigo);
            $query->execute();
            return $query;
        }
    }