<?PHP
//error_reporting(0);
			if (isset($_POST["quizfixedid"])) $quizfixedid=$_POST["quizfixedid"];
			elseif (isset($_GET["quizfixedid"])) $quizfixedid=$_GET["quizfixedid"];
			else $quizfixedid="";
			if (isset($_POST["attempt"])) $attempt=$_POST["attempt"];
			elseif (isset($_GET["attempt"])) $attempt=$_GET["attempt"];
			else $attempt=0;
			$userid=intval(trim($_SESSION["idmoodle"])); 
			$fullname=$_SESSION['fullname'];
			$profileimageurl=$_SESSION['avatar_chico'];
if($attempt==0){ 
	  //buscar nro de intentos
	$ur1 = $uri.'v2/index.php/gesinpol_quiz_fixed_not_tiempo';
	$parametro1="userid=".$userid."&quizfixedid=".$quizfixedid;
	$tupl1 = resulrow($ur1, $parametro1);	
	$solicitu1=count($tupl1["quizfixet"]);
	if($solicitu1>0){ 
		$title="Reporte de Intentos Previos";
?>
<div align="left"><h4>Resumen <small>de sus Intentos Previos</small></h4></div>
<hr />
<div class="table-responsive">
<table id="example" class="table table-hover c_table">
<thead>
<tr class="bg-success text-white">
<th>Intento</th>
<th>Fecha de Realizaci&oacute;n</th>
<th>Tiempo Empleado</th>
<th>Calificaci&oacute;n</th>
<th>Posici&oacute;n</th>
<th>Opción</th>
</tr>
</thead>	
<tbody>			
<?php 
	$quizid	  = $tupl1["quizfixed"]["questionfailed"];
	$courseid = $tupl1["quizfixed"]["courseid"];
	
	$ur21 = $uri.'v2/index.php/gesinpol_curso_categorias';
	$parametro21 = "courseid=".$courseid;
	$t21 = resulrow($ur21, $parametro21);
	$cat=$t21["cat"]; 
	
	$ur91 = $uri.'v2/index.php/gesinpol_cursos';
	$parametro91 = "courseid=".$courseid;
	$t91 = resulrow($ur91, $parametro91);
	$catid = $t91['cursos']['category'];
	
	$ur22 = $uri.'v2/index.php/gesinpol_quiz_fixed_ranking_show';
	$parametro22 = "quizid=".$quizid;
	$tupl2 = resulrow($ur22, $parametro22);
	$posranki = count($tupl2["quizfixedas"]);

foreach ($tupl1["quizfixet"] as $tup1){
	
	$attempt = $tup1["attempt"];
	$timei	 = $tup1["ts"];
	$timeseg = $tup1["tf"] - $tup1["ts"];
	$total	 = $tup1["total"];
	$dur = segundostocadena($timeseg);
	$i=1;
	$qa=$quizfixedid."".$attempt;
	$posicion=0;
	foreach ($tupl2["quizfixedas"] as $t22){
		if ($qa==$t22["qa"]){ $posicion=$i; break; }
		$i++;
	}
 ?>
<tr>
    <td><a title="Revisar respuesta"  href="simulacro.php?tipo=<?PHP echo $_GET["tipo"]; ?>&op=a&quizfixedid=<?PHP echo $quizfixedid; ?>&attempt=<?PHP echo $attempt; ?>"><?PHP echo $attempt; ?></a></td>
    <td><?PHP echo date("d-m-Y H:i:s", $timei); ?></td>
    <td><?PHP echo $dur; ?></td>
    <td>
    <?PHP 
		if ($total) {echo number_format($total, 2, ',', '.')." de 100,00 puntos";} 
					else echo "0,00 de 100,00 puntos";
	 ?>
    </td>   
    <td><?PHP echo "<b>".$posicion."</b> de ".$posranki; ?></td>
    <td>
    <form id="asig-form" action="simulacro.php?tipo=<?PHP echo $_GET["tipo"]; ?>&op=a" method="post">
      <input type='hidden' name='quizfixedid' value='<?PHP echo $quizfixedid; ?>'>
      <input type='hidden' name='attempt' value='<?PHP echo $attempt; ?>'>
      
      <input type='hidden' name='courseid' value='<?PHP echo $courseid; ?>'>
   	  <input type='hidden' name='coursecatid' value='<?PHP echo $catid; ?>'>
      
      <button type="submit" class="btn btn-warning btn-xs waves-effect text-white" id="asignar_registro" name="asignar_registro" value="Revisar"><i class="zmdi zmdi-eye" data-toggle="tooltip" title="Revisar"></i></button>
    </form>
    </td>
  </tr>	
<?php }//foreach tup1 ?>
</tbody>
</table>
</div>
<hr />
<div class="col-12"><?php /*?>simulacro.php?tipo=<?PHP echo $_GET["tipo"]; ?>&op=m<?php */?>
   <div class="form-group" style="text-align: right;">
   <?php if ($_GET["tipo"]==8){ ?>
   <form id="contact-form" action="area_estudio_ajax.php?curso=<?PHP echo $courseid; ?>&cat=<?PHP echo $cat; ?>" method="post">
   <?php }else{ ?>
   <form id="contact-form" action="simulacro.php?tipo=<?PHP echo $_GET["tipo"]; ?>&op=m" method="post">
   <?php } ?>
   <input type='hidden' name='quizfixedid' value='<?php echo $quizfixedid; ?>'>
   <input type='hidden' name='courseid' value='<?PHP echo $courseid; ?>'>
   <input type='hidden' name='coursecatid' value='<?PHP echo $catid; ?>'>
   
   <input type="submit" class="btn btn-lg btn-warning text-white" id="regresa_reg" name="regresa_reg" value="Volver">
   </form>
   </div>
  </div>
<?php }else{
		echo"<script language='JavaScript'>alert('No Existen Respuestas!')</script>";
		if ($_GET["tipo"]==8){
	  		if (isset($_POST["courseid"])) $courseid=$_POST["courseid"];
			elseif (isset($_GET["courseid"])) $courseid=$_GET["courseid"];
			else $courseid=0;
			$ur21 = $uri.'v2/index.php/gesinpol_curso_categorias';
			$parametro21 = "courseid=".$courseid;
			$t21 = resulrow($ur21, $parametro21);
			$cat=$t21["cat"]; 
			echo"<script language='JavaScript'>window.self.location='area_estudio_ajax.php?curso=".$courseid."&cat=".$cat."';</script>";	
   		}else{
	  		echo"<script language='JavaScript'>window.self.location='simulacro.php?tipo=".$_GET["tipo"]."&op=m';</script>";	
   		} 
	  }
	}
