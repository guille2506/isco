<?PHP
//error_reporting(0);
			if (isset($_POST["quizfixedid"])) $quizfixedid=$_POST["quizfixedid"];
			elseif (isset($_GET["quizfixedid"])) $quizfixedid=$_GET["quizfixedid"];
			else $quizfixedid="";
			if (isset($_POST["attempt"])) $attempt=$_POST["attempt"];
			elseif (isset($_GET["attempt"])) $attempt=$_GET["attempt"];
			else $attempt=0;
			$userid=$_SESSION['id'];
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
<table id="example" class="table table-hover c_table">
<thead>
<tr class="bg-success text-white">
<th>Intento</th>
<th>Fecha de Realizaci&oacute;n</th>
<th>Tiempo Empleado</th>
<th>Calificaci&oacute;n</th>
<th>Opción</th>
</tr>
</thead>	
<tbody>			
<?php 
	/*$quizid	  = $tupl1["quizfixed"]["questionfailed"];
	$courseid = $tupl1["quizfixed"]["courseid"];
	$ur21 = $uri.'v2/index.php/gesinpol_curso_categorias';
	$parametro21 = "courseid=".$courseid;
	$t21 = resulrow($ur21, $parametro21);
	$cat=$t21["cat"]; 
	$ur22 = $uri.'v2/index.php/gesinpol_quiz_fixed_ranking_show';
	$parametro22 = "quizid=".$quizid;
	$tupl2 = resulrow($ur22, $parametro22);
	$posranki = count($tupl2["quizfixedas"]);*/
foreach ($tupl1["quizfixet"] as $tup1){
	
	$attempt = $tup1["attempt"];
	$timei	 = $tup1["ts"];
	$timeseg = $tup1["tf"] - $tup1["ts"];
	$total	 = $tup1["total"];
	$dur = segundostocadena($timeseg);
	/*$i=1;
	$qa=$quizfixedid."".$attempt;
	$posicion=0;
	foreach ($tupl2["quizfixedas"] as $t22){
		if ($qa==$t22["qa"]){ $posicion=$i; break; }
		$i++;
	}*/
 ?>
<?php 
/*foreach ($tupl1["attemps"] as $tup1){
  $attempt=$tup1["attempt"];
  $ur2 = $uri.'v2/index.php/gesinpol_quiz_fixed_not_tiempo';
  $parametro2 = "userid=".$userid."&quizfixedid=".$quizfixedid."&attempt=".$attempt;
  $t2 = resulrow($ur2, $parametro2);
  $dur = segundostocadena($t2["timeseg"]);
  $timei=$t2["timei"]; */
?>
<tr>
    <td><a title="Revisar respuesta"  href="simulacro.php?tipo=<?PHP echo $_GET["tipo"]; ?>&op=a&quizfixedid=<?PHP echo $quizfixedid; ?>&attempt=<?PHP echo $attempt; ?>"><?PHP echo $attempt; ?></a></td>
    <td><?PHP echo date("d-m-Y H:i:s", $timei); ?></td>
    <td><?PHP echo $dur; ?></td>
    <td>
    <?PHP 
		//echo " d1 ".$d1." d2 ".$d2;
		if ($total) {echo number_format($total, 2, ',', '.')." de 100,00 puntos";} 
					else echo "0,00 de 100,00 puntos";
	 ?>
    </td>
    <td>
    <form id="asig-form" action="simulacro.php?tipo=<?PHP echo $_GET["tipo"]; ?>&op=a" method="post">
      <input type='hidden' name='quizfixedid' value='<?PHP echo $quizfixedid; ?>'>
      <input type='hidden' name='attempt' value='<?PHP echo $attempt; ?>'>
      <button type="submit" class="btn btn-warning btn-xs waves-effect text-white" id="asignar_registro" name="asignar_registro" value="Revisar"><i class="zmdi zmdi-eye" data-toggle="tooltip" title="Revisar"></i></button>
    </form>
    </td>
  </tr>	
<?php }//foreach tup1 ?>
</tbody>
</table>
<hr />
<div class="col-12">
   <div class="form-group" style="text-align: right;">
   <form id="contact-form" action="simulacro.php?tipo=<?PHP echo $_GET["tipo"]; ?>&op=m" method="post">
    <input type='hidden' name='quizfixedid' value='<?php echo $quizfixedid; ?>'>
   <input type="submit" class="btn btn-lg btn-warning waves-effect waves-oranget" id="regresa_reg" name="regresa_reg" value="Volver">
   </form>
   </div>
  </div>
