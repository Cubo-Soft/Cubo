/* funciones js del carnitszona.php */
$(function(){

})

function act(obj,opc){
    //alert("Botón Actualizar");
    console.log('Boton '+obj.id);
    $idbtn = obj.id;
    let id = separa($idbtn,'_',1);
    idselect = document.getElementById('select_'+id); 
    console.log('id: '+id);
    let idregion = idselect.options[idselect.selectedIndex].value;
    let camposuc = document.getElementById('idsuc_'+id);
    let id_suc = separa(camposuc.value,'-',0);
    console.log('Sucursal:'+id_suc);
    console.log('seleccion: '+idregion);
    //$objson = {"id":id,"id_region":idregion,"sucursal":id_suc};
    $objson = {"campo":"id_region","valor":idregion,"sucursal":id_suc,"opcion":opc};
    console.log('Sale:'+JSON.stringify($objson));
    /*
    if(opc == 1){ // adicionar en nm_sucursal.id_region
        add($objson);
    }else{  // actualizar en nm_sucursal.id_region el id_region de tmp_clientes_zona
        mod($objson);
    } */
    mod($objson); 
}

function mod($objson){  // modifica
    //console.log('Viene '+$objson);
    /* let vr_regiones = false;
    for(let key in $objson){
        console.log(' atributo:'+key+' Valor:'+$objson[key]);
        if(key == 'id_region'){
            vr_regiones = true;
        }    
    }
    if(vr_regiones){ */
        $.ajax({
            async: false,
            data: $objson,
            type:'POST',
            dataType: 'json',
            url: '../ctr/ct_nmsucursal.php',
            beforeSend:function(){
                console.log("Envio de datos: "+JSON.stringify($objson));
            },
            success:function(response){
                console.log('procesa-Llega: '+response);
                leeData(response,$objson.opcion);
                /*
                sprove.empty();
                if(response != ""){     
                    sprove.append("<option value='0'>Todos</option>");
                    for(let i in response){
                        sprove.append("<option value='"+response[i].numid+"'>"+response[i].nom_provee+"</option>");  
                    }; 
                } */
            },
            error: function(jqXHR, status, error) {
                console.error("Error en opcion: "+response.opcion+" error: "+error+" xhr: "+jqXHR+" status: "+status);
                console.log("error en procesa,VIENE: "+JSON.stringify(response));
            }
        })
    //}
}

function leeData(data,opcion){
    console.log("Llega: "+JSON.stringify(data));
    if( data.sale == true ){
        alert("Actualizado !");
    }
}