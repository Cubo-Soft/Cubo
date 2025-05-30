<?php

define("GRUPONITS1", "SELECT nm_juridicas.numid,nm_juridicas.razon_social,nm_sucursal.telefono,nm_sucursal.direccion,nm_sucursal.ciudad,nm_sucursal.pais FROM nm_juridicas,nm_sucursal WHERE nm_juridicas.numid=nm_sucursal.numid  ");
//define("RETORNARCONTACTOS1","SELECT nm_nits.numid,nm_contactos.email,nm_contactos.id_contacto,nm_contactos.cc_contacto,nm_contactos.nom_contacto,nm_contactos.cargo,nm_contactos.tel_contacto,nm_sucursal.direccion,np_ciudades.nom_ciudad,np_deptos.nom_dpto,nm_contactos.estado,(SELECT concat(nm_personas.nombres,' ',nm_personas.apellidos) FROM nm_personas WHERE nm_personas.numid=nm_nits.numid) as personas,(SELECT nm_juridicas.razon_social FROM nm_juridicas WHERE nm_juridicas.numid=nm_nits.numid ) as juridicas FROM nm_contactos,nm_sucursal,nm_nits,np_paises,np_deptos,np_ciudades WHERE nm_nits.numid=nm_sucursal.numid AND nm_sucursal.id_sucursal=nm_contactos.id_sucursal AND np_paises.id_pais=np_deptos.id_pais AND np_deptos.id_dpto=np_ciudades.id_dpto AND nm_sucursal.ciudad=np_ciudades.id_ciudad ");
define("RETORNARCONTACTOS1","SELECT nm_nits.numid, nm_nits.idclase, nm_contactos.email, nm_contactos.id_contacto, nm_contactos.cc_contacto, nm_contactos.nom_contacto, nm_contactos.cargo, nm_contactos.tel_contacto, nm_sucursal.direccion, np_ciudades.nom_ciudad, np_deptos.nom_dpto, nm_contactos.estado, (SELECT concat(nm_personas.nombres,' ',nm_personas.apellidos) FROM nm_personas WHERE nm_personas.numid=nm_nits.numid) AS personas, (SELECT nm_juridicas.razon_social FROM nm_juridicas WHERE nm_juridicas.numid=nm_nits.numid ) AS juridicas, nm_sucursal.id_region, 
( SELECT nom_region FROM ap_regiones WHERE ap_regiones.id_region = nm_sucursal.id_region ) AS nom_region FROM nm_contactos,nm_sucursal,nm_nits,np_paises,np_deptos,np_ciudades WHERE nm_nits.numid=nm_sucursal.numid AND nm_sucursal.id_sucursal=nm_contactos.id_sucursal AND np_paises.id_pais=np_deptos.id_pais AND np_deptos.id_dpto=np_ciudades.id_dpto AND nm_sucursal.ciudad=np_ciudades.id_ciudad ");
define("IM_ITEMS1","SELECT im_items.cod_item,im_items.alter_item,UPPER(ip_grupos.nom_grupo) as nom_grupo,ip_grupos.cod_grupo,UPPER(ip_marcas.nom_marca) as nom_marca,ip_marcas.id_marca,im_items.precio_vta,UPPER(ip_tipos.descrip) as descrip,ip_tipos.id_tipo,UPPER(ip_modelos.descrip_modelo) as descrip_modelo,ip_modelos.id_modelo,UPPER(ip_dimen.nom_dimen) as nom_dimen,ip_dimen.id_dimen,UPPER(ip_unidades.nom_unidad) as nom_unidad,ip_unidades.cod_unidad,ir_salinve.saldo FROM im_items,ip_grupos,ip_marcas,ip_tipos,ip_modelos,ip_dimen,ip_unidades,ir_salinve WHERE im_items.grup_item=ip_grupos.cod_grupo AND im_items.id_marca=ip_marcas.id_marca AND im_items.tipo_item=ip_tipos.id_tipo AND im_items.modelo=ip_modelos.id_modelo AND im_items.dimensiones=ip_dimen.id_dimen AND im_items.unidad=ip_unidades.cod_unidad AND im_items.cod_item=ir_salinve.cod_item ");
//define("SUCURSALES1","select nm_sucursal.id_region,nm_sucursal.id_sucursal,nm_sucursal.numid,nm_sucursal.orden,nm_sucursal.direccion,nm_sucursal.telefono,nm_sucursal.telefono2,nm_sucursal.fax,nm_sucursal.ciudad,nm_sucursal.pais,UPPER(nm_sucursal.nom_sucur) as nom_sucur,nm_sucursal.suc_lat_gps,nm_sucursal.suc_lng_gps,nm_sucursal.cod_clie_helisa,nm_sucursal.cod_prv_helisa,nm_sucursal.estado,np_ciudades.nom_ciudad,np_paises.nom_pais FROM nm_sucursal,np_ciudades,np_paises where nm_sucursal.ciudad=np_ciudades.id_ciudad and nm_sucursal.pais=np_paises.id_pais ");
define("SUCURSALES1","SELECT nm_sucursal.id_region,nm_sucursal.id_sucursal,nm_sucursal.numid,nm_sucursal.orden,nm_sucursal.direccion,nm_sucursal.telefono,nm_sucursal.telefono2,nm_sucursal.fax,nm_sucursal.ciudad,nm_sucursal.pais,UPPER(nm_sucursal.nom_sucur) as nom_sucur,nm_sucursal.suc_lat_gps,nm_sucursal.suc_lng_gps,nm_sucursal.cod_clie_helisa,nm_sucursal.cod_prv_helisa,nm_sucursal.estado,np_ciudades.nom_ciudad,np_paises.nom_pais, (SELECT nom_region FROM ap_regiones WHERE id_region=nm_sucursal.id_region) AS nom_region FROM nm_sucursal,np_ciudades,np_paises where nm_sucursal.ciudad=np_ciudades.id_ciudad and nm_sucursal.pais=np_paises.id_pais ");
define("DTBASICOS1","SELECT ip_dtbasicos.id_basico,ip_dtbasicos.estado,UPPER(ip_dtbasicos.dt_basico) AS dt_basico,ip_dtbasicos.sec_basico FROM ip_dtbasicos ");

define("VRREQUERIM1", "
SELECT 
    UPPER(am_usuarios.nombre) AS nombre,
    vr_requerim.id_requerim,
    vr_requerim.fechora,
    vr_requerim.id_fuente,
    vr_requerim.nom_cliente,
    vr_requerim.suc_cliente,
    vr_requerim.id_contacto,
    vr_requerim.de_linea,
    vr_requerim.estado,

    -- Si sucursal no existe, mostrar 'Cliente Provisional'
    CASE 
        WHEN nm_sucursal.nom_sucur IS NULL THEN 'Cliente Provisional'
        ELSE UPPER(nm_sucursal.nom_sucur)
    END AS nom_sucur,

    -- Si ciudad no existe, mostrar 'Cliente Provisional'
    CASE 
        WHEN np_ciudades.nom_ciudad IS NULL THEN 'Cliente Provisional'
        ELSE np_ciudades.nom_ciudad
    END AS nom_ciudad,

    -- Contacto: primero se intenta con cliente provisional, si no, con nm_contactos
    COALESCE(vm_clientesprov.contacto, nm_contactos.nom_contacto) AS nom_contacto,

    ip_lineas.descrip,
    UPPER(ip_dtbasicos.dt_basico) AS textoFuente,
    (SELECT UPPER(dt_basico) FROM ip_dtbasicos WHERE sec_basico = vr_requerim.estado) AS textoEstado

FROM 
    vr_requerim
JOIN 
    am_usuarios ON vr_requerim.asesor_asignd = am_usuarios.codusr
LEFT JOIN 
    vm_clientesprov ON vr_requerim.nit_cliente = vm_clientesprov.nit_cliente
LEFT JOIN 
    nm_sucursal ON vr_requerim.suc_cliente = nm_sucursal.id_sucursal
LEFT JOIN 
    np_ciudades ON nm_sucursal.ciudad = np_ciudades.id_ciudad
LEFT JOIN 
    nm_contactos ON vr_requerim.id_contacto = nm_contactos.id_contacto
LEFT JOIN 
    ip_lineas ON vr_requerim.de_linea = ip_lineas.id_linea
LEFT JOIN 
    ip_dtbasicos ON vr_requerim.id_fuente = ip_dtbasicos.sec_basico
WHERE 
    (
        am_usuarios.codusr = 100 AND vr_requerim.asesor_asignd IS NULL 
        OR vr_requerim.asesor_asignd = am_usuarios.codusr 
    )
");

define("GRUPONITS3", "SELECT nm_juridicas.numid,nm_juridicas.razon_social,nm_sucursal.telefono,nm_sucursal.direccion,nm_sucursal.ciudad,nm_sucursal.pais FROM nm_juridicas,nm_sucursal,nm_nits WHERE nm_juridicas.numid=nm_sucursal.numid AND nm_nits.numid=nm_juridicas.numid ");
define("AMALERTAS1","select am_alertas.id_alerta,am_alertas.id_tipoalerta,am_alertas.id_proceso,am_alertas.fecha_ini,ap_tipoalerta.descrip_alert from am_alertas,ap_tipoalerta where am_alertas.id_tipoalerta=ap_tipoalerta.id_tipoalerta and am_alertas.id_estado=58 ");
define("AMUSUARIOS1","SELECT * FROM am_usuarios ");