<style>
.accesshide {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0,0,0,0);
    white-space: nowrap;
    border: 0;
}
.qnbutton .thispageholder {
    border: 1px solid;
    border-radius: 3px;
    z-index: 1;
}
.qnbutton .trafficlight, .qnbutton .thispageholder {
    display: block;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
}

.qnbutton {
    text-decoration: none;
    font-size: 14px;
    line-height: 20px;
    font-weight: 400;
    background-color: #fff;
    background-image: none;
    height: 40px;
    width: 30px;
    border-radius: 3px;
    border: 0;
    overflow: visible;
    margin: 0 6px 6px 0;
}

.qnbutton {
    display: block;
    position: relative;
    float: left;
    /*width: 1.5em;
    height: 1.5em;
    overflow: hidden;*/
    margin: .3em .3em .3em 0;
    padding: 0;
    border: 1px solid #bbb;
    background: #ddd;
    text-align: center;
    line-height: 1.5em;
    font-weight: 700;
    text-decoration: none;
}

.qnbutton.answersaved .trafficlight, .qnbutton.requiresgrading .trafficlight {
    background-color: #004C45;
	
}
.qnbutton .trafficlight {
    border: 0;
    background: #fff none center / 10px no-repeat scroll;
    /*height: 20px;*/
    margin-top: 20px;
    border-radius: 0 0 3px 3px;
}
.btns {
    -webkit-user-select: none;
    -ms-user-select: none;
}
.btns {
    display: inline-block;
    font-weight: 400;
    color: #212529;
    text-align: center;
    vertical-align: middle;
    user-select: none;
    background-color: transparent;
    border: 1px solid transparent;
    padding: .375rem .75rem;
    font-size: .9375rem;
    line-height: 1.5;
    border-radius: 0;
    transition: color 0.15s ease-in-out,background-color 0.15s ease-in-out,border-color 0.15s ease-in-out,box-shadow 0.15s ease-in-out;
}
.qnbutton.blocked, .qnbutton.notyetanswered, .qnbutton.requiresgrading, .qnbutton.invalidanswer {
    background-color: #fff;
}
.qnbutton.thispage {
    border-color: #666;
	border: solid;
    border-radius: 5px;
}
.qnbutton.flagged .thispageholder {
    background: transparent url(assets/images/flag-on.svg) 15px 0 no-repeat;
}
.free{
	padding: 0px;
}
</style>
<?php
include("../../session.php");
require"../fun_varios.php";

$uri=$_SESSION['url']; 
$quizfixedid=$_GET["quizfixedid"];
$attempt=$_GET["attempt"];
$t=$_GET["t"];
$idp=$_GET["idp"];
$maxpreg=$_GET["maxpreg"];
$pai=$idp-$maxpreg;
$paf=$idp-1;

if (($pai==1) && ($paf == $t)){}
elseif((($pai%$maxpreg) != 0) && ($paf == $t)){
while(($pai%$maxpreg) != 0){
	$pai++;
}
}
$userid=intval(trim($_SESSION["idmoodle"]));

echo '<div class="col-lg-12 col-sm-12">
	<div class="qn_buttons clearfix multipages">';
	$ur8 = $uri.'v2/index.php/gesinpol_quiz_fixed_preg_seq';
	$parametro8 = "quizfixedid=".$quizfixedid."&pai=".$pai."&paf=".$paf."&t=".$t."&attempt=".$attempt."&userid=".$userid;
	$tup8 = resulrow($ur8, $parametro8);
	for ($j=1;$j<=$t;$j++){
		echo $tup8["pregs"][$j];
	//pregunta respodida
	/*$ur8 = $uri.'v2/index.php/gesinpol_quiz_fixed_preg_seq';
	$parametro8 = "quizfixedid=".$quizfixedid."&pai=".$pai."&paf=".$paf."&t=".$t."&attempt=".$attempt."&userid=".$userid;
	$tup8 = resulrow($ur8, $parametro8);	
	$clase=$tup8["clase"];
	if ($clase=="success"){
		$claser="answersaved"; //notyetanswered
		$titlea="Respuesta guardada"; //Sin responder aún
	}else{
		$claser="notyetanswered"; //answersaved
		$titlea="Sin responder aún"; //Respuesta guardada
	}
	if(($j>=$pai) && ($j<=$paf)){
		$claset="thispage"; //
		$respep=" Esta página "; //
	}else{
		$claset=""; //
		$respep=""; //
	}

	echo '<a class="qnbutton '.$claser.' free btns '.$claset.'" id="quiznavbutton19" title="'.$titlea.'" data-quiz-page="0" href="javascript:void(0);">';
	echo '<span class="thispageholder"></span>
         <span class="trafficlight"></span>
         <span class="accesshide">Pregunta </span>
		 '.$j.'
		 <span class="accesshide">'.$respep.'<span class="flagstate"></span></span>'; 
	echo "</a>";*/
	}//end for
echo '</div>
</div>';
echo '<div class="modal-footer">
      <button type="button" class="btn btn-success waves-effect" data-dismiss="modal">CERRAR</button>
      </div>';
?>