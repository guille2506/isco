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

?> 
<form id="form_validation" action="simulacro.php?tipo=<?PHP echo $_GET["tipo"]; ?>&op=m" method="post">
<div class="row">
<div class="col-md-6">
<div class="form-group">
<label for="curse">Categoria</label>
<select id="coursecatid" name="coursecatid"  class="form-control show-tick" data-live-search="true" required onchange="cargarCursosCategorias(this.value,<?PHP echo $c=1; ?>)">
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
			 if ($coursecatid==0 && $filcath["coursecount"]>0){$coursecatid=$filcath["id"];}
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
<label for="curse">Curso</label>
<select id="courseid" name="courseid"  class="form-control show-tick" data-live-search="true" required onchange="this.form.submit()">
<?PHP //cargarCursosTemas(this.value,this.value)
echo"<option value=''>Seleccione...</option>";
$url = $uri.'v2/index.php/gesinpol_curso_select';
$parametros="categoria=".$coursecatid;
$resp = resulrow($url, $parametros);
$solicitud=count($resp["cursos"]);
if($solicitud>0){
	 foreach($resp["cursos"] as $fil3) {
		  if ($courseid==0){$courseid=$fil3["id"];}
			 if ($courseid==$fil3["id"]){$selected="selected='selected'";}
			 else{$selected="";}
		  echo"<option value=".$fil3["id"]." ".$selected.">".$fil3["fullname"]."</option>";
     }
}
?>
</select>
</div>
<div id="rcursos"></div>
</div>
</form>
<div class="table-responsive">
    <table id="test-a-table" class="table table-striped table-hover js-basic-example dataTable">
        <thead>
            <tr>
                <th>Cuestionario</th><?php /*?><th>Temas</th><?php */?><th>Preguntas</th><th>Tiempo</th><th>Acciones</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Cuestionario</th><?php /*?><th>Temas</th><?php */?><th>Preguntas</th><th>Tiempo</th><th>Acciones</th>
            </tr>
        </tfoot>
        <tbody>
<?php 
$url = $uri.'v2/index.php/gesinpol_curso_secciones_select';
$parametros="courseid=".$courseid;
$resp = resulrow($url, $parametros);
$solicitud=count($resp["sections"]);
if($solicitud>0){
	//$tupla=sort($resp, 1);	
	 $selected="";
	 foreach($resp["sections"] as $fil3) {
		$mystring = $fil3["name"];
		$findme   = 'TEST ALEATORIO';
		$pos = strpos($mystring, $findme);
		// Nótese el uso de ===. Puesto que == simple no funcionará como se espera
		// porque la posición de 'a' está en el 1° (primer) caracter.
		if ($pos === false) {
		} else {
			if ($coursesectionsid==0){$coursesectionsid=$fil3["id"];}
			 //	if ($coursesectionsid==$fil3["id"]){$selected="selected='selected'";}
			 //	else{$selected="";}
			//echo"<option value=".$fil3["id"]." ".$selected.">".$fil3["name"]."</option>";
		}
		// if (str_contains($fil3["name"], 'TEST')) {
		 // echo"<option value=".$fil3["id"]." ".$selected.">".$fil3["name"]."</option>";
		// }
     }
}
$url = $uri.'v2/index.php/gesinpol_items_tema_curso';
$parametros="curso=".$courseid."&tema=".$coursesectionsid;
$tupla = resulrow($url, $parametros);
$solicitud=count($tupla);
if($solicitud>0){	
foreach($tupla["items"] as $tupl1) {
//if ($tupl1["timeclose"]==0){$status="No Realizado";}else{$status="Realizado";}

$url2 = $uri.'v2/index.php/gesinpol_curso_quiz';
$parametro2="course=".$courseid."&id=".$tupl1["instance"];
$tupla2 = resulrow($url2, $parametro2);
$name=$tupla2["cursoquiz"];
if($name!=""){
//$solicitud=count($tupla2["cursoquiz"]);
//if($solicitud>0){
//	foreach($tupla2["cursoquiz"] as $tupl2) {
	$tt=$j="";
//$j  = count($tupla2["quizslots"]);
$j  = $tupla2["quizslots"];
//$tf = $tupla2["questiontime"] * $j;
$tf = $tupla2["timelimit"];
$tt = segundostocadena($tf);
echo "<tr><td>".$name."</td>";
//echo "<td>".$name."</td>";
echo "<td>".$j."</td><td>".$tt."</td>";
//if ($tupl1["timelimit"] < 1) $tt= "Sin Tiempo";
//echo "<tr><td>".$tupl2["name"]."</td>";
//echo "<td>".$tupl2["name"]."</td><td>".$j."</td><td>".$tt."</td>";
$url3 = $uri.'v2/index.php/gesinpol_quiz_fixed_quiz';
$parametros3="qtype=1&userid=".$userid."&quizid=".$tupl1["instance"];
$tupla3 = resulrow($url3, $parametros3);
$quizfixedid=$tupla3["quizfixedid"];
?>
<td>
<form id="resul-form" action="simulacro.php?tipo=<?PHP echo $_GET["tipo"]; ?>&op=e" method="post">
<input type='hidden' name='courseid' value='<?PHP echo $courseid; ?>'>
<input type='hidden' name='quizid' value='<?PHP echo $tupl1["instance"]; ?>'>
<input type='hidden' name='name' value='<?PHP echo $name; ?>'>
<?php /*?><input type='hidden' name='quizid' value='<?PHP echo $tupl2["id"]; ?>'>
<input type='hidden' name='name' value='<?PHP echo $tupl2["name"]; ?>'><?php */?>
<button type="submit" class="btn btn-warning btn-icon float-right text-white" id="cambia_registro" name="cambia_registro" value="Iniciar"><i class="zmdi zmdi-eye" data-toggle="tooltip" title="Iniciar TEST"></i></button>
</form>
<?php if ($quizfixedid>0) { ?>
<form id="asig-form" action="simulacro.php?tipo=<?PHP echo $_GET["tipo"]; ?>&op=a" method="post">
<input type='hidden' name='quizfixedid' value='<?PHP echo $quizfixedid; ?>'>
<button type="submit" class="btn btn-success btn-icon float-right" id="asignar_registro" name="asignar_registro" value="Intentos"><i class="zmdi zmdi-view-list-alt" data-toggle="tooltip" title="Visualizar Intentos"></i></button>
</form>
<?php } ?>
</td>
</tr>
<?php
	//}
}
}
}
?>                                        
        </tbody>
    </table>
</div>
<script>
function cargarCursosCategorias(val,c)
{
 	$('#rcursos').html('<img src="assets/images/loader.gif" /> Por favor espere un momento');  
    $.ajax({
        type: "POST",
        url: 'web/xxdvare/categorias.php',
        data: {categoria: val, c: c},
       	success: function(resp){
 			$('#cursos').html(resp);
            $('#rcursos').html("");
        }
    });
}
function cargarCursosTemas(val,c)
{
 	$('#rtema').html('<img src="assets/images/loader.gif" /> Por favor espere un momento');  
    $.ajax({
        type: "POST",
        url: 'web/xxcfijo/secciones.php',
        data: {courseid: val, c: c},
       	success: function(resp){
 			$('#tema').html(resp);
            $('#rtema').html("");
        }
    });
}
</script>