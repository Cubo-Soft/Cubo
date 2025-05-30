let idmensaje = $("#idmensaje");
//conduleta = document.getElementById("id_conduleta");
//let vr_conduleta = '';
//$(document).ready(function(){
$(function(){
    $("#btn_limpia").click(function (e) { 
        e.preventDefault();
        limpia();
    });
})
    
function limpia(){
    console.log('Limpiando...');
    let elemen = $("#totelemen").val();
    let comple = $("#totcomplem").val();
    let bandej = $("#totbandeja").val();
    for($e=1;$e<=elemen;$e++){
        for($c=1;$c<=comple;$c++){
            for($b=1;$b<=bandej;$b++){
                let nombreid = "_"+$e+"_"+$c+"_"+($b * 10);
                //let idcelda = document.getElementById(nombreid);
                $("#"+nombreid).val('');
                //idcelda.value = '';
                console.log('Celda:'+nombreid);
            }
        }
    }
}


function md_dato(obj_campo){  // modifica dato de la tabla con id _campo1_campo2_campo3
    console.log('Viene campo: '+obj_campo.id);
    //console.log('con conduleta:->'+idconduleta.value+'<-');
    /*if(vr_conduleta == '' || vr_conduleta.length == 0 || vr_conduleta == null ){
        alert('No ha seleccionado la Conduleta !!');
        inicio();    
    }*/
    let elemen = separa(obj_campo.id,"_",1);
    let complem = separa(obj_campo.id,"_",2);
    let bandej = separa(obj_campo.id,"_",3);
    console.log('Variables: Elemento:'+elemen+' complemento:'+complem+' bandeja:'+bandej);
    console.log('Valor digitado:'+obj_campo.value);
    let valor = parseFloat(obj_campo.value);
    if(isNaN(valor)){
        alert('Valor:->'+valor+'<- '+obj_campo.value+' NO ES VALIDO !');
        obj_campo.value='';
        obj_campo.focus();
    }else{
        console.log('Valor correcto, se procesa');
        const $dato = { 'opcion':2,
                        'elemento':elemen,
                        'complemento':complem,
                        'bandeja':bandej,
                        'valor':valor
               }
        $.ajax({
            async: true,
            data: $dato,
            type:'POST',
            dataType: 'json',
            url: '../ctr/ct_grcost_bandejas.php',
            //beforeSend:function(){
            //},
            success:function(rpta){
               //console.log('Sale:'+rpta); viene objeto
                if(rpta==1){
                    alert("Ok!");
                }else{
                    alert("Falló act !");
                }
            },
            error:function(ht){
                console.log(ht);
            }
        })  
    }
}