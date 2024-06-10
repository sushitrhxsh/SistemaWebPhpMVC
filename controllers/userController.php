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

            // verificando integridad de los datos
            if(mainModel::verificarDatos("[0-9-]{10,20}",$dni)){
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrio un error inesperado",
                    "Texto"  => "El DNI no coincide con el formato solicitado",
                    "Tipo"   => "error"
                ];

                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}",$nombre)){
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrio un error inesperado",
                    "Texto"  => "El nombre no coincide con el formato solicitado",
                    "Tipo"   => "error"
                ];

                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}",$apellido)){
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrio un error inesperado",
                    "Texto"  => "El apellido no coincide con el formato solicitado",
                    "Tipo"   => "error"
                ];

                echo json_encode($alerta);
                exit();
            }

            if($telefono != ""){
                if(mainModel::verificarDatos("[0-9()+]{8,20}",$telefono)){
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrio un error inesperado",
                        "Texto"  => "El telefono no coincide con el formato solicitado",
                        "Tipo"   => "error"
                    ];
    
                    echo json_encode($alerta);
                    exit();
                }
            }

            if($direccion != ""){
                if(mainModel::verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,190}",$direccion)){
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrio un error inesperado",
                        "Texto"  => "El direccion no coincide con el formato solicitado",
                        "Tipo"   => "error"
                    ];
    
                    echo json_encode($alerta);
                    exit();
                }
            }

            if(mainModel::verificarDatos("[a-zA-Z0-9]{1,35}",$usuario)){
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrio un error inesperado",
                    "Texto"  => "El nombre de usuario no coincide con el formato solicitado",
                    "Tipo"   => "error"
                ];

                echo json_encode($alerta);
                exit();
            }

            if(mainModel::verificarDatos("[a-zA-Z0-9$@.-]{7,12}",$clave1) || mainModel::verificarDatos("[a-zA-Z0-9$@.-]{7,12}",$clave2)){
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrio un error inesperado",
                    "Texto"  => "La contraseñas no coinciden con el formato solicitado",
                    "Tipo"   => "error"
                ];

                echo json_encode($alerta);
                exit();
            }

            // Comprobando DNI
            $checkDNI = mainModel::ejecutarConsultaSimple("SELECT usuario_dni FROM usuario WHERE usuario_dni ='$dni';");
            if($checkDNI->rowCount() > 0){
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrio un error inesperado",
                    "Texto"  => "El DNI ingresado ya se encuentra registrado, intentelo nuevamente",
                    "Tipo"   => "error"
                ];

                echo json_encode($alerta);
                exit();
            }
            
            // comprobando el nombre usuario
            $checkUser = mainModel::ejecutarConsultaSimple("SELECT usuario_usuario FROM usuario WHERE usuario_usuario ='$usuario';");
            if($checkUser->rowCount() > 0){
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrio un error inesperado",
                    "Texto"  => "El nombre de usuario ingresado ya se encuentra registrado, intentelo nuevamente",
                    "Tipo"   => "error"
                ];

                echo json_encode($alerta);
                exit();
            }

            // comprobando email
            if($email != ""){
                if(filter_var($email,FILTER_VALIDATE_EMAIL)){
                    $checkEmail = mainModel::ejecutarConsultaSimple("SELECT usuario_email FROM usuario WHERE usuario_email ='$email';");
                    
                    if($checkEmail->rowCount() > 0){
                        $alerta = [
                            "Alerta" => "simple",
                            "Titulo" => "Ocurrio un error inesperado",
                            "Texto"  => "El email ingresado ya se encuentra registrado, intentelo nuevamente",
                            "Tipo"   => "error"
                        ];

                        echo json_encode($alerta);
                        exit();
                    }
                } else {
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrio un error inesperado",
                        "Texto"  => "El email ingresado es un correo no valido, intentelo nuevamente",
                        "Tipo"   => "error"
                    ];
    
                    echo json_encode($alerta);
                    exit();
                }
            }

            // Comprobar contrasenas
            if($clave1 != $clave2){
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrio un error inesperado",
                    "Texto"  => "Las contraseñas ingresadas no coinciden, intentelo nuevamente",
                    "Tipo"   => "error"
                ];

                echo json_encode($alerta);
                exit();
            } else {
                $clave = mainModel::encryption($clave1);
            }

            // Comprobar privilegios
            if($privilegio < 1 || $privilegio > 3){
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrio un error inesperado",
                    "Texto"  => "El privilegio seleccionado no es valido",
                    "Tipo"   => "error"
                ];

                echo json_encode($alerta);
                exit();
            }

            $datosUserReg = [
                "DNI"       => $dni,
                "Nombre"    => $nombre ,
                "Apellido"  => $apellido,
                "Telefono"  => $telefono,
                "Direccion" => $direccion,
                "Email"     => $email,
                "Usuario"   => $usuario,
                "Clave"     => $clave,
                "Estado"    => "Activa",
                "Privilegio"=> $privilegio
            ];

            // Agregarlo a la bd
            $agregarUsuario = userModel::agregarUserModel($datosUserReg);
            if($agregarUsuario->rowCount() == 1){
                $alerta = [
                    "Alerta" => "limpiar",
                    "Titulo" => "Usuario registrado",
                    "Texto"  => "Los datos del usuario han sido registrados correctamente",
                    "Tipo"   => "success"
                ];

                echo json_encode($alerta);
                exit();

            } else {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrio un error inesperado",
                    "Texto"  => "No hemos podido registrar el usuario, intentelo nuevamente",
                    "Tipo"   => "error"
                ];

                echo json_encode($alerta);
                exit();
            }
        }/* fin controlador */

    }



?>