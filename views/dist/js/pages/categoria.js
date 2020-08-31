const formaddCategoria = document.getElementById('formAddCategoria');
const formEditCategoria = document.getElementById('formEditCategoria');

var tablaCategoria;
var idCategoria;

async function init(){

    tablaCategoria = $("#categoria").DataTable({
        "responsive": true,
        "autoWidth" : false,
        "ajax" : {
            "url" : "../controllers/CategoriaController.php",
            "type": "POST",
            "data": {
                "obtenerCategorias" : "OK"
            },
            "dataSrc":""
        },
        "columns" :[
            {"data" : "id_c"},
            {"data" : "descr"},
            {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-info btn-sm btnEditar'><i class='fas fa-edit'></i></button><button class='btn btn-danger btn-sm btnBorrar'><i class='fas fa-trash-alt'></i></button></div></div>"}
        ]
    });

    // Llenar select categorias
    try {
        var datosC = new FormData();
        datosC.append("obtenerCategorias","OK");

        var peticion = await fetch('../controllers/CategoriaController.php',{
            method : 'POST',
            body : datosC
        });

        var resjson = await peticion.json();

        let selectCategoriaM = document.getElementById('selectCategoriaM');
        for(let item of resjson){
            let option = document.createElement('option');
            option.value = item.id_c;
            option.text = item.descr;
            selectCategoriaM.appendChild(option);
        }

    } catch (error) {
        console.log(error);
    }
}
init();

formaddCategoria.addEventListener('submit', async (e) =>{
    e.preventDefault();

    try {
        var datosCategoria = new FormData(formaddCategoria);
        datosCategoria.append('agregarCategoria', 'OK');

        var peticion = await fetch('../controllers/CategoriaController.php',{
            method : 'POST',
            body : datosCategoria
        });

        var resjson = await peticion.json();

        if (resjson.respuesta == "OK") {
            notificacionExitosa('¡Alta de categoria exitosa!');
            tablaCategoria.ajax.reload(null, false);
        } else {
            notificarError('Hubo un error :(');
        }

    } catch (error) {
        console.log(error);
    }
})

formEditCategoria.addEventListener('submit', async (e) =>{
    e.preventDefault();

    try {

        var datosCategoria = new FormData(formEditCategoria); //obtenemos el formulario y creamos un objeto
        datosCategoria.append('editarCategoria', 'OK');
        datosCategoria.append('idCategoria', idCategoria);
    
        var peticion = await fetch('../controllers/CategoriaController.php', {
            method : 'POST',
            body : datosCategoria
        });

        var resjson = await peticion.json();

        if(resjson.respuesta == "OK"){
            notificacionExitosa('¡Modificación de Categoria exitosa!');
            tablaCategoria.ajax.reload(null, false);
        }else{
            notificarError(resjson.respuesta);
        }
        
    } catch (error) {
        console.log(error);
    }
})

/* CUANDO SE PRESIONA EL BOTON EDITAR */     
$(document).on("click", ".btnEditar", function(){
    
    if(tablaCategoria.row(this).child.isShown()){
        var data = tablaCategoria.row(this).data();
    }else{
        var data = tablaCategoria.row($(this).parents("tr")).data();
    }

    /* Cargamos los datos obtenidos al modal editar */
    idCategoria = data[0];
    $("#desCategoria").val(data[1]);
   
    /* Hacemos visible el modal */
    $('#modalEditarCategoria').modal('show');		   
});

$(document).on('click', ".btnBorrar", async function() {

    if(tablaCategoria.row(this).child.isShown()){
        var data = tablaCategoria.row(this).data();
    }else{
        var data = tablaCategoria.row($(this).parents("tr")).data();
    }

    idCategoria = data[0];

    const result = await Swal.fire({
        title: '¿ESTA SEGURO DE ELIMINAR LA CATEGORIA?',
        text: "Si no lo esta puede cancelar la acción!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#5bc0de',
        cancelButtonColor: '#d9534f',
        confirmButtonText: 'Si, eliminar!'
    });

    if(result.value){
        try {

            var datosCategoria = new FormData();
            datosCategoria.append('eliminarCategoria', 'OK');
            datosCategoria.append('idCategoria', idCategoria);
        
            var peticion = await fetch('../controllers/CategoriaController.php', {
                method : 'POST',
                body : datosCategoria
            });
    
            var resjson = await peticion.json();
    
            if(resjson.respuesta == "OK"){
                notificacionExitosa('¡ELiminación exitosa!');
                tablaCategoria.ajax.reload(null, false);
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
        formaddCategoria.reset();
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

/* Limpiar campos del formulario agregar Categoria */
document.getElementById('altaCategoria').addEventListener('click', () => {
    formaddCategoria.reset();
})

/* Generar Reporte Materiales por Categoria*/ 
$(document).on('click', '.btnC', function(){
    const selectCategoriaM = document.getElementById('selectCategoriaM').value;
    if(selectCategoriaM != "show"){

        window.location = "templates/pdf_categoria.php?id_c="+selectCategoriaM;

    }else{
        notificarError("No has Seleccionado una Categoria!!");
    }
});