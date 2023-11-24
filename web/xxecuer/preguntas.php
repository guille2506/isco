<?php
include("../../session.php");
require"../fun_varios.php";

$uri=$_SESSION['url'];
$id=$_POST["idcategory"];
$t=0;
$userid=intval(trim($_SESSION["idmoodle"]));
echo'<label for="questionrandom">N&uacute;mero de Preguntas</label>';
echo'<select id="questionrandom" name="questionrandom" class="form-control show-tick" data-live-search="true" required>';
echo'<option value="">Seleccione...</option>';

$url = $uri.'v2/index.php/gesinpol_curso_secciones_preguntas_select';
$parametros="userid=".$userid."&quizid=".$id;
$resp = resulrow($url, $parametros);
$solicitud=$resp["quizpregunta"];
if($solicitud>0){
if(isset($id)){echo '<option value="9999">Todas</option>';}
 foreach($resp["quizpregunta"] as $fil3) {
	$t=$fil3["c"];
	}
}
if($t==0){$t = count($resp["quizslots"]);}
for($i=1; $i<=$t; $i++)
	{
		echo"<option value='$i'>".$i."</option>";
	}
echo'</select>';
?>