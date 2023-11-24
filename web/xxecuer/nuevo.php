<?PHP
error_reporting(0);

if (isset($_POST["coursecatid"])) $coursecatid=$_POST["coursecatid"];
	  elseif (isset($_GET["coursecatid"]))  $coursecatid=$_GET["coursecatid"];
	  else { $coursecatid=0; }
if (isset($_POST["courseid"])) $courseid=$_POST["courseid"];
	  elseif (isset($_GET["courseid"]))  $courseid=$_GET["courseid"];
	  else { $courseid=0; }
if (isset($_POST["coursesectionsid"])) $coursesectionsid=$_POST["coursesectionsid"];
	  elseif (isset($_GET["coursesectionsid"]))  $coursesectionsid=$_GET["coursesectionsid"];
	  else { $coursesectionsid=0; }	 
if (isset($_POST["name"])) $name=$_POST["name"];
	  elseif (isset($_GET["name"]))  $name=$_GET["name"];
	  else { $name=""; }		   
$userid=intval(trim($_SESSION["idmoodle"])); 
?> 
<form id="form_validation" action="simulacro.php?tipo=<?PHP echo $_GET["tipo"]; ?>&op=n" method="post">
<div class="row">
<div class="col-md-12">
<div class="form-group">
<label for="name">Nombre del Cuestionario</label>
<input type="text" class="form-control" id="name" name="name" placeholder="Nombre" value="<?PHP echo $name; ?>" required="required" />
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<label for="curse">Modulo</label>
<select id="coursecatid" name="coursecatid"  class="form-control show-tick" data-live-search="true" required onchange="cargarCursosCategorias(this.value,this.value)">
<?PHP //data-live-search="true"  ms select2
echo"<option value=''>Seleccione...</option>";
$url = $uri.'v2/index.php/gesinpol_categoria_curso_select';
$parametros="categoria=69";
$tupla = resulrow($url, $parametros);
$solicitud=count($tupla);
if($solicitud>0){	
	 foreach($tupla["catcurso"] as $filcat) {
	 if ($filcat["coursecount"]==0){$qstid="";}else{$qstid="(".$filcat["coursecount"].")";}
	 echo"<option value=".$filcat["id"]." ".$selected.">".$filcat["name"].$qstid."</option>";
		$urls = $uri.'v2/index.php/gesinpol_categoria_hijo_curso_select';
		$parametross="categoria=".$filcat["id"];
		$tuplas = resulrow($urls, $parametross);
		$solicituds=count($tuplas["cathcurso"]);
		if($solicituds>0){	
			$aux="";$parent=$filcat["id"]; 
			 foreach($tuplas["cathcurso"] as $filcath) {
				$enc=0;
		     if ($filcath["coursecount"]==0){$qstid="";}else{$qstid="(".$filcath["coursecount"].")";}
			 if ($coursecatid==0 && $filcath["coursecount"]>0){/*$coursecatid=$filcath["id"];*/}
			 	if ($coursecatid==$filcath["id"]){$selected="selected='selected'";}
				else{$selected="";}
			if ($parent==$filcath["parent"]){
				if ($aux==""){$aux=$filcath["id"];}
				  if ($aux==$filcath["id"]){
					echo '<optgroup label="'.$filcath["name"].'">';	
				  }else{
					  echo '</optgroup>';
					  echo '<optgroup label="'.$filcath["name"].'">';
					  $aux=$filcath["id"];
				  }
				  $enc=1;
			}
			 if ($enc==0){	
			 echo"<option value=".$filcath["id"]." ".$selected.">".$filcath["name"].$qstid."</option>";	}		 
			 }
			 if ($aux!=""){ echo '</optgroup>';}
		}	 
	 }
}
?>
</select>
</div>
</div>
<div class="col-md-6">
<div id="cursos" class="form-group">
<label for="curse">Tema</label>
<select id="courseid" name="courseid"  class="form-control show-tick" data-live-search="true" required onchange="cargarPregunta(this.value, $('#name').val())">
<?PHP //this.form.submit(); cargarCursosTemas(this.value,this.value)
echo"<option value=''>Seleccione...</option>";
$url = $uri.'v2/index.php/gesinpol_curso_select';
$parametros="categoria=".$coursecatid;
if ($coursecatid>0){
$resp = resulrow($url, $parametros);
$solicitud=count($resp["cursos"]);
if($solicitud>0){
	 foreach($resp["cursos"] as $fil3) {
		  if ($courseid==0){$courseid=$fil3["id"];}
			 if ($courseid==$fil3["id"]){$selected="selected='selected'";}
			 else{$selected="";}
		  echo"<option value=".$fil3["id"]." ".$selected.">".$fil3["fullname"]."</option>";
     }
}}
?>
</select>
</div>
<div id="rcursos"></div>
</div>
</form>
<div id="rpreg"></div>
<div id="preg" class="table-responsive">
    <table id="test-a-table" class="table table-striped table-hover js-basic-example dataTable">
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
        <tbody>
        
