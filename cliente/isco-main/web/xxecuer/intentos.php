<?php
error_reporting(0);
include("../../session.php");
require"../fun_varios.php";
$uri=$_SESSION['url']; 
$userid=intval(trim($_SESSION["idmoodle"]));
$quizid = $_POST["val1"];
$attempt = $_POST["val2"];
$quizfixedid = $_POST["val3"];
$tipo = $_POST["val4"];

	$ur1 = $uri.'v2/index.php/gesinpol_quiz_fixed_intentos';
	$parametro1="userid=".$userid."&quizfixedid=".$quizfixedid."&attempt=".$attempt;
	$tupl1 = resulrow($ur1, $parametro1);	
	$solicitu1=$tt=count($tupl1["attemps"]);
	if($solicitu1>0){ 
         $ii=1;
         foreach ($tupl1["attemps"] as $tup1){
         $attemp=$tup1["attempt"];
         if ($attemp==$attempt) echo "<strong>$attemp</strong>";
         else echo '<a title="Revisar Respuesta" href="simulacro.php?tipo='.$tipo.'&op=a&quizfixedid='.$quizfixedid.'&attempt='.$attemp.'">'.$attemp.'</a>';
         if ($ii<$tt) echo ", ";
         $ii++;
          }
      }
//echo $msg = $posicion." de ".$posranki;
//echo json_encode(array("mp"=>$mp,"pr"=>$pr));
?>