<?php
        if($peticionAjax){
            require_once "../modelos/nosotrosModelo.php";
        }else{
            require_once "./modelos/nosotrosModelo.php";
        }

        class nosotrosControlador extends nosotrosModelo{


        public function paginador_nosotros_controlador($pagina, $registros, $busqueda){
            $pagina=mainModel::limpiar_cadena ($pagina);
            $registros=mainModel::limpiar_cadena ($registros);
            $busqueda=mainModel::limpiar_cadena ($busqueda);
            $tabla="";
            
            $pagina=(isset($pagina) && $pagina>0) ? (int) $pagina :1;//limipiar la variable por si la manipulan desde el browser
            $inicio=($pagina>0) ? (($pagina*$registros)-$registros) : 0;

            
                if(isset($busqueda) && $busqueda!=""){
                    $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM nosotros 
                    WHERE NosotrosTitulo LIKE '%$busqueda%' 
                    ORDER BY NosotrosTitulo ASC LIMIT $inicio,$registros";
    
                    $paginaurl="nosotrossearch";
                }else{
                    $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM nosotros ORDER BY NosotrosTitulo ASC LIMIT $inicio,$registros";
                    $paginaurl="nosotroslist";
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
                    <th class="text-center">DESCRIPCIÓN</th>
                    <th class="text-center">IMAGEN</th>';
            
                        
            $tabla.='
                <th class="text-center">ACTUALIZAR</th>
            ';
                            

            $tabla.='</tr></thead><tbody>';
            if($total>=1 && $pagina<=$Npaginas){
                $contador=$inicio+1;
                foreach($datos as $rows){
            
            $tabla.='
            <tr>
                <td>'.$contador.'</td>
                <td>'.date("d/m/Y", strtotime($rows['NosotrosFecha'])).'</td>
                <td>'.$rows['NosotrosTitulo'].'</td>
                <td>'.$rows['NosotrosDescripcion'].'</td>
                <td> <img src="data:'.$rows['NosotrosTipImg'].';base64,'.base64_encode(stripslashes($rows['NosotrosImg'])) .'" class="img-responsive" alt="..."></td>';
                $tabla.='
                <td>
                    <a href="'.SERVERURL.'nosotrosinfo/admin/'.mainModel::encryption($rows['NosotrosCodigo']).'/" class="btn btn-success btn-raised btn-xs">
                    <i class="zmdi zmdi-refresh"></i>
                    </a>
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
        
      
        public function datos_nosotros_controlador($codigo){
            $codigo=mainModel::decryption($codigo);
            return nosotrosModelo::datos_nosotros_modelo($codigo);
        }

        public function actualizar_nosotros_controlador(){
            $codigo=mainModel::decryption($_POST['codigo-up']);
            $titulo=mainModel::limpiar_cadena($_POST['titulo-up']);
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
                    $dataNos=[
                    "Codigo"=>$codigo,
                    "Titulo"=>$titulo,
                    "Descripcion"=>$descripcion,
                    "Img"=>$imgContenido,
                    "NomImg"=>$nombre,
                    "TipImg"=>$tipFoto,
                    "Fecha"=>$fechaActual
                    ];

                    $actualizarNos=nosotrosModelo::actualizar_nosotros_modelo($dataNos);
                    // COndicional para verificar la subida del fichero
                    if($actualizarNos->rowCount()>=1){
                        $alerta = [
                        "Alerta"=>"recargar",
                        "Titulo"=>"Item Actualizado",
                        "Texto"=>"El item se actualizo con exito",
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
                    $query1=mainModel::ejecutar_consulta_simple ("SELECT * FROM nosotros WHERE NosotrosCodigo='$codigo' ");
                    $DatosNos=$query1->fetch();
                    $img=$DatosNos['NosotrosImg'];
                    $nomimg=$DatosNos['NosotrosNomImg'];
                    $tipimg=$DatosNos['NosotrosTipImg'];
    
    
                    $dataNos1=[
                        "Codigo"=>$codigo,
                        "Titulo"=>$titulo,
                        "Descripcion"=>$descripcion,
                        "Img"=>$img,
                        "NomImg"=>$nomimg,
                        "TipImg"=>$tipimg
                        ];
    
                        $actualizarNos=nosotrosModelo::actualizar_nosotros_modelo($dataNos1);
                        // COndicional para verificar la subida del fichero
                        if($actualizarNos->rowCount()>=1){
                            $alerta = [
                            "Alerta"=>"recargar",
                            "Titulo"=>"Item Actualizado",
                            "Texto"=>"El item se actualizo con exito",
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
