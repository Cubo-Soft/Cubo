$(document).ready(function () {

    var datos = [];

    //carga un <select> de los programas en el div
    //divGrupoPermisos
    datos = {
        'nombreDiv': 'divListaAPPrograms'
    };
    retornarAPPrograms(1, datos);

    //carga la lista a mostrar de permisos de la tabla ap_opc_permi
    //con las opciones de chequeo en permisosdeprograma.php
    //en el divGrupoPermisos
    datos = {
        'nombreDiv': 'divGrupoPermisos'
    };
    retornarAPOPCPermi(1, datos);


});

