let idmensaje = $("#idmensaje");
let nom_provee ="";
$(document).ready(function(){
    
})

function cambia(campo){
    console.log('Viene '+campo.id);
    let idcampo  = campo.id;
    let grupo = separa(idcampo,"-",0);
    let facto = separa(idcampo,"-",1);
    let tcost = $("#"+grupo+"-"+5);
    let salem = $("#"+grupo+"-"+7);
    let engco = $("#"+grupo+"-"+8);
    let valor = campo.value;
    //$("#divcriterios").css("display","none");
    console.log('campo: factor:'+facto+' grupo:'+grupo+' valor:'+valor);
    const $dato = {"factor":facto,"grupo":grupo,"valor":valor};
    // rpta = procesa($dato,'../ctr/ct_cpmultip.php',false);
    $.ajax({
        async: true,
        data: $dato,
        type:'POST',
        dataType: 'json',
        url: '../ctr/ct_cpmultip.php',
        beforeSend:function(){

        },
        success:function(response){
			//console.log('Sale1:'+response);
			console.log('Sale2:'+JSON.stringify(response));
			if(response.estado == 1){
                location.reload();
				console.log('tcost-5:'+response.tcost);
                console.log('salem-7:'+response.salem);
                console.log('engco-8:'+response.engco);
				alert("Ok!");
            }else{
                //tcost.prop("value",response.tcost);
                //salem.prop("value",response.salem);
                //engco.prop("value",response.engco);
			}
        },
		error: function(jqXHR, status, error) {
			//console.error("Error : "+error+" xhr: "+jqXHR+" status: "+status);
			alert("Error : "+error+" xhr: "+jqXHR+" status: "+status);
		}
    })  
	.done( function(msg){
		//console.log('mensaje:'+msg);
	}) 
}
