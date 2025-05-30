
$(document).ready(function (){
    console.log("Iniciando Cargue CSV de Precios Proveedores ...");

    $("#formCargue").on("submit", function(e){
        e.preventDefault();
        $("#imagen_carga").css("display","block")
        if($("#id_marca").val() == '0' || $("#file").val() == "" ){
            alert("Por favor, seleccione Marca y Archivo CSV");
            $("#id_marca").focus();
        }else{
            var formData = new FormData(this);
            $.ajax({
                url: '../ctr/CT_leaPlanoCsv.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    let obj = JSON.parse(response);
                    let arch = obj.data;
                    let rpta = "";
                    if( obj.error ){
                        rpta = "<div class='callout callout-danger'><h4>"+obj.estado+"</H4></div>";
                        $('#idMensaje').html(rpta);
                    }else{
                        rpta = "<div class='callout callout-success'>"+obj.estado+"</div>";
                        $('#idMensaje').html(rpta);
                        const datos = { "opcion":"leeTmpPrecios","tmpTabla":"tmp_precio_provee","archivo":obj.salida }
                        destino = "../ctr/ctPrecioProvee.php";
                        let asin = false;
                        procesa(datos,destino,asin);
                    }
                },
                error: function() {
                    $('#idMensaje').html("<div class='callout callout-danger'><h4>Error al cargar el archivo.</H4></div>");
                }
            });
        }
    });
})

function readData(respuesta,opcion){
    let obj = "";
    switch(opcion){
        case 'leeTmpPrecios':
            obj = JSON.parse(JSON.stringify(respuesta));
            $("#imagen_carga").css("display","block");
            $("#idMensaje").html("<div class='callout callout-success'>Leyendo "+obj.data+" registros ...</div>");
            procesa_plano(); 
            break;
        case 'actPrecios':
            $("#imagen_carga").css("display","none");
            console.log("REGRESA:"+JSON.stringify(respuesta));
            obj = JSON.parse(JSON.stringify(respuesta));
            $("#imagen_carga").css("display","none")
            if( obj.data === true ){
                $("#idmensaje").html("<div class='callout callout-success'>CARGA EXITOSA !! </div>");
            }else{
                alert("<div class='callout callout-danger'><h4>carga fallida </H4></div>");
            }
            break;
        default:
            alert("Sin la opción");
            break;
    }    
}

function procesa_plano(){
    destino = "../ctr/ctPrecioProvee.php";
    let asin = false;
    const datos = {"opcion":"actPrecios",
                    "tmpTabla":"tmp_precio_provee",
                    "fecha_carga":$("#fechaCarga").val(),
                    "id_moneda":$("#id_moneda").val()
                }
    procesa(datos,destino,asin);
}