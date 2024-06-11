<?php
    $peticionAjax = true;
    require_once "../config/app.php";

    if(isset($_POST['usuario_dni_reg'])){
        // --------- Instancia al controlador -----------
        require_once "../controllers/userController.php";
        $ins_user = new userController();

        // --------- Agregar un usuario --------------
        if(isset($_POST['usuario_dni_reg']) && isset($_POST['usuario_nombre_reg'])){
            echo $ins_user->agregarUserController();
        }


    } else {
        session_start(['name' => 'SPF']);
        session_unset();
        session_destroy();
        header("Location:".SERVERURL."login/");
        exit();
    }


?>