<?php
require_once "models/viewsModel.php";

    class vistasControlador extends vistasModelo
    {
        
        /*----- Controlador obtener plantilla  -----*/
        public function obtenerPlantillaControlador(){
            return require_once "views/plantilla.php";
        }

        /*----- Controlador obtener vistas  -----*/
        public function obtenerVistasControlador(){
            if(isset($_GET['views'])){
                $ruta     = explode("/", $_GET['views']);
                $response = vistasModelo::obtenerVistasModelo($ruta[0]);
            } else {
                $response = "login";
            }

            return $response;
        }

    }
    