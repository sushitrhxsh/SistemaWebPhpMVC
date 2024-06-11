<?php
    $peticionAjax = true;
    require_once "../config/app.php";

    if($peticionAjax){
      

    } else {
        session_start(['name' => 'SPF']);
        session_unset();
        session_destroy();
        header("Location:".SERVERURL."login/");
        exit();
    }


?>