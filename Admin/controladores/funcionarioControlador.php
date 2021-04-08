<?php
        if($peticionAjax){
            require_once "../modelos/funcionarioModelo.php";
        }else{
            require_once "./modelos/funcionarioModelo.php";
        }

        class funcionarioControlador extends funcionarioModelo{

            //Controlador para agregar funcionario
        public function agregar_funcionario_controlador(){
            $cargo = mainModel::limpiar_cadena($_POST['cargo-reg']);
            $nombre = mainModel::limpiar_cadena($_POST['nombre-reg']);
            $apellido = mainModel::limpiar_cadena($_POST['apellido-reg']);
            $descripcion = mainModel::limpiar_cadena($_POST['descripcion-reg']);
            $consulta1 = mainModel::ejecutar_consulta_simple("SELECT id FROM funcionario ");
            $numero = ($consulta1->rowCount())+1;
            $codigo = mainModel::generar_codigo_aleatorio("FC", "9", $numero);
            $tipFoto = $_FILES['imagen-reg']['type'];

            $revisar = getimagesize($_FILES["imagen-reg"]["tmp_name"]);
            if($revisar !== false){
                $image = $_FILES['imagen-reg']['tmp_name'];
                $imgContenido = addslashes(file_get_contents($image));
                if (!isset($_POST["imagen-reg"])){
                    $permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
                    $limite_kb = 16384;
                    $nombrefoto = $_FILES['imagen-reg']['name'];
                    if (in_array($_FILES['imagen-reg']['type'], $permitidos) && $_FILES['imagen-reg']['size'] <= $limite_kb * 1024){


                        // Insertamos en la base de datos.
                        $dataFun=[
                            "Codigo"=>$codigo,
                            "Cargo"=>$cargo,
                            "Nombre"=>$nombre,
                            "Apellido"=>$apellido,
                            "Descripcion"=>$descripcion,
                            "Foto"=>$imgContenido,
                            "NomFoto"=>$nombrefoto,
                            "TipFoto"=>$tipFoto
                        ];

                        $guardarFun=funcionarioModelo::agregar_funcionario_modelo($dataFun);
                        // COndicional para verificar la subida del fichero
                        if($guardarFun->rowCount()>=1){
                            $alerta = [
                                "Alerta"=>"limpiar",
                                "Titulo"=>"Funcionario Registrado",
                                "Texto"=>"El funcionario se registro con exito",
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

        public function paginador_funcionario_controlador($pagina, $registros, $busqueda){
            $pagina=mainModel::limpiar_cadena ($pagina);
            $registros=mainModel::limpiar_cadena ($registros);
            $busqueda=mainModel::limpiar_cadena ($busqueda);
            $tabla="";
            
            $pagina=(isset($pagina) && $pagina>0) ? (int) $pagina :1;//limipiar la variable por si la manipulan desde el browser
            $inicio=($pagina>0) ? (($pagina*$registros)-$registros) : 0;

            
                if(isset($busqueda) && $busqueda!=""){
                    $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM funcionario 
                    WHERE FunCargo LIKE '%$busqueda%' OR FunNombre LIKE '%$busqueda%'
                    OR FunApellido LIKE '%$busqueda%' 
                    ORDER BY FunNombre ASC LIMIT $inicio,$registros";
    
                    $paginaurl="funcionariosearch";
                }else{
                    $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM funcionario ORDER BY FunNombre ASC LIMIT $inicio,$registros";
                    $paginaurl="funcionariolist";
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
                    <th class="text-center">CARGO</th>
                    <th class="text-center">NOMBRE</th>
                    <th class="text-center">APELLIDO</th>
                    <th class="text-center">FOTO</th>';
            
                        
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
                <td>'.$rows['FunCargo'].'</td>
                <td>'.$rows['FunNombre'].'</td>
                <td>'.$rows['FunApellido'].'</td>
                <td> <img src="data:'.$rows['FunTipFoto'].';base64,'.base64_encode(stripslashes($rows['FunFoto'])) .'" class="img-responsive" alt="..."></td>';
                $tabla.='
                <td>
                    <a href="'.SERVERURL.'funcionarioinfo/admin/'.mainModel::encryption($rows['FunCodigo']).'/" class="btn btn-success btn-raised btn-xs">
                    <i class="zmdi zmdi-refresh"></i>
                    </a>
                </td>   
                <td>
                    <form action="'.SERVERURL.'ajax/funcionarioAjax.php" method="POST" class="FormularioAjax" data-form="delete" enctype="multipart/form-data" autocomplete="off">
                    <input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['FunCodigo']).'">   
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
        
        public function eliminar_funcionario_controlador(){
            $codigo=mainModel::decryption($_POST['codigo-del']);
            $codigo=mainModel::limpiar_cadena($codigo);               
            $DelFuncionario=funcionarioModelo:: eliminar_funcionario_modelo($codigo);

                if($DelFuncionario->rowCount()>=1){
                        $alerta = [
                            "Alerta"=>"recargar",
                            "Titulo"=>"Funcionario Eliminado",
                            "Texto"=>"El funcionario fue eliminado con exito del sistema",
                            "Tipo"=>"success"
                        ];
                }else{
                        $alerta = [
                            "Alerta"=>"simple",
                            "Titulo"=>"Ocurrio un error inesperado",
                            "Texto"=>"No podemos eliminar a este funcionario en este momento",
                            "Tipo"=>"error"
                        ]; 
                    }
                return mainModel::sweet_alert($alerta);
        }

        public function datos_funcionario_controlador($codigo){
            $codigo=mainModel::decryption($codigo);
            return funcionarioModelo::datos_funcionario_modelo($codigo);
        }

        public function actualizar_funcionario_controlador(){
            $codigo=mainModel::decryption($_POST['codigo-up']);
            $cargo = mainModel::limpiar_cadena($_POST['cargo-up']);
            $nombre = mainModel::limpiar_cadena($_POST['nombre-up']);
            $apellido = mainModel::limpiar_cadena($_POST['apellido-up']);
            $descripcion=mainModel::limpiar_cadena($_POST['descripcion-up']);
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
                    $nombrefoto = $_FILES['imagen-up']['name'];
                    // Tipo de archivo
                    $tipFoto = $_FILES['imagen-up']['type'];

                    // Insertamos en la base de datos.
                    $dataFun=[
                        "Codigo"=>$codigo,
                        "Cargo"=>$cargo,
                        "Nombre"=>$nombre,
                        "Apellido"=>$apellido,
                        "Descripcion"=>$descripcion,
                        "Foto"=>$imgContenido,
                        "NomFoto"=>$nombrefoto,
                        "TipFoto"=>$tipFoto
                    ];

                    $actualizarFun=funcionarioModelo::actualizar_funcionario_modelo($dataFun);
                    // COndicional para verificar la subida del fichero
                    if($actualizarFun->rowCount()>=1){
                    $alerta = [
                    "Alerta"=>"recargar",
                    "Titulo"=>"Funcionario Actualizado",
                    "Texto"=>"El funcionario se actualizo con exito",
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
                $query1=mainModel::ejecutar_consulta_simple ("SELECT * FROM funcionario WHERE FunCodigo='$codigo' ");
                $DatosFun=$query1->fetch();
                $img=$DatosFun['FunFoto'];
                $nomimg=$DatosFun['FunNomFoto'];
                $tipimg=$DatosFun['FunTipFoto'];


                $dataFun=[
                    "Codigo"=>$codigo,
                    "Cargo"=>$cargo,
                    "Nombre"=>$nombre,
                    "Apellido"=>$apellido,
                    "Descripcion"=>$descripcion,
                    "Foto"=>$img,
                    "NomFoto"=>$nomimg,
                    "TipFoto"=>$tipimg
                ];

                    $actualizarFun=funcionarioModelo::actualizar_funcionario_modelo($dataFun);
                    // COndicional para verificar la subida del fichero
                    if($actualizarFun->rowCount()>=1){
                    $alerta = [
                    "Alerta"=>"recargar",
                    "Titulo"=>"Funcionario Actualizado",
                    "Texto"=>"El funcionario se actualizo con exito",
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
