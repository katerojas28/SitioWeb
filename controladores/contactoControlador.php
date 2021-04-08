<?php
        if($peticionAjax){
            require_once "../modelos/contactoModelo.php";
        }else{
            require_once "./modelos/contactoModelo.php";
        }

        class contactoControlador extends contactoModelo{

            public function agregar_mensaje_controlador(){
                $nombre = mainModel::limpiar_cadena($_POST['nombre-reg']);
                $email = mainModel::limpiar_cadena($_POST['email-reg']);
                $telefono = mainModel::limpiar_cadena($_POST['telefono-reg']);
                $asunto = mainModel::limpiar_cadena($_POST['asunto-reg']);
                $mensaje = mainModel::limpiar_cadena($_POST['mensaje-reg']);
                $consulta = mainModel::ejecutar_consulta_simple("SELECT id FROM mensaje ");
                $numero = ($consulta->rowCount())+1;
                $codigo = mainModel::generar_codigo_aleatorio("", "9", $numero);
                $fechaActual=date("Y-m-d");
                $horaActual=date("h:i:s a");


                if (!isset($_POST["file-reg"])){
                    $tipDoc = $_FILES['file-reg']['type'];
                    $permitidos = array("image/jpg", "image/jpeg", "image/png", "application/pdf");
                    $limite_kb = 16384;
                    $nombredoc = $_FILES['file-reg']['name'];
                    $newname=mainModel::file_name($nombredoc);
                    if (in_array($_FILES['file-reg']['type'], $permitidos) && $_FILES['file-reg']['size'] <= $limite_kb * 1024){
                        $tamArchivo=$_FILES['file-reg']['size'];

                        // Insertamos en la base de datos.
                        $dataMS=[
                            "Codigo"=>$codigo,
                            "Nombre"=>$nombre,
                            "Email"=>$email,
                            "Telefono"=>$telefono,
                            "Asunto"=>$asunto,
                            "Descripcion"=>$mensaje,
                            "Archivo"=>$newname,
                            "TipArchivo"=>$tipDoc,
                            "TamArchivo"=>$tamArchivo,
                            "Fecha"=>$fechaActual,
                            "Hora"=>$horaActual
                        ];
                       

                       // print_r($dataAnuncio);

                        $guardarmensaje=contactoModelo::agregar_mensaje_modelo($dataMS);
                        // COndicional para verificar la subida del fichero
                        if($guardarmensaje->rowCount()>=1){
                            $alerta = [
                                "Alerta"=>"limpiar",
                                "Titulo"=>"Mensaje Enviado",
                                "Texto"=>"El mensaje se envio con exito",
                                "Tipo"=>"success"
                            ];
                        }else{
                            $alerta = [
                                "Alerta"=>"simple",
                                "Titulo"=>"Ocurrio un error inesperado",
                                "Texto"=>"Ocurrió algun error al copiar el archivo.",
                                "Tipo"=>"error"
                            ];
                        }

                    }else{
                        $alerta = [
                            "Alerta"=>"simple",
                            "Titulo"=>"Ocurrio un error inesperado",
                            "Texto"=>"El formato de archivo no permitido o excede el tamaño límite de $limite_kb Kbytes.",
                            "Tipo"=>"error"
                        ];
                    }
                }else{
                    $dataMS=[
                        "Codigo"=>$codigo,
                        "Nombre"=>$nombre,
                        "Email"=>$email,
                        "Telefono"=>$telefono,
                        "Asunto"=>$asunto,
                        "Descripcion"=>$mensaje,
                        "Archivo"=>"",
                        "TipArchivo"=>"SinArchivo",
                        "TamArchivo"=>"0",
                        "Fecha"=>$fechaActual,
                        "Hora"=>$horaActual
                    ];
                    $guardarmensaje=contactoModelo::agregar_mensaje_modelo($dataMS);
                    if($guardarmensaje->rowCount()>=1){
                        $alerta = [
                            "Alerta"=>"limpiar",
                            "Titulo"=>"Mensaje Enviado",
                            "Texto"=>"El mensaje se envio con exito",
                            "Tipo"=>"success"
                        ];
                    }else{
                        $alerta = [
                            "Alerta"=>"simple",
                            "Titulo"=>"Ocurrio un error inesperado",
                            "Texto"=>"Ocurrió algun error al copiar el archivo.",
                            "Tipo"=>"error"
                        ];
                    }
                }
            return mainModel::sweet_alert($alerta);
            }
        }