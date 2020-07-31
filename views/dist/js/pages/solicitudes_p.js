var tablaMateriales;
var productosSolicitud = [];

function initTablaMateriales(){
   
    tablaMateriales =  $("#tablaMateriales").DataTable({
        "responsive": true,
        "autoWidth" : false,
        "ajax" : {
            "url" : "../controllers/MaterialController.php",
            "type": "POST",
            "data": {
                "obtenerMaterialesMadre" : "OK"
            },
            "dataSrc":""
        },
        "columns" :[
            {"data" : "id_m"},
            {"data" : "nom"},
            {"data" : "des"},
            {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-info btn-sm btnAgregarASolicitud'><i class='fas fa-reply'></i></button></div></div>"}
        ]
    })

}

initTablaMateriales();

/* Cuando se presiona el boton para agregar a la lista de solicitud */
$(document).on("click", ".btnAgregarASolicitud", function(){
    
    if(tablaMateriales.row(this).child.isShown()){
        var data = tablaMateriales.row(this).data();
    }else{
        var data = tablaMateriales.row($(this).parents("tr")).data();
    }

    let idProducto = data[0];
    let nomProducto = data[1];
    
    Swal.fire({
        title: 'Ingresa la cantidad a solicitar',
        input: 'number',
        inputAttributes: {
          autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Confirmar',
    }).then( cantidad => {
        if(cantidad.value){
            let ban = validarMaterialRepetido(idProducto);
            if(ban == true ){


                $('.listaSolicitud').find('tbody').append(`
                    <tr>
                        <td>
                            <button class="btn btn-sm btn-danger btnEliminar" id="${idProducto}">ELIMINAR</button>
                        </td>
                        <td>${nomProducto}</td>
                        <td>${cantidad.value}</td>
                    </tr>
                `);

                // Agregamos el producto a nuestro objeto
                productosSolicitud.push({
                    id : idProducto,
                    cantidad : cantidad.value
                });

                console.log(productosSolicitud);

            }else{
                notificarError('¡Este producto ya esta agregado, si desea agregar más eliminado y agregalo de nuevo!');
            }
        }
    });

});


$(document).on('click', '.btnEliminar', (e) => {

    let pos = 0;
    
    for( let item of productosSolicitud){
        if(item == undefined){}
        else{
            if(  item.id  ==  e.target.id  ){
                delete productosSolicitud[pos];
            }
        }
        pos = pos + 1;
    }
    
    e.target.parentNode.parentNode.remove();

});

$(document).on('click', '#procesarVenta', (e) => {
    let contador = 0;

    // Validamos si por lo menos hay un producto en la lista
    for(let item of productosSolicitud){
        if(item == undefined){}
        else{
            contador = contador + 1;
        }
    }


    if(contador == 0){
        notificarError('No has agregado productos a lista');
    }else{
        console.log('Procesando solicitud')
    }
});

function validarMaterialRepetido(id){

    
    for( let item of productosSolicitud){
        if(item == undefined){}
        else{
            if(  item.id  ==  id ){
                return false;
            }
        }
    }

    return true;

}

function notificacionExitosa(mensaje){
    Swal.fire(
        mensaje,
        '',
        'success'
    ).then(result => {
        formaddBodega.reset();
        document.getElementById('closeAdd').click();
        document.getElementById('closeEdit').click();
    });
}

function notificarError(mensaje){
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: mensaje
    })
}


