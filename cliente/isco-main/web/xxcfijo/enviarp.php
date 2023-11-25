<?php
include("../../session.php");
require"../fun_varios.php";
$uri=$_SESSION['url'];
$courseid = $_POST["val1"];
$quizid	  = $_POST["val2"];
$attempt  = $_POST["val3"];
$questionid = $_POST["val4"];
$idp	  = $_POST["val5"];
$userid	  = $_POST["val6"];
$obsv	  = $_POST["val7"];
$uid 	  = 3;
//$url = new moodle_url('/mod/quiz/review.php', array('attempt'=>$attid));
$url = $uri.'v2/index.php/gesinpol_quiz_fixed_question_error';
$parametros="courseid=".$courseid."&quizid=".$quizid."&attempt=".$attempt."&questionid=".$questionid."&idp=".$idp."&userid=".$userid."&obsv=".$obsv."&uid=".$uid;
$resp = resulrow($url, $parametros);
$msg=$resp["mensaje"];

//echo $msg;
echo '
<div class="alert alert-success" role="alert">
    <div class="container">
        <div class="alert-icon">
            <i class="zmdi zmdi-thumb-up"></i>
        </div>
        <strong>Genial!</strong> '.$msg.'.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">
                <i class="zmdi zmdi-close"></i>
            </span>
        </button>
    </div>
</div>';
?>