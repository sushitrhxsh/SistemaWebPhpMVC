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
            try
            {
                $conn = new PDO(SGBD, USER, PASS);
                $conn->exec("SET CHARACTER SET utf8");
                
                return $conn;
            } catch(PDOException $e) {
                die("Connection failed: ".$e->getMessage()." ...");
            }
        }

        /*----- funcion consultas simples ----- */
        protected static function ejecutarConsultaSimple($consulta){
            $sql = self::conectar()->prepare($consulta);
            $sql->execute();
            
            return $sql;
        }
        
        /*----- Encryptar cadeans ----- */
        public function encryption($string) {
            $output = FALSE;
            $key = hash('sha256',SECRET_KEY);
            $iv = substr(hash('sha256',SECRET_IV), 0, 16);
            $output = openssl_encrypt($string, METHOD, $key, 0, $iv);
            $output = base64_encode($output);

            return $output;
        } 

        /*----- Desencriptar cadenas ----- */
        protected static function decryption($string) {
            $key = hash('sha256', SECRET_KEY);
			$iv = substr(hash('sha256', SECRET_IV), 0, 16);
			$output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
			
            return $output;
        }

        /*----- funcion generar codigo aleatorios ----- */
        protected static function generarCodigoAleatorio($letra, $longitud, $numero) {
            for ($i = 1; $i <= $longitud; $i++){
                $random = rand(0,9);
                $letra .= $random;
            }
            
            return $letra."-".$numero;
        }

        /*----- funcion para limpiar cadenas ----- */
        protected static function limpiarCadena($cadena) {
            $cadena = str_replace("<script>", "", $cadena);
            $cadena = str_replace("</script>", "", $cadena);
            $cadena = str_replace("<script src", "", $cadena);
            $cadena = str_replace("<script type=", "", $cadena);
            $cadena = str_replace("SELECT * FROM", "", $cadena);
            $cadena = str_replace("DELETE FROM", "", $cadena);
            $cadena = str_replace("INSERT INTO", "", $cadena);
            $cadena = str_replace("DROP TABLE", "", $cadena);
            $cadena = str_replace("DROP DATABASE", "", $cadena);
            $cadena = str_replace("TRUNCATE TABLE", "", $cadena);
            $cadena = str_replace("SHOW TABLE", "", $cadena);
            $cadena = str_replace("SHOW DATABASES", "", $cadena);
            $cadena = str_replace("<?php", "", $cadena);
            $cadena = str_replace("?>", "", $cadena);
            $cadena = str_replace("--", "", $cadena);
            $cadena = str_replace(">", "", $cadena);
            $cadena = str_replace("<", "", $cadena);
            $cadena = str_replace("[", "", $cadena);
            $cadena = str_replace("]", "", $cadena);
            $cadena = str_replace("^", "", $cadena);
            $cadena = str_replace("==", "", $cadena);
            $cadena = str_replace(";", "", $cadena);
            $cadena = str_replace("::", "", $cadena);
            $cadena = stripslashes($cadena);
            $cadena = trim($cadena);

            return $cadena;
        }

        /*----- funcion verificar datos ----- */
        protected static function verificarDatos($filtro, $cadena) {
            if(preg_match("/^".$filtro."$/",$cadena)){
                return false;
            } else {
                return true;
            }
        }

        /*----- funcion verificar fechas ----- */
        protected static function verificarFecha($fecha) {
            $valores = explode('-',$fecha);
            if(count($valores) == 3 && checkdate($valores[1],$valores[2],$valores[0])){
                return false;
            } else {
                return true;
            }
        }
        
        /*----- funcion paginador de tablas ----- */
        protected static function paginadorTablas($pagina, $numPaginas, $url, $botones) {
            $tabla = '<nav aria-label="Page navigation example"><ul class="pagination justify-content-center">';
            
            if($pagina == 1){
                $tabla.= '<li class="page-item disabled">
                            <a class="page-link"><i class="fa-solid fa-angles-left"></i></a>
                          </li>';
            } else {
                $tabla.= '<li class="page-item">
                            <a class="page-link" href="'.$url.'1/"><i class="fa-solid fa-angles-left"></i></a>
                          </li>
                          <li class="page-item">
                            <a class="page-link" href="'.$url.($pagina-1).'">Anterior</a>
                          </li>';
            }

            $count = 0;
            for($i = $pagina; $i <= $numPaginas; $i++) {
                if ($count >= $botones) {
                    break;
                }

                if($pagina == $i) {
                    $tabla.= '<li class="page-item">
                                <a class="page-link active" href="'.$url.$i.'/">'.$i.'</a>
                              </li>';
                } else {
                    $tabla.= '<li class="page-item">
                                <a class="page-link" href="'.$url.$i.'/">'.$i.'</a>
                              </li>';
                }

                $count++;
            }

            if($pagina == $numPaginas){
                $tabla.= '<li class="page-item disabled">
                            <a class="page-link"><i class="fa-solid fa-angles-right"></i></a>
                          </li>';
            } else {
                $tabla.= '<li class="page-item">
                            <a class="page-link" href="'.$url.($pagina-1).'">Siguiente</a>
                          </li>
                          <li class="page-item">
                            <a class="page-link" href="'.$url.$numPaginas.'/"><i class="fa-solid fa-angles-right"></i></a>
                          </li>
                          ';
            }
            
            $tabla.='</ul></nav>';

            return $tabla;
        }

    }



?>