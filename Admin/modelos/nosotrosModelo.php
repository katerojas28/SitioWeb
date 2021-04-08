<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";
    }

    class nosotrosModelo extends mainModel{
        
        protected function datos_nosotros_modelo($codigo){
            $query=mainModel::conectar()->prepare("SELECT * FROM nosotros WHERE NosotrosCodigo=:Codigo");
            $query->bindParam(":Codigo",$codigo);
            $query->execute();
            return $query;
        }

        protected function actualizar_nosotros_modelo($datos){
            $query=mainModel::conectar()->prepare("UPDATE nosotros SET NosotrosTitulo=:Titulo, NosotrosDescripcion=:Descripcion,
            NosotrosImg=:Img, NosotrosNomImg=:NomImg, NosotrosTipImg=:TipImg,NosotrosFecha=:Fecha WHERE NosotrosCodigo=:Codigo");
            $query->bindParam(":Titulo",$datos['Titulo']);
            $query->bindParam(":Descripcion",$datos['Descripcion']);
            $query->bindParam(":Img",$datos['Img']);
            $query->bindParam(":NomImg",$datos['NomImg']);
            $query->bindParam(":TipImg",$datos['TipImg']);
            $query->bindParam(":Fecha",$datos['Fecha']);
            $query->bindParam(":Codigo",$datos['Codigo']);
            $query->execute();
           return $query;
        }
    }