<?php
include("../../session.php");
require"../fun_varios.php";

$uri=$_SESSION['url']; 
$courseid=$_GET["courseid"];
$userid=intval(trim($_SESSION["idmoodle"]));
$u1 = $uri.'v2/index.php/gesinpol_cursos';
$p1="courseid=".$courseid;
$rs = resulrow($u1, $p1);
$s1=count($rs['cursos']);
$cname=$rs['cursos']["fullname"];
echo '<div class="col-lg-12 col-sm-12">
	<div class="qn_buttons clearfix multipages">
	<div id="preg" class="table-responsive">
    <table id="test-a-table" class="table table-striped table-hover js-basic-example dataTable">
        <thead>
            <tr>
                <th colspan="3">'.$cname.'</th>
            </tr><tr>
                <th>Cuestionario</th><th>Calificación</th><th>Posición</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Cuestionario</th><th>Calificación</th><th>Posición</th>
            </tr>
        </tfoot>
        <tbody>';
$solicitud=0;
$url = $uri.'v2/index.php/gesinpol_curso_quiz_notas';
$parametros="courseid=".$courseid."&userid=".$userid;
$resp = resulrow($url, $parametros);
if (isset($resp["quizerrores"])){
$solicitud=count($resp["quizerrores"]["id"]); }
//echo "- ".$solicitud;

if($solicitud>0){
	$selected="";
	for($ii=0;$ii<$solicitud;$ii++) {
		 $quizid=$resp["quizerrores"]["questionfailed"][$ii];
		 $name=$resp["quizerrores"]["name"][$ii];
		 //$t=$resp["quizerrores"]["total"][$ii];
		 //$n=$resp["quizerrores"]["rawgrade"][$ii];
		 $n=number_format($resp["quizerrores"]["rawgrade"][$ii], 2, '.', '');
		 $notas=$n;
		 $r=$resp["quizerrores"]["r"][$ii];
		 $tr=$resp["quizerrores"]["tr"][$ii];
		 if ($quizid==0){
			 echo"<tr><th colspan='3'>".$name."</th></tr>";
		 }else{
			echo "<tr><td>".$name."</td>";
			//echo "<tr><td>".$name."(".$t.")</td>";
			echo '<td>'.$notas.'</td>';
			if ($tr==0)
			echo '<td>NO MATRICULADO</td></tr>';
			else
			echo '<td>'.$r.'/'.$tr.'</td></tr>';  
		 }
	}
}else{ echo"<tr><th class='text-center' colspan='3'>No Existen Registros</th></tr>"; }

 echo '</tbody>
    </table>
</div>
</div>
</div>';
echo '<div class="modal-footer">
      <button type="button" class="btn btn-success waves-effect" data-dismiss="modal">CERRAR</button>
      </div>';
?>