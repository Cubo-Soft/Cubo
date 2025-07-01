var a_reg = reg = [], ventana=0,venPlano="",erradas = 0,lineac = 0;

$(document).ready(function () {
    console.log("Iniciando...");

    $("#refProvee_1").focus();

    $("#refProvee").on("focus",function(){
        if( $("#tipo_referencia").val() === ""){
            alert("No ha elegido el tipo de referencia ...");
            $("#tipo_referencia").focus();
        }
    })

    $("#referencia").on("keypress",function(){
        llamaDatos( $("#marca option:selected").val(), $("#tipo_referencia").val(), $("#referencia").val(), $("#cant").val() ); 
    });   

    $("#idSubPlano").on("click", function(){
        subePlano();
    })
    $("#idGenPlano").on("click", function(){
        generaPlano();
    })

    $("#idExcel").on("click", function(){
        generaExcel();
    })

    $("#formCargue").on("submit", function(e){
        $("#imagen_carga").css("display","block")
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            //url: '../ctr/CT_carguePlanoCsv.php',
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
                }else{
                    rpta = "<div class='callout callout-success'>"+obj.estado+"</div>";
                    procesa_plano(arch);
                }
                $('#idMensaje').html(rpta);
            },
            error: function() {
                $('#idMensaje').html("<div class='callout callout-danger'><h4>Error al cargar el archivo.</H4></div>");
            }
        });
    });
});

function subePlano(){
    if( $("#divSubePlano").css("display") == "none"){
        $("#divSubePlano").css("display","block");
        $("#idCarguePlano").focus();    
    }else{
        $("#divSubePlano").css("display","none");
    }
}

function busca_precio(obj){
    $("#idMensajePpal").html("");
    let id_campo = $(obj).attr('id');
    console.log("idcampo: "+id_campo);
    //let campo = separa(id_campo,"_",0);
    let linea = separa(id_campo,"_",1);
    let refer = $(obj).val();
    const datos = { 'opcion':'precioVenta','ref_provee':refer,'linea':linea,'cant': $("#cant_"+linea).val() }
    destino = "../ctr/ctPrecioProvee.php";
    let asin = false;
    procesa(datos,destino,asin);
}

function readData(respuesta,opcion){
    switch(opcion){
        case 'precioVenta':
            arma(respuesta);
            break;
        default:
            alert("Sin Opción !");    
    }
}

function arma(rpta){
    let linea = parseInt(rpta.linea),lista = ""; 
    let obj   = rpta.data;
    if( obj[0].precio == 0 ){
        $("#idMensajePpal").html("<div class='callout callout-danger'><B>Referencia "+rpta.ref_provee+" NO EXISTE !</B></div>");
        $("#ulReferErradas").append("<li>"+rpta.ref_provee+"</li>");
        erradas += 1;
        $("#ref_prove_"+linea).val("");
        $("#refProvee").val(false);
        //$("#refProvee_"+linea).focus();
    }else{
        $("#refProvee").val(true);
        let cant  = rpta.cantidad;
        let lin2  = linea + 1;
        pinta(lin2);
        $("#marca_"+linea).val( obj[0].nom_marca );
        $("#descrip_"+linea).val( obj[0].descrip );
        $("#divisa_"+linea).val( obj[0].abr_moneda );
        $("#vrUnit_"+linea).val( obj[0].precio.toFixed(2) );
        let vrTotal = ( parseFloat( cant ) * parseFloat( obj[0].precio ) ); 
        $("#vrTotal_"+linea).val( vrTotal.toFixed(2) );
        $("#refProvee_"+lin2).focus();    
    }
}

function carga_arg(linea=0){
    a_reg = [];
    $("#body_precios tr").each(function(){
        reg = {};
        $(this).find('td input').each(function(){
            idcampo = $(this).attr('id');
            campo = separa(idcampo,"_",0);
            linx  = separa(idcampo,"_",1);
            valor = $(this).val();
            if( campo !== 'bor'){
                reg[campo] = valor;
            }
        });
        if( linx !== linea && reg.refProvee !== "" ){
            ult = a_reg.length;
            a_reg[ult] = reg;    
        }
    });
} 

function pinta(lin2){
    let registro = "";
    registro += "<tr>";
    registro +="<td><input type='number' id='consec_"+lin2+"' style='width:100%' min=1 step=1 value='"+lin2+"' class='valor' readonly></td>";
    registro +="<td><input type='text'   id='refProvee_"+lin2+"' style='width:100%' maxlength='30' onchange='busca_precio(this);'></td>";
    registro +="<td><input type='number' id='cant_"+lin2+"' style='width:100%' min=1 max=200 step=1 value='1' class='valor' onchange='cant(this);'></td>";
    registro +="<td><input type='text'   id='marca_"+lin2+"'  style='width:100%' readonly></td>";
    registro +="<td><input type='text'   id='descrip_"+lin2+"' style='width:100%' readonly></td>";
    registro +="<td><input type='text'   id='divisa_"+lin2+"' style='width:100%' readonly></td>";
    registro +="<td><input type='text'   id='vrUnit_"+lin2+"' style='width:100%' class='valor' readonly></td>";
    registro +="<td><input type='text'   id='vrTotal_"+lin2+"' style='width:100%' class='valor' readonly></td>";
    registro +="<td><input type='button' name='bor_"+lin2+"' id='bor_"+lin2+"' value='X' title='Borrar línea "+lin2+"' onclick='borrar(this);' ></td>";
    $("#body_precios").append(registro);
}

