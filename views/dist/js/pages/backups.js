const backup = document.getElementById('backups');

backup.addEventListener('click',async function(){
    const result = await Swal.fire({
        title: 'CONFIRMAR BACKUPS DE BASE DE DATOS',
        text: "Si no lo esta puede cancelar la acción!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#5bc0de',
        cancelButtonColor: '#d9534f',
        confirmButtonText: 'Realizar Backups!'
    });

    if (result.value) {
        try {

            let datos = new FormData();
            datos.append('backups', 'OK');

            let peticion = await fetch('../controllers/conexionController.php', {
                method : 'POST',
                body : datos
            });

            let resjson = await peticion.json();

            
            let enlace = document.getElementById('enlace');
            enlace.setAttribute('href', '../models/backups/'+resjson.nombre);
            enlace.setAttribute('download', resjson.nombre);
            enlace.click();

            let datoss = new FormData();
            datoss.append('backups_remove', 'OK');
            datoss.append('ruta', resjson.nombre);

            let peticionn = await fetch('../controllers/conexionController.php', {
                method : 'POST',
                body : datoss
            });

            let resjsonn = await peticionn.json();
            console.log(resjsonn)


        } catch (error) {
            console.log(error);
        }
    }
});