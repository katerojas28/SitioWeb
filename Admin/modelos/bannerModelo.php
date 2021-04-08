<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";
    }

    class bannerModelo extends mainModel{
        protected function agregar_banner_modelo($datos){
            $sql = mainModel::conectar()->prepare("INSERT INTO 
            banner (BannerCodigo, BannerFecha, BannerDescripcion, BannerImg, BannerNomImg, BannerTipImg ) 
            VALUES(:Codigo, :Fecha, :Descripcion, :Foto, :NomFoto, :TipFoto)");
            $sql->bindParam(":Codigo",$datos['Codigo']);
            $sql->bindParam(":Fecha",$datos['Fecha']);
            $sql->bindParam(":Descripcion",$datos['Descripcion']);
            $sql->bindParam(":Foto",$datos['Foto']);
            $sql->bindParam(":NomFoto",$datos['NomFoto']);
            $sql->bindParam(":TipFoto",$datos['TipFoto']);
            $sql->execute();
            return $sql;
        }

        protected function eliminar_banner_modelo($codigo){
            $query = mainModel::conectar()->prepare("DELETE FROM banner WHERE BannerCodigo=:Codigo");
            $query->bindParam(":Codigo",$codigo);
            $query->execute();
            return $query;
        }

        protected function datos_banner_modelo($codigo){
            $query=mainModel::conectar()->prepare("SELECT * FROM banner WHERE BannerCodigo=:Codigo");
            $query->bindParam(":Codigo",$codigo);
            $query->execute();
            return $query;
        }

        protected function actualizar_banner_modelo($datos){
            $query=mainModel::conectar()->prepare("UPDATE banner SET BannerFecha=:Fecha, BannerDescripcion=:Descripcion,
            BannerImg=:Img, BannerNomImg=:NomImg, BannerTipImg=:TipImg WHERE BannerCodigo=:Codigo");
            $query->bindParam(":Fecha",$datos['Fecha']);
            $query->bindParam(":Descripcion",$datos['Descripcion']);
            $query->bindParam(":Img",$datos['Img']);
            $query->bindParam(":NomImg",$datos['NomImg']);
            $query->bindParam(":TipImg",$datos['TipImg']);
            $query->bindParam(":Codigo",$datos['Codigo']);
            $query->execute();
           return $query;
        }
    }