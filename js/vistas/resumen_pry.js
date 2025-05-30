
var par_grales = [],arl_InsEq = [],arg_InsEq = [], arg_InsValv = [], arl_InsValv = [], arg_eqElec = [], arl_eqElec = [];
var arg_tbElec = [], arl_tbElec = [], arg_insTub = [], arl_insTub = [], arg_sopInsEq = [], arg_sopInsTub = [], arg_sopInsElec = [];
//const formatter = new Intl.NumberFormat('es-419', {   // latino: coma (,) para decimales, punto (.) para miles
//const formatter = new Intl.NumberFormat('en-IN', {  // europa: coma (,) para miles, punto (.) para decimales
    const formatter = new Intl.NumberFormat('de-DE', {  // europa: coma (,) para decimales, punto (.) para miles
        style: 'decimal',
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
}); 

$(function(){
//$(document).ready(function () {
  
    trae_param_grales();

    recarga();

    $("#nom_proy").on("input", function(){
        $(this).val( $(this).val().toUpperCase() );
    })

    $("#nom_cliente").on("input", function(){
        $(this).val( $(this).val().toUpperCase() );
    })

    $("#utilid").blur(function(){
        vali_coma(this);
    })

    $("#iva").blur(function(){
        vali_coma(this);
    })

    $("#trm").change(function(){
        vali_coma(this);

    })

    $("#idpersadm").on("click",function(){
        if( valida_pry() ){
            pone_nomProy( $("#nom_proy_admtvo") );
            $("#resumen").css("display","none");
            $("#costos_adm").css("display","block");
            $("#Inicio").focus();    
        }
    })

    $("#xcostos_adm").on("click",function(){
        act_cst_adm();
        $("#resumen").css("display","block");
        $("#costos_adm").css("display","none");
    })

    $("#polizas").focus(function(){
        $("#polizas").val("");
    })

    $("#polizas").blur(function(){
        $("#polizas_x").val( da_valor($("#polizas")) );
        $("#polizas").val( formatter.format( $("#polizas_x").val() ));
        suma_adms();    
    })

    $("#cst_fcro").focus(function(){
        $("#cst_fcro").val("");
    })

    $("#cst_fcro").blur(function(){
        $("#cst_fcro_x").val( da_valor($("#cst_fcro")) );
        $("#cst_fcro").val( formatter.format( $("#cst_fcro_x").val() ));
        suma_adms();    
    })

    $("#comp_cntb").focus(function(){
        $("#comp_cntb").val("");
    })

    $("#comp_cntb").blur(function(){
        $("#comp_cntb_x").val( da_valor($("#comp_cntb")) );
        $("#comp_cntb").val( formatter.format( $("#comp_cntb_x").val() ));
        suma_adms();    
    })

    $("#xresumenGeneral").on("click",function(){
        $("#divResumenCliente").css("display","block");
        $("#divResumenGeneral").css("display","none");
    })

    $("#xresumenCliente").on("click",function(){
        $("#divResumenGeneral").css("display","block");
        $("#divResumenCliente").css("display","none");
    })

    $("#idpersalfrio").on("click",function(){
        if( valida_pry() ){
            pone_nomProy( $("#nom_proy_pers") );
            $("#resumen").css("display","none");
            $("#costos_pers_alfrio").css("display","block");
        }
    })

    $("#xcostos_pers_alfrio").on("click",function(){
        act_cst_pers();
        $("#resumen").css("display","block");
        $("#costos_pers_alfrio").css("display","none");
    })

    $("#idinstal_equipos").on("click",function(){
        if( valida_pry() ){
            pone_nomProy( $("#nom_proy_equipos") );
            $("#resumen").css("display","none");
            $("#costo_instal_equipos").css("display","block");
        }
    })
    
    $("#xcosto_instal_equipos").on("click",function(){
        act_cst_equi();
        $("#resumen").css("display","block");
        $("#costo_instal_equipos").css("display","none");
    })

    $("#pesoEq_0").focus(function(){
        if( $("#nomEquipo_0").val() == "" ){
            alert("Por favor, digite el Equipo");
            $("#nomEquipo_0").focus();
        }
    })

    $("#largoEq_0").focus(function(){
        if( $("#pesoEq_0").val() == "" ){
            alert("Por favor, digite el peso del Equipo");
            $("#pesoEq_0").focus();
        }
    })

    $("#anchoEq_0").focus(function(){
        if( $("#largoEq_0").val() == "" ){
            alert("Por favor, digite el largo del Equipo");
            $("#largoEq_0").focus();
        }
    })

    $("#altoEq_0").focus(function(){
        if( $("#anchoEq_0").val() == "" ){
            alert("Por favor, digite el ancho del Equipo");
            $("#anchoEq_0").focus();
        }
    })
    $("#idinstal_tuberia").on("click",function(){
        if( valida_pry() ){
            pone_nomProy( $("#nom_proy_tuberia") );
            $("#resumen").css("display","none");
            $("#costo_instal_tuberia").css("display","block");
        }
    })
    
    $("#xcosto_instal_tuberia").on("click",function(){
        act_cst_tuberia();
        $("#resumen").css("display","block");
        $("#costo_instal_tuberia").css("display","none");
    })

    $("#idinstal_valvula").on("click",function(){
        if( valida_pry() ){
            pone_nomProy( $("#nom_proy_valvulas") );
            $("#resumen").css("display","none");
            $("#costo_instal_valvula").css("display","block");
        }
    })
    
    $("#xcosto_instal_valvula").on("click",function(){
        act_cst_valvulas();
        $("#resumen").css("display","block");
        $("#costo_instal_valvula").css("display","none");
    })

    $("#idinstal_electrica").on("click",function(){
        if( valida_pry() ){
            pone_nomProy( $("#nom_proy_electrica") );
            $("#resumen").css("display","none");
            $("#costo_instal_electrica").css("display","block");
        }
    })
    
    $("#xcosto_instal_electrica").on("click",function(){
        act_cst_electrica();
        $("#resumen").css("display","block");
        $("#costo_instal_electrica").css("display","none");
    })

    $("#id_pruebas").on("click", function(){
        if( valida_pry() ){
            pone_nomProy( $("#nom_proy_pruebas") );
            $("#resumen").css("display","none");
            $("#costo_pruebas").css("display","block");
        }
    })

    $("#xcosto_pruebas").on("click", function(){
        act_cst_pruebas();
        $("#resumen").css("display","block");
        $("#costo_pruebas").css("display","none");
    })

    $("#id_varios").on("click", function(){
        if( valida_pry() ){
            pone_nomProy( $("#nom_proy_varios") );
            $("#resumen").css("display","none");
            $("#costo_varios").css("display","block");
        }
    })

    $("#xcosto_varios").on("click", function(){
        act_cst_varios();
        $("#resumen").css("display","block");
        $("#costo_varios").css("display","none");
    })

    // peso del equipo
    $("#pesoEq_0").on("change", function(){
        var campo = this;
        let idnombre = $(campo).attr("id");
        let idnum = separa(idnombre,"_",1);
        calc_instEq(idnum);
    })

    $("#borra_equipos").on("click", function(){
        $("#nomEquipo_0").val("");
        $("#pesoEq_0").val("");
        $("#largoEq_0").val("");
        $("#anchoEq_0").val("");
        $("#altoEq_0").val("");
        $("#aislEq_0").val("");
        $("#cstInstEq_0").val("");
        $("#cstAislEq_0").val("");
    })

    $("#salva_equipos").on("click", function(){
        if( $("#cstInstEq_0").val() == "" || $("#cstAislEq_0").val() == "" ){
            alert("No ha registrado datos !!");
        }else{
            carga_arg();    
        }
    })

    $("#borra_sop_equipos").on("click", function(){
        $("#perfil_0").val("");
        $("#matSop_0").val("");
        $("#canSop_0").val("");
        $("#cstMaterial_0").val("");
        $("#cstMobra_0").val("");
        $("#cstPintura_0").val("");
    })

    $("#salva_sop_equipos").on("click", function(){
            guardaPerfil("_0");
    })

    $("#borra_tuberia").on("click", function(){
        $("#linea_suc_des").val("");
        $("#idmat_suc_des").val("");
        $("#diam_suc_des").val("");
        $("#vrmat_suc_des").val("");
        $("#vrmob_suc_des").val("");
        $("#vrpin_suc_des").val("");
        $("#long_suc_des").val("");
        $("#col7_suc_des").val("");
        $("#col2_suc_des").val("");
        $("#col22_suc_des").val("");
        $("#esAi_suc_des").val("");
        $("#cdmat_suc_des").val("");
        $("#cdmob_suc_des").val("");
        $("#cdpin_suc_des").val("");
        $("#codo_suc_des").val("");
        $("#col8_suc_des").val("");
        $("#col3_suc_des").val("");
        $("#col33_suc_des").val("");
        $("#tee_suc_des").val("");
        $("#temat_suc_des").val("");
        $("#temob_suc_des").val("");
        $("#tepin_suc_des").val("");
        $("#col4_suc_des").val("");
        $("#col42_suc_des").val("");
        $("#col43_suc_des").val("");
        $("#uni_suc_des").val("");
        $("#unmat_suc_des").val("");
        $("#unmob_suc_des").val("");
        $("#unpin_suc_des").val("");
        $("#col5_suc_des").val("");
        $("#col52_suc_des").val("");
        $("#col53_suc_des").val("");
        $("#cap_suc_des").val("");
        $("#camat_suc_des").val("");
        $("#camob_suc_des").val("");
        $("#capin_suc_des").val("");
        $("#col6_suc_des").val("");
        $("#col62_suc_des").val("");
        $("#col63_suc_des").val("");
        $("#medi_suc_des").val("");
        $("#canr_suc_des").val("");
        $("#canrmt_suc_des").val("");
        $("#canrmo_suc_des").val("");
        $("#canrpi_suc_des").val("");
        $("#vrAis_suc_des").val("");
        $("#vrRed_suc_des").val("");
        $("#matCst_suc_des").val("");
        $("#mobCst_suc_des").val("");
        $("#pinCst_suc_des").val("");
        $("#aisCst_suc_des").val("");
    })

    $("#salva_tuberia").on("click", function(){
        if( $("#matCst_suc_des").val() !== "" && $("#mobCst_suc_des").val() !== "" && 
            $("#pinCst_suc_des").val() !== "" && $("#aisCst_suc_des").val() !== ""    ){
                add_arr_tuberia();    //aqui subir datos a arreglo instal. tuberia
                totalesInstTuberia();            
            }else{
                alert("No ha registrado datos de Tuberia !!");
            }
    })

    $("#borra_sop_tuberia").on("click", function(){
        $("#perfil_1").val("");
        $("#matSop_1").val("");
        $("#canSop_1").val("");
        $("#cstMaterial_1").val("");
        $("#cstMobra_1").val("");
        $("#cstPintura_1").val("");
    })

    $("#salva_sop_tuberia").on("click", function(){
            guardaPerfil("_1");
    })

    $("#borra_valvulas").on("click", function(){
        $("#valvInsValv_0").val("");
        $("#diamInsValv_0").val("");
        $("#vrManInsValv").val("");
        $("#vrPinInsValv").val("");
        $("#cantInsValv_0").val("");
        $("#esAiInsValv_0").val("");
        $("#vrAisTb").val("");
        $("#vrManInsValv_0").val("");
        $("#vrPinInsValv_0").val("");
        $("#vrAisInsValv_0").val("");
        $("#valvInsValv_0").focus();
    })

    $("#salva_valvulas").on("click", function(){
        if( $("#vrManInsValv_0").val() === "" ||
            $("#vrPinInsValv_0").val() === "" ||
            $("#vrAisInsValv_0").val() === "" ){
            alert("No ha registrado datos de Válvulas !!");
        }else{
            carga_insValv();
        }
    })

    $("#borra_eqElect").on("click", function (){
        limpiaEqElect();        
    })

    $("#borra_tbElect").on("click", function(){
        limpiaTbElect();
    })

    $("#salva_eqElect").on("click", function(){
        if( $("#mateCstEle_0").val() == "" || $("#mobrCstEle_0").val() == "" ){
            alert("No ha registrado datos de cables !!");
        }else{
            guarda_eqElect();
        }
    })

    $("#salva_tbElect").on("click", function(){
        if( $("#cstMtrTubos_0").val() == "" || $("#cstMobTubos_0").val() == "" ){
            alert("No ha registrado valores de tuberia/Bandeja !!");
        }else{
            guarda_tbElect();
        }
    })

    $("#borra_sop_elec").on("click", function(){
        $("#perfil_2").val("");
        $("#matSop_2").val("");
        $("#canSop_2").val("");
        $("#cstMaterial_2").val("");
        $("#cstMobra_2").val("");
        $("#cstPintura_2").val("");
    })

    $("#salva_sop_elec").on("click", function(){
            guardaPerfil("_2");
    })

    $("#idpdf_gral").on("click", function(){
        ventanaPdf($("#id_prycosto").val(),"G");
    })

    $("#idpdf_clie").on("click", function(){
        ventanaPdf($("#id_prycosto").val(),"C");
    })

})

// ========== Funciones dependientes ================

function ventanaPdf(pry,opcion){
    let destino = "../pdf/CL_PDF_resumen_pry.php?id_pry="+pry+"&opcion="+opcion;
    let nombre = "ventanaPdf"+opcion;
    let caract = ""; //"width=1200px,status=0";
    window.open(destino,nombre,caract);
}

function valida_pry(){
    if( $("#id_prycosto").val() === null || $("#id_prycosto").val() === "" ){
        alert("El proyecto NO HA SIDO GUARDADO !!!");
        return false;
    }else{
        return true;
    }
}

function multi(obj_can,vu,tot,grtot,opc){
    let nombre = tot+"_x";
    let tot1 = tot;
    let valor = ( da_valor($(obj_can) ) * da_valor( $("#"+vu) ) );
    if ( document.getElementById(nombre) ) {
        tot = nombre;
        $("#"+tot1).val( formatter.format(valor) );    
    }
    $("#"+tot).val( valor.toFixed(2) );
    
    if(opc==''){
        $("#"+grtot+"_x").val( da_valor( $("#"+tot) ));
        $("#"+grtot).val( formatter.format( valor ) );

    }else if(opc === 'gara'){
        suma_gara(opc,grtot);
    }else{
        suma_viat(opc,grtot);
    }
    suma_persalfrio();
}

function sumaCstSueldos(){   // sumatoria de los sueldos de ingenieros y técnicos
    $("#totmanoinge_x").val(  $("#csttotinge_x").val() );
    $("#totmanoinge").val( formatter.format( $("#csttotinge_x").val() ));
    $("#csttotinge_x").val(  $("#csttotinge_x").val());
    $("#csttotinge").val( formatter.format( $("#csttotinge_x").val()));
    $("#totmanotecn_x").val( $("#csttottecn_x").val() );
    $("#totmanotecn").val( formatter.format( $("#csttottecn_x").val() ));
    $("#csttottecn_x").val( $("#csttottecn_x").val());
    $("#csttottecn").val( formatter.format( $("#csttottecn_x").val()));
}

function suma_viat(opc,grtot){
    let tiquetes = da_valor( $("#tottiq"+opc+"_x") );
    $("#tottiq"+opc).val( formatter.format( tiquetes));
    let hospedaj = da_valor( $("#tothos"+opc+"_x") );
    $("#tothos"+opc).val( formatter.format( hospedaj ));
    let alimenta = da_valor( $("#totali"+opc+"_x") );
    $("#totali"+opc).val( formatter.format( alimenta ));
    let transpor = da_valor( $("#tottra"+opc+"_x") );
    $("#tottra"+opc).val( formatter.format( transpor ));
    $("#totviat"+opc+"_x").val( tiquetes + hospedaj + alimenta + transpor);
    $("#totviat"+opc).val( formatter.format( $("#totviat"+opc+"_x").val() ) );
}

function suma_gara(opc,grtot){
    let transporte = da_valor( $("#tottra"+opc+"_x") );
    $("#tottra"+opc).val( formatter.format( transporte ));
    let sueldo     = da_valor( $("#totsue"+opc+"_x") );
    $("#totsue"+opc).val( formatter.format( sueldo ));
    let viaticos   = da_valor( $("#totvia"+opc+"_x") );
    $("#totvia"+opc).val( formatter.format( viaticos ));

    $("#totgarantias_x").val( transporte + sueldo + viaticos);
    $("#totgarantias").val( formatter.format( $("#totgarantias_x").val() ) );
}

function suma_adms(){
    let poliza = da_valor( $("#polizas_x") );
    let costfi = da_valor( $("#cst_fcro_x") );
    let persad = da_valor( $("#comp_cntb_x") );
    let total = ( poliza + costfi + persad );
    $("#totcstadm").val( formatter.format(total) ); 
    res_formateado('idtotadm',total);
    totalesRes();
}

function da_valor(objeto){
    let valor = parseFloat(0);
    if(isNaN($(objeto).val()) || $(objeto).val() == '' ){
        return valor;
    }else{
        return parseFloat( objeto.val() );
    }
}

function trae_param_grales(){
    let destino = "../ctr/ct_gpcst_generales.php";
    let asin = false;
    let datos = {'opcion':0}
    procesa(datos,destino,asin);
}

