document.getElementById('formIngresar').addEventListener('submit', async (e) => {
    e.preventDefault();

    try {

        var datos = new FormData(document.getElementById('formIngresar'));
        datos.append('ingresar', 'OK');
        
        var peticion = await fetch('../controllers/LoginController.php', {
            method : 'POST',
            body : datos
        })

        var resjson = await peticion.json();
        
        if(resjson.respuesta == "OK"){
            window.location = "admin.php";
        }else{
            notificarError(resjson.respuesta);
        }

    } catch (error) {
        notificarError('Se ha generado un error en el servidor!');
        console.log(error);
    }

})

function notificarError(mensaje) {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: mensaje
    })
}