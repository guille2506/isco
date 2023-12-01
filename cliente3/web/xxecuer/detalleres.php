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
.qnbutton.answersavedr .trafficlight, .qnbutton.requiresgrading .trafficlight {
/*background-color: rgba(4,190,91,0.8);*/
background-color: rgba(117,190,170,0.8);
}
.qnbutton.answersavedc .trafficlight, .qnbutton.requiresgrading .trafficlight {
/*background-color: rgba(4,190,91,0.8);*/
background-color: rgba(255,153,72,0.8);
}
.qnbutton.answersavedi .trafficlight, .qnbutton.requiresgrading .trafficlight {
background-color: rgba(238,37,88,0.8);
}
.qnbutton.answersavedb .trafficlight, .qnbutton.requiresgrading .trafficlight {
background-color: rgba(28,191,208,0.8);
}
.qnbutton.answersavedd .trafficlight, .qnbutton.requiresgrading .trafficlight {
background-color: rgba(255,255,255,0.8);
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
//$t=$_GET["t"];
$userid=intval(trim($_SESSION["idmoodle"]));
$ur2 = $uri.'v2/index.php/gesinpol_quiz_fixed_attempt_show';
$parametro2 = "quizfixedid=".$quizfixedid."&attempt=".$attempt."&userid=".$userid;
$tupl2 = resulrow($ur2, $parametro2);
$t=$tupl2["t"];

echo '<div class="col-lg-12 col-sm-12">
	<div class="qn_buttons clearfix multipages">';
	$ur8 = $uri.'v2/index.php/gesinpol_quiz_fixed_preg_seq_res';
	$parametro8 = "quizfixedid=".$quizfixedid."&t=".$t."&attempt=".$attempt."&userid=".$userid;
	$tup8 = resulrow($ur8, $parametro8);
	for ($j=1;$j<=$t;$j++){
		echo $tup8["pregs"][$j];
	}//end for
echo '</div>
</div>';
echo '<div class="modal-footer">
      <button type="button" class="btn btn-success waves-effect" data-dismiss="modal">CERRAR</button>
      </div>';
?>