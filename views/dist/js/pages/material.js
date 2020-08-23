const formaddMaterial = document.getElementById('formAddMaterial');
const formEditMaterial = document.getElementById('formEditMaterial');

var tablaMaterial;
var idMaterial;

function init() {
    tablaMaterial = $("#material").DataTable({
        "responsive": true,
        "autoWidth": false
    });
}

init();

/*  Funcion generada solo una vez desde el body*/
async function obtenerSelect() {

    try {
        var peticionCategoria = new FormData();
        peticionCategoria.append('obtenerCategorias', 'OK');

        var peticion = await fetch('../controllers/CategoriaController.php', {
            method: 'POST',
            body: peticionCategoria
        });

        var resjson = await peticion.json();
        
        if (resjson != null) {
            for (let item of resjson) {
                var option = document.createElement("option");
    
                option.setAttribute("id", item.id_c);
                option.setAttribute("value", item.id_c);
                $(option).html(item.descr);
                $(option).appendTo("#selectCategoria");
    
            }
    
            for (let item of resjson) {
                var option = document.createElement("option");
    
                option.setAttribute("id", item.id_c);
                option.setAttribute("value", item.id_c);
                $(option).html(item.descr);
                $(option).appendTo("#selectEditCategoria");
    
            }
        }
        
    } catch (error) {
        console.log(error);
    }
}

formaddMaterial.addEventListener('submit', async (e) => {
    e.preventDefault();

    if(document.getElementById('selectCategoria').value == "show"){
        notificarError("¡ Selecciona una categoria para el material !")
    }else{

        try {

            var datosMaterial = new FormData(formaddMaterial); //obtenemos el formulario y creamos un objeto
            datosMaterial.append('agregarMaterial', 'OK');


            var peticion = await fetch('../controllers/MaterialController.php', {
                method: 'POST',
                body: datosMaterial
            });

            var resjson = await peticion.json();

            if (resjson.respuesta == "OK") {
                notificacionExitosa('¡Alta de material exitosa!');
                //tablaMaterial.ajax.reload(null, false);
            } else {
                notificarError(resjson.respuesta);
            }

        } catch (error) {
            console.log(error);
        }
    }
})

formEditMaterial.addEventListener('submit', async (e) => {
    e.preventDefault();

    try {

        var datosMaterial = new FormData(formEditMaterial); //obtenemos el formulario y creamos un objeto
        datosMaterial.append('editarMaterial', 'OK');
        datosMaterial.append('idMaterial', idMaterial);

        var peticion = await fetch('../controllers/MaterialController.php', {
            method: 'POST',
            body: datosMaterial
        });

        var resjson = await peticion.json();

        if (resjson.respuesta == "OK") {
            notificacionExitosa('¡Modificación de Material exitosa!');
            //tablaMaterial.ajax.reload(null, false);
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
    $("#desMaterial").val(data[1]);
    $("#SerialMaterial").val(data[6]);
    $("#stock_max").val(data[4]);
    $("#stock_min").val(data[3]);
    /* Hacemos visible el modal */
    $('#modalEditarMaterial').modal('show');

    try {   /* Obtenemos el ID de la categoria  */
        
        var id = new FormData(); //obtenemos el formulario y creamos un objeto
        id.append('idM', idMaterial);
        id.append('IdMCategoria', 'Ok');

        var peticion = await fetch('../controllers/MaterialController.php', {
            method: 'POST',
            body: id
        });

        var resjson = await peticion.json();
        
        var selec = document.getElementById('selectEditCategoria');
        var id = resjson.id;

        for (let i = 0; i < selec.length; i++) {
            var element = selec[i];

            if (element.value == id) {
                $("#selectEditCategoria").val(element.value);
                break;
            }
        }

    } catch (error) {
        console.log(error);
    }
})

$(document).on('click', ".btnBorrar", async function () {

    if (tablaMaterial.row(this).child.isShown()) {
        var data = tablaMaterial.row(this).data();
    } else {
        var data = tablaMaterial.row($(this).parents("tr")).data();
    }

    idMaterial = data[0];

    const result = await Swal.fire({
        title: '¿ESTA SEGURO DE ELIMINAR EL MATERIAL?',
        text: "Si no lo esta puede cancelar la acción!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#5bc0de',
        cancelButtonColor: '#d9534f',
        confirmButtonText: 'Si, eliminar!'
    });

    if (result.value) {
        try {

            var datosMaterial = new FormData();
            datosMaterial.append('eliminarMaterial', 'OK');
            datosMaterial.append('idMaterial', idMaterial);

            var peticion = await fetch('../controllers/MaterialController.php', {
                method: 'POST',
                body: datosMaterial
            });

            var resjson = await peticion.json();

            if (resjson.respuesta == "OK") {
                notificacionExitosa('¡ELiminación exitosa!');
                tablaMaterial.ajax.reload(null, false);
            } else {
                notificarError(resjson.respuesta);
            }

        } catch (error) {
            console.log(error);
        }
    }

})

function notificacionExitosa(mensaje) {
    Swal.fire(
        mensaje,
        '',
        'success'
    ).then(result => {
        formaddMaterial.reset();
        document.getElementById('closeAdd').click();
        document.getElementById('closeEdit').click();
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

/* Limpiar campos del formulario agregar Categoria */
document.getElementById('altaMaterial').addEventListener('click', () => {
    formaddMaterial.reset();
})

/* Generar Reporte Stock Bajo*/ 
$(document).on('click', '.btnS', function(){
    window.location = "templates/pdf_material.php?materiales="+2;
});

/* Generar Reporte Materiales*/ 
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





