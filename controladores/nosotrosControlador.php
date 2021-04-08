<?php
        if($peticionAjax){
            require_once "../modelos/nosotrosModelo.php";
        }else{
            require_once "./modelos/nosotrosModelo.php";
        }

        class nosotrosControlador extends nosotrosModelo{

        public function datos_nosotros_controlador($codigo){
            $codigo=mainModel::decryption($codigo);
            return nosotrosModelo::datos_nosotros_modelo($codigo);
        }


    }