<?php }else{
		echo"<script language='JavaScript'>alert('No Existen Respuestas!')</script>";
	echo"<script language='JavaScript'>window.self.location='simulacro.php?tipo=".$_GET["tipo"]."&op=m';</script>";	
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
		$ur2 = $uri.'v2/index.php/gesinpol_quiz_fixed_attempt_show';
		$parametro2 = "quizfixedid=".$quizfixedid."&attempt=".$attempt."&userid=".$userid;
		$tupl2 = resulrow($ur2, $parametro2);
		$t=$tupl2["t"];
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
		padding: 12px 20px;
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
  $('.modal-body-respreg').load('web/xxecuer/detalleres.php?quizfixedid=<?php echo $quizfixedid; ?>&attempt=<?php echo $attempt; ?>&t=<?php echo $t; ?>',function(){
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
<?php /*?><tr>
    <td colspan="2"><h4>Resumen de <?PHP echo $t2["quizfixed"]["name"]; ?></h4></td>
</tr><?php */?>
<tr>
    <th class="col-2"><a href="javascript:void(0);"><img class="avatarm" src="<?php echo $profileimageurl; ?>" title="<?php echo $fullname; ?>" /></a></th>
    <td class="col-4"><a href="javascript:void(0);"><?PHP echo $fullname; ?></a></td>
</tr>
<tr>
    <th>Intentos</th>
    <td>
    <?php
    //buscar nro de intentos
    $ur1 = $uri.'v2/index.php/gesinpol_quiz_fixed_intentos';
	$parametro1="userid=".$userid."&quizfixedid=".$quizfixedid."&attempt=".$attempt;
	$tupl1 = resulrow($ur1, $parametro1);	
	$solicitu1=$tt=count($tupl1["attemps"]);
	if($solicitu1>0){ 
         $ii=1;
         foreach ($tupl1["attemps"] as $tup1){
         $attemp=$tup1["attempt"];
         if ($attemp==$attempt) echo "<strong>$attemp</strong>";
         else echo '<a title="Revisar Respuesta" href="simulacro.php?tipo='.$_GET["tipo"].'&op=a&quizfixedid='.$quizfixedid.'&attempt='.$attemp.'">'.$attemp.'</a>';
         if ($ii<$tt) echo ", ";
         $ii++;
          }
      }
    ?>
</tr>
<tr>
    <th>Comenzado el</th>
    <td><?PHP echo date("d-m-Y H:i:s", $timei);//userdate($timei, get_string('strftimedatetime')); ?></td>
</tr>
<tr>
    <th>Finalizado en</th>
    <td><?PHP echo date("d-m-Y H:i:s", $timef);//userdate($timef, get_string('strftimedatetime')); ?></td>
</tr>
<tr>
    <th>Tiempo empleado</th>
    <td><?PHP echo $dur; ?></td>
</tr>
<tr>
    <th>Calificación</th>
    <td><?PHP 
            if ($total) {echo "<b>".number_format($total, 2, ',', '.')."</b> de 100,00 ";} else echo "<b>0,00</b> de 100,00"; ?> puntos</td>
</tr> 
<tr>
    <th>Estado</th>
    <td>Finalizado</td>
</tr>
</tbody>
</table>
<hr />
</div>
<?PHP
	$pa = 0; $pc = 0; $pf = 0; $pb = 0; $fraction=0.00; 
	foreach($tupl2["quizfixedas"] as $tupla20){
	$answerss = $tupla20["answerid"];
	$answesid = explode(",", $answerss);
	$trs=count($answesid);
	if(is_null($answerss)){$pb++;}
	else{
	$aa=0; $qualifys=0; $cc1=$ccc=0;
	$ur4 = $uri.'v2/index.php/gesinpol_quiz_fixed_attempt_answer_show';
	$parametro4 = "questionid=".$tupla20["questionid"]."&fraction=".$fraction;
	$tupl40 = resulrow($ur4, $parametro4);
	$trcc=$tupl40["trc"];
		foreach($tupl40["tuplas4"] as $tupla40){
			if ($tupla40["id"]==$answesid["$aa"]) {
				if ($tupla40["fraction"]>$fraction){	
					$cc1++;
				}
				$qualifys=$qualifys+$tupla40["fraction"]; $ccc++;
			}
			if ($trs==1){}else{$aa++;}
		}
		if($cc1==$trcc && $cc1==$ccc){ $pa++; }
		else{ if($qualifys>$fraction){ $pc++; }else{ $pf++;}}
	}
	}
?>
<div class="col-md-6 col-lg-6" align="left">

  <div class="alert alert-success" role="alert">
    <div class="container">
        <div class="alert-icon">
            <i class="zmdi zmdi-thumb-up"></i>
        </div>
        <strong>PREGUNTAS RESPONDIDAS ACERTADAS:</strong> <?PHP echo $pa; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">
                <i class="zmdi zmdi-close"></i>
            </span>
        </button>
    </div>
</div>
<div class="alert alert-danger" role="alert">
    <div class="container">
        <div class="alert-icon">
            <i class="zmdi zmdi-block"></i>
        </div>
        <strong>PREGUNTAS RESPONDIDAS NO ACERTADAS:</strong> <?PHP echo $pf; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">
                <i class="zmdi zmdi-close"></i>
            </span>
        </button>
    </div>
</div>
<div class="alert alert-warning" role="alert">
    <div class="container">
        <div class="alert-icon">
            <i class="zmdi zmdi-thumb-up"></i>
        </div>
        <strong>PREGUNTAS PARCIALMENTE ACERTADAS:</strong> <?PHP echo $pc; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">
                <i class="zmdi zmdi-close"></i>
            </span>
        </button>
    </div>
</div>
<div class="alert alert-info" role="alert">
    <div class="container">
        <div class="alert-icon">
            <i class="zmdi zmdi-alert-circle-o"></i>
        </div>
        <strong>PREGUNTAS SIN RESPONDER:</strong> <?PHP echo $pb; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">
                <i class="zmdi zmdi-close"></i>
            </span>
        </button>
    </div>
</div>
<hr />
  <div class="progress-container progress-success">
      <span class="progress-badge">Preguntas Respondidas Acertadas</span> <?PHP $ppa=($pa*100)/$t; ?>
      <div class="progress">
          <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?PHP echo $ppa; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?PHP echo $ppa; ?>%;">
              <span class="progress-value"><?PHP echo number_format($ppa, 2, ',', '.'); ?>%</span>
          </div>
      </div>
  </div>
  <div class="progress-container progress-warning">
      <span class="progress-badge">Preguntas Parcialmente Acertadas</span> <?PHP $ppc=($pc*100)/$t; ?>
      <div class="progress">
          <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?PHP echo $ppc; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?PHP echo $ppc; ?>%;">
              <span class="progress-value"><?PHP echo number_format($ppc, 2, ',', '.'); ?>%</span>
          </div>
      </div>
  </div>
  <div class="progress-container progress-danger">
      <span class="progress-badge">Preguntas Respondidas No Acertadas</span> <?PHP $ppf=($pf*100)/$t; ?>
      <div class="progress">
          <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?PHP echo $ppf; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?PHP echo $ppf; ?>%;">
              <span class="progress-value"><?PHP echo number_format($ppf, 2, ',', '.'); ?>%</span>
          </div>
      </div>
  </div>
  <div class="progress-container progress-info">
      <span class="progress-badge">Preguntas Sin Responder</span> <?PHP $ppb=($pb*100)/$t; ?>
      <div class="progress">
          <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?PHP echo $ppb; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?PHP echo $ppb; ?>%;">
              <span class="progress-value"><?PHP echo number_format($ppb, 2, ',', '.'); ?>%</span>
          </div>
      </div>
  </div>

</div>
  <div class="col-12">
   <div class="form-group" style="text-align: right;">
   <form id="contact-form" action="simulacro.php?tipo=<?PHP echo $_GET["tipo"]; ?>&op=m" method="post">
    <input type='hidden' name='quizfixedid' value='<?php echo $quizfixedid; ?>'>
   <input type="submit" class="btn btn-lg btn-warning waves-effect waves-oranget" id="regresa_reg" name="regresa_reg" value="Volver">
   </form>
   </div>
  </div>
</div>
<div class="row clearfix">	
<?PHP
  	/*$ur2 = $uri.'v2/index.php/gesinpol_quiz_fixed_attempt_show';
	$parametro2 = "quizfixedid=".$quizfixedid."&attempt=".$attempt."&userid=".$userid;
	$tupl2 = resulrow($ur2, $parametro2);
	$t=$tupl2["t"];*/
	foreach($tupl2["quizfixedas"] as $tupla2)	
	{
		$idp=$tupla2["sequencenumber"];
		$ur3 = $uri.'v2/index.php/gesinpol_quiz_fixed_attempt_question';
		$parametro3="quizfixedid=".$quizfixedid."&idp=".$idp."&attempt=".$attempt."&userid=".$userid;
		$tupla3 = resulrow($ur3, $parametro3);
		$questionid = $tupla3["quizpreguntas"]["questionid"];
		$qfasid     = $tupla3["quizpreguntas"]["qfasid"];
		$puntua		= $tupla3["quizpreguntas"]["defaultmark"];
		$sum		= $tupla3["quizpreguntas"]["single"];
		$respondida = "Sin responder aún";
		$idp=$tupla2["sequencenumber"];
		if (isset($puntua)){} else {$puntua	= 0.00;}
		
?>
	<div id="<?PHP echo $tupla2["sequencenumber"]; ?>" class="col-md-3 col-lg-3 text-letf">
        <div class="card">
            <div class="body" style="color: #004C45">                            
                <h3><strong>Pregunta <?PHP echo $tupla2["sequencenumber"];//$idp; ?><?php /*?> de <?php */?><?PHP //echo $t; ?></strong></h3>
                <div class="bg-warning" style="padding-block: 10px">
                    <div class="text" style="margin: 10px;"><strong><?PHP if (isset($tupla3["quizpreguntas"]["answerid"])) {$respondida = "Respuesta guardada";} echo $respondida; ?></strong></div>
                    <div class="number"  style="margin: 10px;"><strong>Punt&uacute;a: <?PHP if ($tupla2["qualify"]) echo number_format($tupla2["qualify"], 2, ',', '.'); else echo "0.00"; ?> puntos</strong></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9 col-lg-9 text-letf">
        <div class="card">
            <div class="body">
            <p><strong>
			<?PHP 
			$pos = strpos($tupla3["quizpreguntas"]["questiontext"], '@@/');
			if ($pos > 0){
			$ur31 = $uri.'v2/index.php/gesinpol_quiz_fixed_question_usage';
			$parametro31 = "courseid=".$courseid."&questionid=".$questionid."&userid=".$userid."&quizid=".$quizid."&idp=".$idp."&quizfixedid=".$quizfixedid."&attempt=".$attempt;
			$tupla31 = resulrow($ur31, $parametro31);
			echo $tupla31["messagetext"];
			}else{
			//echo strip_tags($tupla3["quizpreguntas"]["questiontext"]); 
			echo $tupla3["quizpreguntas"]["questiontext"];			
			}?>   
            
            </strong></p> 
            <hr />	  
<?PHP 
	$fraction=0.00;
	$card=1;
	$ur4 = $uri.'v2/index.php/gesinpol_quiz_fixed_attempt_answer_show';
	$parametro4 = "questionid=".$tupla2["questionid"]."&fraction=".$fraction;
	$tupl4 = resulrow($ur4, $parametro4);
	$tupla5["trc"]=$tupl4["trc"];
			/*$sum=0;*/ $tr=1;
			//foreach($tupl4["tuplas4"] as $tupla6){
			foreach($tupla3["quizrespuesta"] as $tupla6){
				//if($tupla6["fraction"]==1.0) $sum=1;
				$tr++;
			}

			//$tr=count($tupl4["tuplas4"]);
			if($tr!=0){
			$i=0;$cont=1;$a=0;$c=$p=0;$r=NULL;$resp='<div class="alert alert-danger"><strong>Respuesta Incorrecta.</strong> </div>';
 			//foreach($tupl4["tuplas4"] as $tupla4)
			foreach($tupla3["quizrespuesta"] as $tupla4)
			{
				if ($card==1) $l='a'; elseif ($card==2) $l='b'; elseif ($card==3) $l='c'; elseif ($card==4) $l='d'; elseif ($card==5) $l='e'; elseif ($card==6) $l='f';
			if ($tupla4["fraction"]>$fraction) {/*if ($r==NULL){}else{*/$r=$r.$l.".) ";/*}*/$r=$r.strip_tags($tupla4["answer"])." ";}
			if($tupla3["quizpreguntas"]["qtype"]=="multichoice"){
			if ($sum==1){
				 if ($i==0) {$j=$tupla4["id"];}
				 if ($tupla4["id"]==$tupla2["answerid"]) {
					 if ($tupla4["fraction"]>$fraction){
					 	$resp='<div class="alert alert-success"><strong>Respuesta Correcta.</strong></div>';}
					 	$s='checked="checked" disabled="disabled"';$c++;}
					 else{$s='disabled="disabled"';} 
				if($tupla2["answerid"]==NULL){$resp='<div class="alert alert-info"><strong>Sin Contestar.</strong></div>';}
	?>
            <div class="radio">
                <input type="radio" name="r<?PHP echo $j; ?>" id="r<?PHP echo $tupla4["id"]; ?>" <?PHP echo $s; ?> />
                <label for="r<?PHP echo $tupla4["id"]; ?>"><strong><span style="color: #004C45;"><?PHP echo $l; ?>.) <?PHP echo strip_tags( $tupla4["answer"]); ?></span></strong></label>
            </div>
            <hr />
     <?php 	}else{	
				$answers = $tupla2["answerid"];
				$answerid = explode(",", $answers);
				if (in_array($tupla4["id"], $answerid)){
				//if ($tupla4["id"]==$answerid[$a]) {
					if ($tupla4["fraction"]>$fraction){$resp='<div class="alert alert-success"><strong>Respuesta Correcta.</strong></div>';$c++;}
					 $s='checked="checked" disabled="disabled"';$a++;}
			 	else{$s='disabled="disabled"';}
			 if($cont==$tr){
			if($c<$tupla5["trc"] && $c==count($answerid)){$resp='<div class="alert alert-warning"><strong>Respuesta Parcialmente Correcta.</strong></div>';}
			elseif($cont==count($answerid) && $cont>$c){$resp='<div class="alert alert-danger"><strong>Respuesta Incorrecta.</strong></div>';}
			elseif($c<count($answerid)){$resp='<div class="alert alert-danger"><strong>Respuesta Incorrecta.</strong></div>';}	 
			}
			if($answers==NULL){$resp='<div class="alert alert-info"><strong>Sin Contestar.</strong></div>';}
			 $cont++;
	?>
            <div class="checkbox">
                <input type="checkbox" name="ch" <?PHP echo $s; ?> />
                <label for="ch"><strong><span style="color: #004C45;"><?PHP echo $l; ?>.) <?PHP echo strip_tags($tupla4["answer"]); ?></span></strong></label>
            </div>
            <hr />
     <?php 	}	?>
     <?PHP  }elseif($tupla3["quizpreguntas"]["qtype"]=="truefalse"){  
	 			 if ($i==0) {$j=$tupla4["id"];}
				 if ($tupla4["id"]==$tupla2["answerid"]) {
					 if ($tupla4["fraction"]>$fraction){
					 	$resp='<div class="alert alert-success"><strong>Respuesta Correcta.</strong></div>';}
					 	$s='checked="checked" disabled="disabled"';$c++;}
					 else{$s='disabled="disabled"';} 
			if($tupla2["answerid"]==NULL){$resp='<div class="alert alert-info"><strong>Sin Contestar.</strong></div>';}
	 ?>
            <div class="radio">
                <input type="radio" name="r<?PHP echo $j; ?>" id="r<?PHP echo $tupla4["id"]; ?>" <?PHP echo $s; ?> />
                <label for="r<?PHP echo $tupla4["id"]; ?>"><strong><span style="color: #004C45;"><?PHP echo $l; ?>.) <?PHP echo strip_tags( $tupla4["answer"]); ?></span></strong></label>
            </div>
            <hr />
      <?PHP $i++;} //elseif truefalse multichoice
	  $card++;}//foreach tupla4
	  		}//$tr!=0 ?>
            <div class="panel-footer">
               <div class="feedback">
                  <div class="specificfeedback"><?PHP echo $resp; ?></div>
                   <?php /*?><div class="rightanswer alert alert-primary"><i class="zmdi zmdi-alert-circle-o"></i><small> La Respuesta Correcta es: </small> <?PHP echo $r; ?></div><?php */?>
                  <div class="rightanswer  alert alert-primary" role="alert">
                      <div class="container">
                          <div class="alert-icon">
                              <i class="zmdi zmdi-notifications"></i>
                          </div>
                          <strong><small><?PHP if (isset($r)) { echo "La Respuesta Correcta es: ";} else { echo "Información"; }?> </small></strong> <?PHP echo $r; ?>
                          <?php /*?><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">
                                  <i class="zmdi zmdi-close"></i>
                              </span>
                          </button><?php */?>
                      </div>
                  </div>
                  <div class="generalfeedback">
				  <?PHP 
					  $pos = strpos($tupla3["quizpreguntas"]["generalfeedback"], '@@/');
					  if ($pos > 0){
						$gfb="generalfeedback";
					  $ur31 = $uri.'v2/index.php/gesinpol_quiz_fixed_question_usage';
					  $parametro31 = "courseid=".$courseid."&questionid=".$questionid."&userid=".$userid."&quizid=".$quizid."&idp=".$idp."&quizfixedid=".$quizfixedid."&attempt=".$attempt."&gfb=".$gfb;
					  $tupla31 = resulrow($ur31, $parametro31);
					  echo $tupla31["messagetext"];
					  }else{
					  //echo strip_tags($tupla3["quizpreguntas"]["questiontext"]); 
					  echo $tupla3["quizpreguntas"]["generalfeedback"];			
					  }
				?>   
				  
				  <?PHP //echo $tupla3["quizpreguntas"]["generalfeedback"]; ?>
                </div>
               </div>
            </div>
            </div>
        </div>
    </div>
<?PHP } //foreach tupla2 ?>
 <div class="row  clearfix">
  <div class="col-12">
   <div class="form-group" style="text-align: right;">
   <form id="contact-form" action="simulacro.php?tipo=<?PHP echo $_GET["tipo"]; ?>&op=m" method="post">
    <?php echo"<input type='hidden' name='quizfixedid' value='$quizfixedid'>"; ?>
   <input type="submit" class="btn btn-lg btn-warning pull-right" id="regresa_reg" name="regresa_reg" value="Volver">
   </form>
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
		padding: 12px 20px;
		bottom: 20px;
		right: 20px;
	}
} 
</style>
<a id="btnfl" href="#" class="btn-flotante btn-icon btn-icon-mini btn-round"><i class="zmdi zmdi-chevron-up" data-toggle="tooltip" title="Ir al Top"></i></a>

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
/*$(document).ready(function(){
	//var altoVentana = $('#Ventana').css('height').replace("px","");//usa este para que desaparezca despues de pasar el alto del div
	alert("hola");
	var altoVentana = 0;
	var posicionVentana = document.getElementById("btnfl").offsetTop;
	$(window).scroll(function(event){
		var posicionScroll = $(this).scrollTop();
	   	if (posicionScroll > (parseInt(posicionVentana)+parseInt(altoVentana))){
	    	$("#btnfl").css("display","none");
	   	} else {
	    	$("#btnfl").css("display","");
	   	}

	});
});*/
</script>
<?PHP }/*else{echo"<img src='img/noencontrado.png'/>";}*/
	/*}else{echo"<img src='img/noencontrado.png'/>";}*/
}/*else{echo"<img src='img/noencontrado.png'/>";}*/
?>