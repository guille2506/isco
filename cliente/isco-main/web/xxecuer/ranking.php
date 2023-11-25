<?php
error_reporting(0);
include("../../session.php");
require"../fun_varios.php";
$uri=$_SESSION['url']; 
$userid=intval(trim($_SESSION["idmoodle"]));
$quizid = $_POST["val1"];
$attempt = $_POST["val2"];
$quizfixedid = $_POST["val3"];

$ur22 = $uri.'v2/index.php/gesinpol_quiz_fixed_ranking_show';
$parametro22 = "quizid=".$quizid;
$tupl2 = resulrow($ur22, $parametro22);
$posranki = count($tupl2["quizfixedas"]);
$i=1;
	$qa=$quizfixedid."".$attempt;
	$posicion=0;
	foreach ($tupl2["quizfixedas"] as $t22){
		if ($qa==$t22["qa"]){ $posicion=$i; break; }
		$i++;
	}
echo $msg = $posicion." de ".$posranki;
//echo json_encode(array("mp"=>$mp,"pr"=>$pr));
?>