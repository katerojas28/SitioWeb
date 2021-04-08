<?php
        if($peticionAjax){
            require_once "../modelos/cursoModelo.php";
        }else{
            require_once "./modelos/cursoModelo.php";
        }

        class cursoControlador extends cursoModelo{  
            /*
          public function agregar_norma_controlador(){
                $titulo = mainModel::limpiar_cadena($_POST['titulo-reg']);
                $descripcion = mainModel::limpiar_cadena($_POST['descripcion-reg']);
                $categoria = mainModel::limpiar_cadena($_POST['optionsNorma']);
                $consulta1 = mainModel::ejecutar_consulta_simple("SELECT id FROM normatividad");
                $numero = ($consulta1->rowCount())+1;
                $codigo = mainModel::generar_codigo_aleatorio("NT", "9", $numero);
                $fechaActual=date("Y-m-d");
                $horaActual=date("h:i:s a");

                if (!isset($_POST["file-reg"])){
                    $tipArchivo = $_FILES['file-reg']['type'];
                    $permitidos = "application/pdf";
                    $limite_kb = 16384;
                    $nombreArchivo = $_FILES['file-reg']['name'];
                    $newname=mainModel::file_name($nombreArchivo);
                    if ( $tipArchivo==$permitidos && $_FILES['file-reg']['size'] <= $limite_kb * 1024){
                        $tamañoArchivo = $_FILES['file-reg']['size'];
                        $queryV = mainModel::ejecutar_consulta_simple("SELECT id FROM normatividad WHERE NormaTitulo='$titulo'");
                        $inf=$queryV->rowCount();
                        if($inf==0){
                            $queryV1 = mainModel::ejecutar_consulta_simple("SELECT id FROM normatividad WHERE NormaNomArchivo='$newname'");
                            $inf1=$queryV1->rowCount();
                            if($inf1==0){
                                // Insertamos en la base de datos.
                                $dataNorma=[
                                    "Codigo"=>$codigo,
                                    "Titulo"=>$titulo,
                                    "Descripcion"=>$descripcion,
                                    "Fecha"=>$fechaActual,
                                    "Hora"=>$horaActual,
                                    "NomArchivo"=>$newname,
                                    "TipArchivo"=>$tipArchivo,
                                    "TamArchivo"=>$tamañoArchivo,
                                    "Categoria"=>$categoria
                                    ];

                                $guardaNorma=normativaModelo::agregar_norma_modelo($dataNorma);
                                // COndicional para verificar la subida del fichero
                                if($guardaNorma->rowCount()>=1){

                                    $carpeta = "../adjuntos/";
                                    opendir($carpeta);
                                    $destino = $carpeta.$newname;
                                    copy($_FILES['file-reg']['tmp_name'],$destino);

                                    $alerta = [
                                        "Alerta"=>"limpiar",
                                        "Titulo"=>"Normativa Registrada",
                                        "Texto"=>"La normatividad se registro con exito",
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
                                    "Texto"=>"El archivo ya se encuentra registrado en el sistema",
                                    "Tipo"=>"error"
                                ];
                            }
                        }else{
                            $alerta = [
                                "Alerta"=>"simple",
                                "Titulo"=>"Ocurrio un error inesperado",
                                "Texto"=>"El titulo de la normatividad ya se encuentra registrado en el sistema, por favor intente nuevamente",
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
                        "Texto"=>"No se ha podido cargar correctamentre la normatividad, por favor intente nuevamente",
                        "Tipo"=>"error"
                        ];
                    }
                    return mainModel::sweet_alert($alerta);
            }


       
            public function paginador_norma_controlador($pagina, $registros, $busqueda){
            $pagina=mainModel::limpiar_cadena ($pagina);
            $registros=mainModel::limpiar_cadena ($registros);
            $busqueda=mainModel::limpiar_cadena ($busqueda);
            $tabla="";
            
            $pagina=(isset($pagina) && $pagina>0) ? (int) $pagina :1;//limipiar la variable por si la manipulan desde el browser
            $inicio=($pagina>0) ? (($pagina*$registros)-$registros) : 0;

            if(isset($busqueda) && $busqueda!=""){
                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM normatividad 
                WHERE NormaTitulo LIKE '%$busqueda%' OR NormaCategoria LIKE '%$busqueda%'
                ORDER BY NormaFecha DESC LIMIT $inicio,$registros";

                $paginaurl="normasearch";
            }else{
                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM normatividad ORDER BY NormaFecha  DESC LIMIT $inicio,$registros";
                $paginaurl="normalist";
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
                <th class="text-center">ARCHIVO</th>
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
                <td>'.date("d/m/Y", strtotime($rows['NormaFecha'])).' - '.$rows['NormaHora'].'</td>
                <td>'.$rows['NormaTitulo'].'</td>
                <td> '.$rows['NormaCategoria'].'
                </td>';
                   
            $tabla.='
            <td>
				<a href="'.SERVERURL.'norma/admin/'.mainModel::encryption($rows['NormaCodigo']).'/" class="btn btn-success btn-raised btn-xs">
				<i class="zmdi zmdi-refresh"></i>
			    </a>
			</td>
		    <td>
				<a href="'.SERVERURL.'normainfo/admin/'.mainModel::encryption($rows['NormaCodigo']).'/" class="btn btn-success btn-raised btn-xs">
				<i class="zmdi zmdi-refresh"></i>
				</a>
			</td> 
            <td>
                <form action="'.SERVERURL.'ajax/normativaAjax.php" method="POST" class="FormularioAjax" data-form="delete" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['NormaCodigo']).'">
                <input type="hidden" name="nombre-del" value="'.mainModel::encryption($rows['NormaNomArchivo']).'">   
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

        public function eliminar_norma_controlador(){
            $codigo=mainModel::decryption($_POST['codigo-del']);
            $nombre=mainModel::decryption($_POST['nombre-del']);
            $codigo=mainModel::limpiar_cadena($codigo);               
            $DelNorma=normativaModelo:: eliminar_norma_modelo($codigo);

                if($DelNorma->rowCount()>=1){
                    unlink('../adjuntos/'.$nombre); 
                        $alerta = [
                            "Alerta"=>"recargar",
                            "Titulo"=>"Normatividad Eliminada",
                            "Texto"=>"La normatividad fue eliminado con exito del sistema",
                            "Tipo"=>"success"
                        ];
                }else{
                        $alerta = [
                            "Alerta"=>"simple",
                            "Titulo"=>"Ocurrió un error inesperado",
                            "Texto"=>"No podemos eliminar esta normatividad en este momento",
                            "Tipo"=>"error"
                        ]; 
                    }
                return mainModel::sweet_alert($alerta);
        }

        public function datos_norma_controlador($codigo){
            $codigo=mainModel::decryption($codigo);
            return normativaModelo::datos_norma_modelo($codigo);
        }

        public function actualizar_norma_controlador(){
            $codigo=mainModel::decryption($_POST['codigo-up']);
            $titulo = mainModel::limpiar_cadena($_POST['titulo-up']);
            $descripcion = mainModel::limpiar_cadena($_POST['descripcion-up']);
            $categoria = mainModel::limpiar_cadena($_POST['optionsNorma-up']);
            $fechaActual=date("Y-m-d");
            $horaActual=date("h:i:s a");

            $dataNorma=[
                "Codigo"=>$codigo,
                "Titulo"=>$titulo,
                "Descripcion"=>$descripcion,
                "Fecha"=>$fechaActual,
                "Hora"=>$horaActual,
                "Categoria"=>$categoria
                ];

            $upAsig=normativaModelo::actualizar_norma_modelo($dataNorma);
            if($upAsig->rowCount()>=1){
                $alerta = [
                    "Alerta"=>"recargar",
                    "Titulo"=>"Normatividad Actualizada",
                    "Texto"=>"La normatividad se actualizo con exito",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"Ocurrio un error y no se pudo actualizar la normatividad.",
                    "Tipo"=>"error"
                ];
            }return mainModel::sweet_alert($alerta);

        }

*/
        public function datos_materias_controlador($tipo,$codigo){
            $tipo=mainModel::limpiar_cadena($tipo);
            $codigo=mainModel::decryption($codigo);

            return cursoModelo::datos_materias_modelo($tipo,$codigo);
        }
    
        public function paginador_materias_controlador($pagina, $registros, $tipo){
            $pagina=mainModel::limpiar_cadena ($pagina);
            $registros=mainModel::limpiar_cadena ($registros);
            $tabla="";
            
            $pagina=(isset($pagina) && $pagina>0) ? (int) $pagina :1;//limipiar la variable por si la manipulan desde el browser
            $inicio=($pagina>0) ? (($pagina*$registros)-$registros) : 0;

            $paginaurl="materia";

            if($tipo != "Unico"){
                $consulta="SELECT  admin.CuentaCodigo, admin.AdminNombre, admin.AdminApellido, asignacion.AsigNombreCurso,
                 asignacion.AsigNombreMateria, asignacion.AsigCodigo FROM admin, asignacion WHERE asignacion.CuentaCodigo='$tipo' AND
                  admin.CuentaCodigo= asignacion.CuentaCodigo ORDER BY asignacion.AsigNombreCurso ASC 
                  LIMIT $inicio,$registros";

                
            }else if ($tipo == "Unico"){
                $consulta="SELECT * FROM asignacion, admin WHERE admin.CuentaCodigo= asignacion.CuentaCodigo ORDER BY AsigNombreCurso ASC LIMIT $inicio,$registros";
                $paginaurl="materia";
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
                    <th class="text-center">CURSO</th>
                    <th class="text-center">NOMBRE</th>
                    <th class="text-center">DOCENTE</th>';
            
                        
            $tabla.='
                <th class="text-center">VER</th>
            ';
                            

            $tabla.='</tr></thead><tbody>';

            if($total>=1 && $pagina<=$Npaginas){
                $contador=$inicio+1;
                foreach($datos as $rows){
            
            $tabla.='
            <tr>
                <td>'.$contador.'</td>
                <td>'.$rows['AsigNombreCurso'].'</td>
                <td> '.$rows['AsigNombreMateria'].'</td>
                <td> '.$rows['AdminNombre'].' '.$rows['AdminApellido'].'</td>';
                   
            $tabla.='
            <td>
				<a href="'.SERVERURL.'cursolist/admin/'.mainModel::encryption($rows['AsigCodigo']).'/" class="btn btn-success btn-raised btn-xs">
				<i class="zmdi zmdi-eye"></i>
				</a>
			</td> 
            ';
                    
                                
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

        public function paginador_materiascurso_controlador($pagina, $registros, $busqueda){
            $pagina=mainModel::limpiar_cadena ($pagina);
            $registros=mainModel::limpiar_cadena ($registros);
            $busqueda=mainModel::limpiar_cadena ($busqueda);
            $tabla="";
            
            $pagina=(isset($pagina) && $pagina>0) ? (int) $pagina :1;//limipiar la variable por si la manipulan desde el browser
            $inicio=($pagina>0) ? (($pagina*$registros)-$registros) : 0;

            if(isset($busqueda) && $busqueda!=""){
                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM asignacion, admin 
                WHERE admin.CuentaCodigo= asignacion.CuentaCodigo AND (AsigNombreMateria LIKE '%$busqueda%' OR AsigNombreCurso LIKE '%$busqueda%' OR AdminNombre LIKE '%$busqueda%' OR AdminApellido LIKE '%$busqueda%')
                ORDER BY AsigNombreCurso ASC LIMIT $inicio,$registros";

                $paginaurl="cursossearch";
            }else{
                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM asignacion, admin WHERE admin.CuentaCodigo= asignacion.CuentaCodigo ORDER BY AsigNombreCurso ASC LIMIT $inicio,$registros";
                $paginaurl="cursossearch";
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
                    <th class="text-center">CURSO</th>
                    <th class="text-center">NOMBRE</th>
                    <th class="text-center">DOCENTE</th>';
            
                        
            $tabla.='
            <th class="text-center">CREAR CONTENIDO</th>
            ';
                            

            $tabla.='</tr></thead><tbody>';

            if($total>=1 && $pagina<=$Npaginas){
                $contador=$inicio+1;
                foreach($datos as $rows){
            
            $tabla.='
            <tr>
                <td>'.$contador.'</td>
                <td>'.$rows['AsigNombreCurso'].'</td>
                <td> '.$rows['AsigNombreMateria'].'</td>
                <td> '.$rows['AdminNombre'].' '.$rows['AdminApellido'].'</td>';
                   
            $tabla.='
            <td>
            <a href="'.SERVERURL.'curso/admin/'.mainModel::encryption($rows['AsigCodigo']).'/" class="btn btn-success btn-raised btn-xs">
            <i class="zmdi zmdi-eye"></i>
				</a>
			</td> 
            ';
                    
                                
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

        public function paginador_curso_controlador($pagina, $registros, $codigo, $busqueda){
            $pagina=mainModel::limpiar_cadena ($pagina);
            $registros=mainModel::limpiar_cadena ($registros);
            $busqueda=mainModel::limpiar_cadena ($busqueda);
            $codigo=mainModel::decryption($codigo);
            $tabla="";
            
            $pagina=(isset($pagina) && $pagina>0) ? (int) $pagina :1;//limipiar la variable por si la manipulan desde el browser
            $inicio=($pagina>0) ? (($pagina*$registros)-$registros) : 0;

            if(isset($busqueda) && $busqueda!=""){
                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM contenido,asignacion 
                WHERE (asignacion.CuentaCodigo='$codigo') AND (ContenidoTitulo LIKE '%$busqueda%')
                ORDER BY ContenidoFecha DESC LIMIT $inicio,$registros";

                $paginaurl="cursosearch";
            }else{
                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM contenido, asignacion WHERE asignacion.CuentaCodigo='$codigo' ORDER BY ContenidoFecha  DESC LIMIT $inicio,$registros";
                $paginaurl="cursolist";
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
                    <th class="text-center">DESCRIPCION</th>
                    <th class="text-center">MATERIA</th>';
            
                        
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
                <td>'.date("d/m/Y", strtotime($rows['ContenidoFecha'])).' - '.$rows['ContenidoHora'].'</td>
                <td>'.$rows['ContenidoTitulo'].'</td>
                <td> '.$rows['ContenidoDescripcion'].'</td>
                <td> '.$rows['AsigNombreMateria'].'</td>';
                   
            $tabla.='
		    <td>
				<a href="'.SERVERURL.'cursoinfo/admin/'.mainModel::encryption($rows['ContenidoCodigo']).'/" class="btn btn-success btn-raised btn-xs">
				<i class="zmdi zmdi-refresh"></i>
				</a>
			</td> 
            <td>
                <form action="'.SERVERURL.'ajax/cursoAjax.php" method="POST" class="FormularioAjax" data-form="delete" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['ContenidoCodigo']).'">   
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
    }

        