<?php
        if($peticionAjax){
            require_once "../modelos/publicacionModelo.php";
        }else{
            require_once "./modelos/publicacionModelo.php";
        }

        class publicacionControlador extends publicacionModelo{

            //Controlador para agregar publicacion
        public function agregar_publicacion_controlador(){
            $titulo = mainModel::limpiar_cadena($_POST['titulo-pub']);
            $descripcion = mainModel::limpiar_cadena($_POST['descripcion-pub']);
            $consulta1 = mainModel::ejecutar_consulta_simple("SELECT id FROM publicacion ");
            $numero = ($consulta1->rowCount())+1;
            $codigo = mainModel::generar_codigo_aleatorio("PB", "9", $numero);
            $fechaActual=date("Y-m-d");
            $horaActual=date("h:i:s a");
            $tipFoto = $_FILES['imagen-pub']['type'];

            $revisar = getimagesize($_FILES["imagen-pub"]["tmp_name"]);
            if($revisar !== false){
                $image = $_FILES['imagen-pub']['tmp_name'];
                $imgContenido = addslashes(file_get_contents($image));
                if (!isset($_POST["imagen-pub"])){
                    $permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
                    $limite_kb = 16384;
                    $nombre = $_FILES['imagen-pub']['name'];
                    if (in_array($_FILES['imagen-pub']['type'], $permitidos) && $_FILES['imagen-pub']['size'] <= $limite_kb * 1024){


                        // Insertamos en la base de datos.
                        $dataPub=[
                            "Codigo"=>$codigo,
                            "Titulo"=>$titulo,
                            "Descripcion"=>$descripcion,
                            "Fecha"=>$fechaActual,
                            "Hora"=>$horaActual,
                            "Foto"=>$imgContenido,
                            "NomFoto"=>$nombre,
                            "TipFoto"=>$tipFoto
                        ];

                        $guardarPub=publicacionModelo::agregar_publicacion_modelo($dataPub);
                        // COndicional para verificar la subida del fichero
                        if($guardarPub->rowCount()>=1){
                            $alerta = [
                                "Alerta"=>"limpiar",
                                "Titulo"=>"Publicación Registrada",
                                "Texto"=>"La Publicación se registro con exito",
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
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrio un error inesperado",
                        "Texto"=>"No se ha podido cargar correctamentre la imagen, por favor intente nuevamente",
                        "Tipo"=>"error"
                    ];
                }
            }else{
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No se ha podido cargar la imagen, Por favor seleccione imagen a subir.",
                    "Tipo"=>"error"
                ];
            }
          return mainModel::sweet_alert($alerta);
        }

        public function paginador_publicacion_controlador($pagina, $registros, $busqueda){
            $pagina=mainModel::limpiar_cadena ($pagina);
            $registros=mainModel::limpiar_cadena ($registros);
            $busqueda=mainModel::limpiar_cadena ($busqueda);
            $tabla="";
            
            $pagina=(isset($pagina) && $pagina>0) ? (int) $pagina :1;//limipiar la variable por si la manipulan desde el browser
            $inicio=($pagina>0) ? (($pagina*$registros)-$registros) : 0;

            
                if(isset($busqueda) && $busqueda!=""){
                    $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM publicacion 
                    WHERE PubTitulo LIKE '%$busqueda%' OR PubFecha LIKE '%$busqueda%' 
                    ORDER BY PubFecha DESC LIMIT $inicio,$registros";
    
                    $paginaurl="publicacionessearch";
                }else{
                    $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM publicacion ORDER BY PubFecha  DESC LIMIT $inicio,$registros";
                    $paginaurl="publicacioneslist";
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
                    <th class="text-center">IMAGEN</th>';
            
                        
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
                <td>'.date("d/m/Y", strtotime($rows['PubFecha'])).'</td>
                <td>'.$rows['PubTitulo'].'</td>
                <td> <img src="data:'.$rows['PubTipImg'].';base64,'.base64_encode(stripslashes($rows['PubImag'])) .'" class="img-responsive"  alt="..."></td>';
                $tabla.='
                <td>
                    <a href="'.SERVERURL.'publicacionesinfo/admin/'.mainModel::encryption($rows['PubCodigo']).'/" class="btn btn-success btn-raised btn-xs">
                    <i class="zmdi zmdi-refresh"></i>
                    </a>
                </td>   
                <td>
                    <form action="'.SERVERURL.'ajax/publicacionAjax.php" method="POST" class="FormularioAjax" data-form="delete" enctype="multipart/form-data" autocomplete="off">
                    <input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['PubCodigo']).'">   
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
                <td colspan="5">
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
        
        public function eliminar_publicacion_controlador(){
            $codigo=mainModel::decryption($_POST['codigo-del']);
            $codigo=mainModel::limpiar_cadena($codigo);               
            $DelPublicacion=publicacionModelo:: eliminar_publicacion_modelo($codigo);

                if($DelPublicacion->rowCount()>=1){
                        $alerta = [
                            "Alerta"=>"recargar",
                            "Titulo"=>"Publicacion Eliminada",
                            "Texto"=>"La publicacion fue eliminado con exito del sistema",
                            "Tipo"=>"success"
                        ];
                }else{
                        $alerta = [
                            "Alerta"=>"simple",
                            "Titulo"=>"Ocurrio un error inesperado",
                            "Texto"=>"No podemos eliminar esta publicacion en este momento",
                            "Tipo"=>"error"
                        ]; 
                    }
                return mainModel::sweet_alert($alerta);
        }

        public function datos_publicacion_controlador($codigo){
            $codigo=mainModel::decryption($codigo);
            return publicacionModelo::datos_publicacion_modelo($codigo);
        }

        public function actualizar_publicacion_controlador(){
            $codigo=mainModel::decryption($_POST['codigo-up']);
            $titulo = mainModel::limpiar_cadena($_POST['titulo-up']);
            $descripcion=mainModel::limpiar_cadena($_POST['descripcion-up']);
            $fechaActual=date("Y-m-d");
            $horaActual=date("h:i:s a");
            $tipFoto = $_FILES['imagen-up']['type'];
            

            $verificar = $_FILES['imagen-up']['name'];

            if($verificar !=""){
                $revisar = getimagesize($_FILES["imagen-up"]["tmp_name"]);
                if($revisar !== false){
                $permitidos = array("image/jpg", "image/jpeg", "image/png");
                $limite_kb = 16384;
                $tamañoArchivo = $_FILES['imagen-up']['size']; //Obtenemos el tamaño del archivo en Bytes
		        $tamañoArchivoKB = round(intval(strval( $tamañoArchivo / 1024 ))); //Pasamos el tamaño del archivo a KB
                    if (in_array($_FILES['imagen-up']['type'], $permitidos) && $tamañoArchivoKB <= $limite_kb * 1024 ){   
                    $image = $_FILES['imagen-up']['tmp_name'];
                    $imgContenido = addslashes(file_get_contents($image));
                    $nombre = $_FILES['imagen-up']['name'];
                    // Tipo de archivo
                    $tipFoto = $_FILES['imagen-up']['type'];

                    // Insertamos en la base de datos.
                    $dataPub=[
                    "Codigo"=>$codigo,
                    "Titulo"=>$titulo,
                    "Descripcion"=>$descripcion,
                    "Fecha"=>$fechaActual,
                    "Hora"=>$horaActual,
                    "Foto"=>$imgContenido,
                    "NomFoto"=>$nombre,
                    "TipFoto"=>$tipFoto
                    ];

                    $actualizarPub=publicacionModelo::actualizar_publicacion_modelo($dataPub);
                    // COndicional para verificar la subida del fichero
                    if($actualizarPub->rowCount()>=1){
                    $alerta = [
                    "Alerta"=>"recargar",
                    "Titulo"=>"Publicación Actualizada",
                    "Texto"=>"La publicación se actualizo con exito",
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
                    $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No se ha podido cargar correctamentre la imagen, por favor intente nuevamente",
                    "Tipo"=>"error"
                    ];   
                }

            }else{
                $query1=mainModel::ejecutar_consulta_simple ("SELECT * FROM publicacion WHERE PubCodigo='$codigo' ");
                $DatosPub=$query1->fetch();
                $img=$DatosPub['PubImag'];
                $nomimg=$DatosPub['PubNomImg'];
                $tipimg=$DatosPub['PubTipImg'];


                $dataPub=[
                    "Codigo"=>$codigo,
                    "Titulo"=>$titulo,
                    "Descripcion"=>$descripcion,
                    "Fecha"=>$fechaActual,
                    "Hora"=>$horaActual,
                    "Foto"=>$img,
                    "NomFoto"=>$nomimg,
                    "TipFoto"=>$tipimg
                    ];

                    $actualizarPub=publicacionModelo::actualizar_publicacion_modelo($dataPub);
                    // COndicional para verificar la subida del fichero
                    if($actualizarPub->rowCount()>=1){
                    $alerta = [
                    "Alerta"=>"recargar",
                    "Titulo"=>"Publicacion Actualizada",
                    "Texto"=>"La publicación se actualizo con exito",
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
