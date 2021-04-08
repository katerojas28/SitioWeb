<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";
    }

    class contactoModelo extends mainModel{
        protected function agregar_mensaje_modelo($datos){
            $sql = mainModel::conectar()->prepare("INSERT INTO 
            mensaje (MensajeCodigo, MensajeNombre, MensajeEmail, MensajeTelefono, MensajeAsunto, MensajeDescripcion,
             MensajeArchivo, MensajeTipArchivo, MensajeTamArchivo, MensajeFecha, MensajeHora) 
            VALUES(:Codigo, :Nombre, :Email, :Telefono, :Asunto, :Descripcion, :Archivo, :TipArchivo, :TamArchivo, :Fecha, :Hora)");
            $sql->bindParam(":Codigo",$datos['Codigo']);
            $sql->bindParam(":Nombre",$datos['Nombre']);
            $sql->bindParam(":Email",$datos['Email']);
            $sql->bindParam(":Telefono",$datos['Telefono']);
            $sql->bindParam(":Asunto",$datos['Asunto']);
            $sql->bindParam(":Descripcion",$datos['Descripcion']);
            $sql->bindParam(":Archivo",$datos['Archivo']);
            $sql->bindParam(":TipArchivo",$datos['TipArchivo']);
            $sql->bindParam(":TamArchivo",$datos['TamArchivo']);
            $sql->bindParam(":Fecha",$datos['Fecha']);
            $sql->bindParam(":Hora",$datos['Hora']);
            $sql->execute();
            return $sql;
        }
    }