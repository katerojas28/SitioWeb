<?php
        if($peticionAjax){
            require_once "../modelos/bannerModelo.php";
        }else{
            require_once "./modelos/bannerModelo.php";
        }

        class bannerControlador extends bannerModelo{

        public function datos_banner_controlador(){
            return bannerModelo::datos_banner_modelo();
        }


    }