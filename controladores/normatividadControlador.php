<?php
        if($peticionAjax){
            require_once "../modelos/normatividadModelo.php";
        }else{
            require_once "./modelos/normatividadModelo.php";
        }

        class normatividadControlador extends normatividadModelo{  

        public function paginador_normatividad_controlador($pagina, $registros, $codigo, $referencia){
            $pagina=mainModel::limpiar_cadena ($pagina);
            $registros=mainModel::limpiar_cadena ($registros);
            $codigo=mainModel::limpiar_cadena ($codigo);
            $referencia=mainModel::limpiar_cadena ($referencia);
            $tabla="";
            
            $pagina=(isset($pagina) && $pagina>0) ? (int) $pagina :1;//limipiar la variable por si la manipulan desde el browser
            $inicio=($pagina>0) ? (($pagina*$registros)-$registros) : 0;

          
            $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM normatividad 
            WHERE NormaCategoria LIKE '%$codigo%'
            ORDER BY NormaFecha DESC LIMIT $inicio,$registros";
                $paginaurl=$referencia;
            

                $conexion = mainModel::conectar();
                $datos = $conexion->query($consulta);
                $datos = $datos->fetchAll();
                $total = $conexion->query("SELECT FOUND_ROWS()");
                $total = (int) $total->fetchColumn();
                $Npaginas = ceil($total/$registros);


            if($total>=1 && $pagina<=$Npaginas){
                $contador=$inicio+1;
                foreach($datos as $rows){
            
                    $tabla.='
                    <div class="contenedor-section-normatividad">
                    
                    
                        <h3>'.$rows['NormaTitulo'].'</h3>
                            <p>'.$rows['NormaDescripcion'].'</p>
                        <a href="" data-toggle="modal" data-target="#exampleModal">'.$rows['NormaNomArchivo'].'</a>
                        <h6>Escrito el '.date("d/m/Y", strtotime($rows['NormaFecha'])).' a las '.$rows['NormaHora'].'</h6>
                        
                        <!-- Modal -->
                        <div class="modal-xl" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-body">
                                    <embed src="'.SERVERURL.'Admin/adjuntos/'.$rows['NormaNomArchivo'].'" type="application/pdf" width="100%" height="300px" />
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    ';
                   
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

                    if($total>=1 && $pagina<=$Npaginas){
                        $tabla.='<section><nav class="text-center"><ul class="pagination pagination-sm">
                        ';
        
                        if($pagina==1){
                            $tabla.='<li class="disabled"><a>Anterior</a></li>';
                        }else{
                            $tabla.='<li><a href="'.SERVERURL.$paginaurl.'/'.($pagina-1).'">Anterior</a></li>';
                        }
        
        
                        for($i=1;$i<=$Npaginas;$i++){
        
                            if($pagina==$i){
                                $tabla.='<li class="active"><a href="'.SERVERURL.$paginaurl.'/'.$i.'">'.$i.'</a></li>';
                            }else{
                                $tabla.='<li><a href="'.SERVERURL.$paginaurl.'/'.$i.'">'.$i.'</a></li>';
                            }
        
                        }
        
        
        
                        if($pagina==$Npaginas){
                            $tabla.='<li class="disabled"><a>Siguiente</a></li>';
                        }else{
                            $tabla.='<li><a href="'.SERVERURL.$paginaurl.'/'.($pagina+1).'">Siguiente</a></li>';
                        }
        
                        $tabla.='</ul></nav></section>';
                    }
        
                    return$tabla;
        
                }
    }