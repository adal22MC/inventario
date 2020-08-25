const formaddMaterial = document.getElementById('formAddMaterial');
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
                "getMateriales" : "OK"
            },
            "dataSrc":""
        },
        "columns" :[
            {"data" : "id"},
            {"data" : "nombre"},
            {"data" : function test(stock){
                return `<button class="btn btn-primary btn-sm">${stock.stock}</button>`
            }},
            {"data" : "s_max", 
             "visible" :false},
            {"data" : "categoria"},
            {"data" : "s_min", "visible" : false},
            {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-info btn-sm btnAddListDespacho'><i class='fas fa-reply'></i></button></div></div>"}
        ]
    })

}

initTablaMateriales();

/* Cuando se procesa la orden de compra finalmente */
function procesar_orden () {
    
    try {

        let listaDepachoLimpia = [];

        // Limpiamos la lista de ventas de los undefined
        for(let item of productosDespacho){
            if(item == undefined){}
            else{
                listaDepachoLimpia.push({
                    id : item.id,
                    cantidad : item.cantidad,
                    precio : item.precio
                });
            }
        }
                
        // Creamos el JSON que se enviara
        var json_send = ` { "generarOrden" : [ `;

        let ban = 0;

        for(let item of listaDepachoLimpia){
            
            if(item == undefined){}                        
            else{
                if(ban != 0){
                    json_send = json_send + ",";
                }

                json_send = json_send + `
                    {
                        "id" : "${item.id}",
                        "cantidad" : "${item.cantidad}",
                        "precio" : "${item.precio}"
                    }
                `;
            }
            
            ban = 1;
        }
        json_send = json_send + "]}";
        
        
        $.ajax({
            url : "../controllers/OrdenCompraController.php",
            type : "POST",
            data : JSON.parse(json_send),
            dataType : 'json',
            success : function(respuesta){
                
                if(respuesta.respuesta == "OK"){
                    notificacionExitosa('Orden de compra realizado con exito!',1);
                    obtenerUltimaOrden();
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
        });
        
        
        
    } catch (error) {
        console.log(error)
    }

}

/* Cuando se presiona el boton para agregar un material */
document.getElementById('altaMaterial').addEventListener('click', () => {
    formaddMaterial.reset();
});

formaddMaterial.addEventListener('submit', async (e) => {
    e.preventDefault();

    if(document.getElementById('selectCategoria').value == "show"){
        notificarError("¡ Selecciona una categoria para el material !")
    }else{

        try {

            var datosMaterial = new FormData(formaddMaterial); //obtenemos el formulario y creamos un objeto
            datosMaterial.append('agregarMaterial', 'OK');


            var peticion = await fetch('../controllers/MaterialController.php', {
                method: 'POST',
                body: datosMaterial
            });

            var resjson = await peticion.json();

            if (resjson.respuesta == "OK") {
                notificacionExitosa('¡Alta de material exitosa!',0);
                tablaMateriales.ajax.reload(null, false);
                $("#modalAgregarMaterial").modal("hide");
            } else {
                notificarError(resjson.respuesta);
            }

        } catch (error) {
            console.log(error);
        }
    }
})

/*  Llena el select de categoria una sola vez */
async function obtenerSelect() {

    try {
        var peticionCategoria = new FormData();
        peticionCategoria.append('obtenerCategorias', 'OK');

        var peticion = await fetch('../controllers/CategoriaController.php', {
            method: 'POST',
            body: peticionCategoria
        });

        var resjson = await peticion.json();
        
        if (resjson != null) {
            for (let item of resjson) {
                var option = document.createElement("option");
    
                option.setAttribute("id", item.id_c);
                option.setAttribute("value", item.id_c);
                $(option).html(item.descr);
                $(option).appendTo("#selectCategoria");
    
            }
    
            for (let item of resjson) {
                var option = document.createElement("option");
    
                option.setAttribute("id", item.id_c);
                option.setAttribute("value", item.id_c);
                $(option).html(item.descr);
                $(option).appendTo("#selectEditCategoria");
    
            }
        }
        
    } catch (error) {
        console.log(error);
    }
}

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
    let stock_max = parseInt( data['s_max'] );
    
    
    Swal.fire({
        title: 'Ingresa la cantidad a ordenar',
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
                
                if(cantidad.value <= 0){
                    notificarError('Ingresa una cantidad valida')
                }else if( ( parseInt(stock) + parseInt(cantidad.value) )  <= stock_max ){


                    Swal.fire({
                        title: 'Ingresa el precio de compra unitario',
                        input: 'number',
                        inputAttributes: {
                          autocapitalize: 'off'
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Confirmar',
                    }).then(precio => {
                        if(precio.value){
                            if(precio.value <= 0){
                                notificarError('Ingresa una cantidad valida');
                            }else{
                                $('#tablaOrden').find('tbody').append(`
                                    <tr>
                                        <td>
                                            <button class="btn btn-sm btn-danger btnEliminar" id="${idProducto}">Eliminar</button>
                                        </td>
                                        <td>${nomProducto}</td>
                                        <td>${cantidad.value}</td>
                                        <td>${precio.value}</td>
                                    </tr>
                                `);

                                // Agregamos el producto a nuestro objeto
                                productosDespacho.push({
                                    id : idProducto,
                                    cantidad : cantidad.value,
                                    precio : precio.value
                                });

                                console.log(productosDespacho);
                            }
                        }
                    });
                    
                }else{
                    notificarError('El stock disponible más la cantidad a ordenar sobrepasa el stock maximo!')
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
        procesar_orden();
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

function notificacionExitosa(mensaje,ban){
    Swal.fire(
        mensaje,
        '',
        'success'
    ).then(result => {
        if(ban == 1){
            window.location = "orden_compra.php";
        }
    });
}

function notificarError(mensaje){
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: mensaje
    })
}
async function obtenerUltimaOrden(){
    try {
        var peticionOrden = new FormData();
        peticionOrden.append('obtenerUltimaOrden', 'OK');

        var peticion = await fetch('../controllers/OrdenCompraController.php', {
            method: 'POST',
            body: peticionOrden
        });

        var resjson = await peticion.json();
        window.location = "templates/pdf_orden_compra.php?id_orden="+resjson.id;
    } catch (error) {
        console.log(error);
    }
}
