<?php 
    if($peticionAjax){
        require_once "../core/configAPP.php";
    }else{
        require_once "./core/configAPP.php";
    }
    class mainModel {

        //Conectarse de la base de datos
        protected function conectar(){
            $enlace = new PDO(SGBD,USER,PASS);
            return $enlace;
        }

        //Realizar consultas a la base de datos 
        protected function ejecutar_consulta_simple ($consulta){
            $respuesta=self::conectar()->prepare($consulta);
            $respuesta->execute();
            return $respuesta;
        }



        //FUNCIONES DE LA CUENTA 

        protected function agregar_cuenta($datos){
            $sql=self::conectar()->prepare("INSERT INTO 
            cuenta(CuentaCodigo, CuentaPrivilegio, CuentaUsuario, CuentaClave, CuentaEmail, CuentaEstado, CuentaTipo, CuentaGenero, CuentaFoto)
             VALUES (:Codigo, :Privilegio, :Usuario, :Clave, :Email, :Estado, :Tipo, :Genero, :Foto)");
             $sql->bindParam(":Codigo",$datos['Codigo']);
             $sql->bindParam(":Privilegio",$datos['Privilegio']);
             $sql->bindParam(":Usuario",$datos['Usuario']);
             $sql->bindParam(":Clave",$datos['Clave']);
             $sql->bindParam(":Email",$datos['Email']);
             $sql->bindParam(":Estado",$datos['Estado']);
             $sql->bindParam(":Tipo",$datos['Tipo']);
             $sql->bindParam(":Genero",$datos['Genero']);
             $sql->bindParam(":Foto",$datos['Foto']);
            $sql->execute();
            return $sql;
        }

        protected function eliminar_cuenta ($codigo){
            $sql = self::conectar()->prepare("DELETE FROM cuenta WHERE CuentaCodigo=:Codigo");
            $sql->bindParam(":Codigo",$codigo);
            $sql->execute();
            return $sql;
        }

        protected function datos_cuenta ($codigo, $tipo){
            $sql = self::conectar()->prepare("SELECT * FROM cuenta WHERE CuentaCodigo=:Codigo AND CuentaTipo=:Tipo");
            $sql->bindParam(":Codigo",$codigo);
            $sql->bindParam(":Tipo",$tipo);
            $sql->execute();
            return $sql;
        }

        protected function actualizar_cuenta ($datos){
            $sql = self::conectar()->prepare("UPDATE cuenta SET 
            CuentaPrivilegio=:Privilegio,
            CuentaUsuario=:Usuario,
            CuentaClave=:Clave, 
            CuentaEmail=:Email, 
            CuentaEstado=:Estado,  
            CuentaGenero=:Genero, 
            CuentaFoto=:Foto WHERE CuentaCodigo=:Codigo ");
            $sql->bindParam(":Privilegio",$datos['CuentaPrivilegio']);
            $sql->bindParam(":Usuario",$datos['CuentaUsuario']);
            $sql->bindParam(":Clave",$datos['CuentaClave']);
            $sql->bindParam(":Email",$datos['CuentaEmail']);
            $sql->bindParam(":Estado",$datos['CuentaEstado']);
            $sql->bindParam(":Genero",$datos['CuentaGenero']);
            $sql->bindParam(":Foto",$datos['CuentaFoto']);
            $sql->bindParam(":Codigo",$datos['CuentaCodigo']);
           $sql->execute();
           return $sql;
        }




        //FUNCIONES DE LA BITACORA 

        protected function guardar_bitacora($datos){
            $sql = self::conectar()->prepare("INSERT INTO 
            bitacora (BitacoraCodigo, BitacoraFecha, BitacoraHoraInicio, BitacoraHoraFinal, BitacoraTipo, BitacoraYear, CuentaCodigo) 
            VALUES (:Codigo, :Fecha, :HoraInicio, :HoraFinal, :Tipo, :Year, :Cuenta)");
            $sql->bindParam(":Codigo",$datos['Codigo']);
            $sql->bindParam(":Fecha",$datos['Fecha']);
            $sql->bindParam(":HoraInicio",$datos['HoraInicio']);
            $sql->bindParam(":HoraFinal",$datos['HoraFinal']);
            $sql->bindParam(":Tipo",$datos['Tipo']);
            $sql->bindParam(":Year",$datos['Year']);
            $sql->bindParam(":Cuenta",$datos['Cuenta']);
            $sql->execute();
            return $sql;
        }

        protected function actualizar_bitacora($codigo,$hora){
            $sql = self::conectar()->prepare("UPDATE bitacora SET BitacoraHoraFinal=:Hora WHERE BitacoraCodigo=:Codigo");
            $sql->bindParam(":Hora",$hora);
            $sql->bindParam(":Codigo",$codigo);
            $sql->execute();
            return $sql;
        }

        protected function eliminar_bitacora($codigo){
            $sql = self::conectar()->prepare("DELETE FROM bitacora WHERE CuentaCodigo=:Codigo");
            $sql->bindParam(":Codigo",$codigo);
            $sql->execute();
            return $sql;
        }





        public function encryption($string){
			$output=FALSE;
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_encrypt($string, METHOD, $key, 0, $iv);
			$output=base64_encode($output);
			return $output;
		}
		protected function decryption($string){
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
			return $output;
        }
        
        protected function generar_codigo_aleatorio ($letra, $longitud, $num){
            for ($i=1; $i<=$longitud;$i++) {
                $numero = rand(0,9);
                $letra.= $numero;
            }
            return $letra.$num;
        }


        protected function limpiar_cadena ($cadena){
            $cadena = trim($cadena);
            $cadena = stripslashes($cadena);
            $cadena = str_ireplace("<script>","",$cadena);
            $cadena = str_ireplace("</script>","",$cadena);
            $cadena = str_ireplace("<script src","",$cadena);
            $cadena = str_ireplace("<script type=","",$cadena);
            $cadena = str_ireplace("SELECT * FROM","",$cadena);
            $cadena = str_ireplace("DELETE FROM","",$cadena);
            $cadena = str_ireplace("INSERT INTO","",$cadena);
            $cadena = str_ireplace("--","",$cadena);
            $cadena = str_ireplace("^","",$cadena);
            $cadena = str_ireplace("[","",$cadena);
            $cadena = str_ireplace("]","",$cadena);
            $cadena = str_ireplace("==","",$cadena);
            $cadena = str_ireplace(";","",$cadena);
            return $cadena;
        }


        protected function file_name($string) {
            // Tranformamos todo a minusculas
            $string = strtolower($string);
            //Rememplazamos caracteres especiales latinos
            $find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
            $repl = array('a', 'e', 'i', 'o', 'u', 'n');
            $string = str_replace($find, $repl, $string);
            // Añadimos los guiones
            $find = array(' ', '&', '\r\n', '\n', '+','-');
            $string = str_replace($find,'',$string);
            
            return $string;
        }
        


        //Generar diferentes tipos de alertas para el sistema
        protected function sweet_alert($datos){
            if($datos['Alerta'] == "simple"){
                $alerta = "
                    <script>
                    swal(
                        '".$datos['Titulo']."',
                        '".$datos['Texto']."',
                        '".$datos['Tipo']."'
                    );
                    </script>
                ";
            }elseif($datos['Alerta'] == "recargar"){
                $alerta = "
                <script>
                swal({
                    title: '".$datos['Titulo']."',
                    text: '".$datos['Texto']."',
                    type: '".$datos['Tipo']."',
                    confirmButtonText: 'Aceptar'
                }).then(function () {
                    location.reload();
                });
                </script>
            ";
            }elseif($datos['Alerta'] == "limpiar"){
                $alerta = "
                <script>
                swal({
                    title: '".$datos['Titulo']."',
                    text: '".$datos['Texto']."',
                    type: '".$datos['Tipo']."',
                    confirmButtonText: 'Aceptar'
                }).then(function () {
                    $('.FormularioAjax')[0].reset();
                });
                </script>
            ";
            }
            return $alerta;
        }
    }