
function objetoAjax(){
	let xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
		}
	}
 
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
    }
	return xmlhttp;
}

function MostrarConsulta(datos,destino,asincrono){  // asincrono viene false o true
	console.log('VIENE =>'+typeof datos+"  vr: "+datos);
	ajax=objetoAjax();
	ajax.open("POST", destino, asincrono);
	console.log("Saliendo: "+JSON.stringify(datos));
	
	ajax.onreadystatechange = function(rpta) {
		if (this.readyState == 4 && this.status == 200) {
			console.log("respuesta en MostrarConsulta:"+this.responseText);
			console.log("en rpta:"+rpta);
			return this.responseText; 
		}
	}
	ajax.send(datos);
}

function separa(nombre,separador,campo){
    let a_nombre = nombre.split(separador);
    return a_nombre[campo];
}

function procesa(datos,destino,asincrono){
	$.ajax({
		async: asincrono,
		data: datos,
		type:'GET',
		dataType: 'json',
		url: destino,
		beforeSend:function(){
			console.log('Envio de procesa opcion:'+datos.opcion);
			console.log("Envio de procesa datos: "+JSON.stringify(datos));
		},
		success:function(response){
			console.log('procesa-Llega: '+response);
			readData(response,datos.opcion);
		},
		//error: function(jqXHR, status, error) {
		error: function(status, error) {
			console.error("Error en opcion: "+datos.opcion+" error: "+error+" status: "+status);
			//console.log("error en procesa,VIENE: "+JSON.stringify(response));
		}
	});  
}