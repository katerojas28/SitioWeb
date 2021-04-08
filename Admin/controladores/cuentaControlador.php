<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";
      }

    class cuentaControlador extends mainModel {

        public function datos_cuenta_controlador ($codigo,$tipo){
            $codigo=mainModel::decryption($codigo);
            $tipo=mainModel::limpiar_cadena ($tipo);
            if($tipo=="admin"){
                $tipo="Administrador";
            }
            else{
                $tipo="otrouser";
            }
            return mainModel::datos_cuenta ($codigo,$tipo);
        }

        public function actualizar_cuenta_controlador (){
            $CuentaCodigo=mainModel::decryption($_POST['CodigoCuenta-up']);
            $CuentaTipo=mainModel::decryption($_POST['tipoCuenta-up']);

            $query1=mainModel::ejecutar_consulta_simple("SELECT * FROM cuenta WHERE CuentaCodigo='$CuentaCodigo'");

            $DatosCuenta=$query1->fetch();

            $user=mainModel::limpiar_cadena ($_POST['userLog-up']);
            $password=mainModel::limpiar_cadena ($_POST['passwordLog-up']);
            $password=mainModel::encryption($password);

            if($user!="" && $password!=""){
                if(isset($_POST['privilegio-up'])){
                    $login=mainModel::ejecutar_consulta_simple ("SELECT id FROM cuenta 
                    WHERE CuentaUsuario='$user' AND CuentaClave='$password'");
                }else{
                    $login=mainModel::ejecutar_consulta_simple ("SELECT id FROM cuenta 
                    WHERE CuentaUsuario='$user' AND CuentaClave='$password' AND CuentaCodigo='$CuentaCodigo'");
                }
                if($login->rowCount()==0){
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"El nombre de usuario y contraseña que acaba de ingresar no coinciden con los datos de su cuenta",
                        "Tipo"=>"error"
                    ];
                    return mainModel::sweet_alert($alerta);
                    exit();
                }
            }else{
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"Para actualizar los datos de la cuenta debe de ingresar el nombre de usuario y contraseña, 
                    por favor ingrese los datos e intente nuevamente",
                    "Tipo"=>"error"
                ];
                return mainModel::sweet_alert($alerta);
                exit();
            }


            //verificar Usuario
            $CuentaUsuario=mainModel::limpiar_cadena ($_POST['usuario-up']);

            if($CuentaUsuario!=$DatosCuenta['CuentaUsuario']){
                $query2=mainModel::ejecutar_consulta_simple ("SELECT CuentaUsuario FROM cuenta WHERE CuentaUsuario='$CuentaUsuario'");
                if($query2->rowCount()>=1){
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"El nombre de usuario que acaba de ingresar ya se encuentra resgistrado en el sistema",
                        "Tipo"=>"error"
                    ];
                    return mainModel::sweet_alert($alerta);
                    exit();
                }
            }

            //verificar Email
            $CuentaEmail=mainModel::limpiar_cadena ($_POST['email-up']);
            if($CuentaEmail!=$DatosCuenta['CuentaEmail']){
                $query3=mainModel::ejecutar_consulta_simple ("SELECT CuentaEmail FROM cuenta WHERE CuentaEmail='$CuentaEmail'");
                if($query3->rowCount()>=1){
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"El email que acaba de ingresar ya se encuentra resgistrado en el sistema",
                        "Tipo"=>"error"
                    ];
                    return mainModel::sweet_alert($alerta);
                    exit();
                }
            }

            //Genero
            $CuentaGenero=mainModel::limpiar_cadena ($_POST['optionsGenero-up']);

            //Estado
            if(isset($_POST['optionsEstado-up'])){
            $CuentaEstado=mainModel::limpiar_cadena ($_POST['optionsEstado-up']);
            }else{
                $CuentaEstado=$DatosCuenta['CuentaEstado'];
            }


            //privilegio
            if($CuentaTipo=="admin"){
                if(isset($_POST['optionsPrivilegio-up'])){
                    $CuentaPrivilegio=mainModel::decryption($_POST['optionsPrivilegio-up']);
                }else{
                    $CuentaPrivilegio=$DatosCuenta['CuentaPrivilegio'];
                }

                //FOTO
                if($CuentaGenero=="Masculino"){
                    if($CuentaPrivilegio == "1"){
                        $CuentaFoto = "AdminMaleAvatar.png";
                    }else{
                    $CuentaFoto = "TeacherMaleAvatar.png";
                    }
                }else{
                    if($CuentaPrivilegio == "1"){
                        $CuentaFoto = "AdminFemaleAvatar.png";
                    }else{
                    $CuentaFoto = "TeacherFemaleAvatar.png";
                    }
                }


            }else{
                $CuentaPrivilegio=$DatosCuenta['CuentaPrivilegio'];
                 //FOTO
                 if($CuentaGenero=="Masculino"){
                    $CuentaFoto = "AdminMaleAvatar.png";
                }else{
                    $CuentaFoto = "AdminFemaleAvatar.png";
                }
            }

            //VERIFICAR CAMBIO DE LA CONTRASEÑA
            $passwordNueva1=mainModel::limpiar_cadena ($_POST['newPassword1-up']);
            $passwordNueva2=mainModel::limpiar_cadena ($_POST['newPassword2-up']);

            if($passwordNueva1!="" || $passwordNueva2!=""){
                if($passwordNueva1==$passwordNueva2){
                    $CuentaContraseña=mainModel::encryption($passwordNueva1);
                }else{
                    $alerta = [
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"Las nuevas contraseñas que acaba de ingresar no coinciden, por favor intenete nuevamente",
                        "Tipo"=>"error"
                    ];
                    return mainModel::sweet_alert($alerta);
                    exit();
                }
            }else{
            $CuentaContraseña=$DatosCuenta['CuentaClave'];
            }



            //EVIO DE DATOS AL MODELO ACTUALIZAR
            $datosUP=[
                "CuentaPrivilegio"=>$CuentaPrivilegio,
                "CuentaCodigo"=>$CuentaCodigo,
                "CuentaUsuario"=>$CuentaUsuario,
                "CuentaClave"=>$CuentaContraseña,
                "CuentaEmail"=>$CuentaEmail,
                "CuentaEstado"=>$CuentaEstado,
                "CuentaGenero"=>$CuentaGenero,
                "CuentaFoto"=>$CuentaFoto
            ];

            if(mainModel::actualizar_cuenta ($datosUP)){

                if(!isset($_POST['privilegio-up'])){
                    session_start(['name'=>'IELG']);
                    $_SESSION['usuario_ielg']=$CuentaUsuario;
                    $_SESSION['foto_ielg']=$CuentaFoto;
                }

                $alerta = [
                    "Alerta"=>"recargar",
                    "Titulo"=>"Cuenta Actualizada",
                    "Texto"=>"Los datos de la cuenta se actualizaron con éxito",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"Lo sentimos no hemos podido actualizar los datos de la cuenta",
                    "Tipo"=>"error"
                ]; 
            }
            return mainModel::sweet_alert($alerta);

        }
    

    }