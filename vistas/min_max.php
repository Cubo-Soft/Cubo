<?php
session_start();
//$_SESSION['id_rol']=1;
if(!isset($_SESSION['id_rol'])){
  unset($_SESSION);
  session_destroy();
  header("location:index.php");
}

include_once("../css/def.php");
define("C",$_SERVER['DOCUMENT_ROOT'].$direc);
include_once(C."/cls/clsTablam.php");
include_once(C."/cls/cls_ar_roles.php");
include_once(C."/cls/clsBasicos.php");
if($motor=="my"){
    include_once(C."/cls/clsBdmy.php");
}
date_default_timezone_set("America/Bogota");
$titulo = "Mínimos y Máximos de Inventario";
$odb = new Bd($h,$pto,$u,$p,$d);
$items = new Tabla($odb,"im_items");
$nits = new Tabla($odb,"nm_nits");
$sucursales = new Tabla($odb,"nm_sucursal");
$personas = new Tabla($odb,"nm_personas");
$juridicas = new Tabla($odb,"nm_juridicas");
$grupos = new Tabla($odb,"ip_grupos");
$marcas = new Tabla($odb,"ip_marcas");
$lineas = new Tabla($odb,"ip_lineas");
$articulos = new Tabla($odb,"ip_articulos");
$tipos = new Tabla($odb,"ip_tipos");
$basicos = new clsBasicos($odb,"ip_basicos");
$dtbasic = new Tabla($odb,"ip_dtbasicos");
$bsbasic = new Tabla($odb,"ip_basicos_tab");
$tparam = new Tabla($odb,"ap_param");
$aempre = $tparam->leec("valor"," WHERE variable='nomempre'"); 
$a_entidad = $basicos->ejec("SELECT sec_basico,dt_basico FROM ip_dtbasicos WHERE id_basico IN (
            SELECT id_basico FROM ip_basicos WHERE descrip ='Tipo de Entidad') 
            AND sec_basico IN ( SELECT DISTINCT tipo_entidad FROM nm_nits )
            ORDER BY sec_basico ","S","A");

$sql = "SELECT DISTINCT i.id_marca, m.nom_marca FROM im_items i JOIN ip_marcas m ON m.id_marca=i.id_marca";
$a_marcas = $marcas->ejec($sql,"S","A");
?>
<!DOCTYPE html>
<html lang='es'>
    <head>
      <meta charset='UTF-8'>
      <meta http-equiv='X-UA-Compatible' content='IE=edge'>
      <meta name='viewport' content='width=device-width, initial-scale=1.0'>
      <title><?php echo $titulo ?></title>
      <link rel='stylesheet' type='text/css' href='../css/bootstrap.min.css'>
      <link rel="stylesheet" href="../css/ppal.css">
      <script src="../js/jquery_dvlp_3_7_1.js"></script>
      <style type='text/css'>
        .btn-flota{
            position: fixed;
            width:100px;
            left:300px;
        }

        .titulo-flota{
            position: fixed;
            /* width:100px;
            left:300px; */
        }
      </style>
      <script >
      function inicio(){
        document.location.href="<?php echo $_SERVER['PHP_SELF'] ?>";
      }
      </script>
    </head>
    <body>
        <div class="conteiner marco_ppal" id="divcriterios">
        <?php
            include("./adiciones/cabeza.php");
        ?>
            <form action="" method="POST">
                <H5>Indique los criterios de búsqueda:</H5>
                <div class="row">                    
                    <div class="col-sm-4 etiqueta">
                    <label for="id_entidad" >Por Tipo Entidad: </label>
                    </div>
                    <div class="col-sm-8">
                        <select name="entidad" id="id_entidad" onchange="obt_entidad();" class="form-select form-select-sm">
                            <option value="">...</option>
                            <option value="0">Todos</option>
                            <?php
                            for($x=0;$x<count($a_entidad);$x++){
                                echo "<option value='".$a_entidad[$x]['sec_basico']."'>".$a_entidad[$x]['dt_basico']."</option>";
                            }   
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">                    
                    <div class="col-sm-4 etiqueta">
                    <label for="idproveedor" >Por Proveedor: </label>
                    </div>
                    <div class="col-sm-8">
                        <select name="proveedor" id="idproveedor" class="form-select form-select-sm">
                            <option value="">...</option>
                        </select>
                    </div>
                </div>
                <div class="row">                    
                    <div class="col-sm-4 etiqueta">
                    <label for="idmarca" class="etiqueta">Por Marca: </label>
                    </div>
                    <div class="col-sm-8">
                        <select name="marca" id="idmarca" class="form-select form-select-sm">
                            <option value="">Todos</option>
                            <?php
                            for($x=0;$x<count($a_marcas);$x++){
                                echo "<option value='".$a_marcas[$x]['id_marca']."'>".$a_marcas[$x]['nom_marca']."</option>";
                            }   
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">                    
                    <div class="col-sm-4 etiqueta">
                    <label for="idtope" class="etiqueta">Por Mínimo o Máximo: </label>
                    </div>
                    <div class="col-sm-8">
                        <select name="tope" id="idtope" class="form-select form-select-sm">
                            <option value="0">Todos</option>
                            <option value="n">Mínimos</option>
                            <option value="x">Máximos</option>
                        </select>
                    </div>
                </div>
                <div class="row">                    
                    <div id="col-sm-6">
                        <button type="button" class="btn btn-primary" id="btn1" onclick="busca();">Consultar</button>
                    </div>
                    <div class="col-sm-6"></div>
                </div>
            </form>
        </div>
        <div class="conteiner table-responsive-sm" id="divresultado">
            <div class='btn-flota'>
               <button type='button' onclick='inicio();' class='btn btn-primary' >Regresar</button>
            </div>

        <table class='table table-striped table-hover table-bordered table-sm table-responsive-sm caption-top'>
            <caption><div class="row">
                    <div class="col-sm-6"><H4><?php echo $titulo ?></H4></div>
                    <div class="col-sm-4" id="divcuantos"></div>
                    <div class="col-sm-2" id="divfechora"><?php echo date('Y-m-d H:i:s') ?></div>
                </div></caption>
            <thead class='bg-primary' style='color:#FFF'>
                <tr>
                    <th>#</th>
                    <th>Código</th>
                    <th>Código Proveed</th>
                    <th>Descripción</th>
                    <th>Proveedor</th>
                    <th>Marca</th>
                    <th>Línea</th>
                    <th>Artículo</th>
                    <th>Tipo</th>
                   <!--  <th>Iva</th>
                    <th>Vr. Vta</th>
                    <th>Vr. Vta US</th> -->
                    <th>Min</th>
                    <th>Max</th>
                    <th>Saldo Alm.Pal</th>                    
                </tr>
            </thead>
            <tbody id="bodyrest">                         
            </tbody>
        </div>
        <script src='../js/bootstrap.bundle.min.js'></script>
        <script src="../js/vistas/min_max.js?ramdom=<?= time() ?>"></script>
    </body>
</html>