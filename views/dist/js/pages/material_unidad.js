var tablaMaterial;
var idMaterial;

function init() {
    tablaMaterial = $("#material").DataTable({
        "responsive": true,
        "autoWidth": false
    })
}

init();

function notificacionExitosa(mensaje) {
    Swal.fire(
        mensaje,
        '',
        'success'
    ).then(result => {
        window.location = "materiales.php";
    });
}

function notificarError(mensaje) {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: mensaje
    })
}