function readData(data,opcion){
    switch(opcion){
        case 0:
                par_grales = data;
                if(data == null || data == ""){
                    alert("Por favor, refresque la pantalla para que se carguen los parámetros.");
                }else{
                    par_grales.forEach(e => {
                        if(e.subdivide == "N"){
                            $("#id_"+e.id_general).val( e.vr_unit);
                        }
                    })    
                }
                break;
        case 1:
                arr_aislam = data;
                $("#vlrAislam").val( arr_aislam[0].precio_m2 );
                break;
        case 2:  // costos de tubos
                arr_materialTb = data;
                resto = arr_materialTb[0].resto;
                $("#vrmat"+resto ).val( arr_materialTb[0].valor );
                $("#vrmob"+resto ).val( arr_materialTb[1].valor );
                $("#vrpin"+resto ).val( arr_materialTb[2].valor );
                break;
        case 3:   // costos de codos       
                arr_materialTb = data;
                resto = arr_materialTb[0].resto;
                $("#cdmat"+resto ).val( arr_materialTb[0].valor );
                $("#cdmob"+resto ).val( arr_materialTb[1].valor );
                $("#cdpin"+resto ).val( arr_materialTb[2].valor );
                break;
        case 4:   // costos de Tee's
                arr_materialTb = data;
                resto = arr_materialTb[0].resto; 
                $("#temat"+resto ).val( arr_materialTb[0].valor );
                $("#temob"+resto ).val( arr_materialTb[1].valor );
                $("#tepin"+resto ).val( arr_materialTb[2].valor );
                $("#col4"+resto).val( parseFloat( $("#temat"+resto ).val() ) * parseFloat( $("#tee"+resto).val() ) );
                $("#col42"+resto).val( parseFloat( $("#temob"+resto ).val() ) * parseFloat( $("#tee"+resto).val() ) );
                $("#col43"+resto).val( parseFloat( $("#tepin"+resto ).val() ) * parseFloat( $("#tee"+resto).val() ) ); 
                break;
        case 5:   // costos de Uniones
                arr_materialTb = data;
                resto = arr_materialTb[0].resto;
                $("#unmat"+resto ).val( arr_materialTb[0].valor );
                $("#unmob"+resto ).val( arr_materialTb[1].valor );
                $("#unpin"+resto ).val( arr_materialTb[2].valor );
                $("#col5"+resto).val( parseFloat( $("#unmat"+resto ).val() ) * parseFloat( $("#uni"+resto).val() ) );
                $("#col52"+resto).val( parseFloat( $("#unmob"+resto ).val() ) * parseFloat( $("#uni"+resto).val() ) );
                $("#col53"+resto).val( parseFloat( $("#unpin"+resto ).val() ) * parseFloat( $("#uni"+resto).val() ) ); 
                break;
        case 6:   // costos de CAP's
                arr_materialTb = data;
                resto = arr_materialTb[0].resto;
                $("#camat"+resto ).val( arr_materialTb[0].valor );
                $("#camob"+resto ).val( arr_materialTb[1].valor );
                $("#capin"+resto ).val( arr_materialTb[2].valor );
                $("#col6"+resto).val( parseFloat( $("#camat"+resto ).val() ) * parseFloat( $("#cap"+resto).val() ) );
                $("#col62"+resto).val( parseFloat( $("#camob"+resto ).val() ) * parseFloat( $("#cap"+resto).val() ) );
                $("#col63"+resto).val( parseFloat( $("#capin"+resto ).val() ) * parseFloat( $("#cap"+resto).val() ) ); 
                break;
        case 7:     // trae las medidas de Reducción
                if(data != ""){
                    arr_medi = data.dato;
                    resto = data.resto;
                }else{
                    resto = "";
                    arr_medi="";
                }
                cargaMedida(arr_medi,resto);
                break;
        case 8:  // trae lectura del gr_medi_material
                arr_medi_mat = data;
                if(data != ""){
                    resto = arr_medi_mat[0].resto;
                    $("#canrmt"+resto ).val( arr_medi_mat[0].valor );
                    $("#canrmo"+resto ).val( arr_medi_mat[1].valor );
                    $("#canrpi"+resto ).val( arr_medi_mat[2].valor );
                }else{
                    $("#canrmt"+resto ).val(0);
                    $("#canrmo"+resto ).val(0);
                    $("#canrpi"+resto ).val(0);
                }
                sumaCanReduc(resto);
                break;
        case 'lee2': // trae valores de gr_aislam_tb y gr_aislam_reduc
                if(data != ""){
                    console.log("En readData opcion lee2: "+JSON.stringify(data));
                    arr = data.dato;
                    resto = data.resto;
                    $("#vrAis"+resto).val( arr.vr_aislam );
                    $("#vrRed"+resto).val( arr.vr_reduc );
                    sumaCanAislam(resto);
                }else{
                    alert("Sin valores de Aislamiento Tuberia / Aislamiento Reducción");
                }
                break;
        case 'leeinsvalv':
                if(data != ""){
                    arinsvalv = data;
                    $("#vrManInsValv").val( arinsvalv[0].valor );
                    $("#vrPinInsValv").val( arinsvalv[1].valor );
                }
                break;
        case 'leeaisl_tb':
                if(data != ""){
                    ar_aistb = data.dato;
                    $("#vrAisTb").val( ar_aistb[0].valor );
                    let cant = da_valor( $("#cantInsValv_0") );
                    let aisl = da_valor( $("#vrAisTb") );
                    $("#vrAisInsValv_0").val( parseFloat( aisl * cant ));
                    
                }
                break;
        case 'leevr_cable':
                if(data != ""){
                    ar_vrcable = data;
                    switch(ar_vrcable[0].id_tipocable){
                        case '1':
                            $("#vrMatpoteMateri_0").val( ar_vrcable[0].vr_metro);
                            $("#vrMobpoteMateri_0").val( ar_vrcable[0].vr_m_o);
                            break;
                        case '2':
                            $("#vrMatcontMateri_0").val( ar_vrcable[0].vr_metro);
                            $("#vrMobcontMateri_0").val( ar_vrcable[0].vr_m_o);
                            break;
                    }
                }
                break;
        case 'lee_valores':
                if(data != ""){
                    ar = data.dato;
                    $("#elem1_complem1").val( ar[0].valor);
                    $("#elem1_complem2").val( ar[1].valor);
                    $("#elem2_complem1").val( ar[2].valor);
                    $("#elem2_complem2").val( ar[3].valor);
                    $("#elem3_complem1").val( ar[4].valor);
                    $("#elem3_complem2").val( ar[5].valor);
                    $("#elem4_complem1").val( ar[6].valor);
                    $("#elem4_complem2").val( ar[7].valor);
                }
                break;
    
        case 'lee_prycosto':  // lee básico de proyectos
                if(data == ""){
                    alert("No hay datos");
                }else{
                    $("#id_prycosto").val(data.id_prycosto);
                    alert("Actualizado Maestro de Proyectos ");
                }
                break;
        case 'lee_cst_adm':   // lee y/o actualiza costos Admtvos de proyecto
                if(data == ""){
                    alert("No hay datos");
                }else{
                    alert("Actualizado Costos Admtvos ");
                }
                break;
        case 'lee_cst_pers':   // lee y/o actualiza costos de Personal de proyecto
                if(data == ""){
                    alert("No hay datos");
                }else{
                    alert("Actualizado Costos de Personal ");
                    $("#xcostos_pers_alfrio").attr("disabled",false);
                }            
                break;
        case 'save_cst_insequi':  // guarda datos instal. equipos de proyecto
                if(data == ""){
                    alert("No hay datos");
                }else{
                    alert("Actualizado Costo Instal. Equipos ");
                }            
                break;
        case 'lee_cst_insequi':  // lee y carga datos de instal. equipos de proyecto
                if(data == ""){
                    alert("No hay datos");
                }else{
                    console.log("Trayendo Costos Instal. Equipos proy:"+data.id_prycosto);
                    carga_arreglo_equipos( data.datos );
                }            
                break;
        case 'save_cst_tuberia':  // guarda datos de instal. tuberia de proyecto
                if(data == ""){
                    alert("No hay datos");
                }else{
                    alert("Actualiza Costos Instal. Tuberia ");
                }            
                break;
        case 'lee_cst_tuberia':   // lee y carga datos instal. tuberia proyecto
                if(data == ""){
                    alert("No hay datos");
                }else{
                    console.log("Trayendo Costos Instal. Tuberia proy:"+data.id_prycosto);
                    carga_arreglo_tuberia( data.datos, 0 );
                }            
                break;
        case 'save_cst_insvalv':  // guarda datos instal. válvulas de proyecto
                if(data == ""){
                    alert("No hay datos");
                }else{
                    alert("Actualizado Costo Instal. Válvulas ");
                }            
                break;
        case 'lee_cst_insvalv':  // lee y carga datos de instal. valvulas de proyecto
                if(data == ""){
                    alert("No hay datos");
                }else{
                    console.log("Trayendo Costos Instal. Válvulas proy:"+data.id_prycosto);
                    carga_arreglo_valvulas( data.datos );
                }            
                break;
        case 'save_cst_inselec':   // guarda datos instal. electricas de proyecto
            if(data == ""){
                alert("No hay datos");
            }else{
                alert("Actualizado Costo Instal. Eléctrica ");
            }            
            break;
        case 'lee_cst_inselec':  // lee y carga datos de instal. electricas de proyecto
            if(data == ""){
                alert("No hay datos");
            }else{
                carga_arreglo_insElec( data );
            }            
            break;
        case 'save_cst_pruebas':    // guarda costos de pruebas de proyecto
            if(data == ""){
                alert("No hay datos");
            }else{
                alert("Actualizado Costo de Pruebas ");
            }            
            break;
        case 'lee_cst_pruebas':   // lee y carga costos de pruebas de de proyecto
            if(data == ""){
                alert("No hay datos");
            }else{
                carga_arreglo_pruebas( data );
            }            
            break;
        case 'save_cst_varios':    // guarda costos VARIOS de proyecto
            if(data == ""){
                alert("No hay datos");
            }else{
                alert("Actualizado Costo VARIOS ");
            }            
            break;
        case 'lee_cst_varios':   // lee y carga costos VARIOS de proyecto
            if(data == ""){
                alert("No hay datos");
            }else{
                carga_arreglo_varios( data );
            }            
            break;
        case 'leevr_perfil':   // lee valores de perfiles
            if(data == ""){
                alert("No hay datos");
            }else{
                $("#vrMaterial"+data.resto).val(data.dato[0].vr_metro);
                $("#vrMobra"+data.resto).val(data.dato[0].vr_mobra);
                $("#vrPintura"+data.resto).val(data.dato[0].vr_pintura);
            }            
            $("#matSop"+data.resto).focus();
            break;
        case 'save_cst_soporteria':
            if(data == ""){
                alert("No hay datos");
            }else{
                switch(data.resto){
                    case '_0': titmen = "Instal. Equipos";break;
                    case '_1': titmen = "Instal. Tubería";break;
                    case '_2': titmen = "Instal. Eléctricos";break;
                    default: titmen = "";
                }
                alert("Actualizado Costo Soporteria "+titmen);
            }            
            break;
        case 'lee_cst_soporteria':  // lee y carga datos de soporteria de proyecto
            if(data == ""){
                alert("No hay datos");
            }else{
                switch(data.resto){
                    case '_0': carga_arreglo_sopEquipos( data.datos ); break;
                    case '_1': carga_arreglo_sopTuberia( data.datos ); break;
                    case '_2': carga_arreglo_sopElectri( data.datos ); break;
                }
            }            
            break;
        case 'lee_dimensiones':
            if(data == ""){
                alert("No hay datos");
            }else{
                cargaDimensiones(data);
            }
            break;

        default: console.log("por defecto opcion: "+opcion);
            break;
    }
} 

function suma_persalfrio(){
    let manoinge = da_valor( $("#totmanoinge_x") );
    let manotecn = da_valor( $("#totmanotecn_x") );
    let viattecn = da_valor( $("#totviattecn_x") );
    let viatinge = da_valor( $("#totviatinge_x") );
    let garantia = da_valor( $("#totgarantias_x") );
    $("#totcstpers_x").val( manoinge + manotecn + viattecn + viatinge + garantia );
    $("#totcstpers").val( formatter.format($("#totcstpers_x").val()) ); 
    res_formateado("totpersalfrio",$("#totcstpers_x").val());
    totalesRes();
}

function res_formateado(campo,valor){  // estandarizar el formateo de valores en pantalla resumen
    let idcampo = document.getElementById(campo);
    if( idcampo ){
        $("#"+campo+"_x").val( valor );
    }if( campo === "totprecio"){
        //console.log("Precio Venta:"+valor);
    }
    $("#"+campo).val( formatter.format(valor));
    let trm = parseFloat($("#trm_x").val() );
    let dolares = parseFloat( valor / trm );
    $("#us"+campo).val( formatter.format( dolares ) );
    $("#us"+campo+"_y").val( formatter.format( dolares ) );
}

function calc_instEq(idnum){
    let valor = parseFloat( $("#pesoEq_0").val() );
    if( $("#idPesoEq_0").val()=="L"){
        $("#idPesoEq_0").val( "K" );
        valor = parseFloat( valor / 2.2 );
    }
    $("#pesoEq_0").val( valor.toFixed(3) ); 
    let costoInst =  valor * parseFloat( $("#id_0301").val() );
    $("#cstInstEq_0").val( costoInst.toFixed(2) );
}

function carga_arg(){
    ultimo = arg_InsEq.length;
    arg_InsEq[ultimo] = [];
    arg_InsEq[ultimo]["nomEquipo"] = $("#nomEquipo_0").val();
    arg_InsEq[ultimo]["pesoEq"] = parseFloat( $("#pesoEq_0").val() );
    arg_InsEq[ultimo]["cstInstEq"] = parseFloat( $("#cstInstEq_0").val() ); 
    arg_InsEq[ultimo]["largo"] = parseFloat( $("#largoEq_0").val() );
    arg_InsEq[ultimo]["ancho"] = parseFloat( $("#anchoEq_0").val() );
    arg_InsEq[ultimo]["alto"]  = parseFloat( $("#altoEq_0").val() );
    arg_InsEq[ultimo]["espesor"] = $("#aislEq_0 option:selected").text();
    arg_InsEq[ultimo]["cstAislEq"] = parseFloat( $("#cstAislEq_0").val() ); 
    arg_InsEq[ultimo]["precio_m2"] = parseFloat( $("#vlrAislam").val() );
    suma_instEq();
    suma_aislamEq();
    suma_tot_eq();
}

function suma_instEq(){
    let suma_inst_equipos = 0;
    let costo = 0.0;
    if( arg_InsEq.length > 0 ){
        for(let x=0; x<arg_InsEq.length;x++){
            suma_inst_equipos += parseFloat( arg_InsEq[x]["cstInstEq"] );
        }
    } 
    $("#totCostInstal_x").val( parseFloat( suma_inst_equipos ).toFixed(2) );
    $("#totCostInstal").val( formatter.format( suma_inst_equipos ) );
}

function suma_tot_eq(){
    let costoInstal = da_valor( $("#totCostInstal_x") );
    let costoAislam = da_valor( $("#totCostAislam_x") );
    let costoSopEqu = da_valor( $("#totCostSoport_x") );
    let total = ( costoInstal + costoAislam + costoSopEqu );
    $("#totCostEquipos_x").val( total.toFixed(2) );
    $("#totCostEquipos").val( formatter.format(total) );
    res_formateado("totinsequipos",total);
    pinta_arg();
    totalesRes();
}

function pinta_arg(){
    let divTablaReg = $("#cuerpoEntrada");
    divTablaReg.empty();
    let tabla = "";
    for(let x = 0; x<arg_InsEq.length;x++){
        tabla += "<tr style='text-align:right'>";
        tabla += "<td align='left' class='xl102'>"+arg_InsEq[x]["nomEquipo"]+"</td>";
        tabla += "<td class='xl102'>"+arg_InsEq[x]["pesoEq"]+"</td>";
        tabla += "<td class='xl102'>"+arg_InsEq[x]["largo"]+"</td>";
        tabla += "<td class='xl102'>"+arg_InsEq[x]["ancho"]+"</td>";
        tabla += "<td class='xl102'>"+arg_InsEq[x]["alto"]+"</td>";
        tabla += "<td class='xl102'>"+arg_InsEq[x]["espesor"]+"</td>";
        tabla += "<td class='xl102'>"+arg_InsEq[x]["cstInstEq"]+"</td>";
        tabla += "<td class='xl102'>"+arg_InsEq[x]["cstAislEq"]+"</td>";
        tabla += "<td><button onclick='borra("+x+")' title='Indice a Borrar'>x</button></td>";
        tabla += "<td class='xl102' style='display:none;'>"+arg_InsEq[x]["precio_m2"]+"</td>";
        tabla += "</tr>";
    }
    
    divTablaReg.append(tabla);
    let ultimo = parseInt( $("#id_contador").val() );
    $("#id_contador").val( ultimo + 1);
    limpiaEntrada();
}

function borra(x){
    arg_InsEq.splice(x,1);
    let ultimo = parseInt( $("#id_contador").val() );
    $("#id_contador").val( parseInt( ultimo - 1 ) );
    arl_InsEq = arg_InsEq.slice();
    arg_InsEq.splice(0,arg_InsEq.length);
    let nume = 0;
    for(let x=0; x < arl_InsEq.length; x++){
        arg_InsEq[nume] = [];
        arg_InsEq[nume] = arl_InsEq[x];
        nume++;
    }
    suma_instEq()
    suma_aislamEq();
    suma_tot_eq();
}

function limpiaEntrada(){
    $("#nomEquipo_0").val("");
    $("#idPesoEq").val("L");
    $("#pesoEq_0").val("");
    $("#idMediEq").val("P");   
    $("#largoEq_0").val("");
    $("#anchoEq_0").val("");
    $("#altoEq_0").val("");
    $("#aislEq_0").val("");
    $("#cstInstEq_0").val("");
    $("#cstAislEq_0").val("");
}

