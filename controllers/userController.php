<?php 
    
    if($peticionAjax) {
        require_once "../models/userModel.php";
    } else {
        require_once "./models/userModel.php";
    }

    class userController extends userModel
    {
        /*----- Controlador agregar usuario  -----*/
        public function agregarUserController() {
            $dni =       mainModel::limpiarCadena($_POST['usuario_dni_reg']);
            $nombre =    mainModel::limpiarCadena($_POST['usuario_nombre_reg']);
            $apellido =  mainModel::limpiarCadena($_POST['usuario_apellido_reg']);
            $telefono =  mainModel::limpiarCadena($_POST['usuario_telefono_reg']);
            $direccion = mainModel::limpiarCadena($_POST['usuario_direccion_reg']);
            
            $usuario =   mainModel::limpiarCadena($_POST['usuario_usuario_reg']);
            $email =     mainModel::limpiarCadena($_POST['usuario_email_reg']);
            $clave1 =    mainModel::limpiarCadena($_POST['usuario_clave_1_reg']);
            $clave2 =    mainModel::limpiarCadena($_POST['usuario_clave_2_reg']);
            
            $privilegio =mainModel::limpiarCadena($_POST['usuario_privilegio_reg']);
            
            // Comprobar campos vacios
            if(($dni == "" || empty($dni)) || ($nombre == "" || empty($nombre)) || ($apellido == "" || empty($apellido)) || ($usuario == "" || empty($usuario)) || ($clave1 == "" || empty($clave1)) || ($clave2 == "" || empty($clave2))){
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrio un error inesperado",
                    "Texto"  => "No has llenado todos los campos obligatorios",
                    "Tipo"   => "error"
                ];

                echo json_encode($alerta);
                exit();
            }
         
        }

    }



?>