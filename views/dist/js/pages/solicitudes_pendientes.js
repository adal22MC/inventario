var table_solicitudes;
var selectSolicitud = document.getElementById('selectSolicitud');

async function init() {
    table_solicitudes = $("#table_ordenes").DataTable({
        "responsive": true,
        "autoWidth": false
    })

    var datos = new FormData();
    datos.append('getSolicitudesAceptadas', 'OK');

    try {

        var peticion = await fetch('../controllers/SolicitudesMadreController.php', {
            method: 'POST',
            body: datos
        });

        var resjson = await peticion.json();

        for (let item of resjson) {
            var option = document.createElement('option');
            option.text = item['id_s'];
            option.value = item['id_s'];
            selectSolicitud.appendChild(option)
        }

    } catch (error) {
        console.log(error);
    }

}

init();

selectSolicitud.addEventListener('change', async (e) => {
    if (e.target.value === "default") {
        notificarError("Selecciona un número de solicitud");
    } else {
        try {

            $('#table_ordenes').DataTable().destroy();
            table_solicitudes = $("#table_ordenes").DataTable({
                "responsive": true,
                "autoWidth": false,
                "ajax": {
                    "url": "../controllers/SolicitudesMadreController.php",
                    "type": "POST",
                    "data": {
                        "getDetalleSolicitud": "OK",
                        "idSolicitud": e.target.value
                    },
                    "dataSrc": ""
                },
                "columns": [
                    { "data": "id_m"},
                    { "data": "descr"},
                    { "data": "cant"},
                    { "data": "recibi"},
                    {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-info btn-sm btnEdit'><i class='fas fa-edit'></i></button></div></div>"}
                ]
            });

        } catch (error) {
            console.log(error);
        }
    }
});

$(document).on('click', '.btnEdit', async function(){
    if(selectSolicitud.value != "default"){
        if(table_solicitudes.row(this).child.isShown()){
            var data = table_solicitudes.row(this).data();
        }else{
            var data = table_solicitudes.row($(this).parents("tr")).data();
        }

        const cantidad = await Swal.fire({
            title: 'Ingresa la cantidad que recibiste',
            input: 'number',
            inputAttributes: {
            autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Confirmar'
        });


        if(cantidad.value){
            if(cantidad.value < 0){
                notificarError('Ingresa una cantidad valida!');
            }else if(cantidad.value > parseInt(data['cant'])){
                notificarError('No puedes sobrepasar la cantidad que solicitaste!');
            }else{
                var datos = new FormData();
                datos.append('editRecibiDetalleSolicitud', 'OK');
                datos.append('id_s', selectSolicitud.value);
                datos.append('id_m', data['id_m']);
                datos.append('recibi', cantidad.value);

                var peticion = await fetch('../controllers/SolicitudesMadreController.php', {
                    method : 'POST',
                    body : datos
                });

                var resjson = await peticion.json();

                if(resjson.respuesta == "OK"){
                    notificacionExitosa('Modificación correcta!',1);
                    table_solicitudes.ajax.reload(null, false);
                }else{
                    notificarError(resjson.respuesta);
                }
            }
        }
    }
    
});

document.getElementById('btnAceptar').addEventListener('click', async () => {
    if(validarOrden() != "default"){
        try {
            
            let datos = new FormData();
            datos.append('aceptarSolicitud_hija', 'OK');
            datos.append('idSolicitud', validarOrden());

            var peticion = await fetch('../controllers/SolicitudesMadreController.php', {
                method : 'POST',
                body : datos
            });

            var resjson = await peticion.json();
            if(resjson.respuesta == "OK"){
                notificacionExitosa('La solicitud ha sido aceptada y finalizada!',0);
            }else{
                notificarError(resjson.respuesta);
            }

        } catch (error) {
            console.log(error);
        }
    }
    
});

document.getElementById('btnRechazar').addEventListener('click', async () => {
    if(validarOrden() != "default"){
        try {
            
            let datos = new FormData();
            datos.append('rechazarSolicitud', 'OK');
            datos.append('idSolicitud', validarOrden());

            var peticion = await fetch('../controllers/SolicitudesMadreController.php', {
                method : 'POST',
                body : datos
            });

            var resjson = await peticion.json();
            if(resjson.respuesta == "OK"){
                notificacionExitosa('La solicitud a sido rechazada!',0);
            }else{
                notificarError(resjson.respuesta);
            }

        } catch (error) {
            console.log(error);
        }
    }
});

function validarOrden(){
    
    if(selectSolicitud.value == "default"){
        return "default";
    }

    return selectSolicitud.value;
}



function notificacionExitosa(mensaje,ban) {
    Swal.fire(
        mensaje,
        '',
        'success'
    ).then(result => {
        if(ban == 0){
            window.location = "solicitudes_pendientes.php";
        }
    });
}

function notificarError(mensaje) {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: mensaje
    })
}


