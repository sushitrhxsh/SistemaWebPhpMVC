<?php
    $peticionAjax = true;
    require_once "../config/app.php";

    if(isset($_POST['token']) && isset($_POST['usuario'])){
        // --------- Instancia al controlador -----------
       require_once "../controllers/loginController.php.php";
       $ins_login = new loginController();

       echo $ins_login->cerrarSesionController();

    } else {
        session_start(['name' => 'SPF']);
        session_unset();
        session_destroy();
        header("Location:".SERVERURL."login/");
        exit();
    }


?>