var table_solicitudes;
var selectSolicitud = document.getElementById('selectSolicitud');

async function init() {
    table_solicitudes = $("#table_ordenes").DataTable({
        "responsive": true,
        "autoWidth": false
    })

    var datos = new FormData();
    datos.append('getTrasladosPendientes', 'OK');

    try {

        var peticion = await fetch('../controllers/TrasladosPendientesController.php', {
            method: 'POST',
            body: datos
        });

        var resjson = await peticion.json();

        console.log(resjson);

        
        for (let item of resjson) {
            var option = document.createElement('option');
            option.text = item['id'];
            option.value = item['id'];
            selectSolicitud.appendChild(option)
        }
        

    } catch (error) {
        console.log(error);
    }

}

init();

selectSolicitud.addEventListener('change', async (e) => {
    if (e.target.value === "default") {
        notificarError("Selecciona un número de traslado");
    } else {
        try {

            $('#table_ordenes').DataTable().destroy();
            table_solicitudes = $("#table_ordenes").DataTable({
                "responsive": true,
                "autoWidth": false,
                "ajax": {
                    "url": "../controllers/TrasladosPendientesController.php",
                    "type": "POST",
                    "data": {
                        "getDetalleTraslado": "OK",
                        "id_traslado": e.target.value
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
                datos.append('editarRecibiTrasladoPendiente', 'OK');
                datos.append('id_traslado', selectSolicitud.value);
                datos.append('id_m', data['id_m']);
                datos.append('recibi', cantidad.value);

                var peticion = await fetch('../controllers/TrasladosPendientesController.php', {
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

        const result = await Swal.fire({
            title: 'Observaciones',
            input: 'textarea',
            inputValue : 'Sin observaciones',
            inputAttributes: {
              autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Confirmar',
        })
    
        if (result.value) {
            
            try {
                
                let datos = new FormData();
                datos.append('aceptar_traslado', 'OK');
                datos.append('id_traslado', validarOrden());
                datos.append('observaciones', result.value);
    
                var peticion = await fetch('../controllers/TrasladosPendientesController.php', {
                    method : 'POST',
                    body : datos
                });
    
                var resjson = await peticion.json();
                if(resjson.respuesta == "OK"){
                    notificacionExitosa('El traslado ha sido aceptado y finalizado!',0);
                }else{
                    notificarError(resjson.respuesta);
                }
                
    
            } catch (error) {
                console.log(error);
            }
            
        }
    }
    
});

document.getElementById('btnRechazar').addEventListener('click', async () => {
    if(validarOrden() != "default"){
        try {
            
            let datos = new FormData();
            datos.append('rechazar_traslado', 'OK');
            datos.append('id_traslado', validarOrden());

            var peticion = await fetch('../controllers/TrasladosPendientesController.php', {
                method : 'POST',
                body : datos
            });

            var resjson = await peticion.json();
            if(resjson.respuesta == "OK"){
                notificacionExitosa('El traslado a sido rechazado!',0);
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
            window.location = "traslados_pendientes.php";
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