function cambia(campo){
    let elem = 0;
    let idcampo = $("#"+campo).attr("id");
    let nomCampo = separa(idcampo,"_",0);
    resto = separa(campo,nomCampo,1);
    console.log(" en cambia, campo: "+nomCampo+" resto: "+resto);
    let vlrCampo = $("#"+campo+" option:selected").text();
    let tipoCampo = "text";
    if( vlrCampo == ""){
        vlrCampo = $("#"+campo).val();
        tipoCampo="val";
    }
    
    let opc = '0';
    switch(nomCampo){
        case 'aislEq': 
                    opc=1;
                    idespesor = $("#"+campo).val();
                    eva_linea_aislEq(idespesor,vlrCampo,opc);            
                    break;
        case 'diam'  : opc = 2;elem = 1;
                    if( $("#idmat"+resto).val() == ""){
                        alert("Por favor, seleccione Tipo de Tubo");
                        $("#diam"+resto).val("");
                        $("#idmat"+resto).focus();
                    }else{
                        trae_cstMatTb(campo,nomCampo,resto,opc,elem); // vlrCampo,  iddiametro,
                        trae_medidas(campo,7,vlrCampo); // opcion=7, reenvia valor del campo
                    }
                    break;
        case 'long' : 
                    if( $("#long"+resto).val() == ""){
                        alert("Por favor, digite el diámetro");
                        $("#long"+resto).val("");
                        $("#diam"+resto).focus();
                    }
                    break;
        case 'esAi'  : 
                    if( $("#long"+resto).val() == ""){
                        alert("Por favor, digite la longitud");
                        $("#esAi"+resto).val("");
                        $("#long"+resto).focus();
                    }else{
                        opc = 3;elem = 2;
                        trae_cstMatTb(campo,nomCampo,resto,opc,elem);  // vlrCampo,  iddiametro,
                    }
                    break;
        case 'tee'   : opc = 4;elem = 3;
                    trae_cstMatTb(campo,nomCampo,resto,opc,elem);  // vlrCampo,  iddiametro,
                    break;
        case 'uni'   : opc = 5;elem = 4;
                    trae_cstMatTb(campo,nomCampo,resto,opc,elem);  // vlrCampo,  iddiametro,
                    break;
        case 'cap'   : opc = 6;elem = 5;
                    trae_cstMatTb(campo,nomCampo,resto,opc,elem);   //  vlrCampo, iddiametro,
                    break;
        case 'diamInsValv': 
                    if( $("#valvInsValv"+resto).val() == ""){
                        alert("Por favor, digite el campo Válvula");
                        $("#diamInsValv"+resto).val("");
                        $("#valvInsValv"+resto).focus();
                    } else{
                        opc = 'leeinsvalv';complem = '2_3';
                        trae_insValv(campo,resto,opc,complem);
                    }
                    break;
        case 'esAiInsValv': 
                    if( $("#cantInsValv_0").val() == ""){
                        alert("Por favor, digite la cantidad");
                        $("#esAiInsValv_0").val("");
                        $("#cantInsValv_0").focus();
                    }else{
                        opc = 'leeaisl_tb';
                        trae_aisl_valv(campo,resto,opc); 
                    }    
                    break;
        case 'poteCalibr': opc = 'leevr_cable';tipocable='1';
                    if($("#equi_electr_0").val() == "" || $("#equi_electr_0").val() == null){
                        alert("Por favor, digite el equipo !");
                        $("#poteCalibr_0").val("");
                        $("#equi_electr_0").focus();
                    } else{
                        trae_vrcable(campo,tipocable,opc);
                    }
                    break;
        case 'contCalibr': opc = 'leevr_cable';tipocable='2';
                    trae_vrcable(campo,tipocable,opc);
                    break;
        case 'iddimension': 
                    complem='1_2'; elemen='1_2_3_4';
                    trae_valores(campo,complem,elemen,$("#opc_dimen").val());
                    break;
        case 'perfil': opc = "leevr_perfil";
                    $("#vrMaterial"+resto).val("");
                    $("#vrMobra"+resto).val("");
                    $("#vrPintura"+resto).val("")
                    trae_vrperfil(campo,opc,vlrCampo,tipoCampo,resto);
                    break;
        case 'idmat':
                    if( $("#linea"+resto).val() == "" ){
                        alert("Por favor, digite el campo Línea");
                        $("#idmat"+resto).val('');
                        $("#linea"+resto).focus();
                    }
                    break;
        case 'idtuberia':
                    let eleccion = $("#idtuberia"+resto+" option:selected").text();
                    eleccion = eleccion.toLowerCase();
                    let ar_elec = eleccion.split(" ");
                    eleccion = ar_elec[0];
                    opc = $("#opc_dimen").val(); 
                    if( eleccion !== opc ) {
                        $("#opc_dimen").val(eleccion);
                        llamaOpcionesDimension('iddimension',eleccion,resto);
                    }    
                    break;    
        default: console.log(" En cambia, nomCampo NO IDENTIFICADO");
                    break;
    }
}

function eva_linea_aislEq(idespesor,vlrCampo,opc){
    let largo = da_valor($("#largoEq_0"));
    let ancho = da_valor($("#anchoEq_0"));
    let alto  = da_valor($("#altoEq_0")); 

    if( $("#idMediEq_0").val()=="P"){
        $("#idMediEq_0").val( "M" );
        largo = parseFloat( largo * 0.0254 );
        ancho = parseFloat( ancho * 0.0254 );
        alto  = parseFloat( alto  * 0.0254 );
    }
    $("#largoEq_0").val(largo.toFixed(4));
    $("#anchoEq_0").val(ancho.toFixed(4));
    $("#altoEq_0").val(alto.toFixed(4));
    
    // traer el dato de tabla.
    let destino = "../ctr/ct_graislam_eq.php";
    let asin = false;  // Viene opcion = 1
    let datos = {'opcion':opc,'idespesor':idespesor}
    procesa(datos,destino,asin);

    let pi = parseFloat( $("#vr_pi").val() );
    let vlr_aislam = parseFloat( $("#vlrAislam").val() );
    
    let vr_totAislam = ( ancho * alto * pi * 2 * largo * vlr_aislam );
    $("#cstAislEq_0").val( vr_totAislam.toFixed(2) );      
}

function suma_aislamEq(){
    let suma_aislam_eq = 0.0;
    if(arg_InsEq.length>0){
        for(let x=0; x<arg_InsEq.length;x++){
            suma_aislam_eq = parseFloat(suma_aislam_eq ) + parseFloat( arg_InsEq[x]["cstAislEq"] ) ;
        }   
    }
    $("#totCostAislam_x").val(  suma_aislam_eq.toFixed(2) ); 
    $("#totCostAislam").val(  formatter.format(suma_aislam_eq ) ); 
}

function longTb(objLong){   // logitud de tuberia
    let campo = $(objLong).attr("id");
    nomLong = separa(campo,"_",0);
    resto = separa(campo,nomLong,1);
    if( $("#vrmat"+resto).val() == "" || $("#vrmob"+resto).val() == "" || $("#vrpin"+resto).val() == "" ){
        alert("Debe Seleccionar el Tipo de Tubo y el Diámetro ");
        $("#diam"+resto).focus();
    }else{
        $("#col7"+resto).val( parseFloat( $("#vrmat"+resto).val()) * parseFloat( $(objLong).val() ) );
        $("#col2"+resto).val( parseFloat( $("#vrmob"+resto).val()) * parseFloat( $(objLong).val() ) );
        $("#col22"+resto).val( parseFloat( $("#vrpin"+resto).val()) * parseFloat( $(objLong).val() ) );    
    }
}

function trae_cstMatTb(campo,nomCampo,resto,opc,elem){   // vlrCampo, iddiametro,
    if( $("#"+campo+" option:selected").text() == "Sin elegir"){
        alert("Por favor, elija un Diámetro ");
        $("#"+campo).focus();
    }else{
        nomDiam = $("#"+campo).attr("id");
        resto = separa(nomDiam,nomCampo,1);
        tipoTubo = $("#idmat"+resto+" option:selected").text();
        idmaterial = $("#idmat"+resto).val();
        iddiametro= $("#diam"+resto).val();
        if(idmaterial == ""){
            alert("Debe seleccionar el Tipo de Tubo");
            $("#diam"+resto).val("");
            $("#idmat"+resto).focus();
        }else{
            let destino = "../ctr/ct_grcost_elem.php";
            let asin = false;
            let datos = {'opcion':opc,'material':idmaterial,'diametro':iddiametro,'elemento':elem,'comple':'1_2_3','resto':resto}
            procesa(datos,destino,asin);
        }
    }
}

function vrCodo(objCodo){  // logitud de codos
    let campo = $(objCodo).attr("id");
    nomLong = separa(campo,"_",0);
    resto = separa(campo,nomLong,1);
    if( $("#cdmat"+resto).val() == "" || $("#cdmob"+resto).val() == "" || $("#cdpin"+resto).val() == "" ){
        alert("Debe Seleccionar el Tipo de Tubo y el Diámetro ");
        $("#esAi"+resto).focus();
    }else{
        $("#col8"+resto).val( parseFloat( $("#cdmat"+resto).val()) * parseFloat( $(objCodo).val() ) );
        $("#col3"+resto).val( parseFloat( $("#cdmob"+resto).val()) * parseFloat( $(objCodo).val() ) );
        $("#col33"+resto).val( parseFloat( $("#cdpin"+resto).val()) * parseFloat( $(objCodo).val() ) );    
    }
}

function cargaMedida(arr_medi,resto){
    let objMedida = $("#medi"+resto);
    objMedida.empty();
    let opcion = "";
    opcion = $('<option>',{
        text : "Sin elegir",
        value:  "",
    })
    objMedida.append(opcion);

    if(arr_medi != ""){
        for(let x=0;x<arr_medi.length;x++){
            opcion = $('<option>',{
                text : arr_medi[x].pulg_medi,
                value:  ( x + 1 ),
            })
            objMedida.append(opcion);
        }
    } 
}

function trae_medidas(campo,opc,iddiametro){
    // funcion 2 de diametro debe venir opc: 7
    if( $("#"+campo+" option:selected").text() == "Sin elegir"){
        alert("Por favor, elija un Diámetro ");
        $("#"+campo).focus();
    }else{
        let idcampo = $("#"+campo).attr("id");       
        let nomCampo = separa(idcampo,"_",0);
        resto = separa(idcampo,nomCampo,1);
        diametro= $("#diam"+resto).val();
        if( diametro == "" ){
            alert("Debe seleccionar el Diámetro");
            $("#diam"+resto).focus();
        }else{
            carga_medidas(opc,iddiametro,resto);
        }
    }
}

function carga_medidas(opc,iddiametro,resto){
    let destino = "../ctr/ct_gpmedi_mercado.php";
    let asin = false;
    let datos = {'opcion':opc,'diametro':iddiametro,'resto':resto}
    procesa(datos,destino,asin);
}

function canReduc(objCanR){ // captura Cantidad Reducción
    /* Llama costo de gr_medi_material con tipo tubo y medida, 
    en readData sube valores a campos canr__ */
    let campo = $(objCanR).attr("id");
    nomCampo = separa(campo,"_",0);
    resto = separa(campo,nomCampo,1);
    vlrCampo = $(objCanR).val();
    tipoTubo = $("#idmat"+resto+" option:selected").text(); // sale "Acero Carbono"
    idmaterial = $("#idmat"+resto).val();  // Sale "1"
    medida = $("#medi"+resto+" option:selected").text();
    if(medida == "0" || medida == "" ){ medida = '4x2';}
    let opc = 8;  // Cantidad Reducción
    let destino = "../ctr/ct_grmedi_material.php";
    let asin = false;
    let datos = {'opcion':opc,'material':idmaterial,'medida':medida,'resto':resto}
    procesa(datos,destino,asin);
}

function sumaCanReduc(resto){
    /* multiplica costo por cantidad y le suma los valores de materiales de columnas 4,5,6,7 y 8 */
    let total1 = ( da_valor( $("#canrmt"+resto ) ) * da_valor($("#canr"+resto )));
    let total2 = ( da_valor( $("#canrmo"+resto ) ) * da_valor($("#canr"+resto )));
    let total3 = ( da_valor( $("#canrpi"+resto ) ) * da_valor($("#canr"+resto )));
    let col4 = da_valor( $("#col4"+resto) );
    let col5 = da_valor( $("#col5"+resto) );
    let col6 = da_valor( $("#col6"+resto) );
    let col7 = da_valor( $("#col7"+resto) );
    let col8 = da_valor( $("#col8"+resto) );
    
    let col2  = da_valor( $("#col2"+resto) );
    let col3  = da_valor( $("#col3"+resto) );
    let col42 = da_valor( $("#col42"+resto) );
    let col52 = da_valor( $("#col52"+resto) );
    let col62 = da_valor( $("#col62"+resto) );

    let col22 = da_valor( $("#col22"+resto) );
    let col33 = da_valor( $("#col33"+resto) );
    let col43 = da_valor( $("#col43"+resto) );
    let col53 = da_valor( $("#col53"+resto) );
    let col63 = da_valor( $("#col63"+resto) );

    $("#matCst"+resto).val( parseFloat( total1 + col4 + col5 + col6 + col7 + col8 ).toFixed(2) );
    $("#mobCst"+resto).val( parseFloat( total2 + col2 + col3 + col42+ col52+ col62).toFixed(2) ) ;
    $("#pinCst"+resto).val( parseFloat( total3 + col22+ col33+ col43+ col53+ col63).toFixed(2) );
    canAislam(resto);
}

function canAislam(resto){
    diametro = $("#diam"+resto).val();  // select, trae el id_diametro
    aislam =   $("#esAi"+resto).val();  // select, trae el id_aislam 
    medida =   $("#medi"+resto+" option:selected").text();  // select armado, trae el pulg_medida, ej: '4x3'
    if(medida == "0" || medida == "" ){ medida = '4x2';}
    let opc = 'lee2';  // Cantidad para aislamiento y reducción
    let destino = "../ctr/ct_graislam_tb.php";
    let asin = false;
    let datos = {'opcion':opc,'diametro':diametro,'medida':medida,'aislam':aislam,'resto':resto}
    procesa(datos,destino,asin); 
}

function sumaCanAislam(resto){ // calcula valor de aislamiento segun diametro,aislamiento, medida
    let vlrn = ( da_valor($("#vrRed"+resto)) * da_valor($("#canr"+resto)) );
    let long = da_valor( $("#long"+resto) );
    let codo = da_valor( $("#codo"+resto) );
    let tee  = da_valor( $("#tee"+resto) );
    let union= da_valor( $("#uni"+resto) );
    let cap  = da_valor( $("#cap"+resto) );
    let suma = parseFloat( long + codo + tee + union + cap );
    let vlr1 = ( da_valor( $("#vrAis"+resto) ) * suma );
    let total = ( vlr1 + vlrn );
    $("#aisCst"+resto).val( total.toFixed(2) );

}    

function totalesInstTuberia(){
    let resto = "suc_des";  
    let smCstMat = 0; smCstMob = 0; smCstPin = 0; smCstAis = 0; smCstSopTuberia = 0;
    for(x=0;x<arg_insTub.length;x++){
        smCstMat += parseFloat( arg_insTub[x]['cst_material'] );              
        smCstMob += parseFloat( arg_insTub[x]['cst_mobra'] );         
        smCstPin += parseFloat( arg_insTub[x]['cst_pintura'] );       
        smCstAis += parseFloat( arg_insTub[x]['cst_aislam'] );         
    }
    $("#sumaCstMat").val( smCstMat );
    $("#sumaCstMob").val( smCstMob );
    $("#sumaCstPin").val( smCstPin );
    $("#sumaCstAis").val( smCstAis );

    $("#gtMatInstTuberia_x").val( smCstMat.toFixed(2) );
    $("#gtMatInstTuberia").val( formatter.format( smCstMat ) );
    $("#gtMobInstTuberia_x").val( smCstMob.toFixed(2) );
    $("#gtMobInstTuberia").val( formatter.format( smCstMob ) );
    $("#gtPinInstTuberia_x").val( smCstPin.toFixed(2) );
    $("#gtPinInstTuberia").val( formatter.format( smCstPin ) );
    $("#gtAisInstTuberia_x").val( smCstAis.toFixed(2) );
    $("#gtAisInstTuberia").val( formatter.format( smCstAis ) );

    smCstSopTuberia = da_valor( $("#gtSopInstTuberia_x") );
    console.log("En totalesInstTuberia viene SopTuberia: "+smCstSopTuberia);
    let gtCstInstTuberia = parseFloat( smCstMat + smCstMob + smCstPin + smCstAis + smCstSopTuberia );
    $("#gtCstInstTuberia").val( formatter.format( gtCstInstTuberia.toFixed(2) ) );
    $("#gtCstInstTuberia_x").val( gtCstInstTuberia.toFixed(2) );
    res_formateado("totinstb",gtCstInstTuberia);
    totalesRes();
}

function add_arr_tuberia(){
    let resto = "_suc_des";
    const arr_tuberia = [];
    let ult = arr_tuberia.length;
    arr_tuberia[ult] = [];

    arr_tuberia[ult] = {
        'linea':        $("#linea"+resto).val(),
        'tipotubo':     $("#idmat"+resto+" option:selected").text(),
        'diametro':     $("#diam"+resto+" option:selected").text(),
        'longitud':     $("#long"+resto).val(),
        'aislam':       $("#esAi"+resto+" option:selected").text(),
        'codo':         $("#codo"+resto).val(),
        'tee':          $("#tee"+resto).val(),
        'uniones':      $("#uni"+resto).val(),
        'cap':          $("#cap"+resto).val(),
        'medi_reduc':   $("#medi"+resto+" option:selected").text(),
        'cant':         $("#canr"+resto).val(),
        'cst_material': $("#matCst"+resto).val(), 
        'cst_mobra':    $("#mobCst"+resto).val(),
        'cst_pintura':  $("#pinCst"+resto).val(),
        'cst_aislam':   $("#aisCst"+resto).val()
    }
    carga_arreglo_tuberia(arr_tuberia, 1);
    limpia_insTuberia(resto);
}

function limpia_insTuberia(resto){
    $("#linea"+resto).val("");
    $("#idmat"+resto).val("");
    $("#diam"+resto).val("");
    $("#long"+resto).val("");
    $("#esAi"+resto).val("");
    $("#codo"+resto).val("");
    $("#tee"+resto).val("");
    $("#uni"+resto).val("");
    $("#cap"+resto).val("");
    $("#medi"+resto).val("");
    $("#canr"+resto).val("");
    $("#matCst"+resto).val("");
    $("#mobCst"+resto).val("");
    $("#pinCst"+resto).val("");
    $("#aisCst"+resto).val("");
}

function trae_insValv(campo,resto,opc,complem){
    // Viene opc = 'leeinsvalv'
    let id_diametro = $("#"+campo).val(); // Viene campo diamInsValv  
    let destino = '../ctr/ct_grinst_valvulas.php';
    let asin = false;
    let datos = {'opcion':opc,'diametro':id_diametro,'complem':complem}
    procesa(datos,destino,asin);   
}

function trae_aisl_valv(campo,resto,opc){
    let id_aislam = $("#"+campo).val(); // Viene campo esAiInsValv  
    let id_diam   = $("#diamInsValv_0").val();
    let destino = '../ctr/ct_graislam_tb.php';
    let asin = false;
    let datos = {'opcion':opc,'aislam':id_aislam,'diametro':id_diam}
    procesa(datos,destino,asin);   
}

function canInsValv(objCan){
    if( $("#diamInsValv_0").val() == ""){
        alert("Por favor, seleccione el diámetro");
        $(objCan).val("");
        $("#diamInsValv_0").focus();
    }else{
        let vrManInsValv = parseFloat( $("#vrManInsValv").val());
        let vrPinInsValv = parseFloat( $("#vrPinInsValv").val());
        if( isNaN(vrManInsValv) || isNaN(vrPinInsValv)){
            alert("No hay Valores de Mano de Obra y Pintura en Instalación Válvulas !");
        }else{
            let cant = $(objCan).val();
            $("#vrManInsValv_0").val( parseFloat( vrManInsValv * cant ));
            $("#vrPinInsValv_0").val( parseFloat( vrPinInsValv * cant ));
        }    
    }
}

