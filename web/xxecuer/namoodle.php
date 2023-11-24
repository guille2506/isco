<?php
error_reporting(0);
include("../../session.php");
require"../fun_varios.php";
$uri=$_SESSION['url']; 
$userid=intval(trim($_SESSION["idmoodle"]));
$quizid = $_POST["val1"];
$attempt = $_POST["val2"];
$notas = $_POST["val3"];

$ur23 = $uri.'v2/index.php/gesinpol_guardar_nota_moodle';
$parametro23="userid=".$userid."&quizid=".$quizid."&attempt=".$attempt."&cotas=".$notas;
$tupl23 = resulrow($ur23, $parametro23);	
echo $msg = "";
//sleep(1);
//echo json_encode(array("msg"=>$msg));
?>