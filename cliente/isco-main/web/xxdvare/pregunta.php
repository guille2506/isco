<?php
include("../../session.php");
require"../fun_varios.php";
$uri=$_SESSION['url'];
$id=$_POST["idcategory"];
echo'<label for="questionrandom">N&uacute;mero de Preguntas Aleatorias</label>';
echo'<select id="questionrandom" name="questionrandom" class="form-control show-tick" data-live-search="true" required>';
echo'<option value="">Seleccione...</option>';
$url = $uri.'v2/index.php/gesinpol_categoria_nro_select';
$parametros="categoria=$id";
$resp = resulrow($url, $parametros);
$solicitud=$resp["qstid"];
if($solicitud>0){
$t=$resp["qstid"];
for($i=1; $i<=$t; $i++)
	{
		echo"<option value='$i'>".$i."</option>";
	}
}
echo'</select>';
?>