function carga_insValv(){
    ult = arg_InsValv.length;
    arg_InsValv[ult] = [];
    arg_InsValv[ult]["valvInsValv"] = $("#valvInsValv_0").val();
    arg_InsValv[ult]["diamInsValv"] = parseFloat( $("#diamInsValv_0").val() );
    arg_InsValv[ult]["cantInsValv"] = parseFloat( $("#cantInsValv_0").val() ); 
    arg_InsValv[ult]["esAiInsValv"] = parseFloat( $("#esAiInsValv_0").val() );
    arg_InsValv[ult]["vrManInsValv"] = parseFloat( $("#vrManInsValv_0").val() ).toFixed(2);
    arg_InsValv[ult]["vrPinInsValv"] = parseFloat( $("#vrPinInsValv_0").val() ).toFixed(2);
    arg_InsValv[ult]["vrAisInsValv"] = parseFloat( $("#vrAisInsValv_0").val() ).toFixed(2);
    suma_insValv();
}

function suma_insValv(){
    let totMan = 0, totPin = 0, totAis = 0,totInsValv = 0;
    for(let x=0; x < arg_InsValv.length;x++){
        totMan += parseFloat( arg_InsValv[x]['vrManInsValv'] );
        totPin += parseFloat( arg_InsValv[x]['vrPinInsValv'] );
        totAis += parseFloat( arg_InsValv[x]['vrAisInsValv'] );
    }
    totInsValv = parseFloat( totMan + totPin + totAis );
    $("#totCstManValv_x").val( totMan.toFixed(2));
    $("#totCstManValv").val( formatter.format( totMan.toFixed(2)));
    $("#totCstPinValv_x").val( totPin.toFixed(2));
    $("#totCstPinValv").val( formatter.format(totPin.toFixed(2)));
    $("#totCstAisValv_x").val( totAis.toFixed(2));
    $("#totCstAisValv").val( formatter.format(totAis.toFixed(2)));
    $("#gtTotCstInstValv_x").val( totInsValv.toFixed(2));
    $("#gtTotCstInstValv").val( formatter.format(totInsValv.toFixed(2)));
    res_formateado("totinsvalv",totInsValv);
    pinta_Insvalv();
    totalesRes();
}

function pinta_Insvalv(){
    let divTablaValv = $("#bodyInsValv");
    divTablaValv.empty();
    let tabla = "";
    for(let x = 0; x<arg_InsValv.length;x++){
        tabla += "<tr style='text-align:right'>";
        tabla += "<td align='left' class='xl102'>"+arg_InsValv[x]["valvInsValv"]+"</td>";
        tabla += "<td class='xl102'>"+arg_InsValv[x]["diamInsValv"]+"</td>";
        tabla += "<td class='xl102'>"+arg_InsValv[x]["cantInsValv"]+"</td>";
        tabla += "<td class='xl102'>"+arg_InsValv[x]["esAiInsValv"]+"</td>";
        tabla += "<td class='xl102'>"+arg_InsValv[x]["vrManInsValv"]+"</td>";
        tabla += "<td class='xl102'>"+arg_InsValv[x]["vrPinInsValv"]+"</td>";
        tabla += "<td class='xl102'>"+arg_InsValv[x]["vrAisInsValv"]+"</td>";
        tabla += "<td><button onclick='borraInsValv("+x+")' title='Indice a Borrar'>x</button></td>";
        tabla += "</tr>";
    }    
    divTablaValv.append(tabla);
    limpiaInsValv();
}

function limpiaInsValv(){
    $("#valvInsValv_0").val("");
    $("#diamInsValv_0").val("");
    $("#cantInsValv_0").val("");
    $("#esAiInsValv_0").val("");
    $("#vrManInsValv_0").val("");
    $("#vrPinInsValv_0").val("");
    $("#vrAisInsValv_0").val("");
}

function borraInsValv(x){
    arg_InsValv.splice(x,1);
    arl_InsValv = arg_InsValv.slice();
    arg_InsValv.splice(0,arg_InsValv.length);
    let nume = 0;
    for(let x=0; x < arl_InsValv.length; x++){
        arg_InsValv[nume] = [];
        arg_InsValv[nume] = arl_InsValv[x];
        nume++;
    }
    suma_insValv()
}

function trae_vrcable(campo,tipocable,opc){
    let id_cable = $("#"+campo).val(); // Viene campo poteCalibr_0 / contCalibr_0  
    // viene opc: leevr_cable
    let destino = '../ctr/ct_grcst_cables.php';
    let asin = false;
    let datos = {'opcion':opc,'tipocable':tipocable,'id_cable':id_cable}
    procesa(datos,destino,asin);   
}

function cant_electr(obj){ // cantidad de material electrico para instal. electricas.
    let cantEletr = $(obj).val();
    $("#mateCstEle_0").val( da_valor($("#mateCstEle_0")) + ( da_valor($("#vrMatpoteMateri_0")) * cantEletr ) );
    $("#mobrCstEle_0").val( da_valor($("#mobrCstEle_0")) + ( da_valor($("#vrMobpoteMateri_0")) * cantEletr ) );
}

function cant_datos(obj){ // cantidad de material datos para instal. electricas.
    let cantDatos = $(obj).val();
    $("#mateCstEle_0").val( da_valor($("#mateCstEle_0")) + ( da_valor($("#vrMatcontMateri_0")) * cantDatos ));
    $("#mobrCstEle_0").val( da_valor($("#mobrCstEle_0")) + ( da_valor($("#vrMobcontMateri_0")) * cantDatos ));
}

function guarda_eqElect(){
    ult = arg_eqElec.length;
    arg_eqElec[ult] = [];
    arg_eqElec[ult]["equi_electr_0"] = $("#equi_electr_0").val();
    arg_eqElec[ult]["poteCalibr_0"] = $("#poteCalibr_0 option:selected").text();
    arg_eqElec[ult]["poteCalibr"] = $("#poteCalibr_0").val();
    arg_eqElec[ult]["contCalibr_0"] = $("#contCalibr_0 option:selected").text(); 
    arg_eqElec[ult]["contCalibr"] = $("#contCalibr_0").val(); 
    arg_eqElec[ult]["poteMateri_0"] = da_valor( $("#poteMateri_0") );
    arg_eqElec[ult]["contMateri_0"] = da_valor( $("#contMateri_0") );
    arg_eqElec[ult]["mateCstEle_0"] = da_valor( $("#mateCstEle_0") ).toFixed(2);
    arg_eqElec[ult]["mobrCstEle_0"] = da_valor( $("#mobrCstEle_0") ).toFixed(2);
    pinta_eqElec();
    suma_InsElectr();
}

function guarda_tbElect(){
    ult = arg_tbElec.length;
    arg_tbElec[ult] = [];
    arg_tbElec[ult]['idtuberia_0']    = $("#idtuberia_0 option:selected").text() ;
    arg_tbElec[ult]['idtuberia']    = $("#idtuberia_0").val() ;
    arg_tbElec[ult]['iddimension_0']  = $("#iddimension_0 option:selected").text();
    arg_tbElec[ult]['canMtr_Tubos_0'] = da_valor( $("#canMtr_Tubos_0") );
    arg_tbElec[ult]['canCur_Tubos_0'] = da_valor( $("#canCur_Tubos_0") );
    arg_tbElec[ult]['canTee_Tubos_0'] = da_valor( $("#canTee_Tubos_0") );
    arg_tbElec[ult]['canUni_Tubos_0'] = da_valor( $("#canUni_Tubos_0") );
    arg_tbElec[ult]['cstMtrTubos_0'] = da_valor( $("#cstMtrTubos_0") ).toFixed(2);
    arg_tbElec[ult]['cstMobTubos_0'] = da_valor( $("#cstMobTubos_0") ).toFixed(2);
    pinta_tbElec();
    suma_InsElectr();
}

function suma_InsElectr(){
    let totMatrCab = 0, totMobCab = 0, totMatrBan = 0,totMobBan = 0,totSoporBan=0;
    for(let x=0; x < arg_eqElec.length;x++){
        totMatrCab += parseFloat( arg_eqElec[x]['mateCstEle_0'] );
        totMobCab  += parseFloat( arg_eqElec[x]['mobrCstEle_0'] );
    }

    for(let x=0; x < arg_tbElec.length;x++){
        totMatrBan += parseFloat( arg_tbElec[x]['cstMtrTubos_0'] );
        totMobBan  += parseFloat( arg_tbElec[x]['cstMobTubos_0'] );
    }

    for(let x=0; x < arg_sopInsElec.length; x++ ){
        totSoporBan += parseFloat( arg_sopInsElec[x]['cstMaterial_2'] );
        totSoporBan += parseFloat( arg_sopInsElec[x]['cstMobra_2'] );
        totSoporBan += parseFloat( arg_sopInsElec[x]['cstPintura_2'] );
    }
    totInsElectr = parseFloat( totMatrCab + totMobCab + totMatrBan + totMobBan + totSoporBan );
    $("#totCstMtrCables_x").val( totMatrCab.toFixed(2));
    $("#totCstMtrCables").val( formatter.format( totMatrCab.toFixed(2)) );
    $("#totCstMobCables_x").val( totMobCab.toFixed(2));
    $("#totCstMobCables").val( formatter.format( totMobCab.toFixed(2)) );
    $("#totCstMtrBandej_x").val( totMatrBan.toFixed(2));
    $("#totCstMtrBandej").val( formatter.format( totMatrBan.toFixed(2)) );
    $("#totCstMobBandej_x").val( totMobBan.toFixed(2));
    $("#totCstMobBandej").val( formatter.format( totMobBan.toFixed(2)) );
    $("#totCstSopBandej_x").val( totSoporBan.toFixed(2));
    $("#totCstSopBandej").val( formatter.format( totSoporBan.toFixed(2)) );
    $("#totCstInsElectr_x").val( totInsElectr.toFixed(2));
    $("#totCstInsElectr").val( formatter.format( totInsElectr.toFixed(2)) );
    res_formateado("totinselec",totInsElectr);
    totalesRes();
}

function limpia_equipos(){

}

function limpiaEqElect(){
    $("#equi_electr_0").val("");
    $("#poteCalibr_0").val("");
    $("#contCalibr_0").val("");
    $("#poteMateri_0").val("");
    $("#contMateri_0").val("");
    $("#mateCstEle_0").val("");
    $("#mobrCstEle_0").val("");
}

function limpiaTbElect(){
    $("#idtuberia_0").val("");
    $("#iddimension_0").val("");
    $("#canMtr_Tubos_0").val("");
    $("#canCur_Tubos_0").val("");
    $("#canTee_Tubos_0").val("");
    $("#canUni_Tubos_0").val("");
    $("#cstMtrTubos_0").val("");
    $("#cstMobTubos_0").val("");
}

function pinta_eqElec(){
    let divTabla = $("#body_reg_equipos_eletricos");
    divTabla.empty();
    let tabla = "";
    for(let x = 0; x<arg_eqElec.length;x++){
        tabla += "<tr>";
        tabla += "<td class='xl102'>"+arg_eqElec[x]["equi_electr_0"]+"</td>";
        tabla += "<td class='xl102'>"+arg_eqElec[x]["poteCalibr_0"]+"</td>";
        tabla += "<td class='xl102'>"+arg_eqElec[x]["contCalibr_0"]+"</td>";
        tabla += "<td class='xl102 valor'>"+arg_eqElec[x]["poteMateri_0"]+"&nbsp;</td>";
        tabla += "<td class='xl102 valor'>"+arg_eqElec[x]["contMateri_0"]+"&nbsp;</td>";
        tabla += "<td class='xl102 valor'>"+arg_eqElec[x]["mateCstEle_0"]+"</td>";
        tabla += "<td class='xl102 valor'>"+arg_eqElec[x]["mobrCstEle_0"]+"</td>";
        tabla += "<td><button onclick='borraEqElec("+x+")' title='Indice a Borrar'>x</button></td>";
        tabla += "</tr>";
    }    
    divTabla.append(tabla);
    limpiaEqElect();
}

function borraEqElec(x){
    arg_eqElec.splice(x,1);
    arl_eqElec = arg_eqElec.slice();
    arg_eqElec.splice(0,arg_eqElec.length);
    let nume = 0;
    for(let x=0; x < arl_eqElec.length; x++){
        arg_eqElec[nume] = [];
        arg_eqElec[nume] = arl_eqElec[x];
        nume++;
    }
    pinta_eqElec();
    suma_InsElectr();
}

function trae_valores(campo,complem,elemen,opc){
    let id_dimen = $("#"+campo).val(); // Viene campo iddimension_0 y opcion: leevr_conduleta
    let id_condu = $("#idtuberia_0").val();
    if( opc == "bandeja"){
        destino = '../ctr/ct_grcost_bandejas.php';
        datos = {'opcion':'lee_valores','bandeja':id_dimen,'complem':complem,'elemen':elemen}
    }else{
        destino = '../ctr/ct_grcost_condule.php';
        datos = {'opcion':'lee_valores','tuberia':id_condu,'dimension':id_dimen,'complem':complem,'elemen':elemen}
    }
    let asin = false;
    procesa(datos,destino,asin);   
}

function trae_vrbandeja(campo,complem,elemen,opc){
    let id_dimen = $("#"+campo).val(); // Viene campo iddimension_0 y opcion: leevr_bandeja
    let id_bande = $("#idtuberia_0").val();
    let asin = false;
    procesa(datos,destino,asin);   
}

function cambia_cantTb(obj){
    let id = $(obj).attr("id");
    let campo1 = separa(id,"_",0);
    let valor = $(obj).val();
    console.log("en cambia_cantTb campo: "+campo1+" valor: "+valor);
    let cstMtr = da_valor( $("#cstMtrTubos_0") );
    let cstMob = da_valor( $("#cstMobTubos_0") );
    switch(campo1){
        case 'canMtr': 
            cstMtr += ( da_valor( $("#elem1_complem1") ) * valor );
            cstMob += ( da_valor( $("#elem1_complem2") ) * valor );
            break;
        case 'canCur':
            cstMtr += ( da_valor( $("#elem2_complem1") ) * valor );
            cstMob += ( da_valor( $("#elem2_complem2") ) * valor );
            break;
        case 'canTee':
            cstMtr += ( da_valor( $("#elem3_complem1") ) * valor );
            cstMob += ( da_valor( $("#elem3_complem2") ) * valor );
            break;
        case 'canUni':
            cstMtr += ( da_valor( $("#elem4_complem1") ) * valor );
            cstMob += ( da_valor( $("#elem4_complem2") ) * valor );
            break;
    }
    $("#cstMtrTubos_0").val(cstMtr.toFixed(2));
    $("#cstMobTubos_0").val(cstMob.toFixed(2));
}

function pinta_tbElec(){
    let divTabla = $("#body_reg_tuberias");
    divTabla.empty();
    let tabla = "";
    for(let x = 0; x<arg_tbElec.length;x++){
        tabla += "<tr>";
        tabla += "<td class='xl102'>"+arg_tbElec[x]["idtuberia_0"]+"</td>";
        tabla += "<td class='xl102'>"+arg_tbElec[x]["iddimension_0"]+"</td>";
        tabla += "<td class='xl102 valor'>"+arg_tbElec[x]["canMtr_Tubos_0"]+"&nbsp;</td>";
        tabla += "<td class='xl102 valor'>"+arg_tbElec[x]["canCur_Tubos_0"]+"&nbsp;</td>";
        tabla += "<td class='xl102 valor'>"+arg_tbElec[x]["canTee_Tubos_0"]+"&nbsp;</td>";
        tabla += "<td class='xl102 valor'>"+arg_tbElec[x]["canUni_Tubos_0"]+"&nbsp;</td>";
        tabla += "<td class='xl102 valor'>"+arg_tbElec[x]["cstMtrTubos_0"]+"</td>";
        tabla += "<td class='xl102 valor'>"+arg_tbElec[x]["cstMobTubos_0"]+"</td>";
        tabla += "<td><button onclick='borraTbElec("+x+")' title='Indice a Borrar'>x</button></td>";
        tabla += "</tr>";
    }    
    divTabla.append(tabla);
    limpiaTbElect();
}

function borraTbElec(x){
    arg_tbElec.splice(x,1);
    arl_tbElec = arg_tbElec.slice();
    arg_tbElec.splice(0,arg_tbElec.length);
    let nume = 0;
    for(let x=0; x < arl_tbElec.length; x++){
        arg_tbElec[nume] = [];
        arg_tbElec[nume] = arl_tbElec[x];
        nume++;
    }
    pinta_tbElec();
    suma_InsElectr();
}

function leeCantPrb(obj,id,tot,pers){
    let vrpers = 1;
    if(pers !== '' && da_valor($("#"+pers)) !== 0 ){
        vrpers = da_valor($("#"+pers));
    }
    let cant = 0;
    if(typeof obj == "string"){
        cant = da_valor($("#"+obj));
    }else{
        cant = da_valor($(obj));
    }
    let valor = da_valor($("#"+id));
    let subtotal = ( cant * vrpers * valor ); 
    console.log("Vienen cant:"+cant+" vr fijo:"+valor+" pers:"+vrpers+" total:"+subtotal);
    $("#"+tot+"_x").val( subtotal );
    $("#"+tot).val( formatter.format(subtotal) );   
    suma_vrPruebas();
}

function suma_vrPruebas(){
    let smMobPruebas = ( da_valor($("#tot_Presion_x")) + da_valor($("#tot_PruebaRX_x")) + da_valor($("#tot_Triple_x")) + da_valor($("#tot_PrueElec_x")) );
    let smPrePruebas = ( da_valor($("#tot_Nitrogeno_x")) + da_valor($("#tot_Soldadura_x")) + da_valor($("#tot_Alquiler_x")) + da_valor($("#tot_TranspMtr_x")) );
    let smElePruebas = ( da_valor($("#tot_Consumib_x")) );
    $("#totMobPruebas_x").val( smMobPruebas.toFixed(2));
    $("#totMobPruebas").val( formatter.format( smMobPruebas ));
    $("#totIsmPruebas_x").val( smPrePruebas.toFixed(2));
    $("#totIsmPruebas").val( formatter.format( smPrePruebas ));
    $("#totElcPruebas_x").val( smElePruebas.toFixed(2));
    $("#totElcPruebas").val( formatter.format( smElePruebas ));
    let GTPruebas = ( smMobPruebas + smPrePruebas + smElePruebas );
    $("#GtPruebas_x").val(GTPruebas.toFixed(2)); 
    $("#GtPruebas").val( formatter.format( GTPruebas )); 
    res_formateado('totpruebas',GTPruebas);
    totalesRes();
}

