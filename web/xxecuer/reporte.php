<?PHP
error_reporting(0);
$userid=intval(trim($_SESSION["idmoodle"]));
if (isset($_POST["msg"])) $msg=$_POST["msg"];
	  elseif (isset($_GET["msg"]))  $msg=$_GET["msg"];
	  else { $msg=0; }
if ($msg==1){
?> 
<div class="alert alert-success" role="alert">
    <div class="container">
        <div class="alert-icon">
            <i class="zmdi zmdi-thumb-up"></i>
        </div>
        <strong>Genial!</strong> Un Nuevo Registro Incluido para Test de Errores.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">
                <i class="zmdi zmdi-close"></i>
            </span>
        </button>
    </div>
</div>
<script>
$(".alert").fadeTo(4000, 500).slideUp(500, function(){
    $(this).alert('close');
});
/*$(".alert").delay(4000).slideUp(200, function() {
    $(this).alert('close');
});*/
</script>
<?PHP }elseif($msg==2){
?> 
<div class="alert alert-danger" role="alert">
    <div class="container">
        <div class="alert-icon">
            <i class="zmdi zmdi-thumb-up"></i>
        </div>
        <strong>Genial!</strong> Registro Eliminado en el Test de Errores.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">
                <i class="zmdi zmdi-close"></i>
            </span>
        </button>
    </div>
</div>
<script>
$(".alert").fadeTo(4000, 500).slideUp(500, function(){
    $(this).alert('close');
});
/*$(".alert").delay(4000).slideUp(200, function() {
    $(this).alert('close');
});*/
</script>
<?PHP }  ?>  
<style>
.linea
{
    display: inline-block;
}
</style>
<div class="table-responsive">
    <table class="table table-striped table-hover js-basic-example dataTable">
        <thead>
            <tr>
                <th>Cuestionario</th>
                <th>Errores</th>
                <th>Preguntas</th>
                <th>Tiempo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Cuestionario</th>
                <th>Errores</th>
                <th>Preguntas</th>
                <th>Tiempo</th>
                <th>Acciones</th>
            </tr>
        </tfoot>
        <tbody>
<?php 
$url = $uri.'v2/index.php/gesinpol_quiz_fixed_report';
$parametros="qtype=3&userid=".$userid;
$tupla = resulrow($url, $parametros);
$solicitud=count($tupla);
if($solicitud>0){	
	 foreach($tupla["quizfixed"] as $tupl1) {
		 if ($tupl1["timeclose"]==0){$status="No Realizado";}else{$status="Realizado";}
	 echo "<tr><td>".$tupl1["name"]."</td>";
	 $url2 = $uri.'v2/index.php/gesinpol_quiz_fixed_categoria_report';
	 $parametro2="qtype=3&quizfixedid=".$tupl1["id"];
	 $tupl2 = resulrow($url2, $parametro2);
	$solicitud=count($tupl2);
	if($solicitud>0){	
		$j=$tupl2["qctotal"];
		$tf= $tupl1["timelimit"]* $j;
		$tt=segundostocadena($tf);
		if ($tupl1["timelimit"] < 1) $tt= "Sin Tiempo";
	 echo "<td>".$tupl2["qctema"]."</td><td>".$j."</td><td>".$tt."</td>";
	}
	 ?>
	 <td>
     	<form id="resul-form" action="simulacro.php?tipo=<?PHP echo $_GET["tipo"]; ?>&op=e" method="post">
      		<input type='hidden' name='questionrandom' value='<?PHP echo $j; ?>'>
      		<input type='hidden' name='quizfixedid' value='<?PHP echo $tupl1["id"]; ?>'>
      		<button type="submit" class="btn btn-warning btn-icon float-right text-white" id="cambia_registro" name="cambia_registro" value="Iniciar"><i class="zmdi zmdi-eye" data-toggle="tooltip" title="Iniciar TEST"></i></button>
      	</form>
		<form id="asig-form" action="simulacro.php?tipo=<?PHP echo $_GET["tipo"]; ?>&op=a" method="post">
			<input type='hidden' name='quizfixedid' value='<?PHP echo $tupl1["id"]; ?>'>
			<button type="submit" class="btn btn-success btn-icon float-right" id="asignar_registro" name="asignar_registro" value="Intentos"><i class="zmdi zmdi-view-list-alt" data-toggle="tooltip" title="Visualizar Intentos"></i></button>
       	</form>
        <form id="delet-form<?PHP echo $tupl1["id"]; ?>" action="simulacro.php?tipo=<?PHP echo $_GET["tipo"]; ?>&op=m" method="post">
			<input type='hidden' name='quizfixedid' value='<?PHP echo $tupl1["id"]; ?>'>
            <input type='hidden' name='msg' value='<?PHP $msg=2; echo $msg; ?>'>
			<button type="button"  onclick="confirmAction<?PHP echo $tupl1["id"]; ?>()" class="btn btn-danger btn-icon float-right" id="elimi_reg" name="elimi_reg" value="Eliminar"><i class="zmdi zmdi-delete" data-toggle="tooltip" title="Eliminar TEST <?PHP echo $tupl1["name"]; ?>"></i></button>
       	</form>
        <script>
		function confirmAction<?PHP echo $tupl1["id"]; ?>() {
		var confirmAction = confirm("Esta seguro de eliminar el test?");
		  if (confirmAction) {
			//alert("Registro eliminado");
			document.getElementById("delet-form<?PHP echo $tupl1["id"]; ?>").submit();
		  } else {
			//alert("Registro Cancelado");
		  }
		}
		</script>
	 </td>
     </tr>
     <?php
	 }
}
?> 
        </tbody>
    </table>
</div>
