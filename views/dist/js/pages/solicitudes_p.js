var tablaMateriales;
var productosSolicitud = [];

function initTablaMateriales(){
   
    tablaMateriales =  $("#tablaMateriales").DataTable({
        "responsive": true,
        "autoWidth" : false
    })

}

initTablaMateriales();

/* Cuando se presiona el boton para agregar a la lista de solicitud */
$(document).on("click", ".btnAgregarASolicitud", async function(){
    
    if(tablaMateriales.row(this).child.isShown()){
        var data = tablaMateriales.row(this).data();
    }else{
        var data = tablaMateriales.row($(this).parents("tr")).data();
    }

    let idProducto = data[0];
    let nomProducto = data[1];
    
    
    cantidad = await Swal.fire({
        title: 'Ingresa la cantidad a solicitar',
        input: 'number',
        inputAttributes: {
          autocapitalize: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Confirmar',
    })

    if(cantidad.value){

        try {

            var material = new FormData();
            material.append('getMaterialBodegaHija_solicitud', 'OK');
            material.append('id_material', idProducto);
            
            let peticion = await fetch('../controllers/MaterialController.php', {
                method : 'POST',
                body : material
            })
    
            let resjson = await peticion.json();

            let stock_max = parseInt( resjson['s_max'] );
            let stock_disp = parseInt( resjson['s_total'] );
            let stock_sum = parseInt(cantidad.value) + stock_disp;
        
            let ban = validarMaterialRepetido(idProducto);

            if(cantidad.value <= 0){
                notificarError('Ingresa un cantidad mayor a 0');
            }else if( stock_sum > stock_max ){
                notificarError('El stock disponible mas la suma de lo que solicita sobrepasa el stock maximo!')
            }else if(ban == true ){

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

                //console.log(productosSolicitud);

            }else{
                notificarError('¡Este producto ya esta agregado, si desea agregar más eliminado y agregalo de nuevo!');
            }
        
        } catch (error) {
            console.log(error);
        }
    }

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
        var materialesSolicitud = [];

        // Limpiamos el json para quitar los empty
        for(let item of productosSolicitud){
            if(!(item == undefined)){
                materialesSolicitud.push({
                    id_material : item.id,
                    cantidad : item.cantidad
                })
            }
        }

        try {
            
            // Creamos el JSON que se enviara
            var json_send = ` { "generarSolicitud" : [ `;
            let ban = 0;
            for(let item of materialesSolicitud){  
                if(ban != 0){
                    json_send = json_send + ",";
                }
                if(!(item == undefined)){                     
                    

                    json_send = json_send + `
                        {
                            "id_material" : "${item.id_material}",
                            "cantidad" : "${item.cantidad}"
                        }
                    `;
                }
                ban = 1;
            }
            json_send = json_send + "]}";
            
            console.log(JSON.parse(json_send))

            $.ajax({
                url : "../controllers/MaterialController.php",
                type : "POST",
                data : JSON.parse(json_send),
                dataType : 'json',
                success : function(respuesta){
                    
                    if(respuesta.respuesta == "OK"){
                        notificacionExitosa('Solicitud realizada con exito!');
                    }else{
                        notificarError(respuesta.respuesta);
                    }
                    
                    console.log(respuesta)
                },
                error : function(xhr, status){
                    notificarError('Ha ocurrido un error');
                }
            })

        } catch (error) {
            console.log(error)
        }

        
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
        window.location = "solicitudes_p.php";
    });
}

function notificarError(mensaje){
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: mensaje
    })
}


