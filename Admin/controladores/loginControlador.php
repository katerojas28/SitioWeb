<?php
    if($peticionAjax){
        require_once "../modelos/loginModelo.php";
    }else{
        require_once "./modelos/loginModelo.php";
    }

    class loginControlador extends loginModelo {
        public function iniciar_sesion_controlador (){
            $usuario=mainModel::limpiar_cadena($_POST['usuario']);
            $clave=mainModel::limpiar_cadena($_POST['clave']);

            $clave=mainModel::encryption($clave);

            $datosLogin=[
                "Usuario"=>$usuario,
                "Clave"=>$clave
            ];

            $datosCuenta=loginModelo::iniciar_sesion_modelo($datosLogin);

            if($datosCuenta->rowCount()==1){
                $row=$datosCuenta->fetch();
                $fechaActual=date("Y-m-d");
                $yearActual=date("Y");
                $horaActual=date("h:i:s a");

                $consulta1=mainModel::ejecutar_consulta_simple("SELECT id
                FROM bitacora");

                $numero=($consulta1->rowCount())+1;
                $codigoB=mainModel::generar_codigo_aleatorio("CB","9",$numero);
                $datosBitacora=[
                    "Codigo"=>$codigoB,
                    "Fecha"=>$fechaActual,
                    "HoraInicio"=>$horaActual,
                    "HoraFinal"=>"Sin registro",
                    "Tipo"=>$row['CuentaTipo'],
                    "Year"=>$yearActual,
                    "Cuenta"=>$row['CuentaCodigo']
                ];
                $insertarBitacora=mainModel::guardar_bitacora($datosBitacora);
                if($insertarBitacora->rowCount()>=1){

                    $sqlAdmin=mainModel::ejecutar_consulta_simple("SELECT * FROM admin WHERE CuentaCodigo='".$row['CuentaCodigo']."'");
                    if($sqlAdmin->rowCount()==1){
                        session_start(['name'=>'IELG']);
                        $userDate=$sqlAdmin->fetch();
                        $_SESSION['nombre_ielg']=$userDate['AdminNombre'];
                        $_SESSION['apellido_ielg']=$userDate['AdminApellido'];
                        $_SESSION['usuario_ielg']=$row['CuentaUsuario'];
                        $_SESSION['tipo_ielg']=$row['CuentaTipo'];
                        $_SESSION['privilegio_ielg']=$row['CuentaPrivilegio'];
                        $_SESSION['foto_ielg']=$row['CuentaFoto'];
                        $_SESSION['token_ielg']=md5(uniqid(mt_rand(),true));
                        $_SESSION['codigo_cuenta_ielg']=$row['CuentaCodigo'];
                        $_SESSION['codigo_bitacora_ielg']=$codigoB;
    
                        if($row['CuentaTipo']=="Administrador"){
                            $url=SERVERURL."home/";
                        }else{
                            $url=SERVERURL."publicaciones/";
                        }
                        return $urlLocation='<script> window.location="'.$url.'" </script>';
                    }else{
                        $alerta = [
                            "Alerta"=>"simple",
                            "Titulo"=>"Ocurrio un error inesperado",
                            "Texto"=>"No hemos podido iniciar la sesión por problemas técnicos, por favor intente nuevamente",
                            "Tipo"=>"error"
                        ];
                        return mainModel::sweet_alert($alerta);
                    }
                    
                }else{
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrio un error inesperado",
                        "Texto"=>"No hemos podido iniciar la sesión por problemas técnicos, por favor intente nuevamente",
                        "Tipo"=>"error"
                    ];
                    return mainModel::sweet_alert($alerta);
                }

            }else{
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"El nombre de usuario y contraseña no son correctos o su cuenta esta deshabilitada",
                    "Tipo"=>"error"
                ];
                return mainModel::sweet_alert($alerta);
            }
        }

        public function cerrar_sesion_controlador(){
            session_start(['name'=>'IELG']);
            $token=mainModel::decryption($_GET['Token']);
            $hora=date("h:i:s a");
            $datos=[
                "Usuario"=>$_SESSION['usuario_ielg'],
                "Token_S"=>$_SESSION['token_ielg'],
                "Token"=>$token,
                "Codigo"=> $_SESSION['codigo_bitacora_ielg'],
                "Hora"=>$hora
            ];

            return loginModelo::cerrar_sesion_modelo($datos);
        }


        public function forzar_cierre_controlador(){
            session_start(['name'=>'IELG']);
            session_destroy();
            return header("Location: ".SERVERURL."login/");
        }
       
        
    }