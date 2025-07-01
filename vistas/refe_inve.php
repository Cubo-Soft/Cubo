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

            <script src="../bower_components/inputmask/dist/jquery.inputmask.bundle.js" type="text/javascript"></script>             
            <script src="../js/comunes.js?ramdom=<?= time() ?>" type="text/javascript"></script>               
            <script src="../js/modelos/ip_dtbasicos.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/nm_contactos.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/np_ciudades.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/np_paises.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/nm_nits.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/nm_juridicas.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ip_lineas.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ip_tipos.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ip_marcas.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ip_articulos.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ip_unidades.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ip_voltajes.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ip_dimen.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ip_presiones.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ip_modelos.js?ramdom=<?= time() ?>" type="text/javascript"></script>            
            <script src="../js/modelos/nm_personas.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/nm_sucursal.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ip_grupos.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ir_caracte.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ir_salinve.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/vm_clientesprov.js?ramdom=<?= time() ?>" type="text/javascript"></script>            
            <script src="../js/modelos/vp_asesor_zona.js?ramdom=<?= time() ?>" type="text/javascript"></script>            
            <script src="../js/modelos/im_items.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/nm_compleme.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ap_regiones.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/vr_requerimdet.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/im_bodeg.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            <script src="../js/modelos/ap_camposx.js?ramdom=<?= time() ?>" type="text/javascript"></script>
            
            <script src="../js/vistas/refe_inve.js?ramdom=<?= time() ?>" type="text/javascript"></script>

            <!--<script src="../bower_components/jquery.elevatezoom.js" type="text/javascript"></script>-->

            <!-- inicio librerias datatables -->
            <link href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css"/>
            <script src="../bower_components/datatables.net/js/jquery.dataTables.min.js" type="text/javascript"></script>
            <script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js" type="text/javascript"></script>

            <!-- fin librerias datatables -->

        </head>
        <body style="background-color: #FFFFFF;">
            <input type="hidden" id="codprog" name="refe_inve" value="refe_inve" />            
            <input type="hidden" id="id_rol" name="id_rol" value='<?= $_SESSION["id_rol"] ?>' />
            <input type="hidden" id="codusr" name="codusr" value='<?= $_SESSION["codusr"] ?>' />     
            <input type="hidden" id="ap_camposx" name="ap_camposx" value="" />
            <input type="hidden" id="permisos" name="permisos" value="" />            
            <div id="container">
                <div class="box-body" id="divFormulario">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <strong>Referencias de inventario</strong>
                        </div>
                        <div class="box-body">
                            <div class="col-lg-12">
                               <div class="col-lg-2">
                                    <label>Referencia</label>
                                    <?php
                                        $datos['idDelCampo'] = 'cod_item';
                                        $datos['nombreLista'] = 'cod_item_1';
                                        $datos['idResultado'] = 'cod_item_2';
                                        $datos['nombreDataList'] = 'Items';
                                        $datos['textoPlaceHolder'] = 'Referencia';
                                        $datos['valorPorDefecto'] = '';
                                        echo retorarCodigoParaListaPHP($datos);
                                    ?>   
                               </div>
                               <div class="col-lg-2">
                                    <label>Referencia alterna</label>
                                    <?php
                                        $datos['idDelCampo'] = 'alter_item';
                                        $datos['nombreLista'] = 'alter_item_1';
                                        $datos['idResultado'] = 'alter_item_2';
                                        $datos['nombreDataList'] = 'ItemsDos';
                                        $datos['textoPlaceHolder'] = 'Referencia alterna';
                                        $datos['valorPorDefecto'] = '';
                                        echo retorarCodigoParaListaPHP($datos);
                                    ?>   
                               </div>
                               <div class="col-lg-4">
                               <label>Número de parte</label>
                                    <input type="text" id="num_parte" name="num_parte" class="form form-control" onkeyup="javascript:this.value = this.value.toUpperCase();" placeholder="Número de parte" />
                               </div>
                               <div class="col-lg-4">
                                    <label>Nombre</label>
                                    <input type="text" id="nom_item" name="nom_item" class="form form-control" onkeyup="javascript:this.value = this.value.toUpperCase();" placeholder="Nombre artículo" />
                                </div>                                                              
                            </div>     
                            <div class="col-lg-12">
                                <div class="col-lg-2">
                                    <label id="lbl_iva">IVA</label>
                                    <input type="number" id="iva" name="iva" class="form form-control" placeholder="Valor IVA"/>
                               </div>
                               <div class="col-lg-5">
                                    <label id="lbl_precio_vta">Precio venta</label>
                                    <input type="number" id="precio_vta" name="precio_vta" class="form form-control" placeholder="Predio venta"/>
                               </div>                
                                <div class="col-lg-5">
                                    <label id="lbl_precio_vta_usd" >Precio Vta. USD</label>
                                    <input type="number" id="precio_vta_usd" name="precio_vta_usd" class="form form-control" placeholder="Predio venta USD"/>
                                </div>                
                            </div>                            
                            <div class="col-lg-12">                                         
                                    <div class="col-lg-10">
                                        <label>Proveedor</label>
                                        <?php
                                        $datos['idDelCampo'] = 'nombre_persona';
                                        $datos['nombreLista'] = 'nombre_persona_1';
                                        $datos['idResultado'] = 'nombre_persona_2';
                                        $datos['nombreDataList'] = 'NombrePersona';
                                        $datos['textoPlaceHolder'] = 'Nombre';
                                        $datos['valorPorDefecto'] = '';
                                        echo retorarCodigoParaListaPHP($datos);
                                    ?>                                          
                                        <input type="hidden" id="numid" name="numid" value="0" />
                                        <input type="hidden" id="id_proveedor" name="id_proveedor" value="0"/>
                                        </div>
                            </div>       
                            <div class="col-lg-12" id="divSucursales">
                                
                            </div>   
                            <div class="col-lg-12">
                                <div class="col-lg-2">
                                    <label>Unidad desgaste</label>
                                    <input type="number" id="unid_desgaste" name="unid_desgaste" class="form form-control" onkeyup="javascript:this.value = this.value.toUpperCase();" placeholder="Unidad desgaste" />
                                </div>
                                <div class="col-lg-2">
                                    <label>Cantidad desgaste</label>
                                    <input type="number" id="cant_desgaste" name="cant_desgaste" class="form form-control" onkeyup="javascript:this.value = this.value.toUpperCase();" placeholder="Cantidad desgaste" />
                                </div>
                                <div class="col-lg-2">
                                <label>Peso</label>
                                    <input type="number" id="peso" name="peso" class="form form-control" placeholder="Peso"/>
                                </div>
                                <div class="col-lg-2">
                                <label>Volumen</label>
                                    <input type="number" id="volumen" name="volumen" class="form form-control" placeholder="Volumen"/>
                                </div>
                                <div class="col-lg-2">
                                <label>Máximo</label>
                                    <input type="number" id="maximo" name="maximo" class="form form-control" placeholder="Máximo" />
                                </div>
                                <div class="col-lg-2">
                                <label>Mínimo</label>
                                    <input type="number" id="minimo" name="minimo" class="form form-control" placeholder="Mínimo" />
                                </div>
                            </div>
                            <div class="col-lg-12">
                               <div class="col-lg-2">
                                    <label>Marca</label>
                                    <div id="divMarcas1"></div>
                               </div>
                               <div class="col-lg-2">
                               <label>Unidad</label>
                                    <div id="divUnidadMedida1"></div>
                               </div>
                               <div class="col-lg-2">
                               <label>Grupo</label>
                                    <div id="divGrupos"></div>
                               </div>
                               <div class="col-lg-2">
                                    <label>Facturable</label>
                                    <div id="divFacturable">
                                        <select class="form form-control" id="facturable" name="facturable">                                            
                                            <option value="1">SI</option>
                                            <option value="1">NO</option>
                                        </select>
                                    </div>
                               </div>
                               <div class="col-lg-2">
                                    <label>Area item</label>
                                    <div id="divAreaItem"></div>
                               </div>
                               <div class="col-lg-2">
                                    <label>Artículo</label>
                                    <div id="divArticulos1"></div>
                               </div>
                            </div>                 
                            <div class="col-lg-12">
                               <div class="col-lg-2">
                                    <label>Tipo</label>
                                    <div id="divTipos1"></div>
                               </div>
                               <div class="col-lg-2">
                               <label>Modelo</label>
                                    <div id="divModelos"></div>
                               </div>
                               <div class="col-lg-2">
                               <label>Línea</label>
                                    <div id="divLineas"></div>  
                               </div>
                               <div class="col-lg-2">
                               <label>Dimensiones</label>
                                    <div id="divDimensiones"></div>
                               </div>
                               <div class="col-lg-2">
                               <label>Estado</label>
                                    <div id="divEstado"></div>     
                               </div>
                               <div class="col-lg-2">
                               
                               </div>
                            </div>                                             
                            <div class="col-lg-12">                              
                               <?php 
                                    $datos["tamanio"]=4;
                                    $datos["nombreDivInterno"]="CrearFotoRepuesto";
                                    $datos["nombreDivExterno"]="SubirFoto";
                                    echo retornarSeccionFoto($datos,1);
                               ?>                                                  
                               <div class="col-lg-4" id="divFoto">                                    
                               </div>                               
                               <div class="col-lg-2">
                                    
                               </div>
                            </div> 
                            <div class="col-lg-12" id="mensajesUsuario">

                            </div>                            
                            <div class="col-lg-12">                                
                                    <input type="button" value="Crear" id="crear" class="btn btn-success"/>
                                    <input type="button" value="Listar" id="listar" class="btn btn-success"/>
                                    <input type="button" value="Actualizar datos generales" id="actualizar"  class="btn btn-warning"/>
                                    <input type="button" value="Iniciar actualizar foto" id="actualizarFoto"  class="btn btn-default"/>                               
                                    <input type="button" value="Limpiar"  onclick="redirigir(null,6)" class="btn btn-info" />                               
                            </div>                           
                        </div>                        
                    </div>
                </div>
                <div class="box-body" id="divListado">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <strong>Listado repuestos</strong>
                        </div>
                        <div class="box-body">
                            <div class="col-lg-12" id="divListadoRepuestos">

                            </div>
                            <div class="col-lg-12" id="mensajeListado">
                                <div class="alert alert-warning">Cargando información...</div>
                            </div>
                            <div class="col-lg-12">
                            <input type="button" value="Mostrar formulario" id="mostrarFormulario" class="btn btn-success"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
    </html>
    <?php
} else {
    header("Location: ../index.php");
}
?>