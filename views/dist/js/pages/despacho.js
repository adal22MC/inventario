var tablaMateriales;
var productosDespacho = [];

function initTablaMateriales(){
   
    tablaMateriales =  $("#tablaMateriales").DataTable({
        "responsive": true,
        "autoWidth" : false,
        "ajax" : {
            "url" : "../controllers/MaterialController.php",
            "type": "POST",
            "data": {
                "getMaterialHijas" : "OK"
            },
            "dataSrc":""
        },
        "columns" :[
            {"data" : "id"},
            {"data" : "nombre"},
            {"data" : function test(stock){
                return `<button class="btn btn-primary btn-sm">${stock.stock}</button>`
            }},
            {"data" : "categoria"},
            {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-info btn-sm btnAddListDespacho'><i class='fas fa-reply'></i></button></div></div>"}
        ]
    })

}

initTablaMateriales();

/* Cuando se procesa el despacho finalmente */
$(document).on('submit', "#formDatosDespacho", (e) => {
    e.preventDefault();
    
    try {

        let listaDepachoLimpia = [];

        // Limpiamos la lista de ventas de los undefined
        for(let item of productosDespacho){
            if(item == undefined){}
            else{
                listaDepachoLimpia.push({
                    id : item.id,
                    cantidad : item.cantidad
                });
            }
        }
        
        listaDepachoLimpia.unshift({
            num_orden : document.getElementById('num_orden').value,
            nombre : document.getElementById('nomTrabajador').value,
            telefono : document.getElementById('telefono').value,
            cedula : document.getElementById('cedula').value,
            obser : document.getElementById('observaciones').value
        })
        
        // Creamos el JSON que se enviara
        var json_send = ` { "generarDespacho" : [ `;

        let ban = 0;

        for(let item of listaDepachoLimpia){
            if(ban != 0){
                if(item == undefined){}                        
                else{

                    json_send = json_send + ",";

                    json_send = json_send + `
                        {
                            "id" : "${item.id}",
                            "cantidad" : "${item.cantidad}"
                        }
                    `;
                }
            }else{
                json_send = json_send + `
                    {
                        "num_orden" : "${item.num_orden}",
                        "nombre" : "${item.nombre}",
                        "telefono" : "${item.telefono}",
                        "cedula" : "${item.cedula}",
                        "obser" : "${item.obser}"
                    }
                `;
            }
            ban = 1;
        }
        json_send = json_send + "]}";
        
        console.log(JSON.parse(json_send))

        $.ajax({
            url : "../controllers/DespachoController.php",
            type : "POST",
            data : JSON.parse(json_send),
            dataType : 'json',
            success : function(respuesta){
                
                if(respuesta.respuesta == "OK"){
                    notificacionExitosa('Despacho realizado con exito!');
                }else{
                    notificarError(respuesta.respuesta);
                }
                
                console.log(respuesta)
            },
            error : function(xhr, status){
                notificarError('Ha ocurrido un error');
                console.log(xhr);
                console.log(status)
            }
        })
        
        
    } catch (error) {
        console.log(error)
    }

})

/* Cuando se presiona el boton para agregar a la lista de solicitud */
$(document).on("click", ".btnAddListDespacho", function(){
    
    if(tablaMateriales.row(this).child.isShown()){
        var data = tablaMateriales.row(this).data();
    }else{
        var data = tablaMateriales.row($(this).parents("tr")).data();
    }

    let idProducto = data[0];
    let nomProducto = data[1];
    let stock = parseInt( data[2] );
    
    Swal.fire({
        title: 'Ingresa la cantidad a despachar',
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
                console.log(stock)
                if(cantidad.value <= 0){
                    notificarError('Ingresa una cantidad valida')
                }else if(stock >= cantidad.value ){

                    $('#tablaDespachos').find('tbody').append(`
                        <tr>
                            <td>
                                <button class="btn btn-sm btn-danger btnEliminar" id="${idProducto}">Eliminar</button>
                            </td>
                            <td>${nomProducto}</td>
                            <td>${cantidad.value}</td>
                        </tr>
                    `);

                    // Agregamos el producto a nuestro objeto
                    productosDespacho.push({
                        id : idProducto,
                        cantidad : cantidad.value
                    });

                    console.log(productosDespacho);

                }else{
                    notificarError('No hay stock suficiente!')
                }
                

            }else{
                notificarError('¡Este producto ya esta agregado, si desea agregar más eliminalo y agregalo de nuevo!');
            }
        }
    });

});

$(document).on('click', '.btnEliminar', (e) => {
    console.log('Eliminando ...');

    let pos = 0;
    
    for( let item of productosDespacho){
        if(item == undefined){}
        else{
            if(  item.id  ==  e.target.id  ){
                delete productosDespacho[pos];
            }
        }
        pos = pos + 1;
    }
    
    e.target.parentNode.parentNode.remove();

});

$(document).on('click', '#procesarVenta', (e) => {
    let contador = 0;
    // Validamos si por lo menos hay un producto en la lista
    for(item of productosDespacho){
        if(item == undefined){}
        else{
            contador = contador + 1;
        }
    }


    if(contador == 0){
        notificarError('No has agregado materiales a lista');
    }else{
        document.getElementById('observaciones').value = "Sin observaciones";
        $('#modalProcesarDespacho').modal('show');
    }
});

function validarMaterialRepetido(id){

    
    for( let item of productosDespacho){
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
        window.location = "despacho.php";
    });
}

function notificarError(mensaje){
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: mensaje
    })
}
