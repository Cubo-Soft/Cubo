function cambiarARRoles(opcion, id) {

    if (opcion === 1) {
        var posGuion = id.indexOf("-"), estado = 0;
        if ($("#" + id).prop("checked") === true) {
            estado = 1;
        }
        var datosAEnviar = {
            'id_permpro': id.substr(posGuion + 1, id.length),
            'condicion': id.substr(0, posGuion),
            'estado': estado,
            'id_rol': $("#ap_roles").val()
        };
        $.ajax({
            url: "../controladores/CT_ar_roles.php",
            data: { 'caso': '1', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                retornarMensaje(obj, 1);
                retornarAPOPCPermi(2, 2);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarAPOPCPermi(opcion=1, data) { opcion 1...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }

}

function retornarARRoles(data, opcion) {
    /*
     * retornar los permisos de un módulo
     */

    var per='';

    if (opcion === 1) {
        
        var datosAEnviar = {
            'id_rol': $("#id_rol").val(),
            'codprog': $("#codprog").val()
        };
        $.ajax({
            url: "../controladores/CT_ar_roles.php",
            data: { 'caso': '2', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {     
                var obj = JSON.parse(respuesta);

                if (obj.length === 0) {
                    Swal.fire({
                        title: "Sin permiso",
                        text: "Por favor informe al administrador de la aplicación si requiere trabajar en este módulo",
                        icon: "warning"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.href = "alertas.php";
                        }
                    });

                } else {
                    //establecer los permisos al arreglo permisos
                    for (let a = 0; a < obj.length; a++) {                          
                        if(obj[a].estado===1){                            
                            permisos[a]=obj[a].permpro;                            
                        }                      
                    }      
                    
                    for (let a = 0; a < obj.length; a++) {                          
                        if(obj[a].estado===1){                            
                            per+=obj[a].permpro+'|';  
                            
                            if(obj[a].permpro==='M'){
                                $("#actualizar").show();                                
                            }

                            if(obj[a].permpro==='MOF'){
                                $("#actualizarFoto").show();
                            }
                            
                            if(obj[a].permpro==='A'){
                                $("#crear").show();
                            }

                            if(obj[a].permpro==='L'){
                                $("#listar").show();
                            }
                            
                        }                      
                    }                      
                    per=per.slice(0,-1);
                    $("#permisos").val(per);                    
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarAPOPCPermi(opcion=2, data) { opcion 1...\nError desde el servidor. Por favor informe a soporte");
            }
        });
     
    }

    return per;
}