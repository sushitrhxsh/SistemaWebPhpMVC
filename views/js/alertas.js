const formulariosAjax = document.querySelectorAll(".FormularioAjax");

function enviarFormularioAjax(e) {
    e.preventDefault();


}

formulariosAjax.forEach(f => {
    f.addEventListener("submit", enviarFormularioAjax);
});

function alertasAjax(alerta) {
    if(alerta.Alerta === "simple") {
        Swal.fire({
            title:  alerta.Titulo,
            text:   alerta.Texto,
            type:   alerta.Tipo,
            confirmButtonText: "Aceptar"
        });

    } else if(alerta.Alerta === "recargar") {
        Swal.fire({
            title:  alerta.Titulo,
            text:   alerta.Texto,
            type:   alerta.Tipo,
            confirmButtonText: "Aceptar"
        }).then((result) => {
            if (result.value) {
                location.reload();
            }
        });

    } else if(alerta.Alerta === "limpiar") {
        Swal.fire({
            title:  alerta.Titulo,
            text:   alerta.Texto,
            type:   alerta.Tipo,
            confirmButtonText: "Aceptar"
        }).then((result) => {
            if (result.value) {
                document.querySelector(".FormularioAjax").reset();
            }
        });
        
    } else if(alerta.Alerta === "redireccionar") {
        window.location.href = alerta.URL;
    }
}