<?PHP
//error_reporting(0);
 date_default_timezone_set('Europe/Madrid');
	if (isset($_POST["courseid"])) $courseid=$_POST["courseid"];
	elseif (isset($_GET["courseid"])) $courseid=$_GET["courseid"];
	else $courseid=0;
	if (isset($_POST["quizid"])) $quizid=$_POST["quizid"];
	elseif (isset($_GET["quizid"])) $quizid=$_GET["quizid"];
	else $quizid=0;
	if (isset($_POST["name"])) $name=$_POST["name"];
	elseif (isset($_GET["name"])) $name=$_GET["name"];
	else $name="";

    $p=0;
	$userid=intval(trim($_SESSION["idmoodle"]));
	$qtype=2;
?>
<style>
.reloj {
  font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
  width: auto;
  /*padding: 20px;*/
  font-size: 2em;
  text-align: center;
  color: #fff;
  background: rgba(0,76,69,.8);
  z-index: 100;
}
.reloj2 {
  font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
  width: auto;
  /*padding: 20px;*/
  font-size: 2em;
  text-align: center;
  color: #fff;
  background: rgba(255,255,255,1.0);
  z-index: 90;
}
.reloj .cajaSegundos {
  display: inline-block;  
}
.reloj .ampm, .reloj .segundos{
  display: block;
  font-size: 2rem;
}
</style>
<form id="formpreg" action="simulacro.php?tipo=<?PHP echo $_GET["tipo"]; ?>&op=e" method="post">
<?PHP if(isset($_POST["cambia_registro"])){   ?>
<?PHP  
$url = $uri.'v2/index.php/gesinpol_quiz_fixed';
$parametros="courseid=".$courseid."&quizid=".$quizid."&qtype=".$qtype."&name=".$name."&userid=".$userid;
//$parametros="quizfixedid=".$quizfixedid."&questionrandom=".$questionrandom."&qtype=".$qtype."&userid=".$userid;

$tupla = resulrow($url, $parametros);

	$p=1;
	if(isset($tupla))
	{
	$attempt=$tupla["attempt"];
	$quizfixedid=$tupla["quizfixed"]["quizfixedid"];
	$quizid=$tupla["quizfixed"]["quizid"];
	$courseid=$tupla["quizfixed"]["courseid"];
	$name=$tupla["quizfixed"]["name"];
	$questionpage=$tupla["questionpage"];
	$timeopen=$tupla["timeopen"];
	$timeclose=$tupla["timeclose"];
	$timelimit=$tupla["quizfixed"]["timelimit"];
	$j=$tupla["total"];
	$idp=1;
?>
<div class="col-8" style="margin: 0 auto;">
    <div class="card">
        <div class="body taskboard planned_task">
            <div class="dd" data-plugin="nestable">
                <ol class="dd-list">
                    <li class="dd-item" data-id="1">
                        <div class="dd-handle d-flex justify-content-between align-items-center">
                            <div class="h5 mb-0"><strong><?PHP echo $tupla["quizfixed"]["name"]; ?></strong></div>
                            <div class="action">
                                <a href="simulacro.php?tipo=<?PHP echo $_GET["tipo"]; ?>&op=m"><i class="zmdi zmdi-close" style="color: #000 !important"></i></a>
                            </div>
                        </div>
                        <div class="dd-content p-15">
                            <p>
                             <span style="align-content:center"><?PHP echo $tupla["quizfixed"]["intro"]; ?> </span>
                            <ul class="list-unstyled activity">
<?PHP 			if ($timelimit>0) {
				//$tf= $timelimit * $j;
				$tf= $timelimit;
				$tt=segundostocadena($tf);
?>				                            
                            <li class="a_code">
                            	<h4>Tiempo para responder es de:</h4>
                                    <?PHP echo $tt; ?>
                            </li>
<?PHP           } ?>                  
                            <li class="a_code">
                            	<h4>Número de preguntas del cuestionario:</h4>
                                    <?PHP echo $j; ?>
                            </li>
                            <li class="a_code">
                            	<h4>Número de Intentos del cuestionario:</h4>
                                    <?PHP echo $attempt; ?>
                            </li>
                            <li class="a_code">
                            	<h4>Elige un tipo de corrección:</h4>
                                    
									<div class="radio">
                                        <input type="radio" name="ropcion" id="radio1" value="1" checked="checked">
                                        <label for="radio1">Al finalizar</label>
                                        <input type="radio" name="ropcion" id="radio2" value="2">
                                        <label for="radio2">Pregunta a pregunta</label>
                                    </div>

                            </li>
                            </ul>
<?PHP 			
				echo"<input type='hidden' name='tf' value='".$tf."'>";
				echo"<input type='hidden' name='tp' value='".$j."'>";
				echo"<input type='hidden' name='attempt' value='".$attempt."'>";
				echo"<input type='hidden' name='courseid' value='".$courseid."'>";
				echo"<input type='hidden' name='quizfixedid' value='".$quizfixedid."'>";
				echo"<input type='hidden' name='name' value='".$name."'>";
				echo"<input type='hidden' name='idp' value='".$idp."'>";
				//echo"<input type='hidden' name='questionrandom' value='".$questionrandom."'>";
				echo"<input type='hidden' name='timelimit' value='".$timelimit."'>";
				echo"<input type='hidden' name='timeopen' value='".$timeopen."'>";
				echo"<input type='hidden' name='timeclose' value='".$timeclose."'>";
				echo"<input type='hidden' name='questionpage' value='".$questionpage."'>";
				echo"<input type='hidden' name='quizid' value='".$quizid."'>";
?>
     						</p>
                      <div class="d-flex justify-content-between">
                      <input type="submit" class="btn btn-warning btn-block btn-lg waves-effect" id="asigna_reg" name="asigna_reg" value="INICIAR TEST">
                      </div>
					</div>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>

    <?PHP 
	}}else{  
	if (isset($tuplq)) {
		$timeopen=$tuplq["quizfixed"]["timeopen"];
		$timeclose=$tuplq["quizfixed"]["timeclose"];	
	}else{
		$timeopen=$_POST["timeopen"];
		$timeclose=$_POST["timeclose"];
	}
	$timelimit=$_POST["timelimit"];
	$questionpage=$_POST["questionpage"];
	$courseid=$_POST["courseid"];
	$quizid=$_POST["quizid"];
	if (isset($_POST["quizfixedid"])) $quizfixedid=$_POST["quizfixedid"];
	elseif (isset($_GET["quizfixedid"])) $quizfixedid=$_GET["quizfixedid"];
	else $quizfixedid=0;
	if (isset($_POST["attempt"])) $attempt=$_POST["attempt"];
	elseif (isset($_GET["attempt"])) $attempt=$_GET["attempt"];
	else $attempt=0;
	if (isset($_POST["idp"])) $idp=$_POST["idp"];
	elseif (isset($_GET["idp"])) $name=$_GET["idp"];
	else $idp=0;
	if (isset($_POST["ropcion"])) $ropcion=$_POST["ropcion"];
	  elseif (isset($_GET["ropcion"]))  $ropcion=$_GET["ropcion"];
	  else { $ropcion=0; }

	$maxpreg = $questionpage; 
	$t = $_POST["tp"];
	if($maxpreg==0) $maxpreg = 10;	//else $maxpreg = 10;
	if ($idp==0){ $idp++;}
	$mp = $idp+$maxpreg;
	$n  = $mp/$maxpreg;
	if (is_int($n)){$e=$n;} else
	{list($e, $d) = explode('.', $n);}
	$idp = $idmp =($e*$maxpreg)-($maxpreg-1);
	$mp  = $e*$maxpreg;
	//total de preguntas
	if ($mp > $t) $mp = $t;
	//echo $mp; echo " mp <br>";
echo '<div class="row clearfix"><div class="col-2 position-fixed reloj"><span><label id="countdown"></label></span></div>';
//echo '<div class="col-2 reloj2"><span><label id="countdown"></label></span></div>';
echo '<div class="col-12" align="center"><h4><strong>'.$_POST["name"].'</strong></h4></div></div>';
echo '<div class="row clearfix">';	
	for ($idp=$idmp;$idp<=$mp;$idp++){
		$url = $uri.'v2/index.php/gesinpol_quiz_fixed_attempt_question';
		$parametros="quizfixedid=".$quizfixedid."&idp=".$idp."&attempt=".$attempt."&userid=".$userid."&quizid=".$quizid;
		$tupla2 = resulrow($url, $parametros);
		$questionid = $tupla2["quizpreguntas"]["questionid"];
		$qfasid     = $tupla2["quizpreguntas"]["qfasid"];
		$marcar     = $tupla2["quizpreguntas"]["flagged"];
		$puntua		= $tupla2["quizpreguntas"]["defaultmark"];
		$sum		= $tupla2["quizpreguntas"]["single"];
		$respondida = "Sin responder aún";
		if (isset($puntua)){} else {$puntua	= 0.00;}
?>

	<div id="<?PHP echo $idp; ?>" class="col-md-3 col-lg-3 text-letf">
        <div class="card">
            <div class="body" style="color: #004C45">                            
                <h3><strong>Pregunta <?PHP echo $idp; ?><?php /*?> de <?php */?><?PHP //echo $t; ?></strong></h3>
                <div class="bg-warning" style="padding-block: 10px">
                    <div id="resultado_msg_<?PHP echo $idp; ?>" class="text" style="margin: 10px;"><strong><?PHP if (isset($tupla2["quizpreguntas"]["answerid"])) {$respondida = "Respuesta guardada";} echo $respondida; ?></strong></div>
                    <div class="number"  style="margin: 10px;"><strong>Puntúa como <?PHP echo number_format($puntua, 2, '.', ''); ?></strong></div>
                </div>

<?PHP  /*echo '<a href="javascript:enviarMail_'.$idp.'('.$courseid.', '.$quizid.', '.$attempt.', '.$questionid.', '.$idp.', '.$userid.');" class="btn btn-warning btn-block btn-lg waves-effect" id="e1" title="Notifcar Error Pregunta con errores">Notificar Error</a><br />';*/
?>
<?php /*?>			<div id="resultado_mensaje_<?PHP echo $idp; ?>" class="info"></div>
			<script>
			function enviarMail_<?PHP echo $idp; ?>(val1, val2, val3, val4, val5, val6)
			{
			var confirmAction = confirm("Esta seguro de Notificar Error en la Pregunta N° <?PHP echo $idp; ?>");
		    if (confirmAction) {
			$("#resultado_mensaje_<?PHP echo $idp; ?>").html('<img src="assets/images/loader.gif" /> Por favor espere un momento');  
			$.ajax({
					type: "POST",
					url: "web/xxcfijo/enviarp.php",
					data: {val1: val1, val2: val2, val3: val3, val4: val4, val5: val5, val6: val6},
					success: function(resp){
					$("#resultado_mensaje_<?PHP echo $idp; ?>").html(resp);
					}
				});  
			}
			}			
			</script><?php */?>
            <button type="button" class="btn btn-warning btn-block btn-lg text-white waves-effect openBtnem<?php echo $idp; ?>">Notificar Error</button>
			<script>
			$('.openBtnem<?php echo $idp; ?>').on('click',function(){
			  $('.modal-body-enviarmail').load('web/xxcfijo/enviarpm.php?val1=<?php echo $courseid; ?>&val2=<?php echo $quizid; ?>&val3=<?php echo $attempt; ?>&val4=<?php echo $questionid; ?>&val5=<?php echo $idp; ?>&val6=<?php echo $userid; ?>',function(){
				  $('#enviarmaillargeModal').modal({show:true});
			  });
			});
			</script>
            <div id="resultado_marca_<?PHP echo $idp; ?>" class="info">
<?PHP if($marcar==1){ echo '<a href="javascript:enviarMarca_'.$idp.'('.$qfasid.', '.$idp.', 2);" class="btn btn-warning btn-block btn-lg waves-effect" id="mp1" title="Marcar Pregunta">Marcar Pregunta</a><br />';}
else{ echo '<a href="javascript:enviarMarca_'.$idp.'('.$qfasid.', '.$idp.', 1);" class="btn btn-warning btn-block btn-lg waves-effect" id="mp1" title="Desmarcar Pregunta">Desmarcar Pregunta</a><br />';}
?>            
            </div>
			<script>
			function enviarMarca_<?PHP echo $idp; ?>(val1, val2, val3)
			{
			
			$("#resultado_marca_<?PHP echo $idp; ?>").html('<img src="assets/images/loader.gif" /> Por favor espere un momento');  
			$.ajax({
					type: "POST",
					url: "web/xxecuer/enviarm.php",
					data: {val1: val1, val2: val2, val3: val3},
					success: function(resp){
					$("#resultado_marca_<?PHP echo $idp; ?>").html(resp);
					}
				});  
			}
			
			</script>
            </div>
        </div>
    </div>
<?php /*?>    <div class="col-md-3 col-lg-3 text-letf">
        <div class="card">
            <div class="body">                            
                <p style="color: gray"><?PHP echo strip_tags($tupla2["quizpreguntas"]["questiontext"]); ?></p>
            </div>
        </div>
    </div><?php */?>
	<div class="col-md-9 col-lg-9 text-letf">
        <div class="card">
            <div class="body">
            <h5><strong><?PHP 
			$pos = strpos($tupla2["quizpreguntas"]["questiontext"], '@@/');
			if ($pos > 0){
			$ur31 = $uri.'v2/index.php/gesinpol_quiz_fixed_question_usage';
			$parametro31 = "courseid=".$courseid."&questionid=".$questionid."&userid=".$userid."&quizid=".$quizid."&idp=".$idp."&quizfixedid=".$quizfixedid."&attempt=".$attempt;
			// $parametro31 = "questiontext=".$tupla2["quizpreguntas"]["questiontext"]."&courseid=".$courseid."&questionid=".$questionid."&userid=".$userid;
			$tupla31 = resulrow($ur31, $parametro31);
			echo $tupla31["messagetext"];
			}else{
			//echo strip_tags($tupla2["quizpreguntas"]["questiontext"]); 
			echo $tupla2["quizpreguntas"]["questiontext"];			
			}?>   
            
            </strong></h5> 
            <hr />
    <?PHP $card=1; $fraction=0.00; $blanco=0; $ss='';  $cont=1;
	$c1=$c=$cc=$p=0;$r=NULL;$resp='<div class="alert alert-danger"><strong>Respuesta Incorrecta.</strong></div>';
	if($tupla2["quizpreguntas"]["qtype"]=="multichoice"){
			$a=0; $auxid=0; /*$sum=0;*/$idjs=""; $qualify=0;
			/*foreach($tupla2["quizrespuesta"] as $tupla5)
			{ if($tupla5["fraction"]==1.0) $sum++;}*/
			if ($sum==1){
			foreach($tupla2["quizrespuesta"] as $tupla55)
			{
			if ($ropcion == 2){ $idjs .= 'document.getElementById("r'.$tupla55["id"].'").disabled = true;'; }
			}
			}else{
			foreach($tupla2["quizrespuesta"] as $tupla55)
			{
			if ($ropcion == 2){ $idjs .= 'document.getElementById("ch'.$tupla55["id"].'").disabled = true;'; }
			}	
			}
			foreach($tupla2["quizrespuesta"] as $tupla4)
			{
				if ($card==1) $l='a'; elseif ($card==2) $l='b'; elseif ($card==3) $l='c'; elseif ($card==4) $l='d'; elseif ($card==5) $l='e'; elseif ($card==6) $l='f';
				if ($tupla4["fraction"]>$fraction) {/*if ($r==NULL){}else{*/$r=$r.$l.".) ";/*}*/$r=$r.strip_tags($tupla4["answer"])." ";}
			if ($sum==1){ ?>
	<?PHP //if($tupla4["id"]==$auxid) {} else{ ojo es todo?>
			<?php /*?><div class="msg_list">
                <span class="check">
                	<input type="radio" name="b<?PHP echo $idp; ?>" id="b<?PHP echo $tupla4["id"]; ?>" value="0" <?PHP echo $s; ?> /></span>
                <span class="message"><label for="b<?PHP echo $tupla4["id"]; ?>">Dejar en Blanco</label></span>
            </div><?php */?>
    <?PHP //$aux=$tupla4["id"];} hasta aqui ?>	
	<?PHP				
	if ($ropcion == 2){
		$s=''; $imgr='';
		if($tupla2["quizpreguntas"]["answerid"]==NULL){}
		elseif ($tupla4["id"]==$tupla2["quizpreguntas"]["answerid"]) {
			  if ($tupla4["fraction"]>$fraction){	
					$resp='<div class="alert alert-success"><strong>Respuesta Correcta.</strong></div>';
					$imgr='<img class="imagen" src="assets/images/ai.svg" width="48" height="48" alt="Respuesta Correcta">';
			  }else{$imgr='<img class="imagen" src="assets/images/ei.svg" width="48" height="48" alt="Respuesta Incorrecta">';}
				$s=' checked="checked" disabled="disabled"';$c++;
		}else{$s=' disabled="disabled"';} 

	}elseif ($tupla4["id"]==$tupla2["quizpreguntas"]["answerid"]) {$s=' checked="checked"'; $ss='document.getElementById("e'.$idp.'a").style.display = "block";';
	}else{$s='';} 
	?>        
            <div class="radio">
                <input type="radio" name="r<?PHP echo $idp; ?>" id="r<?PHP echo $tupla4["id"]; ?>" value="<?PHP echo $tupla4["id"]; ?>" <?PHP echo $s; ?> onChange="enviarResp_<?PHP echo $idp; ?>(this.value,<?PHP echo $t; ?>,<?PHP echo $qfasid; ?>)" />
                <label for="r<?PHP echo $tupla4["id"]; ?>"><strong><span style="color: #004C45;"><?PHP echo $l; ?>.) <?PHP echo strip_tags( $tupla4["answer"]); ?></span></strong>
     <?PHP if ($ropcion == 2){ echo '<span id="resultado_img_'.$tupla4["id"].'">'.$imgr.'</span>'; } ?>  </label>
                
                <?php /*?><div id="resultado_msg_<?PHP echo $idp; ?>" class="info"></div><?php */?>
            <script>
			function enviarResp_<?PHP echo $idp; ?>(val1, val2, val3)
			{
				<?PHP echo $idjs; ?>
			$("#resultado_msg_<?PHP echo $idp; ?>").html('<img src="assets/images/loader.gif" /> Por favor espere un momento');  
			/*$.ajax({
					type: "POST",
					url: "web/xxecuer/enviarr.php",
					data: {val1: val1, val2: val2, val3: val3},
					success: function(resp){
					$("#resultado_msg_<?PHP //echo $idp; ?>").html(resp);
					}
				});*/
			$.ajax({
            		type: "POST",
					url: "web/xxecuer/enviarr.php",
					data: {val1: val1, val2: val2, val3: val3},
            		dataType: "json",           
					success: function(resp){
						 $("#resultado_msg_<?PHP echo $idp; ?>").html(resp.msg);
						 $("#resultado_img_"+val1).html(resp.img); 
						 $("#resultado_prg_<?PHP echo $idp; ?>").html(resp.prg);               
					}

    			});  
				document.getElementById("e<?PHP echo $idp; ?>a").style.display = "block";
			}
			
			</script>
            </div>
            <hr />
    <?php 	}else{	
				if ($ropcion == 2){
				  $ur44 = $uri.'v2/index.php/gesinpol_quiz_fixed_attempt_answer_show';
				  $parametro44 = "questionid=".$questionid."&fraction=".$fraction;
				  $tupl44 = resulrow($ur44, $parametro44);
				  $tupla515["trc"]=$tupl44["trc"];				  
				  $tr=0;
				  foreach($tupla2["quizrespuesta"] as $tupla66){	$tr++; }
				}
				$blanco=1;
				$answers = $tupla2["quizpreguntas"]["answerid"];
				$answerid = explode(",", $answers);
				if ($ropcion == 2){
					$s=''; $imgr='';
					if(is_null($answers)){}
					elseif ($tupla4["id"]==$answerid["$a"]) {
						  if ($tupla4["fraction"]>$fraction){	
								$resp='<div class="alert alert-success"><strong>Respuesta Correcta.</strong></div>';
								$imgr='<img class="imagen" src="assets/images/ai.svg" width="48" height="48" alt="Respuesta Correcta">';
							$c1++;
						  }else{$imgr='<img class="imagen" src="assets/images/ei.svg" width="48" height="48" alt="Respuesta Incorrecta">';}
							$s=' checked="checked" disabled="disabled"';$cc++;
							$qualify=$qualify+$tupla4["fraction"];
					}else{$s=' disabled="disabled"';} 
					if($c1==$tupla515["trc"] && $c1==$cc){$resp='<div class="alert alert-success"><strong>Respuesta Correcta.</strong></div>';}
					elseif($cont==$tr){
					if($qualify>$fraction){$resp='<div class="alert alert-warning"><strong>Respuesta Parcialmente Correcta.</strong></div>';}
					else{$resp='<div class="alert alert-danger"><strong>Respuesta Incorrecta.</strong></div>';}
					}
					 $cont++;
			
				}elseif ($tupla4["id"]==$answerid["$a"]) {$s='checked="checked"';
				}else{$s='';} 
				$a++;
				/*if ($tupla4["id"]==$answerid["$a"]) {$s='checked="checked"';$a++;}
			 	else{$s='';}*/
	?>        
           <div class="checkbox">
                <input type="checkbox" id="ch<?PHP echo $tupla4["id"]; ?>"  <?PHP echo $s; ?> onClick="enviarResp_<?PHP echo $tupla4["id"]; ?>(<?PHP echo $tupla4["id"]; ?>,<?PHP echo $t; ?>,<?PHP echo $qfasid; ?>,<?PHP echo $card; ?>)" />
                <label for="ch<?PHP echo $tupla4["id"]; ?>"><strong><span style="color: #004C45;"><?PHP echo $l; ?>.) <?PHP echo strip_tags($tupla4["answer"]); ?></span></strong><?PHP if ($ropcion == 2){ echo '<span id="resultado_img_'.$idp.'_'.$card.'">'.$imgr.'</span>'; } ?></label>
            <?php /*?><div id="resultado_val_<?PHP echo $tupla4["id"]; ?>" class="info"></div><?php */?>
			<script>
			function enviarResp_<?PHP echo $tupla4["id"]; ?>(val1, val2, val3, val4)
			{
				var val5 = $("#ch<?PHP echo $tupla4["id"]; ?>").is(":checked") ? 2:1; 
				<?PHP //echo $idjs; ?>
			$("#resultado_msg_<?PHP echo $idp; ?>").html('<img src="assets/images/loader.gif" /> Por favor espere un momento');
			$.ajax({
            		type: "POST",
					url: "web/xxecuer/enviarch.php",
					data: {val1: val1, val2: val2, val3: val3, val4: val4, val5: val5},
            		dataType: "json",           
					success: function(resp){
						 $("#resultado_msg_<?PHP echo $idp; ?>").html(resp.msg);
						 $("#resultado_cor_<?PHP echo $idp; ?>").html(resp.cor); 
						 /*$("#resultado_prg_<?PHP //echo $idp; ?>").html(resp.prg);
						 $("#resultado_val_"+val1).html(resp.val); */              
					}

    			});  
			}
			
			</script>
            </div>
            <hr />
     <?php 	}	?> 
     <?PHP  $card++; }
	 	  }elseif($tupla2["quizpreguntas"]["qtype"]=="truefalse"){   
	 		foreach($tupla2["quizrespuesta"] as $tupla4)
			{ 
				if ($tupla4["fraction"]>$fraction) {if ($r==NULL){}else{$r=$r."<br />- ";}$r=$r.strip_tags($tupla4["answer"]);}
				if ($ropcion == 2){
					$s=''; $imgr='';
					if($tupla2["quizpreguntas"]["answerid"]==NULL){}
					elseif ($tupla4["id"]==$tupla2["quizpreguntas"]["answerid"]) {
						  if ($tupla4["fraction"]>$fraction){	
							$resp='<div class="alert alert-success"><strong>Respuesta Correcta.</strong></div>';
							$imgr='<img class="imagen" src="assets/images/ai.svg" width="48" height="48" alt="Respuesta Correcta">';
						  }else{$imgr='<img class="imagen" src="assets/images/ei.svg" width="48" height="48" alt="Respuesta Incorrecta">';}
							$s=' checked="checked" disabled="disabled"';$c++;
					}else{$s=' disabled="disabled"';} 			
				}elseif ($tupla4["id"]==$tupla2["quizpreguntas"]["answerid"]) {$s=' checked="checked"'; $ss='document.getElementById("e'.$idp.'a").style.display = "block";';
				}else{$s='';}       
	 ?>
            <div class="radio">
                 <input type="radio" name="r<?PHP echo $idp; ?>" id="r<?PHP echo $tupla4["id"]; ?>" value="<?PHP echo $tupla4["id"]; ?>" <?PHP echo $s; ?> onChange="enviarResp_<?PHP echo $idp; ?>(this.value,<?PHP echo $t; ?>,<?PHP echo $qfasid; ?>)" />
                <label for="r<?PHP echo $tupla4["id"]; ?>"><strong><span style="color: #004C45;"><?PHP echo $l; ?>.) <?PHP echo strip_tags( $tupla4["answer"]); ?></span></strong><span id="resultado_img_<?PHP echo $tupla4["id"]; ?>"><?PHP echo $imgr; ?></span></label>
               	<?php /*?><div id="resultado_msg_<?PHP echo $idp; ?>" class="info"></div><?php */?>
            <script>
			function enviarResp_<?PHP echo $idp; ?>(val1, val2, val3)
			{
				<?PHP echo $idjs; ?>
			$("#resultado_msg_<?PHP echo $idp; ?>").html('<img src="assets/images/loader.gif" /> Por favor espere un momento');  
			$.ajax({
            		type: "POST",
					url: "web/xxecuer/enviarr.php",
					data: {val1: val1, val2: val2, val3: val3},
            		dataType: "json",           
					success: function(resp){
						 $("#resultado_msg_<?PHP echo $idp; ?>").html(resp.msg);
						 $("#resultado_img_"+val1).html(resp.img); 
						 $("#resultado_prg_<?PHP echo $idp; ?>").html(resp.prg);               
					}

    			}); 
				document.getElementById("e<?PHP echo $idp; ?>a").style.display = "block";  
			}
			
			</script>
            </div>
            <hr />
       <?PHP $card++; }} //} ?>
       <?PHP if($ropcion == 2) {} else if($blanco == 1) {} else{ $val1=0; //ojo es todo ?>
			<div class="radio">
                 <?php /*?><input type="radio" name="r<?PHP echo $idp; ?>" id="r<?PHP echo $idp; ?>0" value="<?PHP echo $val=0; ?>"  class="sr-only" onChange="enviarResp_<?PHP echo $idp; ?>0(this.value,<?PHP echo $t; ?>,<?PHP echo $qfasid; ?>)" />
                <label for="r<?PHP echo $idp; ?>0"><strong><span style="color: #004C45;"><?PHP //$l++; echo $l; ?>Quitar mi elección</span></strong></label><?php */?>
               	<a href="javascript:enviarResp_<?PHP echo $idp; ?>a(<?PHP echo $val1; ?>,<?PHP echo $t; ?>,<?PHP echo $qfasid; ?>);" style="display:none;" class="btn btn-warning btn-block btn-lg text-white" id="e<?PHP echo $idp; ?>a" title="Quitar mi elección">Quitar mi elección</a><br />
            <script>
			<?PHP echo $ss; ?>
			function enviarResp_<?PHP echo $idp; ?>a(val1, val2, val3)
			{
			
			$("#resultado_msg_<?PHP echo $idp; ?>").html('<img src="assets/images/loader.gif" /> Por favor espere un momento');  
			$.ajax({
            		type: "POST",
					url: "web/xxecuer/enviarr.php",
					data: {val1: val1, val2: val2, val3: val3},
            		dataType: "json",           
					success: function(resp){
						 $("#resultado_msg_<?PHP echo $idp; ?>").html(resp.msg);
						 $("#resultado_prg_<?PHP echo $idp; ?>").html(resp.prg);               
					}

    			}); 
			document.querySelectorAll('[name=r<?PHP echo $idp; ?>]').forEach((x) => x.checked=false);
			document.getElementById("e<?PHP echo $idp; ?>a").style.display = "none";	 
			}
			
			</script>
            </div>
            <?php /*?><hr /><?php */?>
    <?PHP } //hasta aqui ?>
	   <?PHP if ($ropcion == 2){ ?> 
       <div id="resultado_cor_<?PHP echo $idp; ?>" class="info">
       </div>
			<script>
			function enviarCorregir_<?PHP echo $idp; ?>(val1)
			{
			<?PHP echo $idjs; ?>
			$("#resultado_cor_<?PHP echo $idp; ?>").html('<img src="assets/images/loader.gif" /> Por favor espere un momento');  
			$.ajax({
					type: "POST",
					url: "web/xxecuer/enviarchi.php",
					data: {val1: val1},
            		dataType: "json",           
					success: function(resp){
						 $("#resultado_cor_<?PHP echo $idp; ?>").html(resp.msg);
						 $("#resultado_prg_<?PHP echo $idp; ?>").html(resp.prg);
						 <?PHP for ($ii=1;$ii<$card;$ii++) { ?>
						 $("#resultado_img_<?PHP echo $idp; ?>_<?PHP echo $ii; ?>").html(resp.img<?PHP echo $ii; ?>); 
						 <?PHP } ?>
						 
					}
				});  
			}
			
			</script>
	   
       <div id="resultado_prg_<?PHP echo $idp; ?>">
	   <?PHP if($tupla2["quizpreguntas"]["answerid"]==NULL){} else { ?>
          <button class="btn btn-success l-turquoise waves-effect" type="button" data-toggle="collapse" data-target="#collapsePreg<?PHP echo $tupla2["quizpreguntas"]["sequencenumber"]; ?>" aria-expanded="false" aria-controls="collapseExample"> MOSTRAR Solución </button>
            <div class="collapse" id="collapsePreg<?PHP echo $tupla2["quizpreguntas"]["sequencenumber"]; ?>">
            <div class="panel-footer">
               <div class="feedback">
                  <div class="specificfeedback"><?PHP echo $resp; ?></div>
                  <div class="rightanswer  alert alert-primary" role="alert">
                      <div class="container">
                          <div class="alert-icon">
                              <i class="zmdi zmdi-notifications"></i>
                          </div>
                          <strong><small>La Respuesta Correcta es: </small></strong> <?PHP echo $r; ?>
                          <?php /*?><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">
                                  <i class="zmdi zmdi-close"></i>
                              </span>
                          </button><?php */?>
                      </div>
                  </div>
                  <div class="generalfeedback"><?PHP echo $tupla2["quizpreguntas"]["generalfeedback"]; ?></div>
                  <?php /*?><div class="rightanswer"><i class="fa fa-angle-double-right"></i> <?PHP echo $r; ?></div><?php */?>
               </div>
            </div>
            </div>
       <?PHP } ?>
       </div> 
       <?PHP } ?>    
            </div>
        </div>
    </div>

