const formulariosAjax = document.querySelectorAll(".FormularioAjax");

function enviarFormularioAjax(e) {
    e.preventDefault();

    let data   = new FormData(this);
    let method = this.getAttribute("method");
    let action = this.getAttribute("action");
    let type   = this.getAttribute("data-form");

    let header = new Headers();

    let config  = {
        method  : method,
        headers : header,
        mode    : 'cors',
        cache   : 'no-cache',
        body    : data
    }
    
    let textAlert;
    switch(type){
        case "save":
            textAlert = "Desea guardar los datos completamente al sistema?";
        break;
        case "delete":
            textAlert = "Desea eliminar los datos completamente?";
        break;
        case "update":
            textAlert = "Desea actualizar los datos al sistema?";
        break;
        case "search":
            textAlert = "Se eliminara el termino de busqueda y escribiras uno nuevo";
        break;
        case "loans":
            textAlert = "Desea remover los datos seleccionados para prestamos o reservaciones";
        break;
        default:
            textAlert = "Quieres realizar la operacion solicitada";
        break;
    }

    Swal.fire({
        title:  'Estas seguro?',
        text:   textAlert,
        type:   'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar', 
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            fetch(action, config)
            .then(response => response.json())
            .then(response => {
                return alertasAjax(response); 
            });
        }
    });



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