function totalesVrs(){
    let totalVrs = 0;
    $(".totVrs").each(function(index){
        totalVrs += da_valor( $(this));
    })
    $("#totCostoVrs_x").val(totalVrs.toFixed(2));
    $("#totCostoVrs").val( formatter.format( totalVrs ) );
    res_formateado('totvarios',totalVrs);
    totalesRes();
}

function cstTranspVrs(obj){ // Suma Costos de transportes en Varios
    let valor = da_valor( $(obj) );
    $(obj).val(valor.toFixed(2));
    let sumaTransp = 0;
    $(".transp").each(function(index){
        sumaTransp += da_valor( $(this));
    })
    $("#totTransVrs_x").val(sumaTransp.toFixed(2));
    $("#totTransVrs").val( formatter.format( sumaTransp ) );
    totalesVrs();
}

function cstGruasVrs(obj){  // suma costos de Gruas
    let valor = da_valor($(obj));
    $(obj).val( valor.toFixed(2));
    let campo = $(obj).attr('id');
    let linea = separa(campo,"_",1);
    let nomCampo = separa(campo,"_",0);
    resto = separa(campo,nomCampo,1);
    let cant  = da_valor( $("#idcant_"+linea) );
    if( $("#idgrua"+resto).val() == "" || $("#idcapac"+resto).val() == "" || cant < 1 ){
        alert("Por favor, llene los campos de la grua");
        $("#idgrua"+resto).val("");
        $("#idcapac"+resto).val("");
        $("#idcant"+resto).val("");
        $("#idvrdia"+resto).val("");
        $("#idtotgrua"+resto).val("");
        $("#idgrua"+resto).focus();
    }else{
        let cstGrua = parseFloat( cant * valor );
        $("#idtotgrua"+resto).val( cstGrua.toFixed(2));
        let sumaGruas = 0;
        $(".gruas").each(function(index){
            sumaGruas += da_valor( $(this));
        })
        $("#totGruasVrs_x").val(sumaGruas.toFixed(2));
        $("#totGruasVrs").val( formatter.format( sumaGruas ) );
        let nueva = parseInt( linea ) + 1;
        if( nueva < 10 ){  
            $("#trGruas_"+nueva).css("display","table-row");
            $("#idgrua_"+nueva).focus();
        }
        totalesVrs();
    }
}

function cstMontaVrs(obj){  // costo alquiler montacargas
    let campo = $(obj).attr('id');
    let linea = separa(campo,"_",1);
    let nomCampo = separa(campo,"_",0);
    resto = separa(campo,nomCampo,1);

    let cantMontacargas = da_valor( $("#idcanMonta"+resto) );
    let vrunMontacargas = da_valor( $("#idvrMonta"+resto)  );
    if( $("#iddesMonta"+resto).val() == "" || $("#idcapMonta"+resto).val() == "" || $("#idcanMonta"+resto).val() == "" || $("#idvrMonta"+resto).val == "" ){
        alert("Por favor, llene los campos del montacargas");
        $("#iddesMonta"+resto).val("");
        $("#idcapMonta"+resto).val("");
        $("#idcanMonta"+resto).val("");
        $("#idvrMonta"+resto).val("");
        $("#idcstMonta"+resto).val("");
        $("#iddesMonta"+resto).focus();
    }else{
        let cstMonta = parseFloat( cantMontacargas * vrunMontacargas );
        $("#idcstMonta"+resto).val( cstMonta.toFixed(2));
        let sumaMonta = 0;
        $(".Montacargas").each(function(index){
            sumaMonta += da_valor( $(this));
        })
        $("#totMontaVrs_x").val(sumaMonta.toFixed(2));
        $("#totMontaVrs").val( formatter.format( sumaMonta ) );
        let nueva = parseInt( linea ) + 1;
        if( nueva < 10 ){  
            $("#trMonta_"+nueva).css("display","table-row");
            $("#iddesMonta_"+nueva).focus();
        }
        totalesVrs();
    }
}

function cstAndamios(obj,iddiasAndam,id_vruni,idcostAndam){
    let cantSecc = da_valor($(obj));
    let diasSecc = da_valor( $("#"+iddiasAndam));
    let vrunSecc = da_valor( $("#"+id_vruni));
    let cstSecc  = parseFloat( cantSecc * diasSecc * vrunSecc ); 
    $("#"+idcostAndam).val( cstSecc.toFixed(2));
    let linea = separa($(obj).attr('id'),"_",1);
    if(linea == '1'){
        linea2 = '2';
    }else{
        linea2 = '1';
    }
    let otroCosto = da_valor($("#idcostAndam_"+linea2));
    $("#totAndamVrs_x").val( (cstSecc + otroCosto).toFixed(2));
    $("#totAndamVrs").val( formatter.format(cstSecc + otroCosto) );
    totalesVrs();
}

function cst1(obj,id_08060){
    let dias = da_valor($(obj));
    let idcampo = $(obj).attr('id');
    let grupo = separa(idcampo,"_",1);
    let linea = separa(idcampo,"_",2);
    let cost = da_valor( $("#"+id_08060+linea) );
    let costo = parseFloat( dias * cost );
    $("#cst_"+grupo+"_"+linea).val( costo.toFixed(2));

    let sumaGrupo =0;
    $("."+grupo).each(function(index){
        sumaGrupo += da_valor( $(this));
    })
    $("#tot"+grupo+"Vrs_x").val(sumaGrupo.toFixed(2));
    $("#tot"+grupo+"Vrs").val( formatter.format( sumaGrupo ) );
    totalesVrs();
}

function cstImpre(obj){
    let id = $(obj).attr("id");
    let valor = da_valor($(obj));
    $("#"+id+"_x").val( valor.toFixed(2) );
    $(obj).val( formatter.format( valor ) );
    totalesVrs();
}

function totalesRes(){
    let totalRes = 0, totalResUS = 0,totalPor=0; ar_items = [],x=0;
    let trm = $("#trm_x").val();
    let vrUs = 0.00;
    $(".Resumen").each(function(index){
        totalRes += da_valor( $(this) );
        id   = $(this).attr('id');
        vrId = $(this).val();
        idpal= separa(id,"_x",0);
        idus = $("#us"+idpal).attr('id');
        vrUs = $("#"+idus).val();
        if( vrUs.includes(',')){
            vrUs = vrUs.replace(".","");
            vrUs = vrUs.replace(",",".");
        }
        if( (vrId / trm ) !== vrUs ){
            vrUs = parseFloat( vrId / trm );
            $("#"+idus).val( formatter.format(vrUs) );
        }

        ar_items[x] = [];
        ar_items[x]['item']  = id;
        ar_items[x]['valor'] = da_valor( $("#"+id) );
        ar_items[x]['_%']    = 0;
        totalResUS += da_valor( $("#"+idus));
        x++;
    })

    for(let n=0; n < ar_items.length;n++){
        ar_items[n]['_%'] = parseFloat( ar_items[n]['valor'] / totalRes * 100 ).toFixed(2);
        totalPor += parseFloat(ar_items[n]['_%']);
        campo = separa(ar_items[n]['item'],"_",0);
        $("#por"+ campo ).val( formatter.format( ar_items[n]['_%'] ) );
    }
    res_formateado('totcostos',totalRes);
    $("#portotcostos").val( formatter.format(totalPor) );
    let utilid = quitaporc('utilid');
    let costoPers = da_valor( $("#totpersalfrio_x") );
    let pventa = parseFloat( ( totalRes - costoPers ) / ( 1 - utilid ) ) + costoPers ;
    res_formateado('totprecio',pventa);
    let porc_pventa = parseFloat( totalPor / ( 1 - utilid));
    $("#portotprecio").val( formatter.format( porc_pventa ) );
    let profit = parseFloat( pventa - totalRes );
    res_formateado('totprofit',profit);
    let porc_profit = parseFloat( porc_pventa - totalPor );
    $("#portotprofit").val( formatter.format( porc_profit ) );
    let porciva = quitaporc('iva');
    let vriva = parseFloat(pventa * porciva );
    res_formateado('totiva',vriva);
    let porc_iva = parseFloat( porc_pventa * porciva );
    $("#portotiva").val( formatter.format( porc_iva ) );
}

function quitaporc(campo){   // lee campo con porcentaje convirtiendo a decimal
    let idcampo = document.getElementById(campo);
    let valor = 0;
    if( idcampo){
        valor = $("#"+campo+"_x").val();
    }else{
        valor = $("#"+campo).val();
    }
    return parseFloat((separa(valor,"%",0))/100);
}

function lee_vacio(campo){
    let dato = $.trim($("#"+campo).val());
    let datox = $.trim( $("#"+campo+"_x").val());
    if( dato.length < 1){
        return true;
    }else{
        return false;
    }
}

function act_pry(){ // actualiza datos básicos del proyecto
    if( lee_vacio("nom_proy") ){
        alert("por favor, llene el campo Proyecto");
        $("#nom_proy").focus();
    }else if( lee_vacio("nom_cliente") ){
        alert("Por favor, seleccione el cliente");
        $("#nom_cliente").focus();
    }else if( lee_vacio("ciudad") ){
        alert("Por favor, seleccione la ciudad");
        $("#ciudad").focus();
    }else if( lee_vacio("fecha") ){
        alert("Por favor, seleccione la fecha");
        $("#fecha").focus();
    }else if( lee_vacio("codciu_proy") ){
        alert("Por favor, seleccione la ciudad del proyecto");
        $("#codciu_proy").focus();
    }else if( lee_vacio("utilid") ){
        alert("Por favor, registre el valor Profit");
        $("#utilid").focus();
    }else if( lee_vacio("iva") ){
        alert("Por favor, registre el valor del iva");
        $("#iva").focus();
    }else if( lee_vacio("trm") ){
        alert("Por favor, registre la TRM");
        $("#trm").focus();
    }else{
        let id_prycosto = $("#id_prycosto").val();
        let descrip_pry = $("#nom_proy").val();
        let nom_cliente = $("#nom_cliente").val();
        let ciudad      = $("#ciudad").val();
        let ciudad_proy = $("#codciu_proy").val();
        let utilidad    = $("#utilid").val();
        let iva         = $("#iva").val();
        let trm         = $("#trm_x").val();
        let fecha       = $("#fecha").val();
        let ctro_costo  = $("#ctro_costo").val();
        const $dato = {
            'id_prycosto': id_prycosto,
            'descrip_pry': descrip_pry,
            'nom_cliente': nom_cliente,
            'ciudad': ciudad,
            'ciudad_proy': ciudad_proy,
            'utilidad': utilidad,
            'iva': iva,
            'trm': trm,
            'fecha': fecha,
            'ctro_costo': ctro_costo,
            'opcion': 'lee_prycosto'
        }
        let destino = '../ctr/ct_grpry_costo.php';
        let asin = false;
        procesa($dato,destino,asin);
    }
}

function act_cst_adm(){  // actualiza costos admtvos
    if( lee_vacio("polizas") && lee_vacio("cst_fcro") && lee_vacio("comp_cntb") ){
        alert("por favor, llene alguno de los campos de Costos Admtvos");
        $("#polizas").focus();
    }else{
        const $dato = {
            'id_prycosto': $("#id_prycosto").val(),
            'id_cons_adm': $("#id_cons_adm").val(),
            'polizas': $("#polizas_x").val(),
            'costo_fcro': $("#cst_fcro_x").val(),
            'pers_admto': $("#comp_cntb_x").val(),
            'opcion':'lee_cst_adm'
        }
        let destino = "../ctr/ct_grpry_adm.php";
        let asin = false;
        procesa($dato,destino,asin);
    }
}

function recarga(){
    if( $("#id_prycosto").val() !== "" ){
        if($("#polizas").val() != ""){
            sumaCstSueldos();
            suma_viat('');
            suma_viat('inge');
            suma_viat('tecn');
            suma_gara('gara');
            suma_adms();
            suma_persalfrio();
        }
        if($("#hay_equipos").val() != 0 ){
            suba_arr_equipos();
        }
        if($("#hay_perfiles").val() != 0 ){
            suba_arr_sopEquipos();
        }
        if($("#hay_tuberia").val() != 0 ){
            suba_arr_tuberia();
        }
        if($("#hay_soptuberia").val() != 0 ){
            suba_arr_sopTuberia();
        }
        if($("#hay_valvulas").val() != 0 ){
            suba_arr_valvulas();
        }
        if($("#hay_eqelect").val() != 0 || $("#hay_tuelect").val() != 0 ){
            suba_arr_insElectrico();
        }
        if($("#hay_sopElectri").val() != 0 ){
            suba_arr_sopElectri();
        }
        if($("#hay_pruebas").val() != 0 ){
            suba_arr_pruebas();
        }
        if($("#hay_varios").val() != 0 ){
            suba_arr_varios();
        }    
    }
}

function act_cst_pers(){
        const $dato = {"dato":[
            {
                "concepto": "cstinge",
                "cant":     $("#caninge").val(),
                "valor_un": $("#id_020101").val(),
                "valor_total": $("#csttotinge_x").val() 
            },
            {
                "concepto": "csttecn",
                "cant":     $("#cantecn").val(),
                "valor_un": $("#id_020201").val(),
                "valor_total": $("#csttottecn_x").val()
            },
            {
                "concepto": "tiqinge",
                "cant":     $("#cantiqinge").val(),
                "valor_un": $("#id_020301").val(),
                "valor_total": $("#tottiqinge_x").val()
            },
            {
                "concepto": "hosinge",
                "cant":     $("#canhosinge").val(),
                "valor_un": $("#id_020302").val(),
                "valor_total": $("#tothosinge_x").val()
            },
            {
                "concepto": "aliinge",
                "cant":     $("#canaliinge").val(),
                "valor_un": $("#id_020303").val(),
                "valor_total": $("#totaliinge_x").val()
            },
            {
                "concepto": "trainge",
                "cant":     $("#cantrainge").val(),
                "valor_un": $("#id_020304").val(),
                "valor_total": $("#tottrainge_x").val()
            },
            {
                "concepto": "tiqtecn",
                "cant":     $("#cantiqtecn").val(),
                "valor_un": $("#id_020401").val(),
                "valor_total": $("#tottiqtecn_x").val()
            },
            {
                "concepto": "hostecn",
                "cant":     $("#canhostecn").val(),
                "valor_un": $("#id_020402").val(),
                "valor_total": $("#tothostecn_x").val()
            },
            {
                "concepto": "alitecn",
                "cant":     $("#canalitecn").val(),
                "valor_un": $("#id_020403").val(),
                "valor_total": $("#totalitecn_x").val()
            },
            {
                "concepto": "tratecn",
                "cant":     $("#cantratecn").val(),
                "valor_un": $("#id_020404").val(),
                "valor_total": $("#tottratecn_x").val()
            },
            {
                "concepto": "tragara",
                "cant":     $("#cantragara").val(),
                "valor_un": $("#id_020501").val(),
                "valor_total": $("#tottragara_x").val()
            },
            {
                "concepto": "suegara",
                "cant":     $("#cansuegara").val(),
                "valor_un": $("#id_020502").val(),
                "valor_total": $("#totsuegara_x").val()
            },
            {
                "concepto": "viagara",
                "cant":     $("#canviagara").val(),
                "valor_un": $("#id_020503").val(),
                "valor_total": $("#totviagara_x").val()
            }],
            "id_prycosto": $("#id_prycosto").val(),
            "opcion":"lee_cst_pers"
        }

        let destino = "../ctr/ct_grpry_pers.php";
        let asin = false;
        procesa($dato,destino,asin); 
}

function act_cst_equi(){
    let id_prycosto = $("#id_prycosto").val();
    if( Array.isArray( arg_InsEq ) ){
        const dato = [];
        for(let x=0; x< arg_InsEq.length;x++){
            dato[x] = { 
                'equipo':arg_InsEq[x]["nomEquipo"],
                'peso':arg_InsEq[x]["pesoEq"],
                'largo':arg_InsEq[x]["largo"],
                'ancho':arg_InsEq[x]["ancho"],
                'alto':arg_InsEq[x]["alto"],
                'aislam':arg_InsEq[x]["espesor"],
                'costo_instal':arg_InsEq[x]["cstInstEq"],
                'costo_aislam':arg_InsEq[x]["cstAislEq"]
            }
        }
        const $dato = {'dato':dato,
            'id_prycosto':id_prycosto,
            'opcion':'save_cst_insequi'
        }
        let destino = "../ctr/ct_grpry_insequi.php";
        let asin = false;
        procesa($dato,destino,asin); 
    }
    if( Array.isArray( arg_sopInsEq ) ){
        const dato2 = [];
        for(let x=0; x< arg_sopInsEq.length;x++){
            dato2[x] = { 
                'descr_perfil':arg_sopInsEq[x]["perfil_0"],
                'matsop':arg_sopInsEq[x]["matSop_0"],
                'cansop':arg_sopInsEq[x]["canSop_0"],
                'cst_material':arg_sopInsEq[x]["cstMaterial_0"],
                'cst_mobra':arg_sopInsEq[x]["cstMobra_0"],
                'cst_pintura':arg_sopInsEq[x]["cstPintura_0"]
            }
        }
        const $daton = {'dato':dato2,
                'id_prycosto':id_prycosto,
                'resto':'_0',
                'opcion':'save_cst_soporteria'
        }
        let destino = "../ctr/ct_grpry_soporteria.php";
        let asin = false;
        procesa($daton,destino,asin); 
    }
}   

function suba_arr_equipos(){
    // aqui, llamo ajax para leer los registros del gr_pry_equi y subirlos al
    // arreglo para luego pintarlo y realizar las sumas.
    let id_prycosto = $("#id_prycosto").val();
    const $dato = {
        'id_prycosto': id_prycosto,
        'opcion': 'lee_cst_insequi'
    }
    let destino = "../ctr/ct_grpry_insequi.php";
    let asin = false;
    procesa($dato,destino,asin); 
}

