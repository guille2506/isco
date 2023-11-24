<?php
error_reporting(0);
include("../../session.php");
require"../fun_varios.php";
$uri=$_SESSION['url']; 
$userid=intval(trim($_SESSION["idmoodle"]));
$quizid = $_POST["val1"];
$attempt = $_POST["val2"];
$quizfixedid = $_POST["val3"];
$t=1;
	$ur2 = $uri.'v2/index.php/gesinpol_quiz_fixed_attempt_question_show'; 
	$parametro2 = "quizfixedid=".$quizfixedid."&attempt=".$attempt."&userid=".$userid;
	$tupl2 = resulrow($ur2, $parametro2);
	$t=count($tupl2["quizfixedas"]);
	
foreach($tupl2["quizfixedas"] as $tupla2)	
	{
		//usleep(10);
		$idp=$tupla2["sequencenumber"];
		$questionid = $tupla2["questionid"];
		$qfasid     = $tupla2["qfasid"];
		$puntua		= $tupla2["defaultmark"];
		$sum		= $tupla2["single"];
		$respondida = "Sin responder aún";
		
		if (isset($puntua)){} else {$puntua	= 0.00;}
		$shanswers	= $tupla2["shuffleanswers"];
		if (is_null($shanswers) || ($shanswers=="")){ $shanswers = "NULL"; }
		
?>
	<div id="<?PHP echo $tupla2["sequencenumber"]; ?>" class="col-md-3 col-lg-3 text-letf">
        <div class="card">
            <div class="body" style="color: #004C45">                            
                <h3><strong>Pregunta <?PHP echo $tupla2["sequencenumber"]; ?></strong></h3>
                <div class="bg-warning" style="padding-block: 10px">
                    <div class="text" style="margin: 10px;"><strong><?PHP if (isset($tupla2["answerid"])) {$respondida = "Respuesta guardada";} echo $respondida; ?></strong></div>
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
			$pos = strpos($tupla2["questiontext"], '@@/');
			if ($pos > 0){
			$ur31 = $uri.'v2/index.php/gesinpol_quiz_fixed_question_usage';
			$parametro31 = "courseid=".$courseid."&questionid=".$questionid."&userid=".$userid."&quizid=".$quizid."&idp=".$idp."&quizfixedid=".$quizfixedid."&attempt=".$attempt;
			$tupla31 = resulrow($ur31, $parametro31);
			echo $tupla31["messagetext"];
			}else{
			//echo strip_tags($tupla2["questiontext"]); 
			echo $tupla2["questiontext"];			
			}?>   
            
            </strong></p> 
            <hr />	  
<?PHP 
	$fraction=0.00;
	$card=1;
	if($tupla2["qtype"]=="multichoice"){
			if ($sum==1){}else{
				$ur4 = $uri.'v2/index.php/gesinpol_quiz_fixed_attempt_answer_show';
				$parametro4 = "questionid=".$tupla2["questionid"]."&fraction=".$fraction;
				$tupl4 = resulrow($ur4, $parametro4);
				$tupla5["trc"]=$tupl4["trc"];
			}
	}
	
	$ur3 = $uri.'v2/index.php/gesinpol_quiz_fixed_attempt_answers_show';
	$parametro3="qfasid=".$tupla2["qfasid"]."&questionid=".$tupla2["questionid"]."&shuffleanswers=".$shanswers."&quizid=".$quizid;
	$tupla3 = resulrow($ur3, $parametro3);
	
			 $tr=0;
			$tr=count($tupla3["quizrespuesta"]);
			if($tr!=0){
			$i=0;$cont=1;$a=0;$c=$cc=$p=0;$r=NULL;$resp='<div class="alert alert-danger"><strong>Respuesta Incorrecta.</strong> </div>';
 			//foreach($tupl4["tuplas4"] as $tupla4)
			foreach($tupla3["quizrespuesta"] as $tupla4)
			{
				if ($card==1) $l='a'; elseif ($card==2) $l='b'; elseif ($card==3) $l='c'; elseif ($card==4) $l='d'; elseif ($card==5) $l='e'; elseif ($card==6) $l='f';
			if ($tupla4["fraction"]>$fraction) {$r=$r.$l.".) "; $r=$r.strip_tags($tupla4["answer"])." ";}
			if($tupla2["qtype"]=="multichoice"){
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
				if (isset($answers)){
				$answerid = explode(",", $answers);
				//echo $a." - ".$answerid[$a]; echo "<br>";
				if (in_array($tupla4["id"], $answerid)){
				//if ($tupla4["id"]==$answerid[$a]) {
					if ($tupla4["fraction"]>$fraction){$c++;}
					 $s='checked="checked" disabled="disabled"'; $cc++;}
			 	else{$s='disabled="disabled"';}
				$a++;}else{$s='disabled="disabled"';}
				//echo $c." - ".$tupla5["trc"]; echo "<br>";
			if($c==$tupla5["trc"] && $c==$cc){$resp='<div class="alert alert-success"><strong>Respuesta Correcta.</strong></div>';}
			elseif($cont==$tr){
			if($tupla2["qualify"]>$fraction){$resp='<div class="alert alert-warning"><strong>Respuesta Parcialmente Correcta.</strong></div>';}
			else{$resp='<div class="alert alert-danger"><strong>Respuesta Incorrecta.</strong></div>';}
			}
			if($answers==NULL){$resp='<div class="alert alert-info"><strong>Sin Contestar.</strong></div>';}
			 $cont++;
	?>
            <div class="checkbox">
                <input type="checkbox" name="ch" <?PHP echo $s; ?> />
                <label for="ch"><strong><span style="color: #004C45;"><?PHP echo $l; ?>.) <?PHP echo strip_tags($tupla4["answer"]); ?></span></strong></label>
            </div>
            <hr />
     <?php 	} 	?>
     <?PHP  }elseif($tupla2["qtype"]=="truefalse"){  
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
                  <div class="rightanswer  alert alert-primary" role="alert">
                      <div class="container">
                          <div class="alert-icon">
                              <i class="zmdi zmdi-notifications"></i>
                          </div>
                          <strong><small><?PHP if (isset($r)) { echo "La Respuesta Correcta es: ";} else { echo "Información"; }?> </small></strong> <?PHP echo $r; ?>
                      </div>
                  </div>
                  <div class="generalfeedback">
				  <?PHP 
					  $pos = strpos($tupla2["generalfeedback"], '@@/');
					  if ($pos > 0){
						$gfb="generalfeedback";
					  $ur31 = $uri.'v2/index.php/gesinpol_quiz_fixed_question_usage';
					 echo $parametro31 = "courseid=".$courseid."&questionid=".$questionid."&userid=".$userid."&quizid=".$quizid."&idp=".$idp."&quizfixedid=".$quizfixedid."&attempt=".$attempt."&gfb=".$gfb;
					  $tupla31 = resulrow($ur31, $parametro31);
					  echo $tupla31["messagetext"];
					  }else{
					  //echo strip_tags($tupla2["questiontext"]); 
					  echo $tupla2["generalfeedback"];			
					  }
				?>   
				  
				  <?PHP //echo $tupla2["generalfeedback"]; ?>
                </div>
               </div>
            </div>
            </div>
        </div>
    </div>
<?PHP } //foreach tupla2 ?>