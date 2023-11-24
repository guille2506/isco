<?php
error_reporting(0);
include("../../session.php");
require"../fun_varios.php";
$uri=$_SESSION['url']; 
$userid=intval(trim($_SESSION["idmoodle"]));
$quizid = $_POST["val1"];
$attempt = $_POST["val2"];
$courseid = $_POST["val3"];
$quizfixedid = $_POST["val4"];

$ur23 = $uri.'v2/index.php/gesinpol_quiz_n_moodle_final';
$parametro23="userid=".$userid."&quizid=".$quizid."&courseid=".$courseid;
$tupl23 = resulrow($ur23, $parametro23);	
echo $msg = "";
//echo json_encode(array("msg"=>$msg));
?>