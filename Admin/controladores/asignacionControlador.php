<?php
        if($peticionAjax){
            require_once "../modelos/asignacionModelo.php";
        }else{
            require_once "./modelos/asignacionModelo.php";
        }

        class asignacionControlador extends asignacionModelo{  
            public function agregar_asignacion_controlador(){
                $nombre1 = mainModel::limpiar_cadena($_POST['nombre1-reg']);
                $curso1 = mainModel::limpiar_cadena($_POST['optionsAsig1']);
                $docente1 = mainModel::decryption($_POST['optionsDoc1']);
                $consulta1 = mainModel::ejecutar_consulta_simple("SELECT id FROM asignacion");
                $numero1 = ($consulta1->rowCount())+1;
                $codigo1 = mainModel::generar_codigo_aleatorio("AC", "9", $numero1);
            
                $nombre2 = mainModel::limpiar_cadena($_POST['nombre2-reg']);
                $curso2 = mainModel::limpiar_cadena($_POST['optionsAsig2']);
                $docente2 = mainModel::decryption($_POST['optionsDoc2']);
                $consulta2 = mainModel::ejecutar_consulta_simple("SELECT id FROM asignacion");
                $numero2 = ($consulta2->rowCount())+1;
                $codigo2 = mainModel::generar_codigo_aleatorio("AC", "9", $numero2);


                if($nombre1!="" && $curso1!="" && $docente1!=""){
                    $dataAsig1=[
                        "Codigo"=>$codigo1,
                        "NombreCurso"=>$curso1,
                        "NombreMateria"=>$nombre1,
                        "Cuenta"=>$docente1
                    ];
                    if($nombre2!="" && $curso2!="" && $docente2!=""){
                        $dataAsig2=[
                            "Codigo"=>$codigo2,
                            "NombreCurso"=>$curso2,
                            "NombreMateria"=>$nombre2,
                            "Cuenta"=>$docente2
                        ];
                        $guardarAsig1=asignacionModelo::agregar_asignacion_modelo($dataAsig1);
                        if($guardarAsig1->rowCount()>=1){
                            $guardarAsig2=asignacionModelo::agregar_asignacion_modelo($dataAsig2);
                            if($guardarAsig2->rowCount()>=1){
                                $alerta = [
                                    "Alerta"=>"limpiar",
                                    "Titulo"=>"Normativa Registrada",
                                    "Texto"=>"La normatividad se registro con exito",
                                    "Tipo"=>"success"
                                    ];
                            }else{
                                $alerta = [
                                    "Alerta"=>"limpiar",
                                    "Titulo"=>"Normativa Registrada",
                                    "Texto"=>"La normatividad se registro con exito",
                                    "Tipo"=>"success"
                                    ];
                            }
                        }else{
                            $alerta = [
                                "Alerta"=>"limpiar",
                                "Titulo"=>"Normativa Registrada",
                                "Texto"=>"La normatividad se registro con exito",
                                "Tipo"=>"success"
                                ];
                            }                        
                    }else{
                        $guardarAsig1=asignacionModelo::agregar_asignacion_modelo($dataAsig1);
                        if($guardarAsig1->rowCount()>=1){
                            $alerta = [
                                "Alerta"=>"limpiar",
                                "Titulo"=>"Normativa Registrada",
                                "Texto"=>"La normatividad se registro con exito",
                                "Tipo"=>"success"
                                ];
                        }else{
                            $alerta = [
                                "Alerta"=>"limpiar",
                                "Titulo"=>"Normativa Registrada",
                                "Texto"=>"La normatividad se registro con exito",
                                "Tipo"=>"success"
                                ];
                        }
                    }

                }else{
                    $alerta = [
                        "Alerta"=>"limpiar",
                        "Titulo"=>"Normativa Registrada",
                        "Texto"=>"La normatividad se registro con exito",
                        "Tipo"=>"success"
                        ];
                }
                return mainModel::sweet_alert($alerta);
            }


        public function paginador_asignacion_controlador($pagina, $registros, $busqueda){
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

                $paginaurl="asigsearch";
            }else{
                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM asignacion, admin WHERE admin.CuentaCodigo= asignacion.CuentaCodigo ORDER BY AsigNombreCurso ASC LIMIT $inicio,$registros";
                $paginaurl="asiglist";
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
                <td>'.$rows['AsigNombreCurso'].'</td>
                <td> '.$rows['AsigNombreMateria'].'</td>
                <td> '.$rows['AdminNombre'].' '.$rows['AdminApellido'].'</td>';
                   
            $tabla.='
            <td>
				<a href="'.SERVERURL.'asiginfo/admin/'.mainModel::encryption($rows['AsigCodigo']).'/" class="btn btn-success btn-raised btn-xs">
				<i class="zmdi zmdi-refresh"></i>
				</a>
			</td> 
            <td>
                <form action="'.SERVERURL.'ajax/asignacionAjax.php" method="POST" class="FormularioAjax" data-form="delete" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['AsigCodigo']).'"> 
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

        public function eliminar_asignacion_controlador(){
            $codigo=mainModel::decryption($_POST['codigo-del']);
            $codigo=mainModel::limpiar_cadena($codigo);               
            $DelAsig=asignacionModelo:: eliminar_asignacion_modelo($codigo);

                if($DelAsig->rowCount()>=1){
                        $alerta = [
                            "Alerta"=>"recargar",
                            "Titulo"=>"Materia Eliminada",
                            "Texto"=>"La materia fue eliminado con exito del sistema",
                            "Tipo"=>"success"
                        ];
                }else{
                        $alerta = [
                            "Alerta"=>"simple",
                            "Titulo"=>"Ocurrió un error inesperado",
                            "Texto"=>"No podemos eliminar esta materia en este momento",
                            "Tipo"=>"error"
                        ]; 
                    }
                return mainModel::sweet_alert($alerta);
        }

        public function datos_asignacion_controlador($codigo){
            $codigo=mainModel::decryption($codigo);
            return asignacionModelo::datos_asignacion_modelo($codigo);
        }

        public function actualizar_asignacion_controlador(){
            $codigo=mainModel::decryption($_POST['codigo-up']);
            $nombre = mainModel::limpiar_cadena($_POST['nombre-up']);
            $curso = mainModel::limpiar_cadena($_POST['optionsAsig-up']);
            $docente = mainModel::decryption($_POST['optionsDoc-up']);

            $dataAsig=[
                "NombreCurso"=>$curso,
                "NombreMateria"=>$nombre,
                "Cuenta"=>$docente,
                "Codigo"=>$codigo
            ];

            $upAsig=asignacionModelo::actualizar_asignacion_modelo($dataAsig);
            if($upAsig->rowCount()>=1){
                $alerta = [
                    "Alerta"=>"recargar",
                    "Titulo"=>"Materias Actualizada",
                    "Texto"=>"La materia se actualizo con exito",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"Ocurrio un error y no se pudo actualizar la materia.",
                    "Tipo"=>"error"
                ];
            }return mainModel::sweet_alert($alerta);

        }

    }

        