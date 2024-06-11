<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title><?php echo COMPANY; ?></title>
	<!-- css links rute -->
    <?php   include "views/inc/link.php"   ?>

</head>
<body>

	<?php 
		$peticionAjax = false;
		require_once "controllers/viewsController.php";	
		$IV = new vistasControlador();
		$vistas = $IV->obtenerVistasControlador();

		if($vistas == "login" || $vistas == "404") {
			require_once "views/contents/".$vistas."-view.php";
		
		} else {
			session_start(['name' => 'SPF']);	

			require_once "./controllers/loginController.php";
			$ins_lc = new loginController();

			if(isset($_SESSION['token_spf']) || isset($_SESSION['usuario_spf']) || isset($_SESSION['privilegio_spf']) || isset($_SESSION['id_spf'])){
				echo $ins_lc->forzarCierreSesionController();
				exit();
			}
	?>

	<!-- Main container -->
	<main class="full-box main-container">

		<!-- Nav lateral -->
		<?php   include "views/inc/navLateral.php"; ?>

		<!-- Page content -->
		<section class="full-box page-content">
			<?php   
				include "views/inc/navBar.php"; 
				include $vistas;
			?>
		</section>

	</main>
	
	<!-- js script rute -->
	<?php   
		}
		include "views/inc/script.php"   
	?>
</body>
</html>