<?php 
if ($coursecatid>0){
$url = $uri.'v2/index.php/gesinpol_curso_quiz_errores_select';
$parametros="courseid=".$courseid."&userid=".$userid;
$resp = resulrow($url, $parametros);
if (isset($resp["quizerrores"])){
$solicitud=count($resp["quizerrores"]["id"]); }
else $solicitud=0;
if($solicitud>0){
	$selected="";
	for($ii=0;$ii<$solicitud;$ii++) {
		 $quizid=$resp["quizerrores"]["questionfailed"][$ii];
		 $idp=$resp["quizerrores"]["id"][$ii];
		 $t=$resp["quizerrores"]["total"][$ii];
		 if ($t==0){
			 echo"<tr><th colspan='3'>".$resp["quizerrores"]["name"][$ii]."</th></tr>";
		 }else{
			echo "<tr><td>".$resp["quizerrores"]["name"][$ii]."(".$resp["quizerrores"]["total"][$ii].")</td>";
			echo '<td><select id="questionrandom'.$idp.'" name="questionrandom'.$idp.'" class="form-control show-tick" data-live-search="true" style="width: 150px;" required>';
			echo '<option value="">Seleccione...</option>';
			echo "<option value='".$t."'>Todas</option>";
			for($i=1; $i<=$t; $i++) { echo "<option value='$i'>".$i."</option>"; }
			echo '</select>';
			echo '</td><td>';
?>			
			<a href="javascript:enviarPreg_<?PHP echo $idp; ?>($('#courseid').val(), <?PHP echo $quizid; ?>, $('#questionrandom<?PHP echo $idp; ?>').val(), $('#name').val());" class="btn btn-warning btn-icon float-right text-white" id="e1"><i class="zmdi zmdi-assignment-check" data-toggle="tooltip" title="Agregar Pregunta"></i></a>
            <script>
			function enviarPreg_<?PHP echo $idp; ?>(val1, val2, val3, val4)
			{
				if (val4==""){alert("Debe escribir un nombre de cuestionario, por favor.");}
				else if (val3==""){alert("Debe selecionar el nro de Preguntas, por favor.");}
				else{
			$("#resultado_msg_<?PHP echo $idp; ?>").html('<img src="assets/images/loader.gif" /> Por favor espere un momento');
			$.ajax({
            		type: "POST",
					url: "web/xxecuer/enviarp.php",
					data: {val1: val1, val2: val2, val3: val3, val4: val4},
            		dataType: "json",           
					success: function(resp){
						 $("#resultado_msg_<?PHP echo $idp; ?>").html(resp.msg);
					}
    			});  
				}
			}
			
			</script>
            <div id="resultado_msg_<?PHP echo $idp; ?>"></div>
<?php 
			echo'</td></tr>';  
		 }
	}
}else{ echo"<tr><th class='text-center' colspan='3'>No Existen Registros</th></tr>"; }
}else{ echo"<tr><th class='text-center' colspan='3'>No Existen Registros</th></tr>"; }
?>
        </tbody>
    </table>
</div>
<div class="col-md-12">
<div class="form-group">
<a href="simulacro.php?tipo=<?PHP echo $_GET["tipo"]; ?>&op=m" class="btn btn-raised btn-warning  waves-effect float-right" >Volver</a>
</div>
<script>
function cargarCursosCategorias(val,c)
{
 	$('#rcursos').html('<img src="assets/images/loader.gif" /> Por favor espere un momento');  
    $.ajax({
        type: "POST",
        url: 'web/xxecuer/categorias.php',
        data: {categoria: val, c: c},
       	success: function(resp){
 			$('#cursos').html(resp);
            $('#rcursos').html("");
        }
    });
}
function cargarPregunta(val1,val2)
{
    $('#rpreg').html('<img src="assets/images/loader.gif" /> Por favor espere un momento');    
    $.ajax({
        type: "POST",
        url: 'web/xxecuer/pregunta.php',
        data: {val1: val1, val2: val2},
       	success: function(resp){
            $('#preg').html(resp);
            $('#rpreg').html("");
        }
    });
}
</script>