function carga_arreglo_equipos(arr){
    for(let x=0; x < arr.length;x++){
        arg_InsEq[x] = [];
        arg_InsEq[x]["nomEquipo"] = arr[x].equipo;
        arg_InsEq[x]["pesoEq"]    = arr[x].peso;
        arg_InsEq[x]["cstInstEq"] = arr[x].costo_instal;  
        arg_InsEq[x]["largo"]     = arr[x].largo; 
        arg_InsEq[x]["ancho"]     = arr[x].ancho;
        arg_InsEq[x]["alto"]      = arr[x].alto;
        arg_InsEq[x]["espesor"]   = arr[x].aislam;
        arg_InsEq[x]["cstAislEq"] = arr[x].costo_aislam; 
        arg_InsEq[x]["precio_m2"] = "";
    
    }
    suma_instEq();
    suma_aislamEq();
    suma_tot_eq();
}

function act_cst_tuberia(){  // Actualiza costos Instalacion Tuberia
    let resto = "_suc_des";
    if( Array.isArray(arg_insTub) ){
        const dato = [];
        for( let x = 0; x < arg_insTub.length; x++ ){
            dato[x] = {
                'id_prycosto': $("#id_prycosto").val(),
                'linea'   : arg_insTub[x]['linea'],
                'tipotubo': arg_insTub[x]['tipotubo'],
                'diametro': arg_insTub[x]['diametro'],
                'longitud': arg_insTub[x]['longitud'],
                'aislam'  : arg_insTub[x]['aislam'],
                'codo'    : arg_insTub[x]['codo'],
                'tee'     : arg_insTub[x]['tee'],
                'uniones' : arg_insTub[x]['uniones'],
                'cap'     : arg_insTub[x]['cap'],
                'medi_reduc':arg_insTub[x]['medi_reduc'],
                'cant'    : arg_insTub[x]['cant'],
                'cst_material':arg_insTub[x]['cst_material'],
                'cst_mobra':arg_insTub[x]['cst_mobra'],
                'cst_pintura':arg_insTub[x]['cst_pintura'],
                'cst_aislam':arg_insTub[x]['cst_aislam']
            }
        }
        const $dato = {
            'dato': dato,
            'opcion': 'save_cst_tuberia',
            'id_prycosto': $("#id_prycosto").val(),
        }
        let destino = "../ctr/ct_grpry_tuberia.php";
        let asin = false;
        procesa($dato,destino,asin); 
    }
    
    if( Array.isArray(arg_sopInsTub) ){
        const dato2 = [];
        for( let x=0; x < arg_sopInsTub.length; x++ ){
            dato2[x] = { 
                'descr_perfil':arg_sopInsTub[x]["perfil_1"],
                'matsop':arg_sopInsTub[x]["matSop_1"],
                'cansop':arg_sopInsTub[x]["canSop_1"],
                'cst_material':arg_sopInsTub[x]["cstMaterial_1"],
                'cst_mobra':arg_sopInsTub[x]["cstMobra_1"],
                'cst_pintura':arg_sopInsTub[x]["cstPintura_1"]
            }
        }
        const $daton = {'dato': dato2,
                'id_prycosto': $("#id_prycosto").val(),
                'resto':'_1',
                'opcion': 'save_cst_soporteria'
        }
        let destino = "../ctr/ct_grpry_soporteria.php";
        let asin = false;
        console.log("ENVIANDO "+JSON.stringify($daton));
        procesa($daton,destino,asin); 
    }
    
}

// SIGUE LA CARGA DE LA INSTALA. TUBERIA
function suba_arr_tuberia(){
    // aqui, llamo ajax para leer los registros del gr_pry_tuberia y subirlos al  arreglo 
    let id_prycosto = $("#id_prycosto").val();
    const $dato = {
        'id_prycosto': id_prycosto,
        'opcion': 'lee_cst_tuberia'
    }
    let destino = "../ctr/ct_grpry_tuberia.php";
    let asin = false;
    procesa($dato,destino,asin); 
}

function carga_arreglo_tuberia(arr,opc){   
    let y = 0;
    if( opc == 1 ){
        y = arg_insTub.length;
    }
    for(let x=0; x < arr.length; x++ ){
        arg_insTub[y] = [];
        arg_insTub[y]["linea"]       = arr[x]['linea'];
        arg_insTub[y]["tipotubo"]    = arr[x]['tipotubo'];  // era id_tipotubo
        arg_insTub[y]["diametro"]    = arr[x]['diametro'];  // era id_diametro
        arg_insTub[y]["longitud"]    = arr[x]['longitud'];
        arg_insTub[y]["aislam"]      = arr[x]['aislam'];  // era id_aislam
        arg_insTub[y]["codo"]        = arr[x]['codo'];
        arg_insTub[y]["tee"]         = arr[x]['tee'];
        arg_insTub[y]["uniones"]     = arr[x]['uniones'];
        arg_insTub[y]["cap"]         = arr[x]['cap'];
        arg_insTub[y]["medi_reduc"]  = arr[x]['medi_reduc'];
        arg_insTub[y]["cant"]        = arr[x]['cant'];
        arg_insTub[y]["cst_material"]= arr[x]['cst_material'];
        arg_insTub[y]["cst_mobra"]   = arr[x]['cst_mobra'];
        arg_insTub[y]["cst_pintura"] = arr[x]['cst_pintura'];
        arg_insTub[y]["cst_aislam"]  = arr[x]['cst_aislam'];
        y++;    
    }  
    pinta_arreglo_tuberia();
    totalesInstTuberia();
}

function pinta_arreglo_tuberia(){
    let divTabla = $("#reg_instuberia");
    divTabla.empty();
    let tabla = "";
    for(let x = 0; x<arg_insTub.length;x++){
        tabla += "<tr>";  
        tabla += "<td class='xl102'>"+arg_insTub[x]["linea"].substring(0,21)+"</td>";
        tabla += "<td class='xl102'>"+arg_insTub[x]["tipotubo"].substring(0,12)+"</td>";
        tabla += "<td class='xl102 valor'>"+arg_insTub[x]["diametro"]+"</td>";
        tabla += "<td class='xl102 valor'>"+arg_insTub[x]["longitud"]+"&nbsp;</td>";
        tabla += "<td class='xl102 valor'>"+arg_insTub[x]["aislam"]+"&nbsp;</td>";
        tabla += "<td class='xl102 valor'>"+arg_insTub[x]["codo"]+"</td>";
        tabla += "<td class='xl102 valor'>"+arg_insTub[x]["tee"]+"</td>";
        tabla += "<td class='xl102 valor'>"+arg_insTub[x]["uniones"]+"</td>";
        tabla += "<td class='xl102 valor'>"+arg_insTub[x]["cap"]+"</td>";
        tabla += "<td class='xl102 valor'>"+arg_insTub[x]["medi_reduc"]+"</td>";
        tabla += "<td class='xl102 valor'>"+arg_insTub[x]["cant"]+"</td>";
        tabla += "<td class='xl102 valor'>"+arg_insTub[x]["cst_material"]+"</td>";
        tabla += "<td class='xl102 valor'>"+arg_insTub[x]["cst_mobra"]+"</td>";
        tabla += "<td class='xl102 valor'>"+arg_insTub[x]["cst_pintura"]+"</td>";
        tabla += "<td class='xl102 valor'>"+arg_insTub[x]["cst_aislam"]+"</td>";

        tabla += "<td><button onclick='borrainsTub("+x+")' title='Indice a Borrar'>x</button></td>";
        tabla += "</tr>";
    }    
    divTabla.append(tabla);
}

function busca_campo(objeto,descrip){
    for(x=0;x< objeto.length;x++){
        if(objeto[x].descrip == descrip){
            return objeto[x].campo;
        }
    }
}

function act_cst_valvulas(){   // guarda los datos de instalacion válvulas a la bd.
    if( Array.isArray(arg_InsValv) ){
        let id_prycosto = $("#id_prycosto").val();
        const dato = [];
        for(let x=0; x < arg_InsValv.length;x++){
            dato[x] = { 
                'valvula':arg_InsValv[x]["valvInsValv"],
                'id_diam':arg_InsValv[x]["diamInsValv"],
                'cantidad':arg_InsValv[x]["cantInsValv"],
                'id_aislam':arg_InsValv[x]["esAiInsValv"],
                'cst_mobra':arg_InsValv[x]["vrManInsValv"],
                'cst_pintura':arg_InsValv[x]["vrPinInsValv"],
                'cst_aislam':arg_InsValv[x]["vrAisInsValv"]
            }
        }
        const $dato = {'dato':dato,
            'id_prycosto':id_prycosto,
            'opcion':'save_cst_insvalv'
        }
        let destino = "../ctr/ct_grpry_insvalv.php";
        let asin = false;
        procesa($dato,destino,asin); 
    }
}

function carga_arreglo_valvulas( arr ){
    for(let x=0; x < arr.length;x++){
        arg_InsValv[x] = [];
        arg_InsValv[x]["valvInsValv"]     = arr[x].valvula;
        arg_InsValv[x]["diamInsValv"]     = arr[x].id_diam;
        arg_InsValv[x]["cantInsValv"]     = arr[x].cantidad;  
        arg_InsValv[x]["esAiInsValv"]     = arr[x].id_aislam; 
        arg_InsValv[x]["vrManInsValv"]    = arr[x].cst_mobra;
        arg_InsValv[x]["vrPinInsValv"]    = arr[x].cst_pintura;
        arg_InsValv[x]["vrAisInsValv"]    = arr[x].cst_aislam;
    }
    suma_insValv();
}

function suba_arr_valvulas(){
    // aqui, llamo ajax para leer los registros del gr_pry_valv y subirlos al
    // arreglo para luego pintarlo y realizar las sumas.
    let id_prycosto = $("#id_prycosto").val();
    const $dato = {
        'id_prycosto': id_prycosto,
        'opcion': 'lee_cst_insvalv'
    }
    let destino = "../ctr/ct_grpry_insvalv.php";
    let asin = false;
    procesa($dato,destino,asin); 
}

function act_cst_electrica(){  // guarda los datos de instalacion Eléctrica, cables, tubos y soporteria 
    totcabelec = arg_eqElec.length; tottubelec = arg_tbElec.length; 
    if( Array.isArray( arg_eqElec ) ){
        let id_prycosto = $("#id_prycosto").val();
        const datoe = [];
        for(let x=0; x < arg_eqElec.length;x++){
            datoe[x] = { 
                'equipo':arg_eqElec[x]["equi_electr_0"], 
                'id_cabelect':arg_eqElec[x]["poteCalibr"],
                'id_cabdatos':arg_eqElec[x]["contCalibr"],
                'can_cabelect':arg_eqElec[x]["poteMateri_0"],
                'can_cabdatos':arg_eqElec[x]["contMateri_0"],
                'cst_material':arg_eqElec[x]["mateCstEle_0"],
                'cst_mobra':arg_eqElec[x]["mobrCstEle_0"]
            }
        }
        const datot = [];
        for(let ult=0; ult < arg_tbElec.length; ult++){
            datot[ult] = { 
                'id_tuberia': arg_tbElec[ult]['idtuberia'],
                'id_dimension': arg_tbElec[ult]['iddimension_0'],
                'metros': arg_tbElec[ult]['canMtr_Tubos_0'],
                'curvas': arg_tbElec[ult]['canCur_Tubos_0'],
                'tees': arg_tbElec[ult]['canTee_Tubos_0'],
                'uniones': arg_tbElec[ult]['canUni_Tubos_0'],
                'cst_material': arg_tbElec[ult]['cstMtrTubos_0'],
                'cst_mobra': arg_tbElec[ult]['cstMobTubos_0']
            }
        }
        const $dato = {
            'datoe':datoe,
            'datot':datot,
            'id_prycosto':id_prycosto,
            'opcion':'save_cst_inselec'
        }
        let destino = "../ctr/ct_grpry_inselec.php";
        let asin = false;
        procesa($dato,destino,asin); 
    }
    if( Array.isArray( arg_sopInsElec ) ){
        const dato2 = [];
        for(let x=0; x< arg_sopInsElec.length;x++){
            dato2[x] = { 
                'descr_perfil':arg_sopInsElec[x]["perfil_2"],
                'matsop':arg_sopInsElec[x]["matSop_2"],
                'cansop':arg_sopInsElec[x]["canSop_2"],
                'cst_material':arg_sopInsElec[x]["cstMaterial_2"],
                'cst_mobra':arg_sopInsElec[x]["cstMobra_2"],
                'cst_pintura':arg_sopInsElec[x]["cstPintura_2"]
            }
        }
        const $daton = {'dato':dato2,
                'id_prycosto':$("#id_prycosto").val(),
                'resto':'_2',
                'opcion':'save_cst_soporteria'
        }
        let destino = "../ctr/ct_grpry_soporteria.php";
        let asin = false;
        procesa($daton,destino,asin); 
    }
}  
            
function suba_arr_insElectrico(){
    // llamo ajax para leer los registros del gr_pry_cabelect y gr_pry_tubelect para subirlos al
    // arreglo y luego pintarlos y realizar las sumas.
    let id_prycosto = $("#id_prycosto").val();
    const $dato = {
        'id_prycosto': id_prycosto,
        'opcion': 'lee_cst_inselec'
    }
    let destino = "../ctr/ct_grpry_inselec.php";
    let asin = false;
    procesa($dato,destino,asin); 
}

function carga_arreglo_insElec( data ){
    // equipo en instal electrica
    if( Array.isArray( data.datoe )){
        let arr_e = data.datoe;
        if( arr_e.length > 0 ){
            for(let x=0; x < arr_e.length;x++){
                arg_eqElec[x] = [];
                arg_eqElec[x]["equi_electr_0"]  = arr_e[x].equipo;
                arg_eqElec[x]["poteCalibr"]     = arr_e[x].id_cabelect;
                arg_eqElec[x]["poteCalibr_0"]   = arr_e[x].id_cabelect_0;
                arg_eqElec[x]["contCalibr"]     = arr_e[x].id_cabdatos;  
                arg_eqElec[x]["contCalibr_0"]   = arr_e[x].id_cabdatos_0;
                arg_eqElec[x]["poteMateri_0"]   = arr_e[x].can_cabelect; 
                arg_eqElec[x]["contMateri_0"]   = arr_e[x].can_cabdatos;
                arg_eqElec[x]["mateCstEle_0"]   = arr_e[x].cst_material;
                arg_eqElec[x]["mobrCstEle_0"]   = arr_e[x].cst_mobra;
            }
            pinta_eqElec();
            suma_InsElectr();
        }    
    }

    // Tuberia en instal. electrica 
    if( Array.isArray( data.datot )){
        let arr_t = data.datot;
        if( arr_t.length > 0 ){
            for(let x=0; x < arr_t.length;x++){
                arg_tbElec[x] = [];
                arg_tbElec[x]["idtuberia_0"]    = arr_t[x].id_tuberia_0;
                arg_tbElec[x]["idtuberia"]      = arr_t[x].id_tuberia;
                arg_tbElec[x]["iddimension_0"]    = arr_t[x].id_dimension;
                arg_tbElec[x]["canMtr_Tubos_0"] = arr_t[x].metros;
                arg_tbElec[x]["canCur_Tubos_0"] = arr_t[x].curvas;
                arg_tbElec[x]["canTee_Tubos_0"] = arr_t[x].tees;
                arg_tbElec[x]["canUni_Tubos_0"] = arr_t[x].uniones;
                arg_tbElec[x]["cstMtrTubos_0"]  = arr_t[x].cst_material;
                arg_tbElec[x]["cstMobTubos_0"]  = arr_t[x].cst_mobra;
            }
            pinta_tbElec();
            suma_InsElectr();
        }
    }
}

function act_cst_pruebas(){  // Actualiza Costos de Pruebas
    let id_prycosto = $("#id_prycosto").val();
    const $dato = {
        'opcion':'save_cst_pruebas',
        'id_prycosto': id_prycosto,
        "dato":[
            {
                "concepto": "1_presion",
                "personal": $("#canPers_pre").val(),
                "cantidad": $("#canDias_pre").val(),
                "valor_un": $("#id_070101").val(),
                "valor_total": $("#tot_Presion_x").val(), 
            },
            {
                "concepto": "2_RX",
                "personal": $("#canPers_RX").val(),
                "cantidad": $("#canDias_RX").val(),
                "valor_un": $("#id_070102").val(),
                "valor_total": $("#tot_PruebaRX_x").val(), 
            },
            {
                "concepto": "3_triple",
                "personal": $("#canPers_Triple").val(),
                "cantidad": $("#canDias_Triple").val(),
                "valor_un": $("#id_070103").val(),
                "valor_total": $("#tot_Triple_x").val(), 
            },
            {
                "concepto": "4_prue_elec",
                "personal": $("#canPers_PrueElec").val(),
                "cantidad": $("#canDias_PrueElec").val(),
                "valor_un": $("#id_070104").val(),
                "valor_total": $("#tot_PrueElec_x").val(), 
            },
            {
                "concepto": "5_nitrogeno",
                "personal": 1,  
                "cantidad": $("#cant_Nitrogeno").val(),
                "valor_un": $("#id_070201").val(),
                "valor_total": $("#tot_Nitrogeno_x").val(), 
            },
            {
                "concepto": "6_soldadura",
                "personal": 1,  
                "cantidad": $("#cant_Soldadura").val(),
                "valor_un": $("#id_070202").val(),
                "valor_total": $("#tot_Soldadura_x").val(), 
            },
            {
                "concepto": "7_alquiler",
                "personal": 1, 
                "cantidad": $("#cant_Alquiler").val(),
                "valor_un": $("#id_070203").val(),
                "valor_total": $("#tot_Alquiler_x").val(), 
            },
            {
                "concepto": "8_transpmtr",
                "personal": 1, 
                "cantidad": $("#cant_TranspMtr").val(),
                "valor_un": $("#id_070204").val(),
                "valor_total": $("#tot_TranspMtr_x").val(), 
            },
            {
                "concepto": "9_consumib",
                "personal": 1, 
                "cantidad": $("#cant_Consumib").val(),
                "valor_un": $("#id_070301").val(),
                "valor_total": $("#tot_Consumib_x").val(), 
            }
        ]    
    }
    let destino = "../ctr/ct_grpry_pruebas.php";
    let asin = false;
    procesa($dato,destino,asin); 
}

