<?php
    
    class vistasModelo 
    {
        
        /*----- Modelo obtener vistas ----- */
        protected static function obtenerVistasModelo($vistas) {
            $listaBlanca = [
                "home", "company", 
                "client-list",      "client-new",       "client-search",        "client-update",
                "item-list",        "item-new",         "item-search",          "item-update", 
                "reservation-list", "reservation-new",  "reservation-search",   "reservation-update", "reservation-reservation", "reservation-pending",
                "user-list",        "user-new",         "user-search",          "user-update",
            ];
            if(in_array($vistas,$listaBlanca)){
                if(is_file("views/contents/".$vistas."-view.php")){
                    $contenido = "views/contents/".$vistas."-view.php";
                } else {
                    $contenido = "404";
                }
            } elseif ($vistas == "login" || $vistas == "index") {
                $contenido = "login";
            } else {
                $contenido = "404";
            }

            return $contenido;
        }

        

    }