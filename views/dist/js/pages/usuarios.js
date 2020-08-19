const formAddUsuario = document.getElementById('formAddUusario');
var tablaUsuarios;

function init(){
    tablaUsuarios = $('#tablaUsuarios').DataTable({
        "responsive": true,
         "autoWidth": false,
        "ajax": {
            "url" : "../controllers/UsuarioController.php",
            "type": "POST",
            "data": {
                "getUsuarios" : "OK"
            },
            "dataSrc":""
        },
        "columns": [
            { "data": "username" },
            { "data": "pass" },
            { "data" : "correo" },
            { "data" : "num_iden" },
            { "data" : "nombres" },
            { "data" : "apellidos" },
            { "data" : "id_tu_u",
              "visible" : true},
            {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-info btn-sm btnEditar'>EDIT</button><button class='btn btn-danger btn-sm btnBorrar'>DELETE</button></div></div>"}
        ]
    });
}

init();

async function llenarSelectTipoUsuario(){
    try {

        var datos = new FormData();
        datos.append('getTiposUsuarios','OK');
        
        var peticion = await fetch('../controllers/UsuarioController.php', {
            method : 'POST',
            body : datos
        });

        var resjson = await peticion.json();

        var selectTipo = document.getElementById('tipoUsuario');

        for(item of resjson){
            let option = document.createElement('option');
            option.value = item.id_tu;
            option.text = item.descr;
            selectTipo.appendChild(option);
        }
        
    } catch (error) {
        console.log(error);
    }
}

llenarSelectTipoUsuario();

formAddUsuario.addEventListener('submit', async (e) => {
    e.preventDefault();

    let selectTipo = document.getElementById('tipoUsuario');
    if(selectTipo.value === "default"){
        notificarError('Selecciona un tipo de usuario');
    }else{
        try {

            var datos = new FormData(formAddUsuario);
            datos.append('addUsuario','OK');
            
            var peticion = await fetch('../controllers/UsuarioController.php', {
                method : 'POST',
                body : datos
            });
    
            var resjson = await peticion.json();
    
            if(resjson.respuesta == "OK"){
                notificacionExitosa('Usuario registrado');
            }else{
                notificarError(resjson.respuesta);
            }
            
        } catch (error) {
            console.log(error);
        }
    }
});

function notificacionExitosa(mensaje) {
    Swal.fire(
        mensaje,
        '',
        'success'
    ).then(result => {
        window.location = "usuarios.php";
    });
}

function notificarError(mensaje) {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: mensaje
    })
}