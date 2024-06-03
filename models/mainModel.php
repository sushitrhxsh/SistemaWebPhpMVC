<?php

    if($peticionAjax){
        require_once "../config/server.php";
    } else {
        require_once "./config/server.php";
    }

    class mainModel 
    {

        /*----- funcion para conectar a BD ----- */
        protected static function conectar() {
            $conn = new PDO(SGBD, USER, PASS);
            $conn->exec("SET CHARACTER SET utf8");
            
            return $conn;
        }

        /*----- funcion consultas simples ----- */
        protected static function ejecutarConsultaSimple($consulta){
            $sql = self::conectar()->prepare($consulta);
            $sql->execute();
            
            return $sql;
        }

    }



?>