<?php
        if($peticionAjax){
            require_once "../modelos/documentModelo.php";
        }else{
            require_once "./modelos/documentModelo.php";
        }

        class documentControlador extends documentModelo{

            //Controlador para agregar documento
      
            public function agregar_document_controlador(){
                $titulo = mainModel::limpiar_cadena($_POST['nombre-reg']);
                $consulta1 = mainModel::ejecutar_consulta_simple("SELECT id FROM documento");
                $numero = ($consulta1->rowCount())+1;
                $codigo = mainModel::generar_codigo_aleatorio("DC", "9", $numero);
                $fechaActual=date("Y-m-d");

                if (!isset($_POST["file-reg"])){
                    $tipDoc = $_FILES['file-reg']['type'];
                    $permitidos = "application/pdf";
                    $limite_kb = 16384;
                    $nombredoc = $_FILES['file-reg']['name'];
                    $newname=mainModel::file_name($nombredoc);
                    if ( $tipDoc==$permitidos && $_FILES['file-reg']['size'] <= $limite_kb * 1024){
                        $queryV = mainModel::ejecutar_consulta_simple("SELECT * FROM documento WHERE DocTitulo='$titulo'");
                        $inf=$queryV->rowCount();
                        if($inf==0){
                            $queryV1 = mainModel::ejecutar_consulta_simple("SELECT * FROM documento WHERE DocNomArchivo='$newname'");
                            $inf1=$queryV1->rowCount();
                            if($inf1==0){
                                // Insertamos en la base de datos.
                                $dataDoc=[
                                    "Codigo"=>$codigo,
                                    "Titulo"=>$titulo,
                                    "NomArchivo"=>$newname,
                                    "TipArchivo"=>$tipDoc,
                                    "Fecha"=>$fechaActual
                                    ];

                                $guardaDoc=documentModelo::agregar_document_modelo($dataDoc);
                                // COndicional para verificar la subida del fichero
                                if($guardaDoc->rowCount()>=1){

                                    $carpeta = "../vistas/assets/documentos/";
                                    opendir($carpeta);
                                    $destino = $carpeta.$newname;
                                    copy($_FILES['file-reg']['tmp_name'],$destino);

                                    $alerta = [
                                        "Alerta"=>"limpiar",
                                        "Titulo"=>"Documento Registrado",
                                        "Texto"=>"El documento se registro con exito",
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
                                    "Texto"=>"Este documento ya se encuentra registrado en el sistema",
                                    "Tipo"=>"error"
                                ];
                            }
                        }else{
                            $alerta = [
                                "Alerta"=>"simple",
                                "Titulo"=>"Ocurrio un error inesperado",
                                "Texto"=>"El titulo del documento ya se encuentra registrado en el sistema, por favor intente nuevamente",
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
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrio un error inesperado",
                        "Texto"=>"No se ha podido cargar correctamentre el documento, por favor intente nuevamente",
                        "Tipo"=>"error"
                        ];
                    }
                    return mainModel::sweet_alert($alerta);
            }


        public function paginador_document_controlador($pagina, $registros, $busqueda){
            $pagina=mainModel::limpiar_cadena ($pagina);
            $registros=mainModel::limpiar_cadena ($registros);
            $busqueda=mainModel::limpiar_cadena ($busqueda);
            $tabla="";
            
            $pagina=(isset($pagina) && $pagina>0) ? (int) $pagina :1;//limipiar la variable por si la manipulan desde el browser
            $inicio=($pagina>0) ? (($pagina*$registros)-$registros) : 0;

            if(isset($busqueda) && $busqueda!=""){
                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM documento 
                WHERE DocTitulo LIKE '%$busqueda%'
                ORDER BY DocTitulo DESC LIMIT $inicio,$registros";

                $paginaurl="documentsearch";
            }else{
                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM documento ORDER BY DocTitulo  DESC LIMIT $inicio,$registros";
                $paginaurl="documentlist";
            }

            $conexion = mainModel::conectar();
            $datos = $conexion->query($consulta);
            $datos = $datos->fetchAll();
            $total = $conexion->query("SELECT FOUND_ROWS()");
            $total = (int) $total->fetchColumn();
            $Npaginas = ceil($total/$registros);


            $tabla.='
            <div class="table-responsive">
            <table class="table table-hover text-center">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">FECHA</th>
                    <th class="text-center">TITULO</th>
                    <th class="text-center">DOCUMENTO</th>';
            
                        
            $tabla.='
                <th class="text-center">ELIMINAR</th>
            ';
                            

            $tabla.='</tr></thead><tbody>';

            if($total>=1 && $pagina<=$Npaginas){
                $contador=$inicio+1;
                foreach($datos as $rows){
            
            $tabla.='
            <tr>
                <td>'.$contador.'</td>
                <td>'.date("d/m/Y", strtotime($rows['DocFecha'])).'</td>
                <td>'.$rows['DocTitulo'].'</td>
                <td> '.$rows['DocNomArchivo'].'
                </td>';
                   
            $tabla.=' 
            <td>
                <form action="'.SERVERURL.'ajax/documentAjax.php" method="POST" class="FormularioAjax" data-form="delete" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['DocCodigo']).'">
                <input type="hidden" name="nombre-del" value="'.mainModel::encryption($rows['DocNomArchivo']).'">   
                <button type="submit" class="btn btn-danger btn-raised btn-xs">
                <i class="zmdi zmdi-delete"></i>
                </button>
                <div class="RespuestaAjax"></div>
                </form>
            </td>';
                    
                                
            $tabla.='</tr>';
                $contador++;
                }
            }else{
                if($total>=1){
                    
            $tabla.='
            <tr>
                <td colspan="3">
                    <a href="'.SERVERURL.$paginaurl.'/" class="btn btn-sm btn-info btn-raised">
                    Haga click acá para recargar el listado</a>
                </td>
            </tr>
            ';
                }else{
            $tabla.='
            <tr>
                <td colspan="5">No hay registros en el sistema</td>
            </tr>
            ';
                }
            }

            $tabla.='</tbody></table></div>';

            if($total>=1 && $pagina<=$Npaginas){
                $tabla.='<nav class="text-center"><ul class="pagination pagination-sm">
                ';

                if($pagina==1){
                    $tabla.='<li class="disabled"><a><i class="zmdi zmdi-arrow-left"></i></a></li>';
                }else{
                    $tabla.='<li><a href="'.SERVERURL.$paginaurl.'/'.($pagina-1).'"><i class="zmdi zmdi-arrow-left"></i></a></li>';
                }


                for($i=1;$i<=$Npaginas;$i++){

                    if($pagina==$i){
                        $tabla.='<li class="active"><a href="'.SERVERURL.$paginaurl.'/'.$i.'">'.$i.'</a></li>';
                    }else{
                        $tabla.='<li><a href="'.SERVERURL.$paginaurl.'/'.$i.'">'.$i.'</a></li>';
                    }

                }



                if($pagina==$Npaginas){
                    $tabla.='<li class="disabled"><a><i class="zmdi zmdi-arrow-right"></i></a></li>';
                }else{
                    $tabla.='<li><a href="'.SERVERURL.$paginaurl.'/'.($pagina+1).'"><i class="zmdi zmdi-arrow-right"></i></a></li>';
                }

                $tabla.='</ul></nav>';
            }

            return$tabla;

        }

        public function eliminar_document_controlador(){
            $codigo=mainModel::decryption($_POST['codigo-del']);
            $nombre=mainModel::decryption($_POST['nombre-del']);
            $codigo=mainModel::limpiar_cadena($codigo);               
            $DelDoc=documentModelo:: eliminar_document_modelo($codigo);

                if($DelDoc->rowCount()>=1){
                    unlink('../vistas/assets/documentos/'.$nombre); 
                        $alerta = [
                            "Alerta"=>"recargar",
                            "Titulo"=>"Documento Eliminado",
                            "Texto"=>"El documento fue eliminado con exito del sistema",
                            "Tipo"=>"success"
                        ];
                }else{
                        $alerta = [
                            "Alerta"=>"simple",
                            "Titulo"=>"Ocurrió un error inesperado",
                            "Texto"=>"No podemos eliminar este documento en este momento",
                            "Tipo"=>"error"
                        ]; 
                    }
                return mainModel::sweet_alert($alerta);
        }

        public function datos_document_controlador($codigo){
            $codigo=mainModel::decryption($codigo);
            return documentModelo::datos_document_modelo($codigo);
        }


    }

        