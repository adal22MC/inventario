var table_ordenes;

async function init() {
    table_ordenes = $("#table_ordenes").DataTable({
        "responsive": true,
        "autoWidth": false
    })

    var datos = new FormData();
    datos.append('getOrdenesPendientes', 'OK');

    try {

        var peticion = await fetch('../controllers/OrdenCompraController.php', {
            method: 'POST',
            body: datos
        });

        var resjson = await peticion.json();

        var selectOrden = document.getElementById('selectOrden');
        for (let item of resjson) {
            var option = document.createElement('option');
            option.text = item['id_oc'];
            option.value = item['id_oc'];
            selectOrden.appendChild(option)
        }

    } catch (error) {
        console.log(error);
    }

}

init();

document.getElementById('selectOrden').addEventListener('change', async (e) => {
    if (e.target.value === "default") {
        notificarError("Selecciona un número de orden");
    } else {
        try {

            $('#table_ordenes').DataTable().destroy();
            table_ordenes = $("#table_ordenes").DataTable({
                "responsive": true,
                "autoWidth": false,
                "ajax": {
                    "url": "../controllers/OrdenCompraController.php",
                    "type": "POST",
                    "data": {
                        "getDetalleOrden": "OK",
                        "id_orden": e.target.value
                    },
                    "dataSrc": ""
                },
                "columns": [
                    { "data": "cns",
                      "visible" : false},
                    { "data": "id_oc_do",
                      "visible" : false},
                    { "data": "cant" },
                    { "data": "recibi"},
                    { "data": "p_compra" },
                    { "data": "te_producto" },
                    { "data": "material" },
                    { "data" : "id_m",
                      "visible" : false},
                    {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-info btn-sm btnEdit'><i class='fas fa-edit'></i></button></div></div>"}
                ]
            });

        } catch (error) {
            console.log(error);
        }
    }
});

$(document).on('click', '.btnEdit', async function(){

    if(table_ordenes.row(this).child.isShown()){
        var data = table_ordenes.row(this).data();
    }else{
        var data = table_ordenes.row($(this).parents("tr")).data();
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
        if(cantidad.value <= 0){
            notificarError('Ingresa una cantidad valida!');
        }else if(cantidad.value > parseInt(data['cant'])){
            notificarError('No puedes sobrepasar la cantidad que solicitaste!');
        }else{
            var datos = new FormData();
            datos.append('editRecibiDetalleOrden', 'OK');
            datos.append('cns', data['cns']);
            datos.append('recibi', cantidad.value);

            var peticion = await fetch('../controllers/OrdenCompraController.php', {
                method : 'POST',
                body : datos
            });

            var resjson = await peticion.json();

            if(resjson.respuesta == "OK"){
                notificacionExitosa('Modificación correcta!',1);
                table_ordenes.ajax.reload(null, false);
            }else{
                notificarError(resjson.respuesta);
            }
        }
    }
    
});

document.getElementById('btnAceptar').addEventListener('click', async () => {
    if(validarOrden() != "default"){
        try {
            
            let datos = new FormData();
            datos.append('aceptarOrden', 'OK');
            datos.append('id_orden', validarOrden());

            var peticion = await fetch('../controllers/OrdenCompraController.php', {
                method : 'POST',
                body : datos
            });

            var resjson = await peticion.json();
            if(resjson.respuesta == "OK"){
                notificacionExitosa('La orden de compra ha sido aceptada!',0);
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
            datos.append('rechazarOrden', 'OK');
            datos.append('id_orden', validarOrden());

            var peticion = await fetch('../controllers/OrdenCompraController.php', {
                method : 'POST',
                body : datos
            });

            var resjson = await peticion.json();
            if(resjson.respuesta == "OK"){
                notificacionExitosa('La orden de compra ha sido rechazada!',0);
            }else{
                notificarError(resjson.respuesta);
            }

        } catch (error) {
            console.log(error);
        }
    }
});

function validarOrden(){
    let selectOrden = document.getElementById('selectOrden');
    if(selectOrden.value == "default"){
        return "default";
    }

    return selectOrden.value;
}



function notificacionExitosa(mensaje,ban) {
    Swal.fire(
        mensaje,
        '',
        'success'
    ).then(result => {
        if(ban == 0){
            window.location = "ver_orden.php";
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


