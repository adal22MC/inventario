const backup = document.getElementById('backups');

backup.addEventListener('click',async function(){
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
        
    } catch (error) {
        console.log(error);
    }
});