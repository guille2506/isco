<?php
include("../../session.php");
require"../fun_varios.php";
$uri=$_SESSION['url']; 
$courseid=$_POST["courseid"];
$c=$_POST["c"];
echo'<label for="questionscategoriesid">Temas</label>';
echo'<select id="questionscategoriesid" name="questionscategoriesid" class="form-control show-tick"  data-live-search="true" required onchange="cargarPregunta(this.value)">';
echo'<option value="">Seleccione...</option>';

$url = $uri.'v2/index.php/gesinpol_categoria_select';
$parametros="curso=$courseid";
$resp = resulrow($url, $parametros);
$solicitud=count($resp["tema"]);
if($solicitud>0){
	//$tupla=sort($resp, 1);	
	 $selected="";
	 foreach($resp["tema"] as $fil3) {
		  if ($fil3["qstid"]==0){$qstid="";}else{$qstid="(".$fil3["qstid"].")";}
		  echo"<option value=".$fil3["id"]." ".$selected.">".$fil3["name"].$qstid."</option>";
     }
}
echo'</select>';
?>