$(document).ready(function () {
    
    var datos = [];

    //carga un <select> de los programas en el div
    //divGrupoPermisos
    datos = {
        'nombreDiv': 'divListaAPPrograms'
    };
    retornarAPPrograms(2, datos);
    
    //carga la lista a mostrar de permisos de la tabla ap_roles
    //con las opciones de chequeo en permisosaroles.php
    //en el divListaAPRoles
    datos = {
        'nombreDiv': 'divListaAPRoles'
    };
    retornarAPRoles(1, datos);
    
});