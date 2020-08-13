const selectSucursal = document.getElementById('sucursalesAcceso');

selectSucursal.addEventListener('change', async () => {
    // Obtenemos el id de la sucursal a la que tenemos que cambiar
    var idSucursal = selectSucursal.value;

    // Hacemos la peticion de cambio
    try {
        
        var datos = new FormData();
        datos.append('cambiarSucursal', 'OK');
        datos.append('id_sucursal', idSucursal);

        var peticion = await fetch('../controllers/UsuarioController.php', {
            method : 'POST',
            body : datos
        });

        var resjson = await peticion.json();

        console.log(resjson);

        if(resjson.respuesta == "OK"){
            notificacionExitosa('Se ha cambiado de sucuusal exitosamente!');
        }else{
            notificarError(resjson.respuesta);
        }


    } catch (error) {
        console.log(error);
    }
    
});


function notificacionExitosa(mensaje){
    Swal.fire(
        mensaje,
        '',
        'success'
    ).then(result => {
        window.location = "admin.php";
    });
}

function notificarError(mensaje){
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: mensaje
    });s
}
