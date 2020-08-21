const formAddUsuario = document.getElementById('formAddUusario');
var tablaUsuarios;
var username;
var opcion; // 1 es agregar, 2 es editar

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
              "visible" : false},
            { "data" : "descr"},
            { "data" : (s) => {
                if(s.status == 1){
                    return `<button class="btn btn-success btn-sm desactivar">Activo</button>`;
                }else{
                    return `<button class="btn btn-danger btn-sm activar">Inactivo</button>`;
                }
            }},
            {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-info btn-sm btnEditar'>EDIT</button><button class='btn btn-primary btn-sm btnVerAccesos'>ACCESOS</button></div></div>"}
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
            var mensaje;
            let datos = new FormData(formAddUsuario);

            if(opcion == 1){
                datos.append('addUsuario','OK');
                mensaje = "Usuario registrado";
            }else if(opcion == 2) {
                datos.append('editUsuario','OK');
                datos.append('username', username);
                mensaje = "Usuario modificado";
            }
            
            
            var peticion = await fetch('../controllers/UsuarioController.php', {
                method : 'POST',
                body : datos
            });
    
            var resjson = await peticion.json();
    
            if(resjson.respuesta == "OK"){
                notificacionExitosa(mensaje);
                tablaUsuarios.ajax.reload(null,false);
            }else{
                notificarError(resjson.respuesta);
            }
            
        } catch (error) {
            console.log(error);
        }
    }
});

$(document).on('click', '.btnEditar', function(){
    opcion = 2;
    if(tablaUsuarios.row(this).child.isShown()){
        var data = tablaUsuarios.row(this).data();
    }else{
        var data = tablaUsuarios.row($(this).parents("tr")).data();
    }

    username = data['username'];
    document.getElementById('tipoUsuario').setAttribute("disabled", true);
    document.getElementById('username').setAttribute("disabled", true);

    $("#username").val(data['username']);
    $("#password").val(data['pass']);
    $("#correo").val(data['correo']);
    $("#num_iden").val(data['num_iden']);
    $("#nombres").val(data['nombres']);
    $("#apellidos").val(data['apellidos']);
    $("#tipoUsuario").val(data['id_tu_u']);
   
    /* Hacemos visible el modal */
    $('#modalAgregarUsuario').modal('show');	
});

$(document).on('click', '.btnVerAccesos', async function(){
    if(tablaUsuarios.row(this).child.isShown()){
        var data = tablaUsuarios.row(this).data();
    }else{
        var data = tablaUsuarios.row($(this).parents("tr")).data();
    }
    if(data['descr'] == "Administrador" || data['descr'] == "Almacenista Principal"){
       Swal.fire({
            title: 'Mensaje',
            text: 'Para ver los acceso selecciona un usuario de tipo Unidad o Multisucursal.',
        }); 
        /*$("#tablaAcceso tbody").children().remove();
        $("#tablaAcceso").find('tbody').append(`
            <tr>
                <td>*</td>
                <td>Unidad Pricipal</td>
            </tr>
        `);
        $("#modalSucursalesAcceso").modal('show'); */
            
        
    }else{
        try {
            let data_form = new FormData();
            data_form.append('getSucursalesAcceso','OK');
            data_form.append('username',data['username']);

            let peticion = await fetch('../controllers/UsuarioController.php', {
                method : 'POST',
                body : data_form
            });

            let resjson = await peticion.json();

            console.log(resjson);

            if(resjson[0].length === 0){
                Swal.fire({
                    title: 'Mensaje',
                    text: 'Sin acceso a sucursales',
                }); 
            }else{
                $("#tablaAcceso tbody").children().remove();
                for(let item of resjson){
                    $("#tablaAcceso").find('tbody').append(`
                        <tr>
                            <td>${item[0].id_b}</td>
                            <td>${item[0].nombre}</td>
                        </tr>
                    `);
                }
                $("#modalSucursalesAcceso").modal('show');
            }

            
            
        } catch (error) {
            console.log(error);
        }
    }
    
});

$(document).on('click', '.desactivar', async function(){
    try {

        if(tablaUsuarios.row(this).child.isShown()){
            var data = tablaUsuarios.row(this).data();
        }else{
            var data = tablaUsuarios.row($(this).parents("tr")).data();
        }

        let datos = new FormData();
        datos.append('desactivarUsuario', 'OK');
        datos.append('username', data['username']);
        let peticion = await fetch('../controllers/UsuarioController.php',{
            method : 'POST',
            body : datos
        });

        let resjson = await peticion.json();

        if(resjson.respuesta == "OK"){
            tablaUsuarios.ajax.reload(null,false);
        }else{
            notificarError(resjson.respuesta);
        }
        
    } catch (error) {
        console.log(error)
    }
})

$(document).on('click', '.activar', async function(){
    try {

        if(tablaUsuarios.row(this).child.isShown()){
            var data = tablaUsuarios.row(this).data();
        }else{
            var data = tablaUsuarios.row($(this).parents("tr")).data();
        }
        
        let datos = new FormData();
        datos.append('activarUsuario', 'OK');
        datos.append('username', data['username']);
        let peticion = await fetch('../controllers/UsuarioController.php',{
            method : 'POST',
            body : datos
        });

        let resjson = await peticion.json();

        if(resjson.respuesta == "OK"){
            tablaUsuarios.ajax.reload(null,false);
        }else{
            notificarError(resjson.respuesta);
        }
        
    } catch (error) {
        console.log(error)
    }
})

document.getElementById('btnAddUsuario').addEventListener('click', () => {
    opcion = 1;
    formAddUsuario.reset();
    document.getElementById('tipoUsuario').removeAttribute("disabled", true);
    document.getElementById('username').removeAttribute("disabled", true);
});

function notificacionExitosa(mensaje) {
    Swal.fire(
        mensaje,
        '',
        'success'
    ).then(result => {
        $('#modalAgregarUsuario').modal('hide');	
    });
}

function notificarError(mensaje) {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: mensaje
    })
}