<?php
include("../../session.php");
require"../fun_varios.php";
$uri=$_SESSION['url'];
$courseid = $_GET["val1"];
$quizid	  = $_GET["val2"];
$attempt  = $_GET["val3"];
$questionid = $_GET["val4"];
$idp	  = $_GET["val5"];
$userid	  = $_GET["val6"];
$uid 	  = 3;

if ($quizid==0){
$url = $uri.'v2/index.php/gesinpol_quizid_questionid_error';
$parametros="questionid=".$questionid;
$resp = resulrow($url, $parametros);
$quizid=$resp["quizid"];
}

/***START BOTON NOTIFICAR**********************************************************/
			$img="assets/images/loader.gif";
			$output = '';
           	$output .= '
			<div id="cont1" class="col-12 m-10 p-4">			
			<div id="resultado_mensaje" class="info"></div>
			<h6 class="no">Indica si existe Error en Pregunta</h6>
			<div class="form-group row">
			  <label for="inputPregunta3" class="col-sm-3 col-form-label">Pregunta</label>
			  <div class="col-sm-9">
				'.$idp.'
			  </div>
			</div>
			<div class="form-group row">
			  <label for="valor2" class="col-sm-3 col-form-label">Observaciones</label>
			  <div class="col-sm-9">
				<input type="text" class="form-control" name="obsv" id="valor2" placeholder="Observaciones" required="required">
			  </div>
			</div>
			<a href="javascript:enviarMail('.$courseid.', '.$quizid.', '.$attempt.', '.$questionid.', '.$idp.', '.$userid.', $(\'#valor2\').val());" class="btn btn-warning btn-block btn-lg text-white waves-effect" id="e1" title="Notifcar Error Pregunta con errores">Notificar Error</a><br />
			</div>';
			$output .= '
			<script>
			function enviarMail(val1, val2, val3, val4, val5, val6, val7)
			{
			if(val7.length<1){
			alert("Por favor, Indique las Observaciones");
			}else{
			var confirmAction = confirm("Esta seguro de Notificar Error en la Pregunta N° '.$idp.'");
		    if (confirmAction) {
			$("#resultado_mensaje").html("<img src='.$img.' />Por favor espere un momento");  
			$.ajax({
					type: "POST",
					url: "web/xxcfijo/enviarp.php",
					data: {val1: val1, val2: val2, val3: val3, val4: val4, val5: val5, val6: val6, val7: val7},
					success: function(resp){
					$("#resultado_mensaje").html(resp);
					}
				});   
			}
			}
			}
			</script>
			';
/***END BOTON NOTIFICAR**********************************************************/	
echo $output;
echo '<div class="modal-footer">
      <button type="button" class="btn btn-success waves-effect" data-dismiss="modal">CERRAR</button>
      </div>';
?>