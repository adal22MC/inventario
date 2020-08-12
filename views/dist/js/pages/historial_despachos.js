var tablaHistorialDespachos;

function init() {
    tablaHistorialDespachos = $("#h_despachos").DataTable({
        "responsive": true,
        "autoWidth": false,
        "ajax" : {
            "url" : "../controllers/BodegaController.php",
            "type": "POST",
            "data": {
                "getHistorialDespachos" : "OK"
            },
            "dataSrc":""
        },
        "columns" :[
            {"data" : "num"},
            {"data" : "fecha"},
            {"data" : "hora"},
            {"data" : "nombre"},
            {"data" : "cedula"},
            {"data" : "tel"},
            {"data" : "obser"},
            {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-danger btn-sm btnDespacho'><i class='fas fa-file-pdf'></i></button></div></div>"}
        ]
       
    })

}
init();

$(document).on('click', '.btnDespacho', function(){
    if (tablaHistorialDespachos.row(this).child.isShown()) {
        var data = tablaHistorialDespachos.row(this).data();
    } else {
        var data = tablaHistorialDespachos.row($(this).parents("tr")).data();
    }

    let id_despacho = data[0];

    window.location = "templates/pdf_despacho.php?id_despacho="+id_despacho;
    
});
$(document).on('click', '.btnfechas', function(){
    var fecha = $('#Date').val();
    var fecha2 = $('#Date2').val();

    window.location = "templates/pdf_despacho.php?fechaInicial="+fecha+"&fechaFinal="+fecha2;
});