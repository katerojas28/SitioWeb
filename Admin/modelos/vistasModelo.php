<?php
    class vistasModelo{
        protected function obtener_vistas_modelo ($vistas) {
            $listaBlanca = ["adminlist","adminsearch","admin","home","myaccount","mydata",
            "anuncio","anunciolist","anunciosearch",
            "publicaciones","publicacionesinfo","publicacioneslist","publicacionessearch",
            "nosotrosinfo","nosotroslist","nosotrossearch",
            "banner","bannerlist","bannersearch","bannerinfo",
            "asig","asiglist","asigsearch","asiginfo",
            "infoup","infolist",
            "funcionario","funcionarioinfo","funcionariolist","funcionariosearch",
            "document","documentlist","documentsearch",
            "norma","normalist","normasearch","normainfo",
            "materia","curso","cursolist","cursosearch","cursossearch","cursoinfo",
            "galeria","galerialist","galeriasearch","galeriainfo",
            "mensajelist","mensajesearch","mensajeinfo",
            "calendar"];

            if(in_array($vistas, $listaBlanca)){
                if(is_file("./vistas/contenidos/".$vistas."-view.php")){
                    $contenido = "./vistas/contenidos/".$vistas."-view.php";
                }else{
                    $contenido = "login";
                }
            }elseif($vistas == "login"){
                $contenido = "login";
            }elseif($vistas == "index"){
                $contenido = "login";
            }else{
                $contenido = "404";
            }

            return $contenido;
        }
    }