function cant(obj){
    let id_campo = $(obj).attr('id');
    let campo = separa(id_campo,"_",0);
    let linea = separa(id_campo,"_",1);
    if( $("#vrTotal_"+linea).val() !== "" ){
        let vrTotal = parseFloat( $("#vrUnit_"+linea).val() * parseFloat( $(obj).val() ) );
        $("#vrTotal_"+linea).val( vrTotal.toFixed(2) );
    }
}

function borrar(obj){
    let id_campo = $(obj).attr('id');
    let linea = separa(id_campo,"_",1);
    if(confirm("Borrará linea "+linea+" Correcto?, oprima Aceptar, \nde lo contrario, oprima Cancelar")){
        let lin = 0; 
        carga_arg(linea);
        $("#body_precios").empty();
        for(let x=0; x < a_reg.length; x++){
            lin = x+1; 
            pinta(lin);
            $.each(a_reg[x], function(key,value){
                if( key === 'consec'){
                    value = lin;
                }else{
                    $("#"+key+"_"+lin).val( value );
                }
            })      
        }
        pinta(lin+1);    
        $("#refProvee_"+(lin+1)).focus();
    }
}

function armaHtml(opc=0){
    let plano = "<html><body><table style='border:solid 1px'>";
    plano += "<thead><tr><th>Referencia</th><th>Cant</th><th>Marca</th><th>Descripción</th><th>Divisa</th><th>Vr.Unit</th><th>vr.Total</th></tr></thead>";
    plano += "<tbody>";
    for(let x=0; x < a_reg.length; x++){
        if(opc == 0 ){
            vrUnit = a_reg[x]['vrUnit']; vrTotal = a_reg[x]['vrTotal'];
        }else{
            vrUnit = reemp_punto( a_reg[x]['vrUnit'] ); vrTotal = reemp_punto( a_reg[x]['vrTotal'] );
        }
        plano += "<tr><td>'" + a_reg[x]['refProvee'] + "</td>";
        plano += "<td>" + a_reg[x]['cant'] + "</td>";
        plano += "<td>" + a_reg[x]['marca'] + "</td>";
        plano += "<td>" + a_reg[x]['descrip'] + "</td>";
        plano += "<td>" + a_reg[x]['divisa'] + "</td>";
        plano += "<td>" + vrUnit + "</td>";
        plano += "<td>" + vrTotal + "</td></tr>";
    }
    plano += "</tbody></table></body></html>";
    return plano;
}

function generaPlano(){
    carga_arg();
    let plano = "";
    if( a_reg.length > 0 ){
        plano = armaHtml(1);
        if( ventana === 1 ){
            venPlano.close();
        }
        venPlano = window.open('https://www.cubosoftalfrio.com','vPlano');
        ventana = 1;
        venPlano.document.write(plano);    
    }else{
        alert("No ha registrado datos !");
        $("#refProvee_1").focus();
    }
}

function reemp_punto(vr){
    let texto = String(vr);
    texto = texto.replace('.',',');
    return texto;
}

function generaExcel(){
    carga_arg();
    let html = "";
    if( a_reg.length > 0 ){
        html = armaHtml(0);
        $("#divTabla").empty();
        $("#divTabla").append(html);
        var wb = XLSX.utils.table_to_book(document.getElementById("divTabla"), {sheet: "Hoja1"});
        XLSX.writeFile(wb, 'Precios.xlsx');    
    }else{
        alert("No ha registrado datos !");
        $("#refProvee_1").focus();
    } 
}

function procesa_plano(listaDatos){
    lineac = 1;
    for(let ind=0; ind < listaDatos.length; ind++){
        if( !$.isNumeric(listaDatos[ind][1]) ){
            listaDatos[ind][1] = 1;
        }
        $("#cant_"+lineac).val( listaDatos[ind][1] );
        $("#refProvee_"+lineac).val( listaDatos[ind][0] );
        let objRefProvee = $("#refProvee_"+lineac);
        busca_precio( objRefProvee );
        if( $("#refProvee").val() === "true" ){
            lineac = parseInt(lineac) + 1;
        }
    }
    $("#imagen_carga").css("display","none");
    $("#divSubePlano").css("display","none");
    if( erradas > 0 ){
        $("#divReferErradas").css("display","block");
    }
}