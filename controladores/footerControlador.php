<?php
        if($peticionAjax){
            require_once "../modelos/footerModelo.php";
        }else{
            require_once "./modelos/footerModelo.php";
        }

        class footerControlador extends footerModelo{

        public function datos_footer_controlador(){
            return footerModelo::datos_footer_modelo();
        }


    }