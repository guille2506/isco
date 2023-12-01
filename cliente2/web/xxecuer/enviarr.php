<?php
error_reporting(0);
include("../../session.php");
require"../fun_varios.php";
$uri=$_SESSION['url']; 
$respid = $_POST["val1"];
$totalp = $_POST["val2"];
$qfasid = $_POST["val3"];

$url = $uri.'v2/index.php/gesinpol_quiz_fixed_actua_reg_r';
$parametros="qfasid=".$qfasid."&totalp=".$totalp."&respid=".$respid;
$resp = resulrow($url, $parametros);
$img = '<img class="imagen" src="assets/images/ei.svg" width="48" height="48" alt="Respuesta Incorrecta">';
$rsp='<div class="alert alert-danger"><strong>Respuesta Incorrecta.</strong></div>';
if ($resp["actresr"]["imgr"]==1){
$img = '<img class="imagen" src="assets/images/ai.svg" width="48" height="48" alt="Respuesta Correcta">';
$rsp='<div class="alert alert-success"><strong>Respuesta Correcta.</strong></div>';
}
$msg = "Respuesta guardada";
$rr=$resp["actresr"]["generalfeedback"];
$r=$resp["actresr"]["answer"];
$prg = '<button class="btn btn-success l-turquoise waves-effect" type="button" data-toggle="collapse" data-target="#collapsePreg'.$resp["actresr"]["questionid"].'" aria-expanded="false" aria-controls="collapseExample"> MOSTRAR Solución </button>
		<div class="collapse" id="collapsePreg'.$resp["actresr"]["questionid"].'">
		<div class="panel-footer">
		   <div class="feedback">
			  <div class="specificfeedback">'.$rsp.'</div>
			  <div class="rightanswer  alert alert-primary" role="alert">
                      <div class="container">
                          <div class="alert-icon">
                              <i class="zmdi zmdi-notifications"></i>
                          </div>
                          <strong><small>La Respuesta Correcta es: </small></strong> '.$r.'
                      </div>
                  </div>
			  <div class="generalfeedback">'.$rr.'</div>
		   </div>
		</div>
		</div>
';
//$prg = "rep";
//echo $msg;
echo json_encode(array("msg"=>$msg, "img"=>$img, "prg"=>$prg));
?>