<?php

session_start();

include_once '../modelos/parametros_conexion.php';
include_once '../cls/varios.php';

try {

    $pdo = new PDO('mysql:host=localhost;dbname=' . BD, USER, PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_PERSISTENT => true));
} catch (Exception $e) {
    echo $e->getMessage();
}

try {
    //$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //ip_grupos que esta como "Línea" y son los grupos 

    $pdo->beginTransaction();

    $sentencia = null;
    $preparacion = null;
    $retorno = array();

    /*$preparacion=$pdo->prepare("START TRANSACTION");
    $preparacion->execute();
    */

    $datosRecibidos = $_POST["datosAEnviar"];

    $sentencia = "SELECT im_trans.cod_trans "
        . "FROM im_trans,ip_oper "
        . "WHERE im_trans.tipo_oper=ip_oper.tipo "
        . "AND ip_oper.tipo='REC';";
    $preparacion = $pdo->prepare($sentencia);
    $preparacion->execute();
    $datosIMTrans = $preparacion->fetchAll();

    if ($datosRecibidos["clienteProvisional"] === '1') {

        if ($datosRecibidos["clienteProvisionalExiste"] === '0') {

            $sentencia = "insert into vm_clientesprov (id_provis,nit_cliente,nombre,direccion,telefono,email,contacto,id_region,grabador) "
                . "values (null,'" . $datosRecibidos["datosClientePrisional"]["nit_cliente"] . "','" . $datosRecibidos["datosClientePrisional"]["nombre"] . "',"
                . "'" . $datosRecibidos["datosClientePrisional"]["direccion"] . "','" . $datosRecibidos["datosClientePrisional"]["telefono"] . "','" . $datosRecibidos["datosClientePrisional"]["email"] . "',"
                . "'" . $datosRecibidos["datosClientePrisional"]["contacto"] . "'," . $datosRecibidos["datosClientePrisional"]["id_region"] . ",'" . $_SESSION["codusr"] . "');";

            //echo $sentencia;

            $preparacion = $pdo->prepare($sentencia);
            $preparacion->execute();
            $id_provis = $pdo->lastInsertId();

            $datosRecibidos["nom_cliente"] = $datosRecibidos["datosClientePrisional"]["nombre"];
            $datosRecibidos["numid"] = $id_provis;
            $datosRecibidos["id_sucursal"] = $id_provis;
            $datosRecibidos["id_contacto"] = $id_provis;
        }

        if ($datosRecibidos["clienteProvisionalExiste"] === '1') {

            $id_provis = $datosRecibidos["id_provis"];

            $datosRecibidos["nom_cliente"] = $datosRecibidos["datosClientePrisional"]["nombre"];
            $datosRecibidos["numid"] = $id_provis;
            $datosRecibidos["id_sucursal"] = $id_provis;
            $datosRecibidos["id_contacto"] = $id_provis;
        }
    }

    if ($datosRecibidos["personaNatural"] === '1') {
        $sentencia = "select nm_sucursal.numid,nm_contactos.id_contacto,nm_contactos.nom_contacto "
            . "from nm_sucursal,nm_contactos "
            . "where nm_contactos.id_sucursal=nm_sucursal.id_sucursal "
            . "and nm_contactos.cc_contacto=" . $datosRecibidos["cc_contacto"] . ";";
        $preparacion = $pdo->prepare($sentencia);
        $preparacion->execute();
        $datosContactos = $preparacion->fetchAll();

        $datosRecibidos["nom_cliente"] = $datosContactos[0]["nom_contacto"];
        $datosRecibidos["numid"] = $datosRecibidos["cc_contacto"];
        $datosRecibidos["id_contacto"] = $datosContactos[0]["id_contacto"];
    }

    if (@$datosRecibidos["vp_asesor_zona"] === '-1') {
        @$sentencia = "insert into vr_requerim (id_requerim,id_fuente,nom_cliente,nit_cliente,suc_cliente,id_contacto,grupo,"
            . "de_linea,asesor_asignd,observs,estado,cod_grabador,area,cod_trans) "
            . "values (null," . $datosRecibidos["id_fuente"] . ",'" . $datosRecibidos["nom_cliente"] . "','" . $datosRecibidos["numid"] . "'," . $datosRecibidos["id_sucursal"] . ","
            . "" . $datosRecibidos["id_contacto"] . ",'" . $datosRecibidos["misional"] . "','" . $datosRecibidos["de_linea"] . "','','" . $datosRecibidos["observs"] . "',82,"
            . "'" . $_SESSION["codusr"] . "',0,'" . $datosIMTrans[0]["cod_trans"] . "');";
    } else {
        @$sentencia = "insert into vr_requerim (id_requerim,id_fuente,nom_cliente,nit_cliente,suc_cliente,id_contacto,grupo,"
            . "de_linea,asesor_asignd,observs,estado,cod_grabador,area,cod_trans) "
            . "values (null," . $datosRecibidos["id_fuente"] . ",'" . $datosRecibidos["nom_cliente"] . "','" . $datosRecibidos["numid"] . "'," . $datosRecibidos["id_sucursal"] . ","
            . "" . $datosRecibidos["id_contacto"] . ",'" . $datosRecibidos["misional"] . "','" . $datosRecibidos["de_linea"] . "','" . $datosRecibidos["vp_asesor_zona"] . "','" . $datosRecibidos["observs"] . "',82,"
            . "'" . $_SESSION["codusr"] . "',0,'" . $datosIMTrans[0]["cod_trans"] . "');";
    }

    //echo $sentencia; 
    //exit();

    $preparacion = $pdo->prepare($sentencia);
    $preparacion->execute();
    $id_requerim = $pdo->lastInsertId();

    //echo $id_requerim; exit();

    $sentencia = "update im_trans "
        . "set consec=" . $id_requerim . " "
        . "where cod_trans='" . $datosIMTrans[0]["cod_trans"] . "';";
    //echo $sentencia; exit();
    $preparacion = $pdo->prepare($sentencia);
    $preparacion->execute();

    $retorno["id_requerim"][0] = $id_requerim;

    //var_dump($datosRecibidos["textosIniciales"]);
    //echo count($datosRecibidos["textosIniciales"]);
    //exit();

    $id_mantenimientos = explode('|', $datosRecibidos["id_mantenimientos"]);

    if (isset($datosRecibidos["mantenimientoARealizar"])) {
        $mantenimientoARealizar = explode('|', $datosRecibidos["mantenimientoARealizar"]);
    }

    if (!isset($datosRecibidos["mantenimientoARealizar"])) {

        //para los repuestos       
        if (isset($datosRecibidos["textosIniciales"]) && count($datosRecibidos["textosIniciales"]) > 0) {

            for ($index = 0; $index < count($datosRecibidos["textosIniciales"]); $index++) {

                if (count($datosRecibidos["textosIniciales"][$index]) > 1) {

                    if ($datosRecibidos["textosIniciales"][$index]["cod_item"] !== '0') {
                        $sentencia = "insert into vr_requerimdet (id_reqdet,id_requerim,linea,misional,articulo,tipo,marca,cod_item,cantidad,observs,a_compras,modo_import) "
                            . "values (null," . $id_requerim . ",'" . $datosRecibidos["de_linea"] . "','02','" . $datosRecibidos["textosIniciales"][$index]["cod_grupo"] . "'," . $datosRecibidos["textosIniciales"][$index]["id_tipo"] . "," . $datosRecibidos["textosIniciales"][$index]["id_marca"] . ",'" . $datosRecibidos["textosIniciales"][$index]["cod_item"] . "','" . $datosRecibidos["cantidadesIniciales"][$index] . "','" . $datosRecibidos["notasIniciales"][$index] . "'," . $datosRecibidos["aCompras"][$index] . ",1);";
                        //echo $sentencia;
                        $preparacion = $pdo->prepare($sentencia);
                        $preparacion->execute();
                        $id_reqdet = $pdo->lastInsertId();

                        $retorno["id_reqdet"][$index] = $id_reqdet;

                        if (isset($datosRecibidos["caracteristicasRespuestos"][$index])) {

                            if (is_array($datosRecibidos["caracteristicasRespuestos"][$index])) {
                                for ($index1 = 0; $index1 < count($datosRecibidos["caracteristicasRespuestos"][$index]); $index1++) {
                                    $sentencia = "insert into vr_requerimcar (id_reqcar,id_requerim,id_reqdet,caract,vr_caract) "
                                        . "values (null," . $id_requerim . "," . $id_reqdet . ",'" . $datosRecibidos["clavesCaracteristicasRespuestos"][$index][$index1] . "','" . $datosRecibidos["caracteristicasRespuestos"][$index][$index1] . "');";                                        
                                    $preparacion = $pdo->prepare($sentencia);
                                    $preparacion->execute();
                                    $retorno["id_reqcar"][$index][$index1] = $pdo->lastInsertId();
                                }
                            }
                        }
                    }
                }
            }
        }

        //para los repuestos que no existen
        if (isset($datosRecibidos["repNoExiste"]) && count($datosRecibidos["repNoExiste"]) > 0) {

            for ($index = 0; $index < count($datosRecibidos["repNoExiste"]); $index++) {

                if ($datosRecibidos["repNoExiste"][$index][0] !== '0') {
                    $sentencia = "insert into vr_requerimdet (id_reqdet,id_requerim,linea,misional,articulo,tipo,marca,cod_item,cantidad,observs,a_compras,modo_import) "
                        . "values (null," . $id_requerim . ",'" . $datosRecibidos["de_linea"] . "','02',"
                        . "'" . $datosRecibidos["repNoExiste"][$index][0] . "'," . $datosRecibidos["repNoExiste"][$index][1] . ","
                        . "" . $datosRecibidos["repNoExiste"][$index][2] . ",'0','" . $datosRecibidos["cantidadesIniciales"][$index] . "',"
                        . "'" . $datosRecibidos["notasIniciales"][$index] . "'," . $datosRecibidos["aCompras"][$index] . ",1);";
                    $preparacion = $pdo->prepare($sentencia);
                    $preparacion->execute();
                    $id_reqdet = $pdo->lastInsertId();
                    $retorno["id_reqdet"][$index] = $id_reqdet;
                    if (isset($datosRecibidos["caracteristicasRespuestos"][$index])) {
                        if (is_array($datosRecibidos["caracteristicasRespuestos"][$index])) {
                            for ($index1 = 0; $index1 < count($datosRecibidos["caracteristicasRespuestos"][$index]); $index1++) {
                                $sentencia = "insert into vr_requerimcar (id_reqcar,id_requerim,id_reqdet,caract,vr_caract) "
                                    . "values (null," . $id_requerim . "," . $id_reqdet . ",'" . $datosRecibidos["clavesCaracteristicasRespuestos"][$index][$index1] . "','" . $datosRecibidos["caracteristicasRespuestos"][$index][$index1] . "');";
                                $preparacion = $pdo->prepare($sentencia);
                                $preparacion->execute();
                                $retorno["id_reqcar"][$index][$index1] = $pdo->lastInsertId();
                            }
                        }
                    }
                }
            }
        }

        //para los equipos o proyectos
        if (isset($datosRecibidos["textosEquipos"])) {
            for ($index = 0; $index < count($datosRecibidos["clvCaracteristicasEquipos"]); $index++) {
                $sentencia = "insert into vr_requerimdet (id_reqdet,id_requerim,linea,misional,articulo,tipo,marca,cod_item,cantidad,observs,a_compras,modo_import) "
                    . "values (null," . $id_requerim . ",'" . $datosRecibidos["clvCaracteristicasEquipos"][$index]["de_linea"] . "','" . $datosRecibidos["misional"] . "','" . $datosRecibidos["clvCaracteristicasEquipos"][$index]["im_items"] . "'," . $datosRecibidos["clvCaracteristicasEquipos"][$index]["ip_tipos"] . "," . $datosRecibidos["clvCaracteristicasEquipos"][$index]["ip_marcas"] . ",0," . $datosRecibidos["cantidadesEquiposEnviar"][$index] . ",'" . $datosRecibidos["observacionesEquiposEnviar"][$index] . "'," . $datosRecibidos["aCompras"][$index] . ",1);";
                $preparacion = $pdo->prepare($sentencia);
                $preparacion->execute();
                $id_reqdet = $pdo->lastInsertId();
                $retorno["id_reqdet"][$index] = $id_reqdet;
                if ($datosRecibidos["etiquetasEquipos"][$index] !== null) {
                    if (is_array($datosRecibidos["clavesEquipos"][$index])) {
                        for ($index1 = 0; $index1 < count($datosRecibidos["textosEquipos"][$index]); $index1++) {
                            $sentencia = "insert into vr_requerimcar (id_reqcar,id_requerim,id_reqdet,caract,vr_caract) "
                                . "values (null," . $id_requerim . "," . $id_reqdet . ",'" . $datosRecibidos["clavesEquipos"][$index][$index1] . "','" . $datosRecibidos["textosEquipos"][$index][$index1] . "');";
                            $preparacion = $pdo->prepare($sentencia);
                            $preparacion->execute();
                            $retorno["id_reqcar"][$index][$index1] = $pdo->lastInsertId();
                        }
                    }
                }
            }
        }
    } else {

        //para los servicios de mantenimiento        
        for ($index = 0; $index < count($id_mantenimientos); $index++) {

            //$id=$id_mantenimientos[$index];

            if (!empty($id_mantenimientos[$index])) {
                $sentencia = "SELECT sr_prog_mant.id_prog,sr_prog_mant.fecha_ini,sr_prog_mant.suc_cliente,sr_prog_mant.equipo,sr_prog_mant.cod_item,"
                    . "sr_prog_mant.nro_parte,sr_prog_mant.codactiv,sr_prog_mant.fec_ult_mant,im_items.linea,im_items.articulo,im_items.tipo_item,im_items.id_marca,"
                    . "im_items.cod_item "
                    . "FROM sr_prog_mant,im_items "
                    . "WHERE sr_prog_mant.cod_item=im_items.cod_item "
                    . "AND sr_prog_mant.id_prog=" . $id_mantenimientos[$index] . ";";
                //echo $sentencia;
                $preparacion = $pdo->prepare($sentencia);
                $preparacion->execute();
                $datosSRProgMant = $preparacion->fetchAll();
                $sentencia = "INSERT INTO vr_requerimdet (id_reqdet,id_requerim,linea,misional,articulo,tipo,marca,cod_item,cantidad,observs,a_compras,modo_import) "
                    . "values (null," . $id_requerim . ",'" . $datosSRProgMant[0]["linea"] . "','" . $datosRecibidos["misional"] . "','" . $datosSRProgMant[0]["articulo"] . "',"
                    . "" . $datosSRProgMant[0]["tipo_item"] . "," . $datosSRProgMant[0]["id_marca"] . ",'" . $datosSRProgMant[0]["cod_item"] . "',1,'" . $mantenimientoARealizar[$index] . "',0,1);";
                $preparacion = $pdo->prepare($sentencia);
                $preparacion->execute();
                $id_reqdet = $pdo->lastInsertId();
                $retorno["id_reqdet"][$index] = $id_reqdet;
                //echo $sentencia;
            }
        }
    }

    $result = $pdo->commit();

    if ($result) {
        //creación de alertas 3
        act_asesor($id_requerim);

        //buscar el asesor asignado 
        $sentencia = "SELECT am_usuarios.nombre "
            . "FROM am_alertas,am_usuarios "
            . "WHERE am_alertas.usuario_asignd=am_usuarios.codusr "
            ."AND am_alertas.id_proceso=$id_requerim";
        $preparacion = $pdo->prepare($sentencia);
        $preparacion->execute();
        $datosAlertas=$preparacion->fetchAll();

        if(count($datosAlertas)>0){
            $retorno["asesor_asignado"] = $datosAlertas[0]["nombre"];
        }else{
            $retorno["asesor_asignado"] = "-";
        }

        echo json_encode($retorno);
    }
} catch (Exception $e) {
    echo $e->getMessage();
    $pdo->rollBack();
    //$pdo->prepare("ROLLBACK");
    //$result=$preparacion->execute();
}

$pdo = null;
