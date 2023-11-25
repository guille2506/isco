<?php
include("../../session.php");
require"../fun_varios.php";
$uri=$_SESSION['url'];
$coursecatid=$_POST["categoria"];
$c=$_POST["c"];
if ($c==1){$change="this.form.submit()";} else{$change='cargarCursosTemas(this.value, '.$c.')';}
echo'<label for="curse">Curso</label>';
echo'<select id="courseid" name="courseid"  class="form-control show-tick" data-live-search="true" required onchange="'.$change.'">';
echo'<option value="">Seleccione...</option>';

$url = $uri.'v2/index.php/gesinpol_curso_select';
$parametros="categoria=$coursecatid";
$resp = resulrow($url, $parametros);
$solicitud=count($resp["cursos"]);
if($solicitud>0){
	//$tupla=sort($resp, 1);	
	 $selected="";
	 foreach($resp["cursos"] as $fil3) {
		  echo"<option value=".$fil3["id"]." ".$selected.">".$fil3["fullname"]."</option>";
     }
}
echo'</select>';
?>