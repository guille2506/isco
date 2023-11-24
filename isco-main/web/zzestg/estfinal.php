<?php
error_reporting(0);
include("../../session.php");
require"../fun_varios.php";
$uri=$_SESSION['url']; 
$userid=intval(trim($_SESSION["idmoodle"]));
$val1 = $_POST["val1"];
//$totalp = $_POST["val2"];
//$qfasid = $_POST["val3"];

$url = $uri.'v2/index.php/gesinpol_quiz_fixed_categoria_notas_promedio_show';
$parametros="categoria=".$val1."&userid=".$userid;
$t = resulrow($url, $parametros);
$msg = number_format($t["percentil"], 0, ',', '.');
//$msg = '<input type="text" class="knob" data-readOnly=true data-linecap="round" value="'.$pc.'" data-width="100" data-height="100" data-thickness="0.25" data-fgColor="#75BEAA" data-bgColor="#005674">';



//echo json_encode(array("msg"=>$msg, "img"=>$img, "prg"=>$prg));
echo json_encode(array("msg"=>$msg));
?>