const formaddBodega = document.getElementById('formAddBodega');
const formEditBodega = document.getElementById('formEditBodega');

var tablaBodega;
var idBodega;

function init(){
   
    tablaBodega =  $("#bodega").DataTable({
        "responsive": true,
        "autoWidth" : false,
        "ajax" : {
            "url" : "../controllers/BodegaController.php",
            "type": "POST",
            "data": {
                "obtenerBodegas" : "OK"
            },
            "dataSrc":""
        },
        "columns" :[
            {"data" : "id_b"},
            {"data" : "f_creacion"},
            {"data" : "nombre"},
            {"data" : "correo"},
            {"data" : "tel"},
            {"data" : "username"},
            {"data" : "pass"},
            {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-info btn-sm btnEditar'><i class='fas fa-edit'></i></button><button class='btn btn-danger btn-sm btnBorrar'><i class='fas fa-trash-alt'></i></button></div></div>"}
        ]
    })

}

init();

formaddBodega.addEventListener('submit', async (e) =>{
    e.preventDefault();

    try {

        var datosBodega = new FormData(formaddBodega); //obtenemos el formulario y creamos un objeto
        datosBodega.append('agregarBodega', 'OK');
    
        var peticion = await fetch('../controllers/BodegaController.php', {
            method : 'POST',
            body : datosBodega
        });

        var resjson = await peticion.json();

        if(resjson.respuesta == "OK"){
            notificacionExitosa('¡Alta de bodega exitosa!');
            tablaBodega.ajax.reload(null, false);
        }else{
            notificarError('Hubo un error :(');
        }
        
    } catch (error) {
        console.log(error);
    }
    
})

formEditBodega.addEventListener('submit', async (e) => {
    e.preventDefault();
    try {

        var datosBodega = new FormData(formEditBodega); //obtenemos el formulario y creamos un objeto
        datosBodega.append('editarBodega', 'OK');
        datosBodega.append('idBodega', idBodega);
    
        var peticion = await fetch('../controllers/BodegaController.php', {
            method : 'POST',
            body : datosBodega
        });

        var resjson = await peticion.json();

        if(resjson.respuesta == "OK"){
            notificacionExitosa('¡Modificación de bodega exitosa!');
            tablaBodega.ajax.reload(null, false);
        }else{
            notificarError(resjson.respuesta);
        }
        
    } catch (error) {
        console.log(error);
    }
})


/* CUANDO SE PRESIONA EL BOTON EDITAR */     
$(document).on("click", ".btnEditar", function(){
    
    if(tablaBodega.row(this).child.isShown()){
        var data = tablaBodega.row(this).data();
    }else{
        var data = tablaBodega.row($(this).parents("tr")).data();
    }

    /* Cargamos los datos obtenidos al modal editar */
    idBodega = data[0];
    $("#nomBodega").val(data[4]);
    $("#correoBodega").val(data[2]);
    $("#numBodega").val(data[3]);
    $("#userBodega").val(data[5]);
    $("#passBodega").val(data[6]);
   
    /* Hacemos visible el modal */
    $('#modalEditarBodega').modal('show');		   
});

$(document).on('click', ".btnBorrar", async function() {

    if(tablaBodega.row(this).child.isShown()){
        var data = tablaBodega.row(this).data();
    }else{
        var data = tablaBodega.row($(this).parents("tr")).data();
    }

    idBodega = data[0];

    const result = await Swal.fire({
        title: '¿ESTA SEGURO DE ELIMINAR LA BODEGA?',
        text: "Si no lo esta puede cancelar la acción!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#5bc0de',
        cancelButtonColor: '#d9534f',
        confirmButtonText: 'Si, eliminar!'
    });

    if(result.value){
        try {

            var datosBodega = new FormData();
            datosBodega.append('eliminarBodega', 'OK');
            datosBodega.append('idBodega', idBodega);
        
            var peticion = await fetch('../controllers/BodegaController.php', {
                method : 'POST',
                body : datosBodega
            });
    
            var resjson = await peticion.json();
    
            if(resjson.respuesta == "OK"){
                notificacionExitosa('¡ELiminación exitosa!');
                tablaBodega.ajax.reload(null, false);
            }else{
                notificarError(resjson.respuesta);
            }
            
        } catch (error) {
            console.log(error);
        }
    }
    
})



function notificacionExitosa(mensaje){
    Swal.fire(
        mensaje,
        '',
        'success'
    ).then(result => {
        formaddBodega.reset();
        document.getElementById('closeAdd').click();
        document.getElementById('closeEdit').click();
    });
}

function notificarError(mensaje){
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: mensaje
    })
}

/* Limpiar campos del formulario agregar bodega */
document.getElementById('altaBodega').addEventListener('click', () => {
    formaddBodega.reset();
})
