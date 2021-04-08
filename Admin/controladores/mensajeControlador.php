<?php
        if($peticionAjax){
            require_once "../modelos/mensajeModelo.php";
        }else{
            require_once "./modelos/mensajeModelo.php";
        }

        class mensajeControlador extends mensajeModelo{

        public function paginador_mensaje_controlador($pagina, $registros, $busqueda){
            $pagina=mainModel::limpiar_cadena ($pagina);
            $registros=mainModel::limpiar_cadena ($registros);
            $busqueda=mainModel::limpiar_cadena ($busqueda);
            $tabla="";
            
            $pagina=(isset($pagina) && $pagina>0) ? (int) $pagina :1;//limipiar la variable por si la manipulan desde el browser
            $inicio=($pagina>0) ? (($pagina*$registros)-$registros) : 0;

            if(isset($busqueda) && $busqueda!=""){
                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM mensaje 
                WHERE MensajeAsunto LIKE '%$busqueda%' OR MensajeNombre LIKE '%$busqueda%' 
                ORDER BY MensajeFecha DESC LIMIT $inicio,$registros";

                $paginaurl="mensajesearch";
            }else{
                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM mensaje ORDER BY MensajeFecha  DESC LIMIT $inicio,$registros";
                $paginaurl="mensajelist";
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
                    <th class="text-center">FECHA</th>
                    <th class="text-center">ASUNTO</th>
                    <th class="text-center">NOMBRE</th>
                    <th class="text-center">DATOS</th>';
            
                        
            $tabla.='
                <th class="text-center">VER</th>
                <th class="text-center">ELIMINAR</th>
            ';
                            

            $tabla.='</tr></thead><tbody>';

            if($total>=1 && $pagina<=$Npaginas){
                $contador=$inicio+1;
                foreach($datos as $rows){
            
            $tabla.='
            <tr>            
                <td>'.date("d/m/Y", strtotime($rows['MensajeFecha'])).' - '.$rows['MensajeHora'].'</td>
                <td>'.$rows['MensajeAsunto'].'</td>
                <td>'.$rows['MensajeNombre'].'</td>
                <td>'.$rows['MensajeEmail'].' - '.$rows['MensajeTelefono'].'</td>';
                   
            $tabla.='
            <td>
                <a href="'.SERVERURL.'mensajeinfo/admin/'.mainModel::encryption($rows['MensajeCodigo']).'/" class="btn btn-success btn-raised btn-xs">
                <i class="zmdi zmdi-email-open"></i>
                </a>
            </td>   
            <td>
                <form action="'.SERVERURL.'ajax/mensajeAjax.php" method="POST" class="FormularioAjax" data-form="delete" enctype="multipart/form-data" autocomplete="off">
                <input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['MensajeCodigo']).'">   
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
    
        public function eliminar_mensaje_controlador(){
            $codigo=mainModel::decryption($_POST['codigo-del']);
            $codigo=mainModel::limpiar_cadena($codigo);               
            $DelMensaje=mensajeModelo:: eliminar_mensaje_modelo($codigo);

                if($DelMensaje->rowCount()>=1){
                        $alerta = [
                            "Alerta"=>"recargar",
                            "Titulo"=>"Mensaje Eliminado",
                            "Texto"=>"El mensaje fue eliminado con exito del sistema",
                            "Tipo"=>"success"
                        ];
                }else{
                        $alerta = [
                            "Alerta"=>"simple",
                            "Titulo"=>"Ocurrio un error inesperado",
                            "Texto"=>"No podemos eliminar este mensaje en este momento",
                            "Tipo"=>"error"
                        ]; 
                    }
                return mainModel::sweet_alert($alerta);
        }

        public function datos_mensaje_controlador($codigo){
            $codigo=mainModel::decryption($codigo);
            return mensajeModelo::datos_mensaje_modelo($codigo);
        }

 

    }

        