elseif($attempt>=1)
	{		
	  $ur2 = $uri.'v2/index.php/gesinpol_quiz_fixed_not_tiempo';
	  $parametro2 = "userid=".$userid."&quizfixedid=".$quizfixedid."&attempt=".$attempt;
	  $t2 = resulrow($ur2, $parametro2);
	  $timei=$timef=$timeseg=$total=$dur=0;
	  foreach ($t2["quizfixet"] as $tup1){
		$timei	 = $tup1["ts"];
		$timef	 = $tup1["tf"];
		$timeseg = $tup1["tf"] - $tup1["ts"];
		$total	 = $tup1["total"];
	    $dur = segundostocadena($timeseg);
	  }
	  if (isset($t2["quizfixed"]))
	  {
		  $courseid=$t2["quizfixed"]["courseid"];
		  $quizid=$t2["quizfixed"]["questionfailed"];
		  $name=$t2["quizfixed"]["name"];
		  $notas=number_format($total, 5, '.', ',');
		  
		  $ur21 = $uri.'v2/index.php/gesinpol_curso_categorias';
		  $parametro21 = "courseid=".$courseid;
		  $t21 = resulrow($ur21, $parametro21);
		  $cat=$t21["cat"];
		  
		  $ur91 = $uri.'v2/index.php/gesinpol_cursos';
		  $parametro91 = "courseid=".$courseid;
		  $t91 = resulrow($ur91, $parametro91);
		  $catid = $t91['cursos']['category'];		  
?>
<div class="row clearfix">
<div class="col-11" align="left"><h4>Resumen <small>de <?PHP echo $t2["quizfixed"]["name"]; ?></small></h4></div>
<div class="col-1" align="right">
<style>
.btn-flotanted {
	font-size: 16px; /* Cambiar el tamaño de la tipografia */
	text-transform: uppercase; /* Texto en mayusculas */
	text-align:center;
	font-weight: bold; /* Fuente en negrita o bold */
	color: #fff; /* Color del texto */
	border-radius: 5px; /* Borde del boton */
	letter-spacing: 2px; /* Espacio entre letras */
	background-color: #004C45; /* Color de fondo */
	padding: 18px 30px; /* Relleno del boton */
	position: fixed;
	top: 150px;
	right: 40px;
	transition: all 300ms ease 0ms;
	box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
	z-index: 98;
	height: 2.375rem;
    min-width: 2.375rem;
    width: 2.375rem;
    padding: 0;
    font-size: .9375rem;
    overflow: hidden;
    line-height: 2.375rem;
}
.btn-flotanted:hover {
	background-color: #004C45; /* Color de fondo al pasar el cursor */
	color: #fff; /* Color del texto */
	box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.3);
	transform: translateY(-7px);
}
@media only screen and (max-width: 600px) {
 	.btn-flotanted {
		font-size: 14px;
		/*padding: 12px 20px;*/
		top: 150px;
		right: 20px;
	}
}
.espacios {
   padding-top: 0px !important;
    padding-right: 0px !important;
    padding-bottom: 0px !important;
    padding-left: 0px !important;
}
</style> 

<button type="button" class="btn-flotanted btn-icon openBtng<?php echo $quizfixedid; ?>"><i class="zmdi zmdi-tag-more" data-toggle="tooltip" title="Resumen de Preguntas"></i></button>
<script>
$('.openBtng<?php echo $quizfixedid; ?>').on('click',function(){
  $('.modal-body-respreg').load('web/xxecuer/detalleres.php?quizfixedid=<?php echo $quizfixedid; ?>&attempt=<?php echo $attempt; ?>',function(){
	  $('#resumenpreglargeModal').modal({show:true});
  });
});
</script>

<!-- Large Size -->
<div class="modal fade" id="resumenpreglargeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="resumenpregLabel">Resumen Preguntas</h4>
            </div>
            <div class="modal-body-respreg"> 


            </div>
        </div>
    </div>
</div>
<!-- #END# Modal Size Example --> 
</div>
<div class="col-md-6 col-lg-6" align="left">
<table class="table table-hover theme-color">
<tbody>
<tr>
    <th class="col-2"><a href="javascript:void(0);"><img class="avatarm" src="<?php echo $profileimageurl; ?>" title="<?php echo $fullname; ?>" /></a></th>
    <td class="col-4"><a href="javascript:void(0);"><?PHP echo $fullname; ?></a></td>
</tr>
<tr>
    <th>Intentos</th>
    <td><span id="intentos"></span></td>
</tr>
<tr>
    <th>Comenzado el</th>
    <td><?PHP echo date("d-m-Y H:i:s", $timei); ?></td>
</tr>
<tr>
    <th>Finalizado en</th>
    <td><?PHP echo date("d-m-Y H:i:s", $timef); ?></td>
</tr>
<tr>
    <th>Tiempo empleado</th>
    <td><?PHP echo $dur; ?></td>
</tr>
<tr>
    <th>Calificación</th>
    <td><?PHP if ($total) {echo "<b>".number_format($total, 2, ',', '.')."</b> de 100,00 ";} else echo "<b>0,00</b> de 100,00"; ?> puntos</td>
</tr>
<?php if ($_GET["tipo"]==7){ } else{ ?>
<tr>
    <th>Posici&oacute;n</th>
    <td><span id="posicion"></span></td>
</tr>
<?php } ?>
</tbody>
</table>
<hr />
</div>
<div id="dest" class="col-md-6 col-lg-6" align="left"></div>
<div class="col-12">
   <div class="form-group" style="text-align: right;">
   <?php if ($_GET["tipo"]==8){ ?>
   <form id="contact-form" action="area_estudio_ajax.php?curso=<?PHP echo $courseid; ?>&cat=<?PHP echo $cat; ?>" method="post">
   <?php }else{ ?>
   <form id="contact-form" action="simulacro.php?tipo=<?PHP echo $_GET["tipo"]; ?>&op=m" method="post">
   <?php } ?>
    <input type='hidden' name='quizfixedid' value='<?php echo $quizfixedid; ?>'>
   <input type='hidden' name='courseid' value='<?PHP echo $courseid; ?>'>
   <input type='hidden' name='coursecatid' value='<?PHP echo $catid; ?>'>
   <input type="submit" class="btn btn-lg btn-warning float-right text-white" id="regresa_reg" name="regresa_reg" value="Volver">
   </form>
   <?php if ($_GET["tipo"]==7){ } else{ ?>
   <form id="resul-form" action="simulacro.php?tipo=<?PHP echo $_GET["tipo"]; ?>&op=e" method="post">
   <input type='hidden' name='courseid' value='<?PHP echo $courseid; ?>'>
   <input type='hidden' name='quizid' value='<?PHP echo $quizid; ?>'>
   <input type='hidden' name='name' value='<?PHP echo $name; ?>'>
   <button type="submit" class="btn btn-warning btn-lg float-right text-white" id="cambia_registro" name="cambia_registro" value="Iniciar">Iniciar Nuevo Intento</button>
	</form>
    <?php } ?>
   </div>
</div>

<div id="detallepreg" class="row clearfix">	</div>
<div class="col-12">
   <div class="form-group" style="text-align: right;">
   <?php if ($_GET["tipo"]==8){ ?>
   <form id="contact-form" action="area_estudio_ajax.php?curso=<?PHP echo $courseid; ?>&cat=<?PHP echo $cat; ?>" method="post">
   <?php }else{ ?>
   <form id="contact-form" action="simulacro.php?tipo=<?PHP echo $_GET["tipo"]; ?>&op=m" method="post">
   <?php } ?>
     <input type='hidden' name='quizfixedid' value='<?php echo $quizfixedid; ?>'>
     <input type='hidden' name='courseid' value='<?PHP echo $courseid; ?>'>
     <input type='hidden' name='coursecatid' value='<?PHP echo $catid; ?>'>
     <input type="submit" class="btn btn-lg btn-warning float-right text-white" id="regresa_reg" name="regresa_reg" value="Volver">
   </form>
<?php 
$url = $uri.'v2/index.php/gesinpol_curso_secciones_select';
$parametros="courseid=".$courseid;
$resp = resulrow($url, $parametros);
$solicitud=count($resp["sections"]);
$tipo=$_GET["tipo"];
if ($tipo==5){ $findme = 'ZONA DE NOVEDADES'; } 
elseif ($tipo==6){ $findme = 'TEST ALEATORIO'; }
else { $findme = 'TEST '; }
if($solicitud>0){
	 foreach($resp["sections"] as $fil3) {
		$mystring = $fil3["name"];
		$pos = strpos($mystring, $findme);
		$entro = 0;
		// Nótese el uso de ===. Puesto que == simple no funcionará como se espera
		// porque la posición de 'a' está en el 1° (primer) caracter.
		if ($pos === false) { if ($tipo==5){ $entro = 1; } 
		} else { if (($tipo==6) || ($tipo==8)){ $entro = 1;  } }
		
		
		if ($entro == 1){
		$coursesectionsid=$fil3["id"];
		$url = $uri.'v2/index.php/gesinpol_items_tema_curso';
		$parametros="curso=".$courseid."&tema=".$coursesectionsid;
		$tupla = resulrow($url, $parametros);
		$solicitud=count($tupla);
		if($solicitud>0){	
		$imp=0;
		  foreach($tupla["items"] as $tupl1) {
		  $url2 = $uri.'v2/index.php/gesinpol_curso_quiz';
		  $parametro2="course=".$courseid."&id=".$tupl1["instance"];
		  $tupla2 = resulrow($url2, $parametro2);
		  $name=$tupla2["cursoquiz"];
			  if($name!=""){
				  if ($imp==1){
			  ?>
			  <form id="resul-form" action="simulacro.php?tipo=<?PHP echo $_GET["tipo"]; ?>&op=e" method="post">
			  <input type='hidden' name='courseid' value='<?PHP echo $courseid; ?>'>
			  <input type='hidden' name='quizid' value='<?PHP echo $tupl1["instance"]; ?>'>
			  <input type='hidden' name='name' value='<?PHP echo $name; ?>'>
			  <button type="submit" class="btn btn-warning btn-lg float-right text-white" id="cambia_registro" name="cambia_registro" value="Iniciar"><?PHP echo $name; ?></button>
			  </form>
			  <?php 
				  break;
				  }
			  if ($tupl1["instance"]==$quizid){$imp=1;}else{$imp=0;}
			  }//if name
		  }//foreach tupl1
		}//if solicitud
		}//if pos
     }//foreach fil3
}//if solicitud
?>                             
   </div>
  </div>
</div>
<style>
.btn-flotante {
	font-size: 16px; /* Cambiar el tamaño de la tipografia */
	text-transform: uppercase; /* Texto en mayusculas */
	text-align: center;
	font-weight: bold; /* Fuente en negrita o bold */
	color: #ffffff; /* Color del texto */
	border-radius: 5px; /* Borde del boton */
	letter-spacing: 2px; /* Espacio entre letras */
	background-color: #004C45; /* Color de fondo */
	padding: 18px 30px; /* Relleno del boton */
	position: fixed;
	bottom: 40px;
	right: 40px;
	transition: all 300ms ease 0ms;
	box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
	z-index: 99;
	height: 2.375rem;
    min-width: 2.375rem;
    width: 2.375rem;
    padding: 0;
    font-size: .9375rem;
    overflow: hidden;
    line-height: 2.375rem;
}
.btn-flotante:hover {
	background-color: #004C45; /* Color de fondo al pasar el cursor */
	color: #ffffff; /* Color del texto */
	box-shadow: 0px 15px 20px rgba(0, 0, 0, 0.3);
	transform: translateY(-7px);
}
@media only screen and (max-width: 600px) {
 	.btn-flotante {
		font-size: 14px;
		/*padding: 12px 20px;*/
		bottom: 20px;
		right: 20px;
	}
} 
</style>
<a id="btnfl" href="#" class="btn-flotante btn-icon btn-icon-mini btn-round"><i class="zmdi zmdi-chevron-up" data-toggle="tooltip" title="Ir al Top"></i></a>
<div id="rc" class="info"></div>
<div id="rcf" class="info"></div>
<script type="text/javascript">
var lastScrollTop = 0;
$(window).scroll(function(event){
   var st = $(this).scrollTop();
   if (st > lastScrollTop){
       // downscroll code
       document.getElementById("btnfl").style.display = "inline"
   } else {
      // upscroll code
      document.getElementById("btnfl").style.display = "none"
   }
   lastScrollTop = st;
});

function intentos(val1,val2,val3,val4) {
	$('#intentos').html('<img src="assets/images/loader.gif" /> ...'); 
	$.ajax({
			type: "POST",
			url: "web/xxecuer/intentos.php",
			data: {val1: val1, val2: val2, val3: val3, val4: val4},
			//dataType: "json",           
			success: function(resp){
				 $("#intentos").html(resp);
				 //$("#pr").val(resp.pr);
			}
		});  
 }
 setTimeout(intentos(<?PHP echo $quizid; ?>,<?PHP echo $attempt; ?>,<?PHP echo $quizfixedid; ?>,<?PHP echo $_GET["tipo"]; ?>),1000);
 
<?php if ($_GET["tipo"]==7){ } else{ ?>
function ranking(val1,val2,val3) {
	$('#posicion').html('<img src="assets/images/loader.gif" /> ...'); 
	$.ajax({
			type: "POST",
			url: "web/xxecuer/ranking.php",
			data: {val1: val1, val2: val2, val3: val3},
			//dataType: "json",           
			success: function(resp){
				 $("#posicion").html(resp);
				 //$("#pr").val(resp.pr);
			}
		});  
 }
 setTimeout(ranking(<?PHP echo $quizid; ?>,<?PHP echo $attempt; ?>,<?PHP echo $quizfixedid; ?>),2000);

 function nmoodle(val1,val2,val3) {
	$('#rc').html('<img src="assets/images/loader.gif" /> ...'); 
	$.ajax({
			type: "POST",
			url: "web/xxecuer/namoodle.php",
			data: {val1: val1, val2: val2, val3: val3},
			//dataType: "json",           
			success: function(resp){
				 $("#rc").html(resp);
				 //$("#rc").val(resp.msg);
			}
		});  
 }
 setTimeout(nmoodle(<?PHP echo $quizid; ?>,<?PHP echo $attempt; ?>,<?PHP echo $notas; ?>),3000);
 <?php } ?>
 function estadisticas(val1,val2,val3) {
	$('#dest').html('<img src="assets/images/loader.gif" /> ...'); 
	$.ajax({
			type: "POST",
			url: "web/xxecuer/detalleest.php",
			data: {val1: val1, val2: val2, val3: val3},
			//dataType: "json",           
			success: function(resp){
				 $("#dest").html(resp);
				 //$("#pr").val(resp.pr);
			}
		});  
 }
 setTimeout(estadisticas(<?PHP echo $quizid; ?>,<?PHP echo $attempt; ?>,<?PHP echo $quizfixedid; ?>),5000);
 
 function detallepreg(val1,val2,val3) {
	$('#detallepreg').html('<img src="assets/images/loader.gif" /> ...'); 
	$.ajax({
			type: "POST",
			url: "web/xxecuer/detallepreg.php",
			data: {val1: val1, val2: val2, val3: val3},
			//dataType: "json",           
			success: function(resp){
				 $("#detallepreg").html(resp);
				 //$("#pr").val(resp.pr);
			}
		});  
 }
 setTimeout(detallepreg(<?PHP echo $quizid; ?>,<?PHP echo $attempt; ?>,<?PHP echo $quizfixedid; ?>),7000);
<?php if ($_GET["tipo"]==7){ } else{ ?> 
 function nmoodlef(val1,val2,val3,val4) {
	$('#rcf').html('<img src="assets/images/loader.gif" /> Calculando Estadisticas...'); 
	$.ajax({
			type: "POST",
			url: "web/xxecuer/namoodlef.php",
			data: {val1: val1, val2: val2, val3: val3, val4: val4},
			//dataType: "json",           
			success: function(resp){
				 $("#rcf").html(resp);
				 //$("#rc").val(resp.msg);
			}
		});  
 }
 setTimeout(nmoodlef(<?PHP echo $quizid; ?>,<?PHP echo $attempt; ?>,<?PHP echo $courseid; ?>,<?PHP echo $quizfixedid; ?>),9000);
 <?php } ?>
</script>
<?PHP }/*else{echo"<img src='img/noencontrado.png'/>";}*/
	/*}else{echo"<img src='img/noencontrado.png'/>";}*/
}/*else{echo"<img src='img/noencontrado.png'/>";}*/
?>