<script>

    let btn_salir = document.querySelector(".btn-exit-system");
    
    btn_salir.addEventListener('click', function(e){
        e.preventDefault();
        Swal.fire({
			title: 'Quieres salir de la aplicacion?',
			text: "La sesion actual se cerrara y saldras de la aplicacion",
			type: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si, salir',
			cancelButtonText: 'No, cancelar'
		}).then((result) => {
			if (result.value) {
				let url = '<?php echo SERVERURL; ?>ajax/loginAjax.php';
                let token = '<?php echo $ins_lc->encryption($_SESSION['token_spf']); ?>';
                let usuario = '<?php echo $ins_lc->encryption($_SESSION['usuario_spf']); ?>';

                let datos = new FormData();
                datos.append("token",token);
                datos.append("usuario",usuario);
                
                fetch(url, {
                    method: 'POST',
                    body: datos
                })
                .then(response => response.json())
                .then(response => {
                    return alertasAjax(response); 
                });
			}
		});
    });

</script>