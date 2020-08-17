const formEditMaterial = document.getElementById('formEditMaterialUnidad');

var tablaMaterial;
var idMaterial;

function init() {
    tablaMaterial = $("#material").DataTable({
        "responsive": true,
        "autoWidth": false
    })
}

init();

formEditMaterial.addEventListener('submit', async (e) => {
    e.preventDefault();

    try {

        var datosMaterial = new FormData(formEditMaterial); //obtenemos el formulario y creamos un objeto
        datosMaterial.append('modificarStock', 'OK');
        datosMaterial.append('idMaterial', idMaterial);

        var peticion = await fetch('../controllers/MaterialController.php', {
            method: 'POST',
            body: datosMaterial
        });

        var resjson = await peticion.json();

        if (resjson.respuesta == "OK") {
            notificacionExitosa('¡Modificación de Stock exitosa!');
        } else {
            notificarError(resjson.respuesta);
        }

    } catch (error) {
        console.log(error);
    }
})

/* CUANDO SE PRESIONA EL BOTON EDITAR */
$(document).on("click", ".btnEditar", async function () {

    if (tablaMaterial.row(this).child.isShown()) {
        var data = tablaMaterial.row(this).data();
    } else {
        var data = tablaMaterial.row($(this).parents("tr")).data();
    }

    /* Cargamos los datos obtenidos al modal editar */
    idMaterial = data[0];
    
    $("#idM").val(idMaterial);
    $("#s_min").val(data[3]);
    $("#s_max").val(data[4]);
    /* Hacemos visible el modal */
    $('#modalEditMaterialUnidad').modal('show');

})


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
    window.location = "templates/pdf_material.php";
});
/* Generar Reporte Stock Bajo*/ 
$(document).on('click', '.btnM', function(){
    window.location = "templates/pdf_material.php?materiales="+1;
});





