var tablaSolicitud;

function init(){
    tablaSolicitud =  $("#tablaSolicitud").DataTable({
        "responsive": true,
        "autoWidth" : false
    })
}

init();

$(document).on('click', '.btnVerDetalle', function(e){

    if (tablaSolicitud.row(this).child.isShown()) {
        var data = tablaSolicitud.row(this).data();
    } else {
        var data = tablaSolicitud.row($(this).parents("tr")).data();
    }

    $('#modalVerDetalleSolicitud').modal("show");

    console.log(data[0]);

    llenarDetalleSolicitud(data[0]);
});


$(document).on('click', '.btnAceptar', async function(e){

    if (tablaSolicitud.row(this).child.isShown()) {
        var data = tablaSolicitud.row(this).data();
    } else {
        var data = tablaSolicitud.row($(this).parents("tr")).data();
    }
    
    var idSolicitud = data[0];

    const result = await Swal.fire({
        title: '¿ESTA SEGURO ACEPTAR LA SOLICITUD?',
        text: "Si no lo esta puede cancelar la acción!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#5bc0de',
        cancelButtonColor: '#d9534f',
        confirmButtonText: 'Si, Aceptar!'
    });

    if(result.value){
        try {

            var datos = new FormData();
            datos.append('aceptarSolicitud', 'OK');
            datos.append('idSolicitud', idSolicitud);
        
            var peticion = await fetch('../controllers/SolicitudesMadreController.php', {
                method : 'POST',
                body : datos
            });
    
            var resjson = await peticion.json();
    
            if(resjson.respuesta == "OK"){
                notificacionExitosa('¡Solicitud aceptada!');
            }else{
                notificarError(resjson.respuesta);
            }
            
        } catch (error) {
            console.log(error);
        }
    }
});

$(document).on('click', '.btnRechazar', async function(e){

    if (tablaSolicitud.row(this).child.isShown()) {
        var data = tablaSolicitud.row(this).data();
    } else {
        var data = tablaSolicitud.row($(this).parents("tr")).data();
    }
    
    var idSolicitud = data[0];

    const result = await Swal.fire({
        title: '¿ESTA SEGURO RECHAZAR LA SOLICITUD?',
        text: "Si no lo esta puede cancelar la acción!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#5bc0de',
        cancelButtonColor: '#d9534f',
        confirmButtonText: 'Si, Rechazar!'
    });

    if(result.value){
        try {

            var datos = new FormData();
            datos.append('rechazarSolicitud', 'OK');
            datos.append('idSolicitud', idSolicitud);
        
            var peticion = await fetch('../controllers/SolicitudesMadreController.php', {
                method : 'POST',
                body : datos
            });
    
            var resjson = await peticion.json();
    
            if(resjson.respuesta == "OK"){
                notificacionExitosa('¡La solicitud ha sido rechazada!');
            }else{
                notificarError(resjson.respuesta);
            }
            
        } catch (error) {
            console.log(error);
        }
    }
    
});

function llenarDetalleSolicitud(idSolicitud){
    $('#detalle_solicitud').DataTable().destroy();
    var detalle_solicitud  =  $("#detalle_solicitud").DataTable({
        "responsive": true,
        "autoWidth" : false,
        "ajax" : {
            "url" : "../controllers/SolicitudesMadreController.php",
            "type": "POST",
            "data": {
                "getDetalleSolicitud" : "OK",
                "idSolicitud" : idSolicitud
            },
            "dataSrc":""
        },
        "columns" :[
            {"data" : "descr"},
            {"data" : "cant"}
        ]
    })
}

function notificacionExitosa(mensaje){
    Swal.fire(
        mensaje,
        '',
        'success'
    ).then(result => {
        window.location = "solicitudes_madre.php";
    });
}

function notificarError(mensaje){
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: mensaje
    })
}