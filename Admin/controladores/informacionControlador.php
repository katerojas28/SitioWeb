<?php
        if($peticionAjax){
            require_once "../modelos/informacionModelo.php";
        }else{
            require_once "./modelos/informacionModelo.php";
        }

        class informacionControlador extends informacionModelo{
            public function mostrar_informacion_controlador(){
            
                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM informacion ";
                $tabla="";
                
                $conexion = mainModel::conectar();
                $datos = $conexion->query($consulta);
                $datos = $datos->fetchAll();


                $tabla.='
                <div class="table-responsive">
                <table class="table table-hover text-center">
                    <thead>
                        <tr>
                            <th class="text-center">FACEBOOK</th>
                            <th class="text-center">TWITTER</th>
                            <th class="text-center">EMAIL</th>
                            <th class="text-center">TELÉFONO</th>
                            <th class="text-center">DIRECCIÓN</th>'; 
                            $tabla.='
                            <th class="text-center">ACTUALIZAR</th>
                ';
                            

                $tabla.='</tr></thead><tbody>';

               
                foreach($datos as $rows){
                    $tabla.='
                        <tr>
							<td>'.$rows['InfoFacebook'].'</td>
							<td>'.$rows['InfoTwitter'].'</td>
							<td>'.$rows['InfoEmail'].'</td>
							<td>'.$rows['InfoTelefono'].'</td>
                            <td>'.$rows['InfoDireccion'].'</td>';
                    $tabla.='   
                    <td>
                        <a href="'.SERVERURL.'infoup/admin/'.mainModel::encryption($rows['id']).'/" class="btn btn-success btn-raised btn-xs">
                            <i class="zmdi zmdi-refresh"></i>
                        </a>
                    </td>';			
                    $tabla.='</tr>';
                }
                $tabla.='</tbody></table></div>';
                return$tabla;
            }

            public function actualizar_informacion_controlador(){
                $codigo=mainModel::decryption($_POST['cuenta-up']);
                $facebook=mainModel::limpiar_cadena($_POST['facebook-up']);
                $twitter=mainModel::limpiar_cadena($_POST['twitter-up']);
                $email=mainModel::limpiar_cadena($_POST['email-up']);
                $telefono=mainModel::limpiar_cadena($_POST['telefono-up']);
                $direccion=mainModel::limpiar_cadena($_POST['direccion-up']);
                

                $dataIn=[
                    "Facebook"=>$facebook,
                    "Twitter"=>$twitter,
                    "Email"=>$email,
                    "Telefono"=>$telefono,
                    "Direccion"=>$direccion,
                    "Codigo"=>$codigo

                ];

                $actualizar=informacionModelo::actualizar_informacion_modelo($dataIn);

                if($actualizar->rowCount()>=1){
                $alerta = [
                    "Alerta"=>"recargar",
                    "Titulo"=>"Datos Actualizados",
                    "Texto"=>"Los datos han sido actualizados con exito",
                    "Tipo"=>"success"
                ];
                }else{
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"No se ha podido actualizar los datos, por favor intente nuevamente",
                        "Tipo"=>"error"
                    ];
                    }
                return mainModel::sweet_alert($alerta);
            }

            public function mostrar_datos_informacion_controlador($codigo){
                $codigo=mainModel::decryption($codigo);
                return informacionModelo::datos_informacion_modelo($codigo);
            }
        }