function suba_arr_pruebas(){
    // llamo ajax para leer los registros del gr_pry_pruebas y subirlos al
    // arreglo para luego pintarlo y realizar las sumas.
    let id_prycosto = $("#id_prycosto").val();
    const $dato = {
        'id_prycosto': id_prycosto,
        'opcion': 'lee_cst_pruebas'
    }
    let destino = "../ctr/ct_grpry_pruebas.php";
    let asin = false;
    procesa($dato,destino,asin); 
}

function carga_arreglo_pruebas(data){
    if( Array.isArray( data.dato )){
        let arr = data.dato;
        if( arr.length > 0 ){
            for(let x=0; x < arr.length;x++){
                switch( arr[x].concepto ){
                    case '1_presion':
                        $("#canPers_pre").val( arr[x].personal ); 
                        $("#canDias_pre").val( arr[x].cantidad );
                        $("#tot_Presion_x").val( arr[x].valor_total ); 
                        $("#tot_Presion").val( formatter.format( arr[x].valor_total ) ); 
                        break;
                    case '2_RX':
                        $("#canPers_RX").val( arr[x].personal );
                        $("#canDias_RX").val( arr[x].cantidad );
                        $("#tot_PruebaRX_x").val( arr[x].valor_total ); 
                        $("#tot_PruebaRX").val( formatter.format( arr[x].valor_total ) ); 
                        break;
                    case '3_triple':
                        $("#canPers_Triple").val( arr[x].personal );
                        $("#canDias_Triple").val( arr[x].cantidad );
                        $("#tot_Triple_x").val( arr[x].valor_total );
                        $("#tot_Triple").val( formatter.format( arr[x].valor_total ) );
                        break;
                    case '4_prue_elec': 
                        $("#canPers_PrueElec").val( arr[x].personal );
                        $("#canDias_PrueElec").val( arr[x].cantidad );
                        $("#tot_PrueElec_x").val( arr[x].valor_total );
                        $("#tot_PrueElec").val( formatter.format( arr[x].valor_total ) );
                        break;
                    case '5_nitrogeno':
                        //"personal": 1,  
                        $("#cant_Nitrogeno").val( arr[x].cantidad );
                        $("#tot_Nitrogeno_x").val( arr[x].valor_total ); 
                        $("#tot_Nitrogeno").val( formatter.format( arr[x].valor_total ) ); 
                        break;
                    case '6_soldadura':
                        //"personal": 1,  
                        $("#cant_Soldadura").val( arr[x].cantidad );
                        $("#tot_Soldadura_x").val( arr[x].valor_total ); 
                        $("#tot_Soldadura").val( formatter.format( arr[x].valor_total ) ); 
                        break;
                    case '7_alquiler':
                        //"personal": 1, 
                        $("#cant_Alquiler").val( arr[x].cantidad );
                        //"valor_un": $("#id_070203").val(),
                        $("#tot_Alquiler_x").val( arr[x].valor_total ); 
                        $("#tot_Alquiler").val( formatter.format( arr[x].valor_total ) ); 
                        break;
                    case '8_transmtr':
                        //"personal": 1, 
                        $("#cant_TranspMtr").val( arr[x].cantidad );
                        //"valor_un": $("#id_070204").val(),
                        $("#tot_TranspMtr_x").val( arr[x].valor_total ); 
                        $("#tot_TranspMtr").val( formatter.format( arr[x].valor_total ) ); 
                        break;
                    case '9_consumib':
                        //"personal": 1, 
                        $("#cant_Consumib").val( arr[x].cantidad );
                        //"valor_un": $("#id_070301").val(),
                        $("#tot_Consumib_x").val( arr[x].valor_total ); 
                        $("#tot_Consumib").val( formatter.format( arr[x].valor_total ) ); 
                        break;
                }
            }
            suma_vrPruebas();
        }    
    }  
}

function act_cst_varios(){
    console.log("en act_cst_varios ...");
    let id_prycosto = $("#id_prycosto").val();
    const datog = [
            {
                "concepto": "Imprevistos",
                "campo1": "",
                "campo2": "",
                "campo3": "",
                "valor_total": $("#totImpreVrs_x").val()
            },
            {
                "concepto": "1_Trans_Mont",
                "campo1": $("#campo1_Trans_Mont").val(),
                "campo2": $("#campo2_Trans_Mont").val(),
                "campo3": $("#campo3_Trans_Mont").val(),
                "valor_total": $("#id_Trans_Mont").val()
            },
           {
                "concepto": "2_Trans_Grua",
                "campo1": $("#campo1_Trans_Grua").val(),
                "campo2": $("#campo2_Trans_Grua").val(),
                "campo3": $("#campo3_Trans_Grua").val(),
                "valor_total": $("#id_Trans_Grua").val()
            },
            {
                "concepto": "3_Trans_Mate",
                "campo1": $("#campo1_Trans_Mate").val(),
                "campo2": $("#campo2_Trans_Mate").val(),
                "campo3": $("#campo3_Trans_Mate").val(),
                "valor_total": $("#id_Trans_Mate").val()
            }, 
            {
                "concepto": "4_Trans_Rack",
                "campo1": $("#campo1_Trans_Rack").val(),
                "campo2": $("#campo2_Trans_Rack").val(),
                "campo3": $("#campo3_Trans_Rack").val(),
                "valor_total": $("#id_Trans_Rack").val()
            },
            {
                "concepto": "5_trans_Cont",
                "campo1": $("#campo1_trans_Cont").val(),
                "campo2": $("#campo2_trans_Cont").val(),
                "campo3": $("#campo3_trans_Cont").val(),
                "valor_total": $("#id_trans_Cont").val()
            },
            {
                "concepto": "6_trans_Bano",
                "campo1": $("#campo1_trans_Bano").val(),
                "campo2": $("#campo2_trans_Bano").val(),
                "campo3": $("#campo3_trans_Bano").val(),
                "valor_total": $("#id_trans_Bano").val()
            },
            {
                "concepto": "idescAndam_1",   
                "campo1": $("#iddiasAndam_1").val(),
                "campo2": $("#idseccAndam_1").val(),
                "campo3": $("#id_080401").val(),
                "valor_total": $("#idcostAndam_1").val()
            },
            {
                "concepto": "idescAndam_2",  
                "campo1": $("#iddiasAndam_2").val(),
                "campo2": $("#idseccAndam_2").val(),
                "campo3": $("#id_080402").val(),
                "valor_total": $("#idcostAndam_2").val()
            },
            {
                "concepto": "txt_Cont_1",  
                "campo1": 1,  
                "campo2": $("#can_Cont_1").val(),
                "campo3": $("#id_080501").val(),
                "valor_total": $("#cst_Cont_1").val()
            },
            {
                "concepto": "txt_Cont_2",  
                "campo1": 1,  
                "campo2": $("#can_Cont_2").val(),
                "campo3": $("#id_080502").val(),
                "valor_total": $("#cst_Cont_2").val()
            },
            {
                "concepto": "txt_Cont_3",   
                "campo1": 1,  
                "campo2": $("#can_Cont_3").val(),
                "campo3": $("#id_080503").val(),
                "valor_total": $("#cst_Cont_3").val()
            },
            {
                "concepto": "tit_Viat_1",   
                "campo1": 1,  
                "campo2": $("#can_Viat_1").val(),
                "campo3": $("#id_080601").val(),
                "valor_total": $("#cst_Viat_1").val()
            },
            {
                "concepto": "tit_Viat_2",  
                "campo1": 1,  
                "campo2": $("#can_Viat_2").val(),
                "campo3": $("#id_080602").val(),
                "valor_total": $("#cst_Viat_2").val()
            },
            {
                "concepto": "tit_Viat_3",   
                "campo1": 1,  
                "campo2": $("#can_Viat_3").val(),
                "campo3": $("#id_080603").val(),
                "valor_total": $("#cst_Viat_3").val()
            },
            {
                "concepto": "tit_Viat_4",    
                "campo1": 1,  
                "campo2": $("#can_Viat_4").val(),
                "campo3": $("#id_080604").val(),
                "valor_total": $("#cst_Viat_4").val()
            },
            {
                "concepto": "txt_Persi_1",   
                "campo1": 1,  
                "campo2": $("#cant_Persi_1").val(),
                "campo3": $("#id_080701").val(),
                "valor_total": $("#cst_Persi_1").val()
            },
            {
                "concepto": "txt_Persi_2",   
                "campo1": 1,  
                "campo2": $("#cant_Persi_2").val(),
                "campo3": $("#id_080702").val(),
                "valor_total": $("#cst_Persi_2").val()
            },
            {
                "concepto": "txt_Persi_3",   
                "campo1": 1,  
                "campo2": $("#cant_Persi_3").val(),
                "campo3": $("#id_080703").val(),
                "valor_total": $("#cst_Persi_3").val()
            },
            {
                "concepto": "txt_Persi_4",   
                "campo1": 1,  
                "campo2": $("#cant_Persi_4").val(),
                "campo3": $("#id_080704").val(),
                "valor_total": $("#cst_Persi_4").val()
            },
            {
                "concepto": "txt_Persi_5",   
                "campo1": 1,  
                "campo2": $("#cant_Persi_5").val(),
                "campo3": $("#id_080705").val(),
                "valor_total": $("#cst_Persi_5").val()
            },
            {
                "concepto": "txt_Resid_1",   
                "campo1": 1,  
                "campo2": $("#cant_Resid_1").val(),
                "campo3": $("#id_080801").val(),
                "valor_total": $("#cst_Resid_1").val()
            },
            {
                "concepto": "txt_Resid_2",   
                "campo1": 1,  
                "campo2": $("#cant_Resid_2").val(),
                "campo3": $("#id_080802").val(),
                "valor_total": $("#cst_Resid_2").val()
            },
            {
                "concepto": "txt_Resid_3",   
                "campo1": 1,  
                "campo2": $("#cant_Resid_3").val(),
                "campo3": $("#id_080803").val(),
                "valor_total": $("#cst_Resid_3").val()
            },
            {
                "concepto": "txt_Banos_1",  
                "campo1": 1,  
                "campo2": $("#cant_Banos_1").val(),
                "campo3": $("#id_080901").val(),
                "valor_total": $("#cst_Banos_1").val()
            }
        ]
    const datogruas = [];
    for(let x = 0; x < 10; x++ ){
        if( $("#idtotgrua_"+x).val() == "" ){
            continue;
        }else{
            datogruas[x] = 
            {
                'concepto'   :$("#idgrua_"+x).val(),
                'campo1'     :$("#idcapac_"+x).val(),
                'campo2'     :$("#idcant_"+x).val(),
                'campo3'     :$("#idvrdia_"+x).val(),
                'valor_total':$("#idtotgrua_"+x).val()
            } 
        }
    }
    const datomonta = [];
    for(let x = 0; x < 10; x++ ){
        if( $("#idcstMonta_"+x).val() == "" ){
            continue;
        }else{
            datomonta[x] = 
            {
                'concepto'   :$("#iddesMonta_"+x).val(),
                'campo1'     :$("#idcapMonta_"+x).val(),
                'campo2'     :$("#idcanMonta_"+x).val(),
                'campo3'     :$("#idvrMonta_"+x).val(),
                'valor_total':$("#idcstMonta_"+x).val()
            } 
        }
    }

    const $dato = {
            'opcion':'save_cst_varios',
            'id_prycosto': $("#id_prycosto").val(),
            'dato':  datog,
            'gruas': datogruas,
            'monta': datomonta
    }
    
    console.log("ENVIANDO: "+JSON.stringify($dato));
    let destino = "../ctr/ct_grpry_varios.php";
    let asin = false;
    procesa($dato,destino,asin);   
}

function trae_vrperfil(campo,opc,vlrCampo,tipoCampo,resto){
    if(tipoCampo == "text"){
        id_perfil = $("#"+campo).val();
    }else{
        id_perfil = vlrCampo;
    }
    let destino = '../ctr/ct_gpcst_perfiles.php';
    let asin = false;
    let datos = {'opcion':opc,'id_perfil':id_perfil,'resto':resto}
    procesa(datos,destino,asin);   
}

function calcPerfil(obj){
    let idcampo = $(obj).attr("id");
    let nomCampo = separa(idcampo,"_",0);
    resto = separa(idcampo,nomCampo,1);
    let matSop = da_valor($("#matSop"+resto));
    let canSop = da_valor($("#canSop"+resto));
    let vrMate = da_valor($("#vrMaterial"+resto));
    let increm = ( 1 + ( $("#id_0907").val()/100) );  // incremento AC estructural
    let material = ( matSop * canSop * vrMate * increm );
    $("#cstMaterial"+resto).val(material.toFixed(2));
    let incre2 = ( 1 + ( $("#id_0901").val()/100) );  // incremento M.O. soldador
    let vrMobra = da_valor($("#vrMobra"+resto));
    let manobra = ( matSop * canSop * vrMobra * incre2 );
    $("#cstMobra"+resto).val( manobra.toFixed(2) );
    let vrPint = da_valor($("#vrPintura"+resto));
    let pintura = ( matSop * canSop * vrPint );
    $("#cstPintura"+resto).val( pintura.toFixed(2));
    $("#perfil"+resto).focus();
}

function guardaPerfil(resto){
    switch(resto){
        case '_0':
            add_Perfiles(resto,arg_sopInsEq);
            sumaPerfiles(arg_sopInsEq,resto);
            pinta_Perfiles('divRegSoporteEquipos',arg_sopInsEq,resto);
            break;
        case '_1':
            add_Perfiles(resto,arg_sopInsTub);
            sumaPerfiles(arg_sopInsTub,resto); 
            pinta_Perfiles('divRegSoporteTuberia',arg_sopInsTub,resto);       
            break;
        case '_2':
            add_Perfiles(resto,arg_sopInsElec);
            sumaPerfiles(arg_sopInsElec,resto); 
            pinta_Perfiles('divRegSoporteElectrico',arg_sopInsElec,resto);       
            break;
    }
}

function add_Perfiles(resto,arr_sop){
    if( $("#cstMaterial"+resto).val() !== "" && 
        $("#cstMobra"+resto).val() !== "" && 
        $("#cstPintura"+resto).val() !== "" ){

        let x = arr_sop.length;
        arr_sop[x] = [];
        arr_sop[x]['perfil'+resto] = $("#perfil"+resto+" option:selected").text();
        arr_sop[x]['matSop'+resto] = $("#matSop"+resto).val();
        arr_sop[x]['canSop'+resto] = $("#canSop"+resto).val();
        arr_sop[x]['cstMaterial'+resto] = $("#cstMaterial"+resto).val();
        arr_sop[x]['cstMobra'+resto] = $("#cstMobra"+resto).val();
        arr_sop[x]['cstPintura'+resto] = $("#cstPintura"+resto).val(); 
        $("#perfil"+resto).val("");
        $("#matSop"+resto).val("");
        $("#canSop"+resto).val("");
        $("#cstMaterial"+resto).val("");
        $("#cstMobra"+resto).val("");
        $("#cstPintura"+resto).val("");
    }
}

function sumaPerfiles(arr_sop,resto){
    let cstMaterial = 0, cstMobra = 0, cstPintura = 0;
    for(let x = 0; x < arr_sop.length; x++ ){
        cstMaterial += parseFloat( arr_sop[x]['cstMaterial'+resto] );
        cstMobra    += parseFloat( arr_sop[x]['cstMobra'+resto] );
        cstPintura  += parseFloat( arr_sop[x]['cstPintura'+resto] ); 
    }
    let totSoport = parseFloat(cstMaterial + cstMobra + cstPintura );
    switch(resto){
        case '_0':
            $("#totCostSoport_x").val( totSoport.toFixed(2) );
            $("#totCostSoport").val( formatter.format(totSoport) );
            suma_tot_eq();
            break;
        case '_1':
            $("#gtSopInstTuberia_x").val( totSoport.toFixed(2) );
            $("#gtSopInstTuberia").val( formatter.format(totSoport) );
            totalesInstTuberia();
            break;  
        case '_2':
            $("#totCstSopBandej_x").val( totSoport.toFixed(2) );
            $("#totCstSopBandej").val( formatter.format(totSoport) );
            $("#totCstSopBandej_x").focus();
            suma_InsElectr();
            break;        
    }
}

function pinta_Perfiles(divArreglo,arr_sop,resto){
    let divTabla = $("#"+divArreglo);
    divTabla.empty();
    let tabla = "";
    for( let x = 0; x < arr_sop.length; x++ ){
        tabla += "<tr>";
        tabla += "<td class='xl102'>"+arr_sop[x]["perfil"+resto]+"</td>";
        tabla += "<td class='xl102 valor'>"+arr_sop[x]["matSop"+resto]+"</td>";
        tabla += "<td class='xl102 valor'>"+arr_sop[x]["canSop"+resto]+"</td>";
        tabla += "<td class='xl102 valor'>"+arr_sop[x]["cstMaterial"+resto]+"</td>";
        tabla += "<td class='xl102 valor'>"+arr_sop[x]["cstMobra"+resto]+"</td>";
        tabla += "<td class='xl102 valor'>"+arr_sop[x]["cstPintura"+resto]+"</td>";
        tabla += "<td><button onclick=\"borra1Perfil("+x+",\'"+resto+"\')\" title='Indice a Borrar'>x</button></td>";  // OJO AQUI
        tabla += "</tr>";
    }    
    divTabla.append(tabla);
}

function borra1Perfil(x,resto){
    let arr_sop = [], divi = "";
    switch(resto){
        case '_0': divi = 'divRegSoporteEquipos';borraRegPerfil(x,arg_sopInsEq,resto,divi);  break;
        case '_1': divi = 'divRegSoporteTuberia';borraRegPerfil(x,arg_sopInsTub,resto,divi);break;
        case '_2': divi = 'divRegSoporteElectrico';borraRegPerfil(x,arg_sopInsElec,resto,divi);break;
    }
}

function borraRegPerfil(x,arr_sop,resto,divi){
    arr_sop.splice(x,1);
    arl = arr_sop.slice();
    arr_sop.splice(0,arr_sop.length);
    let nume = 0;
    for(let x=0; x < arl.length; x++){
        arr_sop[nume] = [];
        arr_sop[nume] = arl[x];
        nume++;
    }
    sumaPerfiles(arr_sop,resto);
    pinta_Perfiles(divi,arr_sop,resto);
}

function borrainsTub(x){
    arg_insTub.splice(x,1);
    arl = arg_insTub.slice();
    arg_insTub.splice(0,arg_insTub.length);
    let nume = 0;
    for(let x=0; x < arl.length; x++){
        arg_insTub[nume] = [];
        arg_insTub[nume] = arl[x];
        nume++;
    }
    totalesInstTuberia();
    pinta_arreglo_tuberia();
}

