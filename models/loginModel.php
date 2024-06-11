<?php 
    require_once "mainModel.php";

    class loginModel extends mainModel
    {
        
        /*----- Modelo iniciar sesion  -----*/
        protected static function iniciarSesionModel($datos) {
            $sql = mainModel::conectar()->prepare("SELECT * FROM usuario WHERE usuario_usuario =:usuario AND usuario_clave =:clave AND usuario_estado='Activa'");
            $sql->bindParam(":usuario",$datos['Usuario']);
            $sql->bindParam(":clave",$datos['Clave']);
            $sql->execute();

            return $sql;
        }

        


    }

?>