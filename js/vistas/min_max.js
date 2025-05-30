let sentidad = $("#id_entidad");
let sprove = $("#idproveedor");
let smarca = $("#idmarca");
let stope  = $("#idtope");
let bodyre = $("#bodyrest");
let cuantos = $("#divcuantos");
let nom_provee ="";
$(document).ready(function(){
    console.log("Iniciando Min Max !");
})

function obt_entidad(){   
    //alert("pulso "+sentidad.val());    
    const $dato = {
        "entidad":sentidad.val()
    }
    $.ajax({
        async: false,
        data: $dato,
        type:'POST',
        dataType: 'json',
        url: '../ctr/ct_nmnits.php',
        beforeSend:function(){

        },
        success:function(response){
            sprove.empty();
            if(response != ""){     
                sprove.append("<option value='0'>Todos</option>");
                for(let i in response){
                    sprove.append("<option value='"+response[i].numid+"'>"+response[i].nom_provee+"</option>");  
                }; 
            } 
        }
    })
}    

function busca(){
    const dato = {
        "opcion":'listaItems',
        "entidad":sentidad.val(),
        "proveedor":sprove.val(),
        "marca":smarca.val(),
        "tope":stope.val()
    }
    $("#divcriterios").css("display","none");
    $("#divresultado").css("display","block");
    $.ajax({
        async: false,
        data: dato,
        type:'POST',
        dataType: 'json',
        url: '../ctr/ct_imitems.php',
        beforeSend:function(){

        },
        success:function(response){
            let vrtope = "";
            if(dato.tope == 'n'){
                vrtope ="Mínimos";
            }else if(dato.tope == 'x'){
                vrtope ="Máximos";
            }
            
            let vcriterio = vrtope; 
            bodyre.empty();
            if(response !== ""){
                let rpta = response.data;
                cuantos.append(` ${vcriterio}  Son ${rpta.length} registros`);
                let template = "", saldo = "", pone="",rojo="class='bg-danger'",verde="";  
                for(let i in rpta){
                    saldo = Math.trunc( rpta[i].saldo );
                    if( rpta[i].saldo == saldo){
                        rpta[i].saldo = saldo;
                    } 
                    if( rpta[i].saldo <= rpta[i].minimo ){
                        pone=rojo;
                    }else{
                        pone=verde;
                    }
                    template += "<tr><td>"+ (parseInt(i) + 1 ) +"</td><td>"+rpta[i].cod_item+"</td><td>"+
                    rpta[i].alter_item+"</td><td>"+rpta[i].nom_item+"</td><td>"+
                    rpta[i].id_proveedor+"</td><td>"+rpta[i].id_marca+"</td><td>"+
                    rpta[i].linea+"</td><td>"+rpta[i].grup_item+"</td><td>"+
                    rpta[i].tipo_item+"</td><td align='right'>"+ 
                    rpta[i].minimo+"</td><td align='right'>"+rpta[i].maximo+"</td><td align='right' "+pone+">"+
                    rpta[i].saldo+"</td></tr>";
                };
                bodyre.append(template);
            }else{
                alert("Sin Resultado ! ");
            } 
        }
    })
}
