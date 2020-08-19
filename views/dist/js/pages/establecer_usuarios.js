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
            { "defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-info btn-sm btnEditar'><i class='fas fa-reply'></i></button></div></div>" }
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

selectUsuario.addEventListener('change', async () => {
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
            console.log(resjson);
            for (let item of resjson) {
                sucursales.push({
                    id_b: item.id_b_bu
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
