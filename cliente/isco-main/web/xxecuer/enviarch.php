<?php
error_reporting(0);
include("../../session.php");
require"../fun_varios.php";
$uri=$_SESSION['url']; 
$respid = $_POST["val1"];
$totalp = $_POST["val2"];
$qfasid = $_POST["val3"];
$cardid = $_POST["val4"];
$valuech = $_POST["val5"];

$url = $uri.'v2/index.php/gesinpol_quiz_fixed_actua_reg_ch_r';
$parametros="qfasid=".$qfasid."&totalp=".$totalp."&respid=".$respid."&cardid=".$cardid."&valuech=".$valuech;
$resp = resulrow($url, $parametros);
$img = '<img class="imagen" src="assets/images/ei.svg" width="48" height="48" alt="Respuesta Incorrecta">';
$rsp='<div class="alert alert-danger"><strong>Respuesta Incorrecta.</strong> <small>La Respuesta Correcta es:</small></div>';
if ($resp["actresr"]["imgr"]==1){
//$img = '<img class="imagen" src="assets/images/ai.svg" width="48" height="48" alt="Respuesta Correcta">';
$rsp='<div class="alert alert-success"><strong>Respuesta Correcta.</strong></div>';
}
$msg = "Respuesta guardada";
$rr=$resp["actresr"]["generalfeedback"]."----------";
$r=$resp["actresr"]["answer"];
$prg = '<button class="btn btn-success l-turquoise waves-effect" type="button" data-toggle="collapse" data-target="#collapsePreg'.$resp["actresr"]["questionid"].'" aria-expanded="false" aria-controls="collapseExample"> MOSTRAR Solución </button>
		<div class="collapse" id="collapsePreg'.$resp["actresr"]["questionid"].'">
		<div class="panel-footer">
		   <div class="feedback">
			  <div class="specificfeedback">'.$rsp.'</div>
			  <div class="generalfeedback">'.$rr.'</div>
			  <div class="rightanswer"><i class="fa fa-angle-double-right"></i>'.$r.'</div>
		   </div>
		</div>
		</div>
';
$val=$resp["actresr"]["valuech"];
$cor='<a href="javascript:enviarCorregir_'.$resp["actresr"]["idp"].'('.$qfasid.');" class="btn btn-warning text-white" id="cp1" title="Corregir Pregunta">Corregir Pregunta</a><br />';
//$prg = "rep";
//echo $msg;
echo json_encode(array("msg"=>$msg, "cor"=>$cor));
?>