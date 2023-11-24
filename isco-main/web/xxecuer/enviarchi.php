<?php
error_reporting(0);
include("../../session.php");
require"../fun_varios.php";
$uri=$_SESSION['url']; 
$qfasid = $_POST["val1"];

$url = $uri.'v2/index.php/gesinpol_quiz_fixed_actua_reg_ch_pxp';
$parametros="qfasid=".$qfasid;
$resp = resulrow($url, $parametros);
$json = array(); $img = '';
$rsp='<div class="alert alert-danger"><strong>Respuesta Incorrecta.</strong></div>';
$answerid = explode(",", $resp["pxp"]["answer"]);
$c=$cc=0; $fraction=0.00; $cont=1;
for($i=0;$i<$resp["pxp"]["tr"];$i++){
$ix=$i+1;
$imgx='img'.$ix;
if ($answerid[$i]>0){
if ($resp["pxp"]["imgr"][$i]==2){
$img = '<img class="imagen" src="assets/images/ai.svg" width="48" height="48" alt="Respuesta Correcta">';
$c++;
}else{
$img = '<img class="imagen" src="assets/images/ei.svg" width="48" height="48" alt="Respuesta Incorrecta">';
}
$cc++;
}else{
$img = "";	
}
if($c==$resp["pxp"]["trc"] && $c==$cc){$rsp='<div class="alert alert-success"><strong>Respuesta Correcta.</strong></div>';}
elseif($cont==$resp["pxp"]["tr"]){
	if($resp["pxp"]["qualify"]>$fraction){$rsp='<div class="alert alert-success"><strong>Respuesta Parcialmente Correcta.</strong></div>';}
	else{$rsp='<div class="alert alert-danger"><strong>Respuesta Incorrecta.</strong></div>';}
}
$cont++;
if ($i==0) $json["img1"]=$img;
elseif ($i==1) $json["img2"]=$img;
elseif ($i==2) $json["img3"]=$img;
elseif ($i==3) $json["img4"]=$img;
elseif ($i==4) $json["img5"]=$img;
elseif ($i==5) $json["img6"]=$img;
elseif ($i==6) $json["img7"]=$img;
elseif ($i==7) $json["img8"]=$img;
elseif ($i==8) $json["img9"]=$img;
elseif ($i==9) $json["img10"]=$img;
}//end for
$msg = "";
$rr=$resp["pxp"]["generalfeedback"];
$r=$resp["pxp"]["r"];
$prg = '<button class="btn btn-success l-turquoise waves-effect" type="button" data-toggle="collapse" data-target="#collapsePreg'.$resp["pxp"]["questionid"].'" aria-expanded="false" aria-controls="collapseExample"> MOSTRAR Solución </button>
		<div class="collapse" id="collapsePreg'.$resp["pxp"]["questionid"].'">
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

$json["msg"]=$msg;
$json["prg"]=$prg;
echo json_encode($json);
//$pri = ', "img1"=>$img1, "img2"=>$img2, "img3"=>$img3, "img4"=>$img4, "img5"=>$img5';
//echo $msg;
//echo json_encode(array("msg"=>$msg, "prg"=>$prg.$pri));
?>