<?php 
    require_once "mainModel.php";

    class userModel extends mainModel
    {
        
        /*----- Modelo agregar usuario  -----*/
        protected static function agregarUserModel($datos) {
            $sql = mainModel::conectar()->prepare("INSERT INTO usuario(usuario_dni,usuario_nombre,usuario_apellido,usuario_telefono,usuario_direccion,usuario_email,usuario_usuario,usuario_clave,usuario_estado,usuario_privilegio) 
                VALUES(:dni,:nombre,:apellido,:telefono,:direccion,:email,:usuario,:clave,:estado,:privilegio)");
            $sql->bindParam(':dni',      $datos['DNI']);
            $sql->bindParam(':nombre',   $datos['Nombre']);
            $sql->bindParam(':apellido', $datos['Apellido']);
            $sql->bindParam(':telefono', $datos['Telefono']);
            $sql->bindParam(':direccion',$datos['Direccion']);
            $sql->bindParam(':email',    $datos['Email']);
            $sql->bindParam(':usuario',  $datos['Usuario']);
            $sql->bindParam(':clave',    $datos['Clave']);
            $sql->bindParam(':estado',   $datos['Estado']);
            $sql->bindParam(':privilegio',$datos['Privilegio']);
            $sql->execute();

            return $sql;
        }

        /*----- Modelo eliminar usuario  -----*/
        protected static function eliminarUserModel($id) {
            $sql = mainModel::conectar()->prepare("DELETE FROM usuario where usuario_id =:Id");
            $sql->bindParam(':Id', $id);
            $sql->execute();

            return $sql;
        }

        /*----- Modelo datos usuario  -----*/
        protected static function datosUserModel($tipo, $id) {
            if($tipo == "Unico"){
                $sql = mainModel::conectar()->prepare("SELECT * FROM usuario WHERE usuario_id = :Id");
                $sql->bindParam(':Id',$id);

            } elseif($tipo == "Conteo") {
                $sql = mainModel::conectar()->prepare("SELECT usuario_id FROM usuario WHERE usuario_id != '1'");
            }

            $sql->execute();
            return $sql;
        }



    }


?>