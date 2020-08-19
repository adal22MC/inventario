var tablaSucursales;
const selectUsuario = document.getElementById('selectUsuarios');
var sucursales = [];

async function init() {
    tablaSucursales = $("#tablaSucursales").DataTable({
        "responsive": true,
        "autoWidth": false,
        "ajax": {
            "url": "../controllers/BodegaController.php",
            "type": "POST",
            "data": {
                "obtenerBodegasHijas": "OK"
            },
            "dataSrc": ""
        },
        "columns": [
            { "data": "id_b" },
            { "data": "f_creacion", "visible": false },
            { "data": "correo", "visible": false },
            { "data": "tel", "visible": false },
            { "data": "nombre" },
            { "data": "direccion" },
            { "data": "tipo", "visible": false },
            { "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-info btn-sm btnListar'><i class='fas fa-reply'></i></button></div></div>" }
        ]

    })

    try {
        let datos = new FormData();
        datos.append('getUsuariosMultisucursal', 'OK');

        var peticion = await fetch('../controllers/UsuarioController.php', {
            method: 'POST',
            body: datos
        });

        var resjson = await peticion.json();
        console.log(resjson);

        for (let item of resjson) {
            let option = document.createElement('option');
            option.value = item.username;
            option.text = item.username;
            selectUsuario.appendChild(option);
        }
    } catch (error) {
        console.log(error);
    }


}

init();

$(document).on('click', '#addUsuario', function () {
    if (selectUsuario.value != "default") {
        try {

            let sucursalesLimpia = [];

            // Limpiamos la lista de ventas de los undefined
            for (let item of sucursales) {
                if (item == undefined) { }
                else {
                    sucursalesLimpia.push({
                        id_bodega: item.id_bodega
                    });
                }
            }

            sucursalesLimpia.unshift({
                username: selectUsuario.value
            });

            // Creamos el JSON que se enviara
            var json_send = ` { "multiusuario" : [ `;

            let ban = 0;

            for (let item of sucursalesLimpia) {
                if (ban != 0) {
                    if (item == undefined) { }
                    else {
                        json_send = json_send + ",";

                        json_send = json_send + `
                            {
                                "id_bodega" : "${item.id_bodega}"
                            }
                        `;
                    }
                } else {
                    json_send = json_send + `
                        {
                            "username" : "${item.username}"
                        }
                    `;
                }
                ban = 1;
            }
            json_send = json_send + "]}";

            console.log(JSON.parse(json_send))

            $.ajax({
                url: "../controllers/UsuarioController.php",
                type: "POST",
                data: JSON.parse(json_send),
                dataType: 'json',
                success: function (respuesta) {

                    if (respuesta.respuesta == "OK") {
                        notificacionExitosa('Accesos modificados!');
                    } else {
                        notificarError(respuesta.respuesta);
                    }

                    console.log(respuesta)
                },
                error: function (xhr, status) {
                    notificarError('Ha ocurrido un error');
                    console.log(xhr);
                    console.log(status)
                }
            })
                

        } catch (error) {
            console.log(error)
        }
    }
});

$(document).on('click', '.btnListar', function () {

    if (selectUsuario.value != "default") {

        if (tablaSucursales.row(this).child.isShown()) {
            var data = tablaSucursales.row(this).data();
        } else {
            var data = tablaSucursales.row($(this).parents("tr")).data();
        }

        let ban = verificarBodega(data['id_b']);
        if (ban == true) {
            $('#tablaAcceso').find('tbody').append(`
            <tr>
                    <td>
                        <button class="btn btn-sm btn-danger btnEliminar" id="${data['id_b']}">Eliminar</button>
                    </td>
                    <td>${data['id_b']}</td>
                    <td>${data['nombre']}</td>
                </tr>
            `);

            sucursales.push({
                id_bodega: data['id_b']
            });
            console.log(sucursales);
        } else {
            notificarError('El usuario ya tiene acceso a esta sucursal');
        }
    } else {
        notificarError('Selecciona un usuario');
    }
})

$(document).on('click', '.btnEliminar', function (e) {
    e.target.parentNode.parentNode.remove();
    let pos = 0;
    for (let item of sucursales) {
        if (item != undefined) {
            if (item.id_bodega == e.target.id) {
                delete sucursales[pos];
            }
        }
        pos++;
    }

});

selectUsuario.addEventListener('change', async () => {

    deleteRows();

    if (selectUsuario.value != "default") {
        try {
            let datos = new FormData();
            datos.append('getBodegasUsuarioMultisucursal', 'OK');
            datos.append('username', selectUsuario.value);

            var peticion = await fetch('../controllers/UsuarioController.php', {
                method: 'POST',
                body: datos
            });

            var resjson = await peticion.json();

            for (let item of resjson) {
                sucursales.push({
                    id_bodega: item.id_b_bu
                });

                $('#tablaAcceso').find('tbody').append(`
                    <tr>
                        <td>
                            <button class="btn btn-sm btn-danger btnEliminar" id="${item.id_b_bu}">Eliminar</button>
                        </td>
                        <td>${item.id_b_bu}</td>
                        <td>${item.nombre}</td>
                    </tr>
                `);
            }

        } catch (error) {
            console.log(error);
        }
    }
});

function deleteRows() {
    $("#tablaAcceso tbody").children().remove();
    sucursales = [];
}

/* =====================================================================
    FUNCION QUE VERIFICA SI EL USUARIO YA TIENES ACCESO A LA BODEGA
 ======================================================================= */
function verificarBodega(id_bodega) {
    for (let item of sucursales) {
        if (item != undefined) {
            if (item.id_bodega == id_bodega) {
                return false;
            }
        }
    }
    return true;
}

function notificacionExitosa(mensaje) {
    Swal.fire(
        mensaje,
        '',
        'success'
    ).then(result => {
        window.location = "establecer_usuarios.php";
    });
}

function notificarError(mensaje) {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: mensaje
    })
}