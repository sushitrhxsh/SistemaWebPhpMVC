<?php

    if($peticionAjax){
        require_once "../models/loginModel.php";
    } else {
        require_once "./models/loginModel.php";
    }

    class loginController extends loginModel
    {

        /*----- Controlador Iniciar sesion  -----*/
        public function iniciarSesionController() {
            $usuario = mainModel::limpiarCadena($_POST['usuario_log']);
            $clave   = mainModel::limpiarCadena($_POST['clave_log']);

            // Comprobar campos vacios 
            if(($usuario == "" || empty($usuario)) ||( $clave == "" || empty($clave))){
                echo '
                <script>
                    Swal.fire({
                        title:  "Ocurrio un error inesperado",
                        text:   "No has llenado todos los campos que son requeridos",
                        type:   "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>';
                exit();
            }

            // Verificar la integridad de los datos
            if(mainModel::verificarDatos("[a-zA-Z0-9]{1,35}",$usuario)){
                echo '
                <script>
                    Swal.fire({
                        title:  "Ocurrio un error inesperado",
                        text:   "El nombre de usuario no coincide con el formato solicitado",
                        type:   "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>';
                exit();
            }

            if(mainModel::verificarDatos("[a-zA-Z0-9$@.-]{7,100}",$clave)){
                echo '
                <script>
                    Swal.fire({
                        title:  "Ocurrio un error inesperado",
                        text:   "La clave no coincide con el formato solicitado",
                        type:   "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>';
                exit();
            }

            $clave = mainModel::encryption($clave); // encrptar
            $datosLogin = [
                "Usuario" => $usuario,
                "Clave"   => $clave  
            ];

            $datosCuenta = loginModel::iniciarSesionModel($datosLogin);
            if($datosCuenta->rowCount() == 1){
                $row = $datosCuenta->fetch();
                
                session_start(['name' => 'SPF']);
                $_SESSION['id_spf']         = $row['usuario_id'];
                $_SESSION['nombre_spf']     = $row['usuario_nombre'];
                $_SESSION['apellido_spf']   = $row['usuario_apellido'];
                $_SESSION['usuario_spf']    = $row['usuario_usuario'];
                $_SESSION['privilegio_spf'] = $row['usuario_privilegio'];
                $_SESSION['token_spf']      = md5(uniqid(mt_rand(),true));

                return header("Location: ".SERVERURL."home/");

            } else {
                echo '
                <script>
                    Swal.fire({
                        title:  "Ocurrio un error inesperado",
                        text:   "El usuario o clave son incorrectos",
                        type:   "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>';
                exit();
            }

        } /* Fin controlador */

        /*----- Controlador forzar cierree de sesion  -----*/
        public function forzarCierreSesionController() {
            session_unset();
            session_destroy();

            if(headers_sent()){
                return "<script> window.location.href = '".SERVERURL."login/'; </script>";
            } else {
                return header("Location: ".SERVERURL."login/");
            }

        } /* Fin controlador */


    }

?>