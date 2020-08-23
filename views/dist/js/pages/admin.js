const formAddSucursal = document.getElementById('formAddSucursal');

async function obtenerDatosSucursalMadre(){
    try {
        var datosSucursal = new FormData();
        datosSucursal.append('obtenerDatosSucursal', 'OK');

        var peticion = await fetch('../controllers/AdminController.php', {
            method: 'POST',
            body: datosSucursal
        });

        var resjson = await peticion.json();
        
        if (resjson != null){
            for (let item of resjson){
                document.getElementById('nombreS').value = item.nombre;
                document.getElementById('correoS').value = item.correo;
                document.getElementById('telefonoS').value = item.tel;
                document.getElementById('direccionS').value = item.direccion;
                document.getElementById('nitS').value = item.nit;
                document.getElementById('paginaS').value = item.pagina;
            }
            
        }
        
    } catch (error) {
        console.log(error);
    }
}
formAddSucursal.addEventListener('submit', async (e) =>{
    e.preventDefault();
    try {

        var datosSucursal = new FormData(formAddSucursal); //obtenemos el formulario y creamos un objeto
        datosSucursal.append('editDatosMadre', 'OK');


        var peticion = await fetch('../controllers/AdminController.php', {
            method: 'POST',
            body: datosSucursal
        });

        var resjson = await peticion.json();

        if (resjson.respuesta == "OK") {
            notificacionExitosa('¡Modificacion exitosa!');
        } else {
            notificarError(resjson.respuesta);
        }

    } catch (error) {
        console.log(error);
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