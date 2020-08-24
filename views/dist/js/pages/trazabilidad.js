var tablaMateriales;
const selectSucursal = document.getElementById('selectSucursal');

async function init() {
    tablaMateriales = $("#tablaMaterialesH").DataTable({
        "responsive": true,
        "autoWidth": false
    })

    try {
        let datos = new FormData();
        datos.append('getSucursalesHijas', 'OK');

        var peticion = await fetch('../controllers/TrazabilidadController.php', {
            method: 'POST',
            body: datos
        });

        var resjson = await peticion.json();
        console.log(resjson);

        for (let item of resjson) {
            let option = document.createElement('option');
            option.value = item.id;
            option.text = item.nombre;
            selectSucursal.appendChild(option);
        }
    } catch (error) {
        console.log(error);
    }


}

init();

selectSucursal.addEventListener('change', async () => {

    deleteRows();

    if (selectSucursal.value != "default") {
        try {
            let datos = new FormData();
            datos.append('getMaterialesSucursal', 'OK');
            datos.append('id', selectSucursal.value);

            var peticion = await fetch('../controllers/TrazabilidadController.php', {
                method: 'POST',
                body: datos
            });

            var resjson = await peticion.json();

            for (let item of resjson) {

               $('#tablaMaterialesH').find('tbody').append(`
                    <tr>
                        <td>${item.id}</td>
                        <td>${item.nombre}</td>
                        <td>${item.serial}</td>
                        <td>
                        <div class='text-center'><div class='btn-group'><button class='btn btn-info btn-sm btnTrazabilidad' value="${item.id}"><i class='fas fa-chart-line'></i></button></div></div>
                        </td>
                    </tr>
                `);
               
            }

        } catch (error) {
            console.log(error);
        }
    }
});
function deleteRows() {
    $("#tablaMaterialesH tbody").children().remove();
}
$(document).on('click', '.btnTrazabilidad', function(){
    var fecha1 = document.getElementById('Date').value;
    var fecha2 = document.getElementById('Date2').value;
    if (fecha1 != "" && fecha2 != "") {
        var fecha = $('#Date').val();
        var fecha2 = $('#Date2').val();
        let id_M = $(this).val();
        var idS = selectSucursal.value;

    window.location = "templates/pdf_trazabilidad.php?id_M="+id_M+"&fechaInicial="+fecha+"&fechaFinal="+fecha2+"&idS="+idS;
    } else {
        notificarError("No has Seleccionado las Fechas!!");
    }
    
    
});
function notificarError(mensaje) {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: mensaje
    })
}