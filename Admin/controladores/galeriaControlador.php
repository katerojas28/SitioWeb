<?php
        if($peticionAjax){
            require_once "../modelos/galeriaModelo.php";
        }else{
            require_once "./modelos/galeriaModelo.php";
        }

        class galeriaControlador extends galeriaModelo{  
            public function agregar_galeria_controlador(){
                $titulo = mainModel::limpiar_cadena($_POST['titulo-reg']);
                $descripcion = mainModel::limpiar_cadena($_POST['descripcion-reg']);
                $categoria = mainModel::limpiar_cadena($_POST['optionsGaleria']);
                $consulta1 = mainModel::ejecutar_consulta_simple("SELECT id FROM galeria");
                $numero = ($consulta1->rowCount())+1;
                $codigo = mainModel::generar_codigo_aleatorio("GA", "9", $numero);
                $fechaActual=date("Y-m-d");
                $horaActual=date("h:i:s a");

                if (!isset($_POST["file-reg"])){
                    $tipArchivo = $_FILES['file-reg']['type'];
                    $permitidos = array("image/jpg", "image/jpeg", "image/png", "video/mp4", "audio/mpeg");
                    $limite_kb = 16384;
                    $nombreArchivo = $_FILES['file-reg']['name'];
                    $newname=mainModel::file_name($nombreArchivo);
                    $nomArchivo=$categoria.$newname;
                    if ( in_array($_FILES['file-reg']['type'], $permitidos) && $_FILES['file-reg']['size'] <= $limite_kb * 1024){
                        $tamañoArchivo = $_FILES['file-reg']['size'];
                        $queryV = mainModel::ejecutar_consulta_simple("SELECT id FROM galeria WHERE GaleriaTitulo='$titulo'");
                        $inf=$queryV->rowCount();
                        if($inf==0){
                            $queryV1 = mainModel::ejecutar_consulta_simple("SELECT id FROM galeria WHERE GaleriaNomArchivo='$nomArchivo'");
                            $inf1=$queryV1->rowCount();
                            if($inf1==0){
                                $imagenes=array("image/jpg", "image/jpeg", "image/png");
                                $video="video/mp4";
                                $audio="audio/mpeg";
                                if(in_array($_FILES['file-reg']['type'], $imagenes) && $categoria=="Imagenes" ){
                                        // Insertamos en la base de datos.
                                        $dataGaleria=[
                                            "Codigo"=>$codigo,
                                            "Titulo"=>$titulo,
                                            "Descripcion"=>$descripcion,
                                            "Fecha"=>$fechaActual,
                                            "Hora"=>$horaActual,
                                            "NomArchivo"=>$nomArchivo,
                                            "TipArchivo"=>$tipArchivo,
                                            "TamArchivo"=>$tamañoArchivo,
                                            "Categoria"=>$categoria
                                            ];

                                        $guardaGaleria=galeriaModelo::agregar_galeria_modelo($dataGaleria);
                                        // COndicional para verificar la subida del fichero
                                        if($guardaGaleria->rowCount()>=1){

                                            $carpeta = "../adjuntos/galeria/";
                                            opendir($carpeta);
                                            $destino = $carpeta.$nomArchivo;
                                            copy($_FILES['file-reg']['tmp_name'],$destino);

                                            $alerta = [
                                                "Alerta"=>"limpiar",
                                                "Titulo"=>"Galeria Registrada",
                                                "Texto"=>"La galeria se registro con exito",
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

                                }else if($_FILES['file-reg']['type']==$video && $categoria=="Videos" ){
                                                // Insertamos en la base de datos.
                                                $dataGaleria=[
                                                    "Codigo"=>$codigo,
                                                    "Titulo"=>$titulo,
                                                    "Descripcion"=>$descripcion,
                                                    "Fecha"=>$fechaActual,
                                                    "Hora"=>$horaActual,
                                                    "NomArchivo"=>$nomArchivo,
                                                    "TipArchivo"=>$tipArchivo,
                                                    "TamArchivo"=>$tamañoArchivo,
                                                    "Categoria"=>$categoria
                                                    ];

                                                $guardaGaleria=galeriaModelo::agregar_galeria_modelo($dataGaleria);
                                                // COndicional para verificar la subida del fichero
                                                if($guardaGaleria->rowCount()>=1){

                                                    $carpeta = "../adjuntos/galeria/";
                                                    opendir($carpeta);
                                                    $destino = $carpeta.$nomArchivo;
                                                    copy($_FILES['file-reg']['tmp_name'],$destino);

                                                    $alerta = [
                                                        "Alerta"=>"limpiar",
                                                        "Titulo"=>"Galeria Registrada",
                                                        "Texto"=>"La galeria se registro con exito",
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
                                } else if($_FILES['file-reg']['type']==$audio && $categoria=="Audios" ){
                                    // Insertamos en la base de datos.
                                    $dataGaleria=[
                                        "Codigo"=>$codigo,
                                        "Titulo"=>$titulo,
                                        "Descripcion"=>$descripcion,
                                        "Fecha"=>$fechaActual,
                                        "Hora"=>$horaActual,
                                        "NomArchivo"=>$nomArchivo,
                                        "TipArchivo"=>$tipArchivo,
                                        "TamArchivo"=>$tamañoArchivo,
                                        "Categoria"=>$categoria
                                        ];

                                    $guardaGaleria=galeriaModelo::agregar_galeria_modelo($dataGaleria);
                                    // COndicional para verificar la subida del fichero
                                    if($guardaGaleria->rowCount()>=1){

                                        $carpeta = "../adjuntos/galeria/";
                                        opendir($carpeta);
                                        $destino = $carpeta.$nomArchivo;
                                        copy($_FILES['file-reg']['tmp_name'],$destino);

                                        $alerta = [
                                            "Alerta"=>"limpiar",
                                            "Titulo"=>"Galeria Registrada",
                                            "Texto"=>"La galeria se registro con exito",
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
                                        "Texto"=>"El formato de archivo que desea subir no coincide con la categoria, por favor verifique",
                                        "Tipo"=>"error"
                                    ];
                                }

                               


                            }else{
                                $alerta = [
                                    "Alerta"=>"simple",
                                    "Titulo"=>"Ocurrio un error inesperado",
                                    "Texto"=>"El archivo ya se encuentra registrado en el sistema",
                                    "Tipo"=>"error"
                                ];
                            }
                        }else{
                            $alerta = [
                                "Alerta"=>"simple",
                                "Titulo"=>"Ocurrio un error inesperado",
                                "Texto"=>"El titulo de la galeria ya se encuentra registrado en el sistema, por favor intente nuevamente",
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
                        "Texto"=>"No se ha podido cargar correctamentre la galeria, por favor intente nuevamente",
                        "Tipo"=>"error"
                        ];
                    }
                    return mainModel::sweet_alert($alerta);
            }


        public function paginador_galeria_controlador($pagina, $registros, $busqueda){
            $pagina=mainModel::limpiar_cadena ($pagina);
            $registros=mainModel::limpiar_cadena ($registros);
            $busqueda=mainModel::limpiar_cadena ($busqueda);
            $tabla="";
            
            $pagina=(isset($pagina) && $pagina>0) ? (int) $pagina :1;//limipiar la variable por si la manipulan desde el browser
            $inicio=($pagina>0) ? (($pagina*$registros)-$registros) : 0;

            if(isset($busqueda) && $busqueda!=""){
                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM galeria 
                WHERE GaleriaTitulo LIKE '%$busqueda%' OR GaleriaCategoria LIKE '%$busqueda%'
                ORDER BY  GaleriaCategoria DESC LIMIT $inicio,$registros";

                $paginaurl="galeriasearch";
            }else{
                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM galeria  ORDER BY  GaleriaCategoria DESC LIMIT $inicio,$registros";
                $paginaurl="galerialist";
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
                    <th class="text-center">CATEGORIA</th>';
            
                        
            $tabla.='
                <th class="text-center">ACTUALIZAR</th>
                <th class="text-center">ELIMINAR</th>
            ';
                            

            $tabla.='</tr></thead><tbody>';

            if($total>=1 && $pagina<=$Npaginas){
                $contador=$inicio+1;
                foreach($datos as $rows){
            
            $tabla.='
            <tr>
                <td>'.$contador.'</td>
                <td>'.date("d/m/Y", strtotime($rows['GaleriaFecha'])).' - '.$rows['GaleriaHora'].'</td>
                <td>'.$rows['GaleriaTitulo'].'</td>
                <td> '.$rows['GaleriaCategoria'].'
                </td>';
                   
            $tabla.='
		    <td>
				<a href="'.SERVERURL.'galeriainfo/admin/'.mainModel::encryption($rows['GaleriaCodigo']).'/" class="btn btn-success btn-raised btn-xs">
				<i class="zmdi zmdi-refresh"></i>
				</a>
			</td> 
            <td>
                <form action="'.SERVERURL.'ajax/galeriaAjax.php" method="POST" class="FormularioAjax" data-form="delete" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['GaleriaCodigo']).'">
                <input type="hidden" name="nombre-del" value="'.mainModel::encryption($rows['GaleriaNomArchivo']).'">   
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

        public function eliminar_galeria_controlador(){
            $codigo=mainModel::decryption($_POST['codigo-del']);
            $nombre=mainModel::decryption($_POST['nombre-del']);
            $codigo=mainModel::limpiar_cadena($codigo);               
            $DelGaleria=galeriaModelo:: eliminar_galeria_modelo($codigo);

                if($DelGaleria->rowCount()>=1){
                    unlink('../adjuntos/galeria/'.$nombre); 
                        $alerta = [
                            "Alerta"=>"recargar",
                            "Titulo"=>"Galeria Eliminada",
                            "Texto"=>"La galeria fue eliminada con exito del sistema",
                            "Tipo"=>"success"
                        ];
                }else{
                        $alerta = [
                            "Alerta"=>"simple",
                            "Titulo"=>"Ocurrió un error inesperado",
                            "Texto"=>"No podemos eliminar esta galeria en este momento",
                            "Tipo"=>"error"
                        ]; 
                    }
                return mainModel::sweet_alert($alerta);
        }

        public function datos_galeria_controlador($codigo){
            $codigo=mainModel::decryption($codigo);
            return galeriaModelo::datos_galeria_modelo($codigo);
        }



        public function actualizar_galeria_controlador(){
            $codigo=mainModel::decryption($_POST['codigo-up']);
            $titulo = mainModel::limpiar_cadena($_POST['titulo-up']);
            $descripcion = mainModel::limpiar_cadena($_POST['descripcion-up']);
            $categoria = mainModel::limpiar_cadena($_POST['optionsGaleria']);
            $nombre = mainModel::limpiar_cadena($_POST['nombreArchivo-up']);
            $tipoArchivo = mainModel::limpiar_cadena($_POST['tipo-up']);
            $tamaArchivo = mainModel::limpiar_cadena($_POST['tamaño-up']);
            $nombreAr = $_FILES['file-up']['name'];
            $fechaActual=date("Y-m-d");
            $horaActual=date("h:i:s a");


            if($nombreAr==""){
                                           
                                $imagenes=array("image/jpg", "image/jpeg", "image/png");
                                $video="video/mp4";
                                $audio="audio/mpeg";
                                if(in_array($tipoArchivo, $imagenes) && $categoria=="Imagenes" ){
                                        // Insertamos en la base de datos.
                                        $dataGaleria=[
                                            "Codigo"=>$codigo,
                                            "Titulo"=>$titulo,
                                            "Descripcion"=>$descripcion,
                                            "Fecha"=>$fechaActual,
                                            "Hora"=>$horaActual,
                                            "NomArchivo"=>$nombre,
                                            "TipArchivo"=>$tipoArchivo,
                                            "TamArchivo"=>$tamaArchivo,
                                            "Categoria"=>$categoria
                                            ];

                                            $upAsig=galeriaModelo::actualizar_galeria_modelo($dataGaleria);
                                        // COndicional para verificar la subida del fichero
                                        if($upAsig->rowCount()>=1){
                                        
                                            $alerta = [
                                                "Alerta"=>"recargar",
                                                "Titulo"=>"Galeria Actualizada",
                                                "Texto"=>"La galeria se actualizo con exito",
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

                                }else if($tipoArchivo==$video && $categoria=="Videos" ){
                                                // Insertamos en la base de datos.
                                                $dataGaleria=[
                                                    "Codigo"=>$codigo,
                                                    "Titulo"=>$titulo,
                                                    "Descripcion"=>$descripcion,
                                                    "Fecha"=>$fechaActual,
                                                    "Hora"=>$horaActual,
                                                    "NomArchivo"=>$nombre,
                                                    "TipArchivo"=>$tipoArchivo,
                                                    "TamArchivo"=>$tamaArchivo,
                                                    "Categoria"=>$categoria
                                                    ];

                                                    $upAsig=galeriaModelo::actualizar_galeria_modelo($dataGaleria);
                                                // COndicional para verificar la subida del fichero
                                                if($upAsig->rowCount()>=1){
                                                   
                                                    $alerta = [
                                                        "Alerta"=>"recargar",
                                                        "Titulo"=>"Galeria Actualizada",
                                                        "Texto"=>"La galeria se actualizo con exito",
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
                                } else if($tipoArchivo==$audio && $categoria=="Audios" ){
                                    // Insertamos en la base de datos.
                                    $dataGaleria=[
                                        "Codigo"=>$codigo,
                                        "Titulo"=>$titulo,
                                        "Descripcion"=>$descripcion,
                                        "Fecha"=>$fechaActual,
                                        "Hora"=>$horaActual,
                                        "NomArchivo"=>$nombre,
                                        "TipArchivo"=>$tipoArchivo,
                                        "TamArchivo"=>$tamaArchivo,
                                        "Categoria"=>$categoria
                                        ];

                                        $upAsig=galeriaModelo::actualizar_galeria_modelo($dataGaleria);
                                    // COndicional para verificar la subida del fichero
                                    if($upAsig->rowCount()>=1){
                                       
                                        $alerta = [
                                            "Alerta"=>"recargar",
                                            "Titulo"=>"Galeria Actualizada",
                                            "Texto"=>"La galeria se actualizo con exito",
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
                                        "Texto"=>"El formato de archivo que desea subir no coincide con la categoria, por favor verifique",
                                        "Tipo"=>"error"
                                    ];
                                }




                        
            }else{
                if (!isset($_POST["file-up"])){
                    $tipArchivo = $_FILES['file-up']['type'];
                    $permitidos = array("image/jpg", "image/jpeg", "image/png", "video/mp4", "audio/mpeg");
                    $limite_kb = 16384;
                    $nombreArchivo = $_FILES['file-up']['name'];
                    $newname=mainModel::file_name($nombreArchivo);
                    $nomArchivo=$categoria.$newname;
                    if ( in_array($_FILES['file-up']['type'], $permitidos) && $_FILES['file-up']['size'] <= $limite_kb * 1024){
                        $tamañoArchivo = $_FILES['file-up']['size'];
                            $queryV1 = mainModel::ejecutar_consulta_simple("SELECT id FROM galeria WHERE GaleriaNomArchivo='$nomArchivo'");
                            $inf1=$queryV1->rowCount();
                            if($inf1==0){
                                $imagenes=array("image/jpg", "image/jpeg", "image/png");
                                $video="video/mp4";
                                $audio="audio/mpeg";
                                if(in_array($_FILES['file-up']['type'], $imagenes) && $categoria=="Imagenes" ){
                                        // Insertamos en la base de datos.
                                        $dataGaleria=[
                                            "Codigo"=>$codigo,
                                            "Titulo"=>$titulo,
                                            "Descripcion"=>$descripcion,
                                            "Fecha"=>$fechaActual,
                                            "Hora"=>$horaActual,
                                            "NomArchivo"=>$nomArchivo,
                                            "TipArchivo"=>$tipArchivo,
                                            "TamArchivo"=>$tamañoArchivo,
                                            "Categoria"=>$categoria
                                            ];

                                            $upAsig=galeriaModelo::actualizar_galeria_modelo($dataGaleria);
                                        // COndicional para verificar la subida del fichero
                                        if($upAsig->rowCount()>=1){
                                            unlink('../adjuntos/galeria/'.$nombre); 
                                            $carpeta = "../adjuntos/galeria/";
                                            opendir($carpeta);
                                            $destino = $carpeta.$nomArchivo;
                                            copy($_FILES['file-up']['tmp_name'],$destino);

                                            $alerta = [
                                                "Alerta"=>"recargar",
                                                "Titulo"=>"Galeria Actualizada",
                                                "Texto"=>"La galeria se actualizo con exito",
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

                                }else if($_FILES['file-up']['type']==$video && $categoria=="Videos" ){
                                                // Insertamos en la base de datos.
                                                $dataGaleria=[
                                                    "Codigo"=>$codigo,
                                                    "Titulo"=>$titulo,
                                                    "Descripcion"=>$descripcion,
                                                    "Fecha"=>$fechaActual,
                                                    "Hora"=>$horaActual,
                                                    "NomArchivo"=>$nomArchivo,
                                                    "TipArchivo"=>$tipArchivo,
                                                    "TamArchivo"=>$tamañoArchivo,
                                                    "Categoria"=>$categoria
                                                    ];

                                                    $upAsig=galeriaModelo::actualizar_galeria_modelo($dataGaleria);
                                                // COndicional para verificar la subida del fichero
                                                if($upAsig->rowCount()>=1){
                                                    unlink('../adjuntos/galeria/'.$nombre); 
                                                    $carpeta = "../adjuntos/galeria/";
                                                    opendir($carpeta);
                                                    $destino = $carpeta.$nomArchivo;
                                                    copy($_FILES['file-up']['tmp_name'],$destino);

                                                    $alerta = [
                                                        "Alerta"=>"recargar",
                                                        "Titulo"=>"Galeria Actualizada",
                                                        "Texto"=>"La galeria se actualizo con exito",
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
                                } else if($_FILES['file-up']['type']==$audio && $categoria=="Audios" ){
                                    // Insertamos en la base de datos.
                                    $dataGaleria=[
                                        "Codigo"=>$codigo,
                                        "Titulo"=>$titulo,
                                        "Descripcion"=>$descripcion,
                                        "Fecha"=>$fechaActual,
                                        "Hora"=>$horaActual,
                                        "NomArchivo"=>$nomArchivo,
                                        "TipArchivo"=>$tipArchivo,
                                        "TamArchivo"=>$tamañoArchivo,
                                        "Categoria"=>$categoria
                                        ];

                                        $upAsig=galeriaModelo::actualizar_galeria_modelo($dataGaleria);
                                    // COndicional para verificar la subida del fichero
                                    if($upAsig->rowCount()>=1){
                                        unlink('../adjuntos/galeria/'.$nombre); 
                                        $carpeta = "../adjuntos/galeria/";
                                        opendir($carpeta);
                                        $destino = $carpeta.$nomArchivo;
                                        copy($_FILES['file-up']['tmp_name'],$destino);

                                        $alerta = [
                                            "Alerta"=>"recargar",
                                            "Titulo"=>"Galeria Actualizada",
                                            "Texto"=>"La galeria se actualizo con exito",
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
                                        "Texto"=>"El formato de archivo que desea subir no coincide con la categoria, por favor verifique",
                                        "Tipo"=>"error"
                                    ];
                                }

                               


                            }else{
                                $alerta = [
                                    "Alerta"=>"simple",
                                    "Titulo"=>"Ocurrio un error inesperado",
                                    "Texto"=>"El archivo ya se encuentra registrado en el sistema",
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
                        "Texto"=>"No se ha podido cargar correctamentre la galeria, por favor intente nuevamente",
                        "Tipo"=>"error"
                        ];
                    }
                   

            }
                return mainModel::sweet_alert($alerta);
        }

    }

        