<?php }//end for 
echo '</div>';
?>  
<?php 
	$ti=strtotime("now");
	$ide=0;
	//$idmp = $mp-$maxpreg;
    echo"<input type='hidden' name='quizfixedid' value='".$quizfixedid."'>
    <input type='hidden' name='idp' id='idp' value='".$mp."'>
	<input type='hidden' name='mp' value='".$mp."'>
	<input type='hidden' name='attempt' value='".$attempt."'>
	<input type='hidden' name='tp' value='".$_POST["tp"]."'>
	<input type='hidden' name='ti' value='".$ti."'>
	<input type='hidden' name='questionpage' id='questionpage' value='".$questionpage."'>
	<input type='hidden' name='timelimit' id='timelimit' value='".$timelimit."'>
	<input type='hidden' name='timeopen' id='timeopen' value='".$timeopen."'>
	<input type='hidden' name='timeclose' id='timeclose' value='".$timeclose."'>
	<input type='hidden' name='courseid' value='".$courseid."'>
	<input type='hidden' name='quizid' value='".$quizid."'>
	<input type='hidden' name='ropcion' value='".$ropcion."'>
	<input type='hidden' name='name' value='".$_POST["name"]."'>";
 ?>
<div class="col-md-12" style="text-align:center;">
    <ul class="pagination pagination-warning">
