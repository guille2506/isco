<?php
error_reporting(0);
include("../../session.php");
require"../fun_varios.php";
$uri=$_SESSION['url']; 

$qtype = 3;
$courseid = $_POST["val1"];
$quizid = $_POST["val2"];
$userid=intval(trim($_SESSION["idmoodle"])); 
$questionrandom = $_POST["val3"];
$name = $_POST["val4"];
$questionfailed = 1;

$url = $uri.'v2/index.php/gesinpol_quiz_errores_guardar_ajax';
		$parametros="courseid=".$courseid."&quizid=".$quizid."&qtype=".$qtype."&userid=".$userid."&questionrandom=".$questionrandom."&name=".$name."&questionfailed=".$questionfailed;
		$tupla = resulrow($url, $parametros);	
		$quizfixedid=$tupla['quizfixedid'];
//$prg = "rep"; , "img"=>$img, "prg"=>$prg
$msg="Registro Guardado";
echo json_encode(array("msg"=>$msg));
?>