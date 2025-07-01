var a_reg = reg = [];

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

});

function busca_precio(obj){
    let id_campo = $(obj).attr('id');
    let campo = separa(id_campo,"_",0);
    let linea = separa(id_campo,"_",1);
    let refer = $(obj).val();
    //console.log("En el campo "+campo+" linea "+linea);
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

function campos(){
    let a_campos = ['consec','refProvee','cant','descrip','marca','divisa','vrUnit','vrTotal'];
}

function arma(rpta){
    //console.log("Llega: "+JSON.stringify(rpta));
    let linea = parseInt(rpta.linea); 
    let obj   = rpta.data;
    if( obj[0].precio == 0 ){
        alert("Referencia NO EXISTE !");
        $("#refProvee_"+linea).focus();
    }else{
        let cant  = rpta.cantidad;
        let lin2  = linea + 1;
        let vrUnit = 0.00;
        /* reg  = obj[0]; 
        reg.cant = cant;
        reg.linea = linea;
        carga_arg(reg); */
        pinta(lin2);
        $("#descrip_"+linea).val( obj[0].descrip );
        $("#marca_"+linea).val( obj[0].nom_marca );
        $("#divisa_"+linea).val( obj[0].abr_moneda );
        $("#vrUnit_"+linea).val( obj[0].precio.toFixed(2) );
        let vrTotal = ( parseFloat( cant ) * parseFloat( obj[0].precio ) ); 
        $("#vrTotal_"+linea).val( vrTotal.toFixed(2) );
        $("#refProvee_"+lin2).focus();    
    }
}

function carga_arg(reg){
    let ult = a_reg.length;
    a_reg[ult] = reg;
    console.log("EN ARREGLO: "+JSON.stringify(a_reg));
}

function pinta(lin2){
    let registro = "";
    registro += "<tr>";
    registro +="<td><input type='number' id='consec_"+lin2+"' style='width:100%' min=1 step=1 value='"+lin2+"' class='valor' readonly></td>";
    registro +="<td><input type='text'   id='refProvee_"+lin2+"' style='width:100%' maxlength='30' onchange='busca_precio(this);'></td>";
    registro +="<td><input type='number' id='cant_"+lin2+"' style='width:100%' min=1 max=200 step=1 value='1' class='valor' onchange='cant(this);'></td>";
    registro +="<td><input type='text'   id='descrip_"+lin2+"' style='width:100%' readonly></td>";
    registro +="<td><input type='text'   id='marca_"+lin2+"'  style='width:100%' readonly></td>";
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
    console.log("cambio de cantidad linea: "+linea);
    if( $("#vrTotal_"+linea).val() !== "" ){
        let vrTotal = parseFloat( $("#vrUnit_"+linea).val() * parseFloat( $(obj).val() ) );
        $("#vrTotal_"+linea).val( vrTotal.toFixed(2) );
    }
}

function borrar(obj){
    let id_campo = $(obj).attr('id');
    let linea = separa(id_campo,"_",1);
    if(confirm("Borrando linea "+linea)){
        a_reg = [];
        let valor = ""; let ult = 0;
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
        console.log("ARREGLO: "+JSON.stringify(a_reg));
        $("#body_precios").empty();
        for(let x=0; x < a_reg.length; x++){
            lin = x+1;  //a_reg[x]['consec'];
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