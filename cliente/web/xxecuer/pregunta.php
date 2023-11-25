<?php
include("../../session.php");
require"../fun_varios.php";

$uri=$_SESSION['url'];
$courseid=$_POST["val1"];
$name=$_POST["val2"];
$userid=intval(trim($_SESSION["idmoodle"]));
$aux="";
echo '<table id="test-a-table" class="table table-striped table-hover js-basic-example dataTable">
        <thead>
            <tr>
                <th>Cuestionario</th><th>Preguntas</th><th></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Cuestionario</th><th>Preguntas</th><th></th>
            </tr>
        </tfoot>
        <tbody>';

$url = $uri.'v2/index.php/gesinpol_curso_quiz_errores_select';
$parametros="courseid=".$courseid."&userid=".$userid."&name=".$name;
$resp = resulrow($url, $parametros);
if (isset($resp["quizerrores"])){
foreach($resp["quizerrores"] as $tupla)
{
		 $quizid=$tupla["questionfailed"];
		 $idp=$tupla["id"];
		 $t=$tupla["total"];
		 $ns=$tupla["csna"];
		 $nq=$tupla["name"];
		 if ($aux!=$ns){
			 echo "<tr><th colspan='3'>".$ns."</th></tr>";
			 $aux=$ns;
		 }
			echo "<tr><td>".$nq."(".$t.")</td>";
			echo '<td><select id="questionrandom'.$idp.'" name="questionrandom" class="form-control show-tick" data-live-search="true" style="width: 150px;" required>';
			echo '<option value="">Seleccione...</option>';
			echo "<option value='".$t."'>Todas</option>";
			for($i=1; $i<=$t; $i++) {
			$selected=""; 
			if ($questionrandom == $i){ $selected="selected='selected'"; }
			echo "<option value='$i' ".$selected.">".$i."</option>"; }
			echo '</select>';
			echo '</td><td>';
		
			echo '<a href="javascript:enviarPreg_'.$idp.'($(\'#courseid\').val(), '.$quizid.', $(\'#questionrandom'.$idp.'\').val(), $(\'#name\').val());" class="btn btn-warning btn-icon float-right text-white" id="e1"><i class="zmdi zmdi-assignment-check" data-toggle="tooltip" title="Agregar Pregunta"></i></a>
            <script>
			function enviarPreg_'.$idp.'(val1, val2, val3, val4)
			{
				if (val4==""){alert("Debe escribir un nombre de cuestionario, por favor.");}
				else if (val3==""){alert("Debe selecionar el nro de Preguntas, por favor.");}
				else{
			$("#resultado_msg_'.$idp.'").html(\'<img src="assets/images/loader.gif" /> Por favor espere un momento\');
			$.ajax({
            		type: "POST",
					url: "web/xxecuer/enviarp.php",
					data: {val1: val1, val2: val2, val3: val3, val4: val4},
            		dataType: "json",           
					success: function(resp){
						 $("#resultado_msg_'.$idp.'").html(resp.msg);
					}
    			});  
				}
			}
			
			</script>
            <div id="resultado_msg_'.$idp.'"></div>';

			echo'</td></tr>';           
}
}else{ echo"<tr><th class='text-center' colspan='3'>No Existen Registros</th></tr>"; }

  echo  '</tbody>
    </table>';
?>