function suba_arr_sopEquipos(){
    // aqui, llamo leer registros del gr_pry_perfiles y subirlos al
    // arreglo para luego pintarlo y realizar las sumas.
    let id_prycosto = $("#id_prycosto").val();
    const $dato = {
        'id_prycosto': id_prycosto,
        'resto': '_0',
        'opcion': 'lee_cst_soporteria'
    }
    let destino = "../ctr/ct_grpry_soporteria.php";
    let asin = false;
    procesa($dato,destino,asin); 
}

function carga_arreglo_sopEquipos(arr_sop){
    for(let x=0; x < arr_sop.length;x++){  // VIENEN: descr_perfil,matsop,cansop,cst_material,cst_mobra,cst_pintura
        arg_sopInsEq[x]                  = [];
        arg_sopInsEq[x]["perfil_0"]      = arr_sop[x].descr_perfil;
        arg_sopInsEq[x]["matSop_0"]      = arr_sop[x].matsop;
        arg_sopInsEq[x]["canSop_0"]      = arr_sop[x].cansop;  
        arg_sopInsEq[x]["cstMaterial_0"] = arr_sop[x].cst_material; 
        arg_sopInsEq[x]["cstMobra_0"]    = arr_sop[x].cst_mobra;
        arg_sopInsEq[x]["cstPintura_0"]  = arr_sop[x].cst_pintura;
    
    }
    sumaPerfiles(arg_sopInsEq,"_0");
    pinta_Perfiles('divRegSoporteEquipos',arg_sopInsEq,"_0");
}

function suba_arr_sopTuberia(){
    // aqui, llamo leer registros del gr_pry_perfiles y subirlos al
    // arreglo para luego pintarlo y realizar las sumas.
    let id_prycosto = $("#id_prycosto").val();
    const $dato = {
        'id_prycosto': id_prycosto,
        'resto': '_1',
        'opcion': 'lee_cst_soporteria'
    }
    let destino = "../ctr/ct_grpry_soporteria.php";
    let asin = false;
    procesa($dato,destino,asin); 
}

function carga_arreglo_sopTuberia(arr_sop){
    for(let x=0; x < arr_sop.length;x++){  // VIENEN: descr_perfil,matsop,cansop,cst_material,cst_mobra,cst_pintura
        arg_sopInsTub[x]                  = [];
        arg_sopInsTub[x]["perfil_1"]      = arr_sop[x].descr_perfil;
        arg_sopInsTub[x]["matSop_1"]      = arr_sop[x].matsop;
        arg_sopInsTub[x]["canSop_1"]      = arr_sop[x].cansop;  
        arg_sopInsTub[x]["cstMaterial_1"] = arr_sop[x].cst_material; 
        arg_sopInsTub[x]["cstMobra_1"]    = arr_sop[x].cst_mobra;
        arg_sopInsTub[x]["cstPintura_1"]  = arr_sop[x].cst_pintura;
    }
    sumaPerfiles(arg_sopInsTub,"_1");
    pinta_Perfiles('divRegSoporteTuberia',arg_sopInsTub,"_1");
}

function suba_arr_sopElectri(){
    // aqui, llamo leer registros del gr_pry_perfiles y subirlos al
    // arreglo para luego pintarlo y realizar las sumas.
    let id_prycosto = $("#id_prycosto").val();
    const $dato = {
        'id_prycosto': id_prycosto,
        'resto': '_2',
        'opcion': 'lee_cst_soporteria'
    }
    let destino = "../ctr/ct_grpry_soporteria.php";
    let asin = false;
    procesa($dato,destino,asin); 
}

function carga_arreglo_sopElectri(arr_sop){
    for(let x=0; x < arr_sop.length;x++){  // VIENEN: descr_perfil,matsop,cansop,cst_material,cst_mobra,cst_pintura
        arg_sopInsElec[x]                  = [];
        arg_sopInsElec[x]["perfil_2"]      = arr_sop[x].descr_perfil;
        arg_sopInsElec[x]["matSop_2"]      = arr_sop[x].matsop;
        arg_sopInsElec[x]["canSop_2"]      = arr_sop[x].cansop;  
        arg_sopInsElec[x]["cstMaterial_2"] = arr_sop[x].cst_material; 
        arg_sopInsElec[x]["cstMobra_2"]    = arr_sop[x].cst_mobra;
        arg_sopInsElec[x]["cstPintura_2"]  = arr_sop[x].cst_pintura;
    }
    sumaPerfiles(arg_sopInsElec,"_2");
    pinta_Perfiles('divRegSoporteElectrico',arg_sopInsElec,"_2");
}

function suba_arr_varios(){
    // llamo ajax para leer los registros del gr_pry_varios y subirlos al
    // arreglo para luego pintarlo y realizar las sumas.
    let id_prycosto = $("#id_prycosto").val();
    const $dato = {
        'id_prycosto': id_prycosto,
        'opcion': 'lee_cst_varios'
    }
    let destino = "../ctr/ct_grpry_varios.php";
    let asin = false;
    procesa($dato,destino,asin); 
}

function carga_arreglo_varios(data){
    let id_prycosto = data.id_prcosto;
    let arr = data.dato;
    let arg = data.gruas;
    let arm = data.monta;    
    let vtotal = 0.0;
    if( Array.isArray( arr ) && arr.length > 0 ){
        for(let x=0; x < arr.length;x++){
            switch( arr[x].concepto ){
                case 'Imprevistos':
                    $("#totImpreVrs").val( parseFloat( arr[x].valor_total ).toFixed(2) );
                    cstImpre( $("#totImpreVrs"));
                    break;
                case '1_Trans_Mont':
                    $("#campo1_Trans_Mont").val(arr[x].campo1);
                    $("#campo2_Trans_Mont").val(arr[x].campo2);
                    $("#campo3_Trans_Mont").val(arr[x].campo3);
                    $("#id_Trans_Mont").val(parseFloat( arr[x].valor_total ).toFixed(2));
                    cstTranspVrs($("#id_Trans_Mont"));
                    break;
                case '2_Trans_Grua':
                    $("#campo1_Trans_Grua").val(arr[x].campo1);
                    $("#campo2_Trans_Grua").val(arr[x].campo2);
                    $("#campo3_Trans_Grua").val(arr[x].campo3);
                    $("#id_Trans_Grua").val(parseFloat( arr[x].valor_total ).toFixed(2));
                    cstTranspVrs($("#id_Trans_Grua"));
                    break;
                case '3_Trans_Mate':
                    $("#campo1_Trans_Mate").val(arr[x].campo1);
                    $("#campo2_Trans_Mate").val(arr[x].campo2);
                    $("#campo3_Trans_Mate").val(arr[x].campo3);
                    $("#id_Trans_Mate").val(parseFloat( arr[x].valor_total ).toFixed(2));
                    cstTranspVrs($("#id_Trans_Mate"));
                    break;
                case '4_Trans_Rack':
                    $("#campo1_Trans_Rack").val(arr[x].campo1);
                    $("#campo2_Trans_Rack").val(arr[x].campo2);
                    $("#campo3_Trans_Rack").val(arr[x].campo3);
                    $("#id_Trans_Rack").val(parseFloat( arr[x].valor_total ).toFixed(2));
                    cstTranspVrs($("#id_Trans_Rack"));
                    break;
                case '5_trans_Cont':
                    $("#campo1_trans_Cont").val(arr[x].campo1);
                    $("#campo2_trans_Cont").val(arr[x].campo2);
                    $("#campo3_trans_Cont").val(arr[x].campo3);
                    $("#id_trans_Cont").val(parseFloat( arr[x].valor_total ).toFixed(2));
                    cstTranspVrs($("#id_trans_Cont"));
                    break;
                case '6_trans_Bano':
                    $("#campo1_trans_Bano").val(arr[x].campo1);
                    $("#campo2_trans_Bano").val(arr[x].campo2);
                    $("#campo3_trans_Bano").val(arr[x].campo3);
                    $("#id_trans_Bano").val(parseFloat( arr[x].valor_total ).toFixed(2));
                    cstTranspVrs($("#id_trans_Bano"));
                    break;
                case 'idescAndam_1':
                    $("#iddiasAndam_1").val(arr[x].campo1);
                    $("#idseccAndam_1").val(arr[x].campo2);
                    $("#id_080401").val(arr[x].campo3);
                    $("#idcostAndam_1").val(parseFloat( arr[x].valor_total ).toFixed(2));
                    cstAndamios($("#idseccAndam_1"),'iddiasAndam_1','id_080401','idcostAndam_1');
                    break;
                case 'idescAndam_2':
                    $("#iddiasAndam_2").val(arr[x].campo1);
                    $("#idseccAndam_2").val(arr[x].campo2);
                    $("#id_080402").val(arr[x].campo3);
                    $("#idcostAndam_2").val(parseFloat( arr[x].valor_total ).toFixed(2));
                    cstAndamios($("#idseccAndam_2"),'iddiasAndam_2','id_080402','idcostAndam_2');
                    break;
                case 'txt_Cont_1':                        
                    //$("#iddiasAndam_2").val(arr[x].campo1);
                    $("#can_Cont_1").val(arr[x].campo2);
                    $("#id_080501").val(arr[x].campo3);
                    $("#cst_Cont_1").val(parseFloat( arr[x].valor_total ).toFixed(2));
                    cst1($("#can_Cont_1"),'id_08050','idCst')
                    break;
                case 'txt_Cont_2':
                    //$("#iddiasAndam_2").val(arr[x].campo1);
                    $("#can_Cont_2").val(arr[x].campo2);
                    $("#id_080502").val(arr[x].campo3);
                    $("#cst_Cont_2").val(parseFloat( arr[x].valor_total ).toFixed(2));
                    cst1($("#can_Cont_2"),'id_08050','idCst')
                    break;
                case 'txt_Cont_3':
                    //$("#iddiasAndam_2").val(arr[x].campo1);
                    $("#can_Cont_3").val(arr[x].campo2);
                    $("#id_080503").val(arr[x].campo3);
                    $("#cst_Cont_3").val(parseFloat( arr[x].valor_total ).toFixed(2));
                    cst1($("#can_Cont_3"),'id_08050','idCst')
                    break;
                case 'tit_Viat_1':
                    //$("#iddiasAndam_2").val(arr[x].campo1);
                    $("#can_Viat_1").val(arr[x].campo2);
                    $("#id_080601").val(arr[x].campo3);
                    $("#cst_Viat_1").val(parseFloat( arr[x].valor_total ).toFixed(2));
                    cst1($("#can_Viat_1"),'id_08060');
                    break;
                case 'tit_Viat_2':
                    //$("#iddiasAndam_2").val(arr[x].campo1);
                    $("#can_Viat_2").val(arr[x].campo2);
                    $("#id_080602").val(arr[x].campo3);
                    $("#cst_Viat_2").val(parseFloat( arr[x].valor_total ).toFixed(2));
                    cst1($("#can_Viat_2"),'id_08060');
                    break;
                case 'tit_Viat_3':
                    //$("#iddiasAndam_2").val(arr[x].campo1);
                    $("#can_Viat_3").val(arr[x].campo2);
                    $("#id_080603").val(arr[x].campo3);
                    $("#cst_Viat_3").val(parseFloat( arr[x].valor_total ).toFixed(2));
                    cst1($("#can_Viat_3"),'id_08060');
                    break;
                case 'tit_Viat_4':
                    //$("#iddiasAndam_2").val(arr[x].campo1);
                    $("#can_Viat_4").val(arr[x].campo2);
                    $("#id_080604").val(arr[x].campo3);
                    $("#cst_Viat_4").val(parseFloat( arr[x].valor_total ).toFixed(2));
                    cst1($("#can_Viat_4"),'id_08060');
                    break;
                case 'txt_Persi_1':
                    //$("#iddiasAndam_2").val(arr[x].campo1);
                    $("#cant_Persi_1").val(arr[x].campo2);
                    $("#id_080701").val(arr[x].campo3);
                    $("#cst_Persi_1").val(parseFloat( arr[x].valor_total ).toFixed(2));
                    cst1($("#cant_Persi_1"),'id_08070');
                    break;
                case 'txt_Persi_2':
                    //$("#iddiasAndam_2").val(arr[x].campo1);
                    $("#cant_Persi_2").val(arr[x].campo2);
                    $("#id_080702").val(arr[x].campo3);
                    $("#cst_Persi_2").val(parseFloat( arr[x].valor_total ).toFixed(2));
                    cst1($("#cant_Persi_2"),'id_08070');
                    break;
                case 'txt_Persi_3':
                    //$("#iddiasAndam_2").val(arr[x].campo1);
                    $("#cant_Persi_3").val(arr[x].campo2);
                    $("#id_080703").val(arr[x].campo3);
                    $("#cst_Persi_3").val(parseFloat( arr[x].valor_total ).toFixed(2));
                    cst1($("#cant_Persi_3"),'id_08070');
                    break;
                case 'txt_Persi_4':
                    //$("#iddiasAndam_2").val(arr[x].campo1);
                    $("#cant_Persi_4").val(arr[x].campo2);
                    $("#id_080704").val(arr[x].campo3);
                    $("#cst_Persi_4").val(parseFloat( arr[x].valor_total ).toFixed(2));
                    cst1($("#cant_Persi_4"),'id_08070');
                    break;
                case 'txt_Persi_5':
                    //$("#iddiasAndam_2").val(arr[x].campo1);
                    $("#cant_Persi_5").val(arr[x].campo2);
                    $("#id_080705").val(arr[x].campo3);
                    $("#cst_Persi_5").val(parseFloat( arr[x].valor_total ).toFixed(2));
                    cst1($("#cant_Persi_5"),'id_08070');
                    break;
                case 'txt_Resid_1':
                    //$("#iddiasAndam_2").val(arr[x].campo1);
                    $("#cant_Resid_1").val(arr[x].campo2);
                    $("#id_080801").val(arr[x].campo3);
                    $("#cst_Resid_1").val(parseFloat( arr[x].valor_total ).toFixed(2));
                    cst1($("#cant_Resid_1"),'id_08080');
                    break;
                case 'txt_Resid_2':
                    //$("#iddiasAndam_2").val(arr[x].campo1);
                    $("#cant_Resid_2").val(arr[x].campo2);
                    $("#id_080802").val(arr[x].campo3);
                    $("#cst_Resid_2").val(parseFloat( arr[x].valor_total ).toFixed(2));
                    cst1($("#cant_Resid_2"),'id_08080');
                    break;
                case 'txt_Resid_3':
                    //$("#iddiasAndam_2").val(arr[x].campo1);
                    $("#cant_Resid_3").val(arr[x].campo2);
                    $("#id_080803").val(arr[x].campo3);
                    $("#cst_Resid_3").val(parseFloat( arr[x].valor_total ).toFixed(2));
                    cst1($("#cant_Resid_3"),'id_08080');
                    break;
                case 'txt_Banos_1':
                    //$("#iddiasAndam_2").val(arr[x].campo1);
                    $("#cant_Banos_1").val(arr[x].campo2);
                    $("#id_080901").val(arr[x].campo3);
                    $("#cst_Banos_1").val(parseFloat( arr[x].valor_total ).toFixed(2));
                    cst1($("#cant_Banos_1"),'id_08090');
                    break;
            }
        }
    }else{
        alert("Sin datos Varios");
    }
    if( Array.isArray( arg ) && arg.length > 0 ){
        for(let x=0; x < arg.length;x++){
            nueva = parseInt(x) +1;
            $("#idgrua_"+x).val( arg[x].concepto );
            $("#idcapac_"+x).val( arg[x].campo1 );
            $("#idcant_"+x).val( arg[x].campo2 );
            $("#idvrdia_"+x).val( arg[x].campo3 );
            $("#idtotgrua_"+x).val( parseFloat( arg[x].valor_total ).toFixed(2) );
            $("#trGruas_"+nueva).css("display","table-row");
            cstGruasVrs($("#idtotgrua_"+x));
        }
    }
    if( Array.isArray( arm ) && arm.length > 0 ){
        for(let x=0; x < arm.length;x++){
            nueva = parseInt(x) +1;
            $("#iddesMonta_"+x).val( arm[x].concepto );
            $("#idcapMonta_"+x).val( arm[x].campo1 );
            $("#idcanMonta_"+x).val( arm[x].campo2 );
            $("#idvrMonta_"+x).val( arm[x].campo3 );
            $("#idcstMonta_"+x).val( parseFloat( arm[x].valor_total ).toFixed(2) );
            $("#trMonta_"+nueva).css("display","table-row");
            cstMontaVrs($("#idvrMonta_"+x));
        }
    }
}

function llamaOpcionesDimension(campoDestino,opcDimen,resto){
    let destino = "";
    if( opcDimen === "bandeja"){
        destino = "../ctr/ct_gp_bandeja.php";
    }else{
        destino = "../ctr/ct_gp_diametro.php";
    }
    let opc = 'lee_dimensiones';  // lee todas las dimensiones
    let asin = false;
    let datos = {'opcion':opc,'destino':campoDestino,'resto':resto}
    procesa(datos,destino,asin);
}

function cargaDimensiones(data){
    let resto = data.resto;
    let destino= data.destino;
    let arr_dimen = data.dato;
    let objDimen = $("#"+destino+resto);
    objDimen.empty();
    let opcion = "";
    opcion = $('<option>',{
        text : "Sin elegir",
        value:  "",
    })
    objDimen.append(opcion);

    if(arr_dimen != ""){
        for(let x=0;x<arr_dimen.length;x++){
            opcion = $('<option>',{
                text : arr_dimen[x][1],
                value: arr_dimen[x][0],
            })
            objDimen.append(opcion);
        }
    }    
}

function vali_coma(objCampo){
    let id = $(objCampo).attr("id");
    let dato = $(objCampo).val();
    if( dato.includes(',')){
        dato = dato.replace(",",".");
    }
    $("#"+id+"_x").val( dato );
    $("#"+id).val( formatter.format( dato ) );
    totalesRes();
}

function pone_nomProy(obj){
    let nomProy = $("#nom_proy").val();
    let ctrProy = $("#ctro_costo").val();
    let texto = "<strong>NOMBRE: </strong>"+nomProy.toUpperCase()+"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    texto += "<strong>CENTRO: </strong>"+ctrProy;
    $(obj).html( texto );
}