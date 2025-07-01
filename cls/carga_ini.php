<?php
require("../css/def.php");
define("C",$_SERVER['DOCUMENT_ROOT'].$direc);
require(C."/cls/clsTablam.php");
if($motor=="my"){
    require(C."/cls/clsBdmy.php");
}
$odb = new Bd($h,$pto,$u,$p,$d);
?>