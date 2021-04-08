<?php
        if($peticionAjax){
            require_once "../modelos/bannerModelo.php";
        }else{
            require_once "./modelos/bannerModelo.php";
        }

        class bannerControlador extends bannerModelo{

            //Controlador para agregar anuncios
        public function agregar_banner_controlador(){
                $descripcion = mainModel::limpiar_cadena($_POST['descripcion-banner']);
                $consulta1 = mainModel::ejecutar_consulta_simple("SELECT id FROM banner");
                $numero = ($consulta1->rowCount())+1;
                $codigoA = mainModel::generar_codigo_aleatorio("BN", "9", $numero);
                $fechaActual=date("Y-m-d");
                $tipFoto = $_FILES['imagen-banner']['type'];
            
                $revisar = getimagesize($_FILES["imagen-banner"]["tmp_name"]);
                if($revisar !== false){
                    $image = $_FILES['imagen-banner']['tmp_name'];
                    $imgContenido = addslashes(file_get_contents($image));

                    if (!isset($_POST["imagen-banner"])){
                        // Verificamos si el tipo de archivo es un tipo de imagen permitido. y que el tamaño del archivo no exceda los 16MB
                        $permitidos = array("image/jpg", "image/jpeg", "image/png");
                        $limite_kb = 16384;
                        $nombre = $_FILES['imagen-banner']['name'];

                        if (in_array($_FILES['imagen-banner']['type'], $permitidos) && $_FILES['imagen-banner']['size'] <= $limite_kb * 1024){
                            // Tipo de archivo
                            $tipFoto = $_FILES['imagen-banner']['type'];

                            // Insertamos en la base de datos.
                            $dataBanner=[
                                "Codigo"=>$codigoA,
                                "Fecha"=>$fechaActual,
                                "Descripcion"=>$descripcion,
                                "Foto"=>$imgContenido,
                                "NomFoto"=>$nombre,
                                "TipFoto"=>$tipFoto
                            ];

                           // print_r($dataAnuncio);

                            $guardarBanner=bannerModelo::agregar_banner_modelo($dataBanner);
                            // COndicional para verificar la subida del fichero
                            if($guardarBanner->rowCount()>=1){
                                $alerta = [
                                    "Alerta"=>"limpiar",
                                    "Titulo"=>"Anuncio Registrado",
                                    "Texto"=>"El Anuncio se registro con exito",
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
                        "Texto"=>"No se ha podido cargar la imagen, Por favor seleccione la imagen a subir.",
                        "Tipo"=>"error"
                    ];  
                }
                return mainModel::sweet_alert($alerta);
        }

        public function paginador_banner_controlador($pagina, $registros, $busqueda){
            $pagina=mainModel::limpiar_cadena ($pagina);
            $registros=mainModel::limpiar_cadena ($registros);
            $busqueda=mainModel::limpiar_cadena ($busqueda);
            $tabla="";
            
            $pagina=(isset($pagina) && $pagina>0) ? (int) $pagina :1;//limipiar la variable por si la manipulan desde el browser
            $inicio=($pagina>0) ? (($pagina*$registros)-$registros) : 0;

            if(isset($busqueda) && $busqueda!=""){
                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM banner 
                WHERE BannerFecha LIKE '%$busqueda%' OR BannerDescripcion LIKE '%$busqueda%' 
                ORDER BY BannerFecha ASC LIMIT $inicio,$registros";

                $paginaurl="bannersearch";
            }else{
                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM banner ORDER BY BannerFecha  ASC LIMIT $inicio,$registros";
                $paginaurl="bannerlist";
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
                    <th class="text-center">DESCRIPCION</th>
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
                <td>'.date("d/m/Y", strtotime($rows['BannerFecha'])).'</td>
                <td>'.$rows['BannerDescripcion'].'</td>
                <td> <img src="data:'.$rows['BannerTipImg'].';base64,'.base64_encode(stripslashes($rows['BannerImg'])) .'" class="img-responsive" alt="..."></td>';
                   
            $tabla.='
            <td>
                <a href="'.SERVERURL.'bannerinfo/admin/'.mainModel::encryption($rows['BannerCodigo']).'/" class="btn btn-success btn-raised btn-xs">
                <i class="zmdi zmdi-refresh"></i>
                </a>
            </td>   
            <td>
                <form action="'.SERVERURL.'ajax/bannerAjax.php" method="POST" class="FormularioAjax" data-form="delete" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['BannerCodigo']).'">   
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
    
        public function eliminar_banner_controlador(){
            $codigo=mainModel::decryption($_POST['codigo-del']);
            $codigo=mainModel::limpiar_cadena($codigo);               
            $DelBanner=bannerModelo:: eliminar_banner_modelo($codigo);

                if($DelBanner->rowCount()>=1){
                        $alerta = [
                            "Alerta"=>"recargar",
                            "Titulo"=>"Banner Eliminado",
                            "Texto"=>"El banner fue eliminado con exito del sistema",
                            "Tipo"=>"success"
                        ];
                }else{
                        $alerta = [
                            "Alerta"=>"simple",
                            "Titulo"=>"Ocurrio un error inesperado",
                            "Texto"=>"No podemos eliminar este banner en este momento",
                            "Tipo"=>"error"
                        ]; 
                    }
                return mainModel::sweet_alert($alerta);
        }

        public function datos_banner_controlador($codigo){
            $codigo=mainModel::decryption($codigo);
            return bannerModelo::datos_banner_modelo($codigo);
        }

        public function actualizar_banner_controlador(){
            $codigo=mainModel::decryption($_POST['codigo-up']);
            $descripcion=mainModel::limpiar_cadena($_POST['descripcion-up']);
            $fechaActual=date("Y-m-d");

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
                    $dataBanner=[
                    "Codigo"=>$codigo,
                    "Fecha"=>$fechaActual,
                    "Descripcion"=>$descripcion,
                    "Img"=>$imgContenido,
                    "NomImg"=>$nombre,
                    "TipImg"=>$tipFoto
                    ];

                    $actualizarBanner=bannerModelo::actualizar_banner_modelo($dataBanner);
                    // COndicional para verificar la subida del fichero
                    if($actualizarBanner->rowCount()>=1){
                    $alerta = [
                    "Alerta"=>"recargar",
                    "Titulo"=>"Banner Actualizado",
                    "Texto"=>"El banner se actualizo con exito",
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
                $query1=mainModel::ejecutar_consulta_simple ("SELECT * FROM banner WHERE BannerCodigo='$codigo' ");
                $DatosBanner=$query1->fetch();
                $img=$DatosBanner['BannerImg'];
                $nomimg=$DatosBanner['BannerNomImg'];
                $tipimg=$DatosBanner['BannerTipImg'];


                $dataBanner=[
                    "Codigo"=>$codigo,
                    "Fecha"=>$fechaActual,
                    "Descripcion"=>$descripcion,
                    "Img"=>$img,
                    "NomImg"=>$nomimg,
                    "TipImg"=>$tipimg
                    ];

                    $actualizarBanner=bannerModelo::actualizar_banner_modelo($dataBanner);
                    // COndicional para verificar la subida del fichero
                    if($actualizarBanner->rowCount()>=1){
                    $alerta = [
                    "Alerta"=>"recargar",
                    "Titulo"=>"Banner Actualizado",
                    "Texto"=>"El banner se actualizo con exito",
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

        