<?php
	$pag=$maxpreg;$answerid=NULL; $nropag=1;
	for ($j=1;$j<=$t;$j++){
	//pregunta respodida
	if((($j%$pag) == 0) || ($j == $t)){
	$pa=($idp-1)/$maxpreg;
	if ($pa==$nropag) {
		$class = " active"; 
		$maxp=$j+$maxpreg; 
		if ($maxp >= $t){ $ide = $t;	}
				   else{ $ide = $j+$maxpreg;  }
	}else {$class = "";}
	$pg = $j-$maxpreg; echo "<br>";
	if($j == $t){ if(($j%$pag) == 0){}else{ $pg = $t;} }
?>
	<li class="page-item<?php echo $class; ?>"><input type="button" class="page-link" id="actua_regp" name="actua_regp" onclick="carga(<?PHP echo $pg; ?>);" value="<?php echo $nropag; ?>"></li>
<?php /*  */ 
	$nropag++;
	}
	}
	?>
    <li class="page-item">
	<?php
	if ($idp<$t){
    ?>
    <input type="submit" class="page-link" id="actua_reg" name="actua_reg" value="Siguiente">
    <?php } else { ?>
	<input type="submit" class="page-link" id="actua_regf" name="actua_regf" value="Finalizar">
	<?php } ?>
    </li>
 </ul>
