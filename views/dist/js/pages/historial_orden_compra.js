var tablaHistorialOrden;

function init() {
    tablaHistorialOrden = $("#h_orden").DataTable({
        "responsive": true,
        "autoWidth": false,
        "ajax" : {
            "url" : "../controllers/OrdenCompraController.php",
            "type": "POST",
            "data": {
                "getHistorialOrden" : "OK"
            },
            "dataSrc":""
        },
        "columns" :[
            {"data" : "id"},
            {"data" : "fecha"},
            {"data" : "hora"},
            {"data" : "nombre"},
            {"data" : function (status){
                if(status.status == 1){
                    return "<p class='badge badge-info mb-0 mt-0'>Pendiente</p>";
                }else if (status.status == 2){
                    return "<p class='badge badge-success mb-0 mt-0'>Aceptada</p>";
                }else{
                    return "<p class='badge badge-danger mb-0 mt-0'>Rechazada</p>";
                }
            }},
            {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-danger btn-sm btnOrden'><i class='fas fa-file-pdf'></i></button></div></div>"}
        ]
    })
}
init();

$(document).on('click', '.btnOrden', function(){
    if (tablaHistorialOrden.row(this).child.isShown()) {
        var data = tablaHistorialOrden.row(this).data();
    } else {
        var data = tablaHistorialOrden.row($(this).parents("tr")).data();
    }

    let id_orden = data[0];

    window.location = "templates/pdf_orden_compra.php?id_orden="+id_orden;
    
});
$(document).on('click', '.btnfechas', function(){
    var fecha = $('#Date').val();
    var fecha2 = $('#Date2').val();

    window.location = "templates/pdf_orden_compra.php?fechaInicial="+fecha+"&fechaFinal="+fecha2;
});