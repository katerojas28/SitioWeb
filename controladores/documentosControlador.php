<?php
        if($peticionAjax){
            require_once "../modelos/documentosModelo.php";
        }else{
            require_once "./modelos/documentosModelo.php";
        }

        class documentosControlador extends documentosModelo{

        public function datos_documentos_controlador(){
            return documentosModelo::datos_documentos_modelo();
        }

        public function paginador_documentos_controlador($pagina, $registros){
            $pagina=mainModel::limpiar_cadena ($pagina);
            $registros=mainModel::limpiar_cadena ($registros);
            $tabla="";
            
            $pagina=(isset($pagina) && $pagina>0) ? (int) $pagina :1;//limipiar la variable por si la manipulan desde el browser
            $inicio=($pagina>0) ? (($pagina*$registros)-$registros) : 0;

          
            $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM documento 
            ORDER BY DocFecha DESC LIMIT $inicio,$registros";
                $paginaurl="documentos";
            

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
                    <i class="fa fa-caret-right" aria-hidden="true"></i>
                    '. $rows['DocTitulo'].'<br>
                    <embed src="'.SERVERURL.'./vistas/assets/documentos/'.$rows['DocNomArchivo'].' type="application/pdf" width="100%" height="300px" /> 
                    <br><br> <br><br>
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