</div> 
<?php echo "<input type='hidden' name='ide' id='ide' value='".$ide."'>"; ?>   
</form>

<style>
.btn-flotante {
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
	color: #fff; /* Color del texto */
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
.espacio {
   padding-top: 0px !important;
    padding-right: 0px !important;
    padding-bottom: 0px !important;
    padding-left: 0px !important;
}
</style> 

<button type="button" class="btn-flotante btn-icon openBtng<?php echo $quizfixedid; ?>"><i class="zmdi zmdi-tag-more" data-toggle="tooltip" title="Resumen de Preguntas"></i></button>
<script>
$('.openBtng<?php echo $quizfixedid; ?>').on('click',function(){
  $('.modal-body-respreg').load('web/xxecuer/detallever.php?quizfixedid=<?php echo $quizfixedid; ?>&attempt=<?php echo $attempt; ?>&t=<?php echo $t; ?>&idp=<?php echo $idp; ?>&maxpreg=<?php echo $maxpreg; ?>',function(){
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
<!-- Large Size -->
<div class="modal fade" id="enviarmaillargeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="enviarmailLabel">Notificar error en pregunta</h4>
            </div>
            <div class="modal-body-enviarmail"> 


            </div>
        </div>
    </div>
</div>
<!-- #END# Modal Size Example --> 

<?PHP

if (($timelimit>0) && ($timeopen>0)) {
  //date_default_timezone_set('Europe/Madrid');
  $tini=strtotime("now");
  if ($tini>=$timeopen){$hor1=date("H:i:s",$tini);}
  else{$hor1=date("H:i:s",$timeopen);}
  $hor2=date("H:i:s",$timeclose);
  if ($tini>=$timeclose){$ts= 0;}
  else{
  $hora = RestarHoras($hor1,$hor2);
  list($horas, $minutos, $segundos) = explode(':', $hora);
  $hora_en_segundos = ($horas * 3600 ) + ($minutos * 60 ) + $segundos;
  $ts= (int)$hora_en_segundos;
  }
}  
//echo $timelimit." ".$timeopen." ".$timeclose." ".$tini;
?>   
<script type="text/javascript">
var seconds= "<?php echo $ts;  ?>";//número de segundos a contar
//var seconds = 65; //número de segundos a contar
function secondPassed() {

  var minutes = Math.round((seconds - 30)/60); //calcula el número de minutos
  var remainingSeconds = seconds % 60; //calcula los segundos
  //si los segundos usan sólo un dígito, añadimos un cero a la izq
  if (remainingSeconds < 10) { 
    remainingSeconds = "0" + remainingSeconds; 
  } 
  document.getElementById('countdown').innerHTML = minutes + ":" +     remainingSeconds; 
  if (seconds <= 0) { 
    clearInterval(countdownTimer); 
    alert('Se acabó el tiempo'); 
    document.getElementById('countdown').innerHTML = "Se acabó el tiempo"; 
	window.self.location='simulacro.php?tipo=<?php echo $_GET["tipo"]; ?>&op=a&quizfixedid=<?php echo $quizfixedid; ?>&attempt=<?php echo $attempt;  ?>';
	//document.getElementById("actua_reg").click();
  } else { 
    seconds--; 
  } 
} 

var countdownTimer = setInterval(secondPassed, 1000);
</script>
<?PHP //} ?> 
<script type="text/javascript">
function carga(c,d){
	if(d){ }else { d=0; }
	document.getElementById("ide").value=c;
	document.getElementById("idp").value=c;
	document.forms["formpreg"].action="simulacro.php?tipo=<?PHP echo $_GET["tipo"]; ?>&op=e#"+d
	document.forms["formpreg"].submit();
	//document.getElementById("actua_reg").click();
}
</script>	
<?PHP } ?>