<?php
    class vistasModelo{
        protected function obtener_vistas_modelo ($vistas) {
            $listaBlanca = ["home",
            "nosotros","vision","mision","objetivos","organigrama","funrector","fundocente",
            "documentos",
            "normatividad","circular","leyes","resolucion","decreto",
            "funcionario",
            "grado","kinder","primero","segundo","tercero","cuarto","quinto","sexto","septimo","octavo","noveno","decimo","once",
            "galeria","imagen","video","audio",
            "contacto"];

            if(in_array($vistas, $listaBlanca)){
                if(is_file("./vistas/contenidos/".$vistas."-view.php")){
                    $contenido = "./vistas/contenidos/".$vistas."-view.php";
                }else{
                    $contenido = "./vistas/contenidos/home-view.php";
                }
            }else{
                $contenido = "./vistas/contenidos/404-view.php";
            }

            return $contenido;
        }
    }