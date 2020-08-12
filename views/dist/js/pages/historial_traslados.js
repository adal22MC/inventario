var tablaHistorialTraslados;

function init(){
    tablaHistorialTraslados = $("#h_traslados").DataTable({
        "responsive": true,
        "autoWidth": false,
        "ajax" : {
            "url" : "../controllers/BodegaController.php",
            "type": "POST",
            "data": {
                "getHistorialTraslados" : "OK"
            },
            "dataSrc":""
        },
        "columns" :[
            {"data" : "id"},
            {"data" : "fecha"},
            {"data" : "hora"},
            {"data" : "resp"},
            {"data" : "nombre"},
            {"data" : "cant"},
            {"data" : "total"},
            {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-danger btn-sm btnTraslado'><i class='fas fa-file-pdf'></i></button></div></div>"}
        ]
    })
}
init();

$(document).on('click', '.btnTraslado', function(){
    if (tablaHistorialTraslados.row(this).child.isShown()) {
        var data = tablaHistorialTraslados.row(this).data();
    } else {
        var data = tablaHistorialTraslados.row($(this).parents("tr")).data();
    }

    let id_traslado = data[0];

    window.location = "templates/pdf_traslado.php?id_traslado="+id_traslado;
    
});
$(document).on('click', '.btnfechas', function(){
    var fecha = $('#Date').val();
    var fecha2 = $('#Date2').val();

    window.location = "templates/pdf_traslado.php?fechaInicial="+fecha+"&fechaFinal="+fecha2;
});