const selectBodega = document.getElementById('selectBodega');
const formEdit = document.getElementById('formEdit');

var tablaMateriales;
var idBodega;
var id_material;

async function init(){
   
    tablaMateriales =  $("#bodega").DataTable({
        "responsive": true,
        "autoWidth" : false
    })

    try {
        let datos = new FormData();
        datos.append('obtenerBodegasHijas', 'OK');

        let peticion = await fetch('../controllers/BodegaController.php', {
            method : 'POST',
            body : datos
        });

        let resjson = await peticion.json();
        let selectBodega = document.getElementById('selectBodega');
        for(let item of resjson){
            let option = document.createElement('option');
            option.value = item.id_b;
            option.text = item.nombre;
            selectBodega.appendChild(option);
        }

    } catch (error) {
        console.log(error);
    }

}

init();

selectBodega.addEventListener('change', () => {
    $('#bodega').DataTable().destroy();
    if(selectBodega.value !== "default"){
        tablaMateriales =  $("#bodega").DataTable({
            "responsive": true,
            "autoWidth" : false,
            "ajax" : {
                "url" : "../controllers/MaterialController.php",
                "type": "POST",
                "data": {
                    "getMaterialesByIdBodega" : "OK",
                    "id_bodega" : selectBodega.value
                },
                "dataSrc":""
            },
            "columns" :[
                {"data" : "id"},
                {"data" : "nombre"},
                {"data" : "categoria"},
                {"data" : "stock", "visible" : false},
                {"data" : "s_max"},
                {"data" : "s_min"},
                {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-info btn-sm btnEditar'><i class='fas fa-edit'></i></button></div></div>"}
            ]
        })
    }else{
        tablaMateriales =  $("#bodega").DataTable({
            "responsive": true,
            "autoWidth" : false
        });
        $("#bodega tbody").children().remove();
    }
});



formEdit.addEventListener('submit', async (e) => {
    e.preventDefault();
    try {

        var datosBodega = new FormData(formEdit); //obtenemos el formulario y creamos un objeto
        datosBodega.append('modificarStock', 'OK');
        datosBodega.append('id_bodega', selectBodega.value);
        datosBodega.append('idMaterial', id_material);
    
        var peticion = await fetch('../controllers/MaterialController.php', {
            method : 'POST',
            body : datosBodega
        });

        var resjson = await peticion.json();

        if(resjson.respuesta == "OK"){
            notificacionExitosa('¡Modificación de parametros de Stock exitosa!');
            tablaMateriales.ajax.reload(null, false);
        }else{
            notificarError(resjson.respuesta);
        }
        
    } catch (error) {
        console.log(error);
    }
})


/* CUANDO SE PRESIONA EL BOTON EDITAR */     
$(document).on("click", ".btnEditar", function(){
    
    if(tablaMateriales.row(this).child.isShown()){
        var data = tablaMateriales.row(this).data();
    }else{
        var data = tablaMateriales.row($(this).parents("tr")).data();
    }

    /* Cargamos los datos obtenidos al modal editar */
    idBodega = selectBodega.value;
    id_material = data['id'];
    $("#s_max").val(data['s_max']);
    $("#s_min").val(data['s_min']);
   
    /* Hacemos visible el modal */
    $('#modalEditarMaterial').modal('show');		   
});

function notificacionExitosa(mensaje){
    Swal.fire(
        mensaje,
        '',
        'success'
    ).then(result => {
        $('#modalEditarMaterial').modal('hide');	
    });
}

function notificarError(mensaje){
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: mensaje
    })
}


