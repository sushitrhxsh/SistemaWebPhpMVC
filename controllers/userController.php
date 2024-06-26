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

            // Array de datos Usuario Registro
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

        /*----- Controlador Paginar los usuarios  -----*/
        public function paginadorUserController($pagina,$registros,$privilegio,$id,$url,$busqueda) {
            $pagina     = mainModel::limpiarCadena($pagina);
            $registros  = mainModel::limpiarCadena($registros);
            $privilegio = mainModel::limpiarCadena($privilegio);
            $id         = mainModel::limpiarCadena($id);
            
            $url = mainModel::limpiarCadena($url);
            $url = SERVERURL.$url."/";

            $busqueda   = mainModel::limpiarCadena($busqueda);
            $tabla = "";
            
            $pagina = (isset($pagina) && $pagina > 0) ?(int) $pagina : 1;
            $inicio = ($pagina > 0) ?(($pagina*$registros)-$registros) : 0;
            
            if(isset($busqueda) && $busqueda != ""){
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM usuario WHERE ((usuario_id != '$id' AND usuario_id != '1') 
                AND (usuario_dni LIKE '%$busqueda%' OR usuario_nombre LIKE '%$busqueda%' OR usuario_apellido LIKE '%$busqueda%' 
                OR usuario_telefono LIKE '%$busqueda%') OR usuario_email LIKE '%$busqueda%' OR usuario_usuario LIKE '%$busqueda%') 
                ORDER BY usuario_nombre ASC LIMIT $inicio,$registros";

            } else {
                $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM usuario WHERE usuario_id != '$id' AND usuario_id != '1' ORDER BY usuario_nombre ASC LIMIT $inicio,$registros";
            }

            $conn = mainModel::conectar();
            $datos = $conn->query($consulta);
            $datos = $datos->fetchAll();

            $total = $conn->query("SELECT FOUND_ROWS()");
            $total = (int) $total->fetchColumn();

            $numPaginas = ceil($total / $registros);
            
            $tabla.= '<div class="table-responsive">
                <table class="table table-dark table-sm">
                    <thead>
                        <tr class="text-center roboto-medium">
                            <th>#</th>
                            <th>DNI</th>
                            <th>NOMBRE</th>
                            <th>APELLIDO</th>
                            <th>TELÉFONO</th>
                            <th>USUARIO</th>
                            <th>EMAIL</th>
                            <th>ACTUALIZAR</th>
                            <th>ELIMINAR</th>
                        </tr>
                    </thead>
                    <tbody>';
            
            if($total > 1 && $pagina <= $numPaginas){
                $count = $inicio+1;
                
                foreach($datos as $row){
                    $tabla.= '
                    <tr class="text-center">
                        <td>'.$count.'</td>
                        <td>'.$row['usuario_dni'].'</td>
                        <td>'.$row['usuario_nombre'].'</td>
                        <td>'.$row['usuario_apellido'].'</td>
                        <td>'.$row['usuario_telefono'].'</td>
                        <td>'.$row['usuario_usuario'].'</td>
                        <td>'.$row['usuario_email'].'</td>
                        <td>
                            <a href="<?php echo SERVERURL; ?>user-update/" class="btn btn-success">
                                <i class="fas fa-sync-alt"></i>
                            </a>
                        </td>
                        <td>
                            <form action="">
                                <button type="button" class="btn btn-warning">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
				    </tr>';
                    $count++;

                }
            } else {
                if($total >= 1){
                    $tabla.='<tr class="text-center">
                        <td colspan="9"><a href="'.$url.'" class="btn btn-raised btn-primary btn-sm">Haga clic para recargar el listado</a></td>
                    </tr>';
                    
                } else {
                    $tabla.='<tr class="text-center"><td colspan="9">No hay registros</td></tr>';
                }
            }
            
            $tabla.= '</tbody></table></div>';

            if($total > 1 && $pagina <= $numPaginas){
                $tabla.= mainModel::paginadorTablas($pagina,$numPaginas,$url,7);
            }

            return $tabla;
        }/* fin controlador */

    }


?>