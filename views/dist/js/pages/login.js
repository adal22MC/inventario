document.getElementById('formIngresar').addEventListener('submit', async (e) => {
    e.preventDefault();

    try {

        var datos = new FormData(document.getElementById('formIngresar'));
        datos.append('ingresar', 'OK');

        var peticion = await fetch('../controllers/LoginController.php', {
            method: 'POST',
            body: datos
        })

        var resjson = await peticion.json();

        if (resjson.respuesta == "OK") {
            window.location = "admin.php";
        } else {
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

function mostrarPass() {
    var cambio = document.getElementById("password");
    if (cambio.type == "password") {
        cambio.type = "text";
        $('.icon').removeClass('fas fa-eye-slash').addClass('fa fa-eye');
    } else {
        cambio.type = "password";
        $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
    }
}
