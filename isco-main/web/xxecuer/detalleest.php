<?php
error_reporting(0);
include("../../session.php");
require"../fun_varios.php";
$uri=$_SESSION['url']; 
$userid=intval(trim($_SESSION["idmoodle"]));
$quizid = $_POST["val1"];
$attempt = $_POST["val2"];
$quizfixedid = $_POST["val3"];
$t=1;
	$ur2 = $uri.'v2/index.php/gesinpol_quiz_fixed_attempt_show';
	$parametro2 = "quizfixedid=".$quizfixedid."&attempt=".$attempt."&userid=".$userid;
	$tupl2 = resulrow($ur2, $parametro2);
	//$t=$tupl2["t"];
	$t=count($tupl2["quizfixedas"]);
	
	$pa = 0; $pc = 0; $pf = 0; $pb = 0; $fraction=0.00;  $ppa=$ppc=$ppf=$ppb=0;
	foreach($tupl2["quizfixedas"] as $tupla20){
	$answerss = $tupla20["answerid"];
	$answesid = explode(",", $answerss);
	$trs=count($answesid);
	if(is_null($answerss)){
		$pb++;
		if($tupla20["sequencenumber"]==1){
			$ur4 = $uri.'v2/index.php/gesinpol_quiz_fixed_attempt_answer_show';
			$parametro4 = "questionid=".$tupla20["questionid"]."&fraction=".$fraction;
			$tupl40 = resulrow($ur4, $parametro4);
			$trcc=$tupl40["trc"];
			if ($trcc==0){$pb--; $t--;}	
		}
	}else{
	$aa=0; $qualifys=0; $cc1=$ccc=0;
	$ur4 = $uri.'v2/index.php/gesinpol_quiz_fixed_attempt_answer_show';
	$parametro4 = "questionid=".$tupla20["questionid"]."&fraction=".$fraction;
	$tupl40 = resulrow($ur4, $parametro4);
	$trcc=$tupl40["trc"];
		foreach($tupl40["tuplas4"] as $tupla40){
			if (in_array($tupla40["id"], $answesid)){
			//if ($tupla40["id"]==$answesid["$aa"]) {
				if ($tupla40["fraction"]>$fraction){	
					$cc1++;
				}
				$qualifys=$qualifys+$tupla40["fraction"]; $ccc++;
			}
			if ($trs==1){}else{$aa++;}
		}
		if($cc1==$trcc && $cc1==$ccc){ $pa++; }
		else{ if($qualifys>$fraction){ $pc++; }else{ $pf++;}}
	}
	}
?>

<div class="alert alert-success" role="alert">
    <div class="container">
        <div class="alert-icon">
            <i class="zmdi zmdi-thumb-up"></i>
        </div>
        <strong>PREGUNTAS RESPONDIDAS ACERTADAS:</strong> <?PHP echo $pa; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">
                <i class="zmdi zmdi-close"></i>
            </span>
        </button>
    </div>
</div>
<div class="alert alert-warning" role="alert">
    <div class="container">
        <div class="alert-icon">
            <i class="zmdi zmdi-thumb-up"></i>
        </div>
        <strong>PREGUNTAS PARCIALMENTE ACERTADAS:</strong> <?PHP echo $pc; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">
                <i class="zmdi zmdi-close"></i>
            </span>
        </button>
    </div>
</div>
<div class="alert alert-danger" role="alert">
    <div class="container">
        <div class="alert-icon">
            <i class="zmdi zmdi-block"></i>
        </div>
        <strong>PREGUNTAS RESPONDIDAS NO ACERTADAS:</strong> <?PHP echo $pf; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">
                <i class="zmdi zmdi-close"></i>
            </span>
        </button>
    </div>
</div>
<div class="alert alert-info" role="alert">
    <div class="container">
        <div class="alert-icon">
            <i class="zmdi zmdi-alert-circle-o"></i>
        </div>
        <strong>PREGUNTAS SIN RESPONDER:</strong> <?PHP echo $pb; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">
                <i class="zmdi zmdi-close"></i>
            </span>
        </button>
    </div>
</div>
<hr />
  <div class="progress-container progress-success">
      <span class="progress-badge">Preguntas Respondidas Acertadas</span> <?PHP $ppa=($pa*100)/$t; ?>
      <div class="progress">
          <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?PHP echo $ppa; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?PHP echo $ppa; ?>%;">
              <span class="progress-value"><?PHP echo number_format($ppa, 2, ',', '.'); ?>%</span>
          </div>
      </div>
  </div>
  <div class="progress-container progress-warning">
      <span class="progress-badge">Preguntas Parcialmente Acertadas</span> <?PHP $ppc=($pc*100)/$t; ?>
      <div class="progress">
          <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?PHP echo $ppc; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?PHP echo $ppc; ?>%;">
              <span class="progress-value"><?PHP echo number_format($ppc, 2, ',', '.'); ?>%</span>
          </div>
      </div>
  </div>
  <div class="progress-container progress-danger">
      <span class="progress-badge">Preguntas Respondidas No Acertadas</span> <?PHP $ppf=($pf*100)/$t; ?>
      <div class="progress">
          <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?PHP echo $ppf; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?PHP echo $ppf; ?>%;">
              <span class="progress-value"><?PHP echo number_format($ppf, 2, ',', '.'); ?>%</span>
          </div>
      </div>
  </div>
  <div class="progress-container progress-info">
      <span class="progress-badge">Preguntas Sin Responder</span> <?PHP $ppb=($pb*100)/$t; ?>
      <div class="progress">
          <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?PHP echo $ppb; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?PHP echo $ppb; ?>%;">
              <span class="progress-value"><?PHP echo number_format($ppb, 2, ',', '.'); ?>%</span>
          </div>
      </div>
  </div>
