<?php
session_start();

header("Access-Control-Allow-Origin: https://titaninmochem.com/cubo/");

if (!isset($_SESSION["estado"])) {
    header("Location: ../index.php");
} else if ($_SESSION["estado"] === 'Activo') {
    include_once '../adicionales/varios.php';
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <?= retornarCabeceraInicial("Cubo") ?>
            <!-- inicio librería mapa -->
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"/>
            <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>   
            <!-- fin libreria mapa -->
            <script src="../js/comunes.js?ramdom=<?= time() ?>" type="text/javascript"></script>                
            <script src="../js/modelos/np_ciudades.js?ramdom=<?= time() ?>" type="text/javascript"></script>            
            <script src="../js/modelos/nm_sucursal.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/np_activeco.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/nm_nits.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/nm_contactos.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/np_tiponit.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ip_dtbasicos.js?ramdom=<?= time() ?>"" type="text/javascript"></script>
            <script src="../js/modelos/nm_personas.js?ramdom=<?= time() ?>"" type="text/javascript"></script>
            <script src="../js/modelos/nm_empleados.js?ramdom=<?= time() ?>"" type="text/javascript"></script>
            <script src="../js/modelos/am_usuarios.js?ramdom=<?= time() ?>"" type="text/javascript"></script>
            <script src="../js/modelos/nm_juridicas.js?ramdom=<?= time() ?>"" type="text/javascript"></script>            
            <script src="../js/modelos/nm_compleme.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/np_cargos.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ap_regiones.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/vistas/admon_clie.js?ramdom=<?= time() ?>" type="text/javascript"></script>
        </head>
        <body class="hold-transition skin-blue sidebar-mini">
            <input type="hidden" id="existe" name="existe" value="1" />                        
            <input type="hidden" id="id_rol" name="id_rol" value='<?= $_SESSION["id_rol"] ?>' />
            <input type="hidden" id="codprog" name="codprog" value="admon_clie" />            
            <div id="container">
                <section class="content-header">
                    <h3>Administración de entidades</h3>
                </section>                 
                <div class="box-body">                                         
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <strong>Datos iniciales</strong>
                        </div>
                        <div class="box-body">                            
                            <div class="col-lg-12" id="mensajes"></div>                            
                            <div class="col-lg-12">  

                                <div class="col-lg-4 form-group">
                                    <label>Tipo de entidad</label>
                                    <div id="divTipoEntidad"></div>
                                </div>

                                <div class="col-lg-4 form-group">
                                    <label>Tipo de identificación</label>
                                    <div id="divTipoNIT">                                        

                                    </div>
                                </div>                                
                                <div class="col-lg-4 form-group">                                       
                                    <div id="divCCContactos" class="row">                                                            
                                        <div class="col-xs-8">
                                            <label>Nro. de identificación</label>
                                            <?php
                                            $datos['idDelCampo'] = 'numid';
                                            $datos['nombreLista'] = 'nm_nits';
                                            $datos['idResultado'] = '';
                                            $datos['nombreDataList'] = 'NMNits';
                                            $datos['textoPlaceHolder'] = 'Nro. de identificación';
                                            $datos['valorPorDefecto'] = '0';
                                            echo retorarCodigoParaListaPHP($datos);
                                            ?>
                                        </div>
                                        <div class="col-xs-4">
                                            <label>DV</label>                                            
                                            <input type="number" id="dv" class="form form-control"  disabled value="0" />
                                        </div>
                                    </div>
                                </div>                                 
                            </div>
                            <div class="col-lg-12">  
                            <div class="col-lg-4 form-group">
                                    <label>Tipo de persona</label>
                                    <div id="divTipoDePersona"></div>
                                </div>                              
                                <?php
                                $datos['idDelCampo'] = 'nombre_empresa';
                                $datos['nombreLista'] = 'nombreEmpresa';
                                $datos['idResultado'] = 'num_id';
                                $datos['nombreDataList'] = 'Empresas';
                                $datos['textoPlaceHolder'] = 'Nombre';
                                $datos['valorPorDefecto'] = '';
                                //retorarCodigoParaListaPHP($datos);
                                ?>                                                            
                                <div class="col-lg-4 form-group">
                                    <label>Actividad</label>
                                    <div id="divActividades"></div>
                                </div>
                                <div class="col-lg-4 form-group" id="divSuperiorEstadoEntidad">
                                    <label>Estado</label>
                                    <div id="divEstadoEntidad"></div>
                                </div>
                            </div>                            
                            <div class="col-lg-12">
                                <input type="button" value="Modificar"  class="btn btn-primary" id="modificarClientes"/>
                                <input type="button" value="Adicionar"  class="btn btn-success" id="crearClientes"/>                                
                                <input type="button" value="Limpiar"  class="btn btn-info" id="nuevaBusqueda" onclick="location.reload();" />
                            </div>
                        </div>
                    </div>
                </div>
                <!--<div class="box-body" id="divEmpleados">
                    <div class="box box-default">
                        <div class="box header with-border">
                            <strong>Empleados</strong>
                        </div>
                        <div class="box-body">
                            <div class="col-lg-12" id="listaEmpleados">
        
                            </div>
                            <div class="col-lg-12" id="datosEmpleados">
                                <div class="col-lg-12">
                                    <div class="col-lg-12 form-group">                
                                        <label>Nombre</label>
                                        <div id="divRazonSocial">                                
                                            <input type="text" id="razon_social" name="razon_social" class="form form-control" onkeyup="javascript:this.value = this.value.toUpperCase();" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12" id="mensajesEmpleados">
        
                                </div>
                                <div class="col-lg-12">
                                    <input type="button" value="Modificar" id="modificarEmpleado" class="btn btn-primary" />
                                    <input type="button" value="Adicionar" id="adicionarEmpleado" class="btn btn-success" />                                    
                                    <input type="button" value="Listar empleados" id="listarEmpleados" class="btn btn-info" />                            
                                </div>
                            </div>
                        </div>
                    </div>
                </div>   -->

                <div class="box-body" id="divComplementosNIT">
                    <div class="box box-default">
                        <div class="box header with-border">
                            <strong>Complementos</strong>
                        </div>
                        <div class="box-body">
                            <div class="col-lg-12" id="listaComplementosNIT">

                            </div>
                            <div class="col-lg-12" id="datosComplementosNIT">
                                <inpu type="hidden" id="id_comple" name="id_comple" value="0" />

                                <div class="col-lg-12 form-group">                
                                    <label>Crédito</label>
                                    <div id="divCredito">                                
                                        <input type="text" id="credito" name="credito" class="form form-control" onkeyup="javascript:this.value = this.value.toUpperCase();" />
                                    </div>
                                </div>
                                <div class="col-lg-12 form-group">                
                                    <label>Factura despacho</label>
                                    <div id="divCredito">                                
                                        <input type="text" id="factu_despacho" name="factu_despacho" class="form form-control" onkeyup="javascript:this.value = this.value.toUpperCase();" />
                                    </div>
                                </div>
                                <div class="col-lg-12 form-group">                
                                    <label>Documentos para facturar</label>
                                    <div id="divCredito">                                
                                        <input type="text" id="docs_pra_facturar" name="docs_pra_facturar" class="form form-control" onkeyup="javascript:this.value = this.value.toUpperCase();" />
                                    </div>
                                </div>


                                <div class="col-lg-12 form-group">                
                                    <label>Cierre factura</label>
                                    <div id="divCredito">                                
                                        <input type="text" id="cierre_factu" name="cierre_factu" class="form form-control" onkeyup="javascript:this.value = this.value.toUpperCase();" />
                                    </div>
                                </div>
                                <div class="col-lg-12 form-group">                
                                    <label>Área contacto</label>
                                    <div id="divCredito">                                
                                        <input type="text" id="area_contacto" name="area_contacto" class="form form-control" onkeyup="javascript:this.value = this.value.toUpperCase();" />
                                    </div>
                                </div>
                                <div class="col-lg-12 form-group">                

                                </div>

                                <div class="col-lg-12" id="mensajesComplementosNIT">

                                </div>
                                <div class="col-lg-12">
                                    <input type="button" value="Modificar" id="modificarComplementosNIT" class="btn btn-primary" />
                                    <input type="button" value="Adicionar" id="adicionarComplementosNIT" class="btn btn-success" />                                    
                                    <input type="button" value="Listar complementos" id="listarComplementosNIT" class="btn btn-info" />                           
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?= retornarDivJuridicas(1); ?>                    
                <?= retornarDivPersonasGeneral() ?>                
                <?= retornarDivSucursalesGeneral() ?>
                <?= retornarDivContactosGeneral(1) ?>             
                <?=  retornarDivEmpleados(1) ?>
                <?= retornarDivUsuarios(1) ?>
            </div>           
        </body>
    </html>
    <?php
} else {
    header("Location: ../index.php");
}
?>