<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";
    }

    class bitacoraControlador extends mainModel{

        public function listado_bitacora_controlador($registros){
            $registros=mainModel::limpiar_cadena ($registros);
            $datos=mainModel::ejecutar_consulta_simple("SELECT * FROM bitacora ORDER BY id DESC LIMIT $registros");

            $conteo=1;
            while($row=$datos->fetch()){
                $datosC=mainModel::ejecutar_consulta_simple("SELECT * FROM cuenta WHERE CuentaCodigo='".$row['CuentaCodigo']."'");
                $datosC=$datosC->fetch();

                $datosU=mainModel::ejecutar_consulta_simple("SELECT AdminNombre,AdminApellido FROM admin WHERE CuentaCodigo='".$row['CuentaCodigo']."'");
                $datosU=$datosU->fetch();

                $NombreCompleto=$datosU['AdminNombre']." ".$datosU['AdminApellido'];

                echo '
                    <div class="cd-timeline-block">
                        <div class="cd-timeline-img">
                         <img src="'.SERVERURL.'vistas/assets/avatars/'.$datosC['CuentaFoto'].'" alt="user-picture">
                        </div>

                        <div class="cd-timeline-content">
                            <h4 class="text-center text-titles">'.$conteo.' - '.$NombreCompleto.' ('.$datosC['CuentaUsuario'].')</h4>
                            <p class="text-center">
                                <i class="zmdi zmdi-timer zmdi-hc-fw"></i> Inicio: <em>'.$row['BitacoraHoraInicio'].'</em> &nbsp;&nbsp;&nbsp; 
                                <i class="zmdi zmdi-time zmdi-hc-fw"></i> Fin: <em>'.$row['BitacoraHoraFinal'].'</em>
                            </p>
                            <span class="cd-date"><i class="zmdi zmdi-calendar-note zmdi-hc-fw"></i>'.date("d/m/Y", strtotime($row['BitacoraFecha'])).'</span>
                        </div>
                    </div>   
                ';
                $conteo++;
            }

        }
    }