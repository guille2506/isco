<?php
error_reporting(0);
include("../../session.php");
require"../fun_varios.php";
$uri=$_SESSION['url']; 
$qfasid = $_POST["val1"];
$idp 	= $_POST["val2"];
$marca 	= $_POST["val3"];

$url = $uri.'v2/index.php/gesinpol_quiz_fixed_actua_reg_m';
$parametros="qfasid=".$qfasid."&marca=".$marca;
$resp = resulrow($url, $parametros);
if ($marca==2){
	$msg = '<a href="javascript:enviarMarca_'.$idp.'('.$qfasid.', '.$idp.', 1);" class="btn btn-warning btn-block btn-lg waves-effect" id="mp1" title="Desmarcar Pregunta">Desmarcar Pregunta</a><br />';
}else{
	$msg = '<a href="javascript:enviarMarca_'.$idp.'('.$qfasid.', '.$idp.', 2);" class="btn btn-warning btn-block btn-lg waves-effect" id="mp1" title="Marcar Pregunta">Marcar Pregunta</a><br />';	
}

//$msg = "Respuesta guardada";
//echo $rr=$resp["marcar"]["marca"];

//$r=$resp["actresr"]["answer"];

//$prg = "rep";
echo $msg;
//echo "<pre>";
//print_r($resp);
//echo "</pre>";
//echo $re=$resp["marcar"]["marks"];
//echo json_encode(array("msg"=>$msg, "img"=>$img, "prg"=>$prg));
?>