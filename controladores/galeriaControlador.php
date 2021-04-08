<?php
        if($peticionAjax){
            require_once "../modelos/galeriaModelo.php";
        }else{
            require_once "./modelos/galeriaModelo.php";
        }

        class galeriaControlador extends galeriaModelo{

        public function datos_galeria_controlador(){
            return galeriaModelo::datos_galeria_modelo();
        }

        public function paginador_galeria_controlador($pagina, $registros, $codigo, $referencia){
            $pagina=mainModel::limpiar_cadena ($pagina);
            $registros=mainModel::limpiar_cadena ($registros);
            $codigo=mainModel::limpiar_cadena ($codigo);
            $referencia=mainModel::limpiar_cadena ($referencia);
            $tabla="";
            
            $pagina=(isset($pagina) && $pagina>0) ? (int) $pagina :1;//limipiar la variable por si la manipulan desde el browser
            $inicio=($pagina>0) ? (($pagina*$registros)-$registros) : 0;

          
            $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM galeria 
            WHERE GaleriaCategoria LIKE '%$codigo%'
            ORDER BY GaleriaFecha DESC LIMIT $inicio,$registros";
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

                    <div class="contenedor-section-galeria">
                    <img src="'.SERVERURL.'Admin/adjuntos/galeria/'.$rows['GaleriaNomArchivo'].'" type="'.$rows['GaleriaTipArchivo'].'" alt="">
                    <h3>'.$rows['GaleriaTitulo'].'</h3>
                    <p>'.$rows['GaleriaDescripcion'].'</p>
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
                        $tabla.='<section class="galeria"><nav class="text-center"><ul class="pagination pagination-sm">
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

        public function paginador_video_controlador($pagina, $registros, $codigo, $referencia){
            $pagina=mainModel::limpiar_cadena ($pagina);
            $registros=mainModel::limpiar_cadena ($registros);
            $codigo=mainModel::limpiar_cadena ($codigo);
            $referencia=mainModel::limpiar_cadena ($referencia);
            $tabla="";
            
            $pagina=(isset($pagina) && $pagina>0) ? (int) $pagina :1;//limipiar la variable por si la manipulan desde el browser
            $inicio=($pagina>0) ? (($pagina*$registros)-$registros) : 0;

          
            $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM galeria 
            WHERE GaleriaCategoria LIKE '%$codigo%'
            ORDER BY GaleriaFecha DESC LIMIT $inicio,$registros";
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

                    <div class="contenedor-section-galeria">
                    <embed src="'.SERVERURL.'Admin/adjuntos/galeria/'.$rows['GaleriaNomArchivo'].'"  type="'.$rows['GaleriaTipArchivo'].'" controls autoplay /> </embed>
  
                    <h3>'.$rows['GaleriaTitulo'].'</h3>
                    <p>'.$rows['GaleriaDescripcion'].'</p>
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
                        $tabla.='<section class="galeria"><nav class="text-center"><ul class="pagination pagination-sm">
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