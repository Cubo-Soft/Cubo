<?php
include_once(C."/css/def.php");
define("C",$_SERVER['DOCUMENT_ROOT'].$direc);
include(C."../cls/clsTablam.php");
include_once(C."../cls/clsItems.php");
if($motor=="my"){
    include(C."../cls/clsBdmy.php");
}


//print_r($_REQUEST);
$tabla = $_REQUEST['tabla'];
if(isset($_REQUEST['where'])){
    $where = $_REQUEST['where'];
    $ar0 = explode(',',$where);
    //echo "<pre>";print_r($ar0);echo "</pre>";
    $arr = [];
    for($n=0;$n<count($ar0);$n++){
        $av = explode("=",$ar0[$n]);
        $arr[$av[0]] = $av[1]; 
    }
}else{
    $arr=[];
}
echo "<pre>";print_r($arr);echo "</pre>";

$odb = new Bd($h,$pto,$u,$p,$d);
//$tbl = new Tabla($odb,$tabla);
$titems = new clsItems($odb);
$res = $titems->leeCon($arr);
print_r($res);
echo json_encode($res);
?>