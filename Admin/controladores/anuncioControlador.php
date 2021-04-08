<?php
        if($peticionAjax){
            require_once "../modelos/anuncioModelo.php";
        }else{
            require_once "./modelos/anuncioModelo.php";
        }

        class anuncioControlador extends anuncioModelo{

            //Controlador para agregar anuncios
            public function agregar_anuncio_controlador(){
                $cuenta=mainModel::decryption($_POST['cuenta-reg']);
                $titulo = mainModel::limpiar_cadena($_POST['titulo-reg']);
                $descripcion = mainModel::limpiar_cadena($_POST['descripcion-reg']);
                $consulta1 = mainModel::ejecutar_consulta_simple("SELECT id FROM anuncio ");
                $numero = ($consulta1->rowCount())+1;
                $codigoA = mainModel::generar_codigo_aleatorio("AI", "9", $numero);
                $fechaActual=date("Y-m-d");
                $horaActual=date("h:i:s a");
                $tipFoto = $_FILES['imagen-reg']['type'];
            
                $revisar = getimagesize($_FILES["imagen-reg"]["tmp_name"]);
                if($revisar !== false){
                    $image = $_FILES['imagen-reg']['tmp_name'];
                    $imgContenido = addslashes(file_get_contents($image));
                    
                    if (!isset($_POST["imagen-reg"])){
                        // Verificamos si el tipo de archivo es un tipo de imagen permitido. y que el tamaño del archivo no exceda los 16MB
                        $permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
                        $limite_kb = 16384;
                        $nombre = $_FILES['imagen-reg']['name'];

                        if (in_array($_FILES['imagen-reg']['type'], $permitidos) && $_FILES['imagen-reg']['size'] <= $limite_kb * 1024){

                            // Tipo de archivo
                            $tipFoto = $_FILES['imagen-reg']['type'];

                            // Insertamos en la base de datos.
                            $dataAnuncio=[
                                "Codigo"=>$codigoA,
                                "Fecha"=>$fechaActual,
                                "Hora"=>$horaActual,
                                "Titulo"=>$titulo,
                                "Descripcion"=>$descripcion,
                                "Foto"=>$imgContenido,
                                "NomFoto"=>$nombre,
                                "TipFoto"=>$tipFoto,
                                "Cuenta"=>$cuenta
                            ];

                           // print_r($dataAnuncio);

                            $guardarAnuncio=anuncioModelo::agregar_anuncio_modelo($dataAnuncio);
                            // COndicional para verificar la subida del fichero
                            if($guardarAnuncio->rowCount()>=1){
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
                        "Texto"=>"No se ha podido cargar la imagen, Por favor seleccione imagen a subir.",
                        "Tipo"=>"error"
                    ];
                }
                return mainModel::sweet_alert($alerta);
             
                   
            }

            //Controlador para paginar administrador
            public function paginador_anuncio_controlador($pagina, $registros, $privilegio, $codigo, $busqueda){
                $pagina=mainModel::limpiar_cadena ($pagina);
                $registros=mainModel::limpiar_cadena ($registros);
                $privilegio=mainModel::limpiar_cadena ($privilegio);
                $codigo=mainModel::limpiar_cadena ($codigo);
                $busqueda=mainModel::limpiar_cadena ($busqueda);
                $tabla="";

                $pagina=(isset($pagina) && $pagina>0) ? (int) $pagina :1;//limipiar la variable por si la manipulan desde el browser
                $inicio=($pagina>0) ? (($pagina*$registros)-$registros) : 0;

                if(isset($busqueda) && $busqueda!=""){
                    $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM anuncio 
                    WHERE AnuncioTitulo LIKE '%$busqueda%' OR AnuncioDescripcion LIKE '%$busqueda%' OR AnuncioFecha LIKE '%$busqueda%' 
                    ORDER BY AnuncioFecha ASC LIMIT $inicio,$registros";

                    $paginaurl="anunciosearch";
                }else{
                    $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM anuncio ORDER BY AnuncioFecha  ASC LIMIT $inicio,$registros";
                    $paginaurl="anunciolist";
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
                            <th class="text-center">HORA</th>
                            <th class="text-center">TITULO</th>
                            <th class="text-center">DESCRIPCION</th>';
                
                            if($privilegio==1){
                            $tabla.='
                            <th class="text-center">ELIMINAR</th>
                            ';
                            }

                $tabla.='</tr>
                    </thead>
                    <tbody>
                ';

                if($total>=1 && $pagina<=$Npaginas){
                    $contador=$inicio+1;
                    foreach($datos as $rows){
                        $tabla.='
                        <tr>
									<td>'.$contador.'</td>
									<td>'.date("d/m/Y", strtotime($rows['AnuncioFecha'])).'</td>
									<td>'.$rows['AnuncioHora'].'</td>
									<td>'.$rows['AnuncioTitulo'].'</td>
                                    <td>'.$rows['AnuncioDescripcion'].'</td>';
                        if($privilegio==1){
                        $tabla.='   
									<td>
										<form action="'.SERVERURL.'ajax/anuncioAjax.php" method="POST" class="FormularioAjax" data-form="delete" enctype="multipart/form-data" autocomplete="off">
                                        <input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['AnuncioCodigo']).'">   
                                        <button type="submit" class="btn btn-danger btn-raised btn-xs">
												<i class="zmdi zmdi-delete"></i>
                                        </button>
                                        <div class="RespuestaAjax"></div>
										</form>
                                    </td>';
                        }
									
                        $tabla.='</tr>';
                    $contador++;
                    }
                }else{
                    if($total>=1){
                        $tabla.='
                        <tr>
                        <td colspan="5">
                            <a href="'.SERVERURL.$paginaurl.'/" class="btn btn-sm btn-info btn-raised">
                                Haga click acá para recargar el listado
                            </a>
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

            //controlador para eliminar anuncio 
            public function eliminar_anuncio_controlador(){
                $codigo=mainModel::decryption($_POST['codigo-del']);
                $codigo=mainModel::limpiar_cadena($codigo);               
                $DelAnuncio=anuncioModelo:: eliminar_anuncio_modelo($codigo);

                    if($DelAnuncio->rowCount()>=1){
                            $alerta = [
                                "Alerta"=>"recargar",
                                "Titulo"=>"Anuncio Eliminado",
                                "Texto"=>"El anuncio fue eliminado con exito del sistema",
                                "Tipo"=>"success"
                            ];
                    }else{
                            $alerta = [
                                "Alerta"=>"simple",
                                "Titulo"=>"Ocurrio un error inesperado",
                                "Texto"=>"No podemos eliminar este administrador en este momento",
                                "Tipo"=>"error"
                            ]; 
                        }
                    return mainModel::sweet_alert($alerta);
                    
            }

            //listar anuncios
            public function listado_anuncios_controlador($registros){
                $registros=mainModel::limpiar_cadena ($registros);
                $datos=mainModel::ejecutar_consulta_simple("SELECT * FROM anuncio ORDER BY id DESC LIMIT $registros");
    
               // while($row = mysqli_fetch_array($datos)){	
                while($row=$datos->fetch()){
                    $datosC=mainModel::ejecutar_consulta_simple("SELECT * FROM cuenta WHERE CuentaCodigo='".$row['CuentaCodigo']."'");
                    $datosC=$datosC->fetch();
    
                    $datosU=mainModel::ejecutar_consulta_simple("SELECT AdminNombre,AdminApellido FROM admin WHERE CuentaCodigo='".$row['CuentaCodigo']."'");
                    $datosU=$datosU->fetch();
    
                    $NombreCompleto=$datosU['AdminNombre']." ".$datosU['AdminApellido'];
           

                    echo'
                    <div class="card mb-3" style="max-width: 100%;">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <img src="data:'.$row['AnuncioTipFoto'].';base64,'.base64_encode(stripslashes($row['AnuncioFoto'])) .'" class="card-img" alt="..." width="99%" height="350px">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h2 class="card-title">'.$row['AnuncioTitulo'].'</h2>
                                    <p class="card-text">'.$row['AnuncioDescripcion'].'</p>
                                    <p class="card-text"><small class="text-muted"><i class="zmdi zmdi-calendar"></i> Publicado: '.date("d/m/Y", strtotime($row['AnuncioFecha'])).' &nbsp;&nbsp;<i class="zmdi zmdi-time"></i> a las '.$row['AnuncioHora'].'  &nbsp;&nbsp; <i class="zmdi zmdi-account-circle"></i> por: '.$NombreCompleto.' </small></p>  
                                </div>
                            </div>
                        </div>
                    </div>
                    <br><br><br>
                    ';
    
                }
    
            }



        }