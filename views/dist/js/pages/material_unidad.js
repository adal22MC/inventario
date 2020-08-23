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
/* Generar Reporte Stock Bajo*/ 
$(document).on('click', '.btnS', function(){
    window.location = "templates/pdf_material.php?materiales="+2;
});
/* Generar Reporte Stock Bajo*/ 
$(document).on('click', '.btnM', function(){
    window.location = "templates/pdf_material.php?materiales="+1;
});
/* Generar Reporte Material Unitario*/ 
$(document).on('click', '.btnMaterialU', function(){
    if (tablaMaterial.row(this).child.isShown()) {
        var data = tablaMaterial.row(this).data();
    } else {
        var data = tablaMaterial.row($(this).parents("tr")).data();
    }

    idMaterial = data[0];
    window.location = "templates/pdf_material.php?materiales="+1+"&idMaterial="+idMaterial;
});





