<?php
include("../../session.php");
require"../fun_varios.php";

$uri=$_SESSION['url'];
$courseid=$_POST["courseid"];
$c=$_POST["c"];
if ($c==1){$roption="Multiple";$roptions='[]';}
else{$roption=$roptions="";}
$userid=intval(trim($_SESSION["idmoodle"])); 
echo'<label for="coursesectionsid">Cuestionarios</label>';
echo'<select id="coursesectionsid" name="coursesectionsid'.$roptions.'" class="form-control  show-tick"  data-live-search="true" required onchange="cargarPregunta(this.value)"  '.$roption.'>';
echo'<option value="">Seleccione...</option>';

$url = $uri.'v2/index.php/gesinpol_curso_quiz_errores_select';
$parametros="courseid=".$courseid."&userid=".$userid;
$resp = resulrow($url, $parametros);
$solicitud=count($resp["quizerrores"]);
if($solicitud>0){
	 $selected="";
	 foreach($resp["quizerrores"] as $fil3) {
			echo"<option value=".$fil3["id"]." ".$selected.">".$fil3["name"]."(".$fil3["total"].")</option>";
		}
}
echo'</select>';
?>
