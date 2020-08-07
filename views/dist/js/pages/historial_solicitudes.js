var tablaHistorialSolicitudes;

function init() {
    tablaHistorialSolicitudes = $("#h_solicitudes").DataTable({
        "responsive": true,
        "autoWidth": false,
        "ajax" : {
            "url" : "../controllers/BodegaController.php",
            "type": "POST",
            "data": {
                "getHistorialSolicitudes" : "OK"
            },
            "dataSrc":""
        },
        "columns" :[
            {"data" : "id_s"},
            {"data" : "fecha"},
            {"data" : "hora"},
            {"data" : "resp"},
            {"data" : function (status){
                if(status.status == 1){
                    return "<p class='badge badge-info mb-0 mt-0'>Pendiente</p>";
                }else if (status.status == 2){
                    return "<p class='badge badge-success mb-0 mt-0'>Aceptada</p>";
                }else{
                    return "<p class='badge badge-danger mb-0 mt-0'>Rechazada</p>";
                }
            }},
            {"defaultContent": "<div class='text-center'><div class='btn-group'><button class='btn btn-danger btn-sm btnSolicitud'><i class='fas fa-file-pdf'></i></button></div></div>"}
        ]
    })
}

init();

$(document).on('click', '.btnSolicitud', function(){
    if (tablaHistorialSolicitudes.row(this).child.isShown()) {
        var data = tablaHistorialSolicitudes.row(this).data();
    } else {
        var data = tablaHistorialSolicitudes.row($(this).parents("tr")).data();
    }

    let id_solicitud = data[0];

    window.location = "templates/pdf_solicitud.php?id_solicitud="+id_solicitud;

});