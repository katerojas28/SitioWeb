    <?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";
    }

    class normatividadModelo extends mainModel{
        protected function datos_normatividad_modelo($codigo){
            $query=mainModel::conectar()->prepare("SELECT * FROM normatividad WHERE NormaCodigo=:Codigo ");
            $query->bindParam(":Codigo",$codigo);
            $query->execute();
            return $query;
        }
    }