<?php
include("../../session.php");
require"../fun_varios.php";
$coursecatid=$_POST["categoria"];
$c=$_POST["c"];
$uri=$_SESSION['url'];
if ($c==1){$change="this.form.submit()";} else{$change='cargarPregunta(this.value)';} 
echo'<label for="curse">Temas</label>';
echo'<select id="courseid" name="courseid"  class="form-control show-tick" data-live-search="true" required onchange="'.$change.'">'; //this.form.submit()
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