<?php
include("../../session.php");
require"../fun_varios.php";
$uri=$_SESSION['url'];
$courseid=$_POST["courseid"];
$c=$_POST["c"];
if ($c==1){$change="this.form.submit()";}
else{$change="cargarPregunta(this.value)";}
echo'<label for="coursesectionsid">Temas</label>';
echo'<select id="coursesectionsid" name="coursesectionsid" class="form-control show-tick"  data-live-search="true" required onBlur="'.$change.'" onFocus="'.$change.'" onChange="'.$change.'">';
echo'<option value="">Seleccione...</option>';

$url = $uri.'v2/index.php/gesinpol_curso_secciones_select';
$parametros="courseid=".$courseid;
$resp = resulrow($url, $parametros);
$solicitud=count($resp["sections"]);
if($solicitud>0){
	//$tupla=sort($resp, 1);	
	 $selected="";
	 foreach($resp["sections"] as $fil3) {
		$mystring = $fil3["name"];
		$findme   = 'ZONA DE NOVEDADES';
		$pos = strpos($mystring, $findme);
		// Nótese el uso de ===. Puesto que == simple no funcionará como se espera
		// porque la posición de 'a' está en el 1° (primer) caracter.
		if ($pos === false) {
			if ($coursesectionsid==0){$coursesectionsid=$fil3["id"];}
			 	if ($coursesectionsid==$fil3["id"]){$selected="selected='selected'";}
			 	else{$selected="";}
			echo"<option value=".$fil3["id"]." ".$selected.">".$fil3["name"]."</option>";
		} else {
			
		}
		// if (str_contains($fil3["name"], 'TEST')) {
		 // echo"<option value=".$fil3["id"]." ".$selected.">".$fil3["name"]."</option>";
		// }
     }
}
echo'</select>';
?>