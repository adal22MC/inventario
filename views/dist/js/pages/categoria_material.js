async function init(){
    // Llenar select categorias
    try {
        var datosC = new FormData();
        datosC.append("obtenerCategorias","OK");

        var peticion = await fetch('../controllers/CategoriaController.php',{
            method : 'POST',
            body : datosC
        });

        var resjson = await peticion.json();

        let selectCategoriaM = document.getElementById('selectCatM');
        for(let item of resjson){
            let option = document.createElement('option');
            option.value = item.id_c;
            option.text = item.descr;
            selectCategoriaM.appendChild(option);
        }

    } catch (error) {
        console.log(error);
    }
}
init();

/* Generar Reporte Materiales por Categoria*/ 
$(document).on('click', '.btnCM', function(){
    const selectCategoriaM = document.getElementById('selectCatM').value;
    if(selectCategoriaM != "show"){

        window.location = "templates/pdf_categoria.php?id_c="+selectCategoriaM;

    }else{
        notificarError("No has Seleccionado una Categoria!!");
    }
});