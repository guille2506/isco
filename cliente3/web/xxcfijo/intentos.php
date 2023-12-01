<?PHP
error_reporting(0);
	if(($c_tipo_usu==1 || $c_tipo_usu==3) || $c_tipo_usu==5)
	{		
			if (isset($_POST[id])) $id=$_POST[id];
			elseif (isset($_GET[id])) $id=$_GET[id];
			else $id="";
			if (isset($_POST[attempt])) $attempt=$_POST[attempt];
			elseif (isset($_GET[attempt])) $attempt=$_GET[attempt];
			else $attempt=0;
			if (isset($_POST[userids])) $userids=$_POST[userids];
			elseif (isset($_GET[userids])) $userids=$_GET[userids];
			else $userids=0;

			//echo $id;
			if($c_tipo_usu==5) $idu=$USER->id; else $idu= $userids;
			//echo "idu ".$idu."<br>";
//			echo "attempt ".$attempt."<br>";
//			echo "id ".$id."<br>";
if(($c_tipo_usu==1 || $c_tipo_usu==3) && ($userids==0))
  {	$attempt=-1;
?> 
   <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
     <div class="x_title">
        <h2>Reporte <small>de Intentos</small></h2>
       <div class="clearfix"></div>
      </div>
       <div class="x_content">
        <table id="example" class="display" style="width:100%">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre </th>
              <th>Acción</th>
            </tr>
          </thead>
           <tbody>
<?PHP
	//por usuario
	//SELECT a.userid, c.name, AVG(a.qualify) FROM `mdlxy_quiz_fixed_attempt_steps` AS a, `mdlxy_question` AS b, `mdlxy_question_categories` AS c, `mdlxy_quiz_fixed` AS d WHERE c.id=b.category AND a.questionid=b.id AND a.quizfixedid=d.id AND d.courseid=2 GROUP BY a.userid,b.category ORDER BY a.userid, b.category, b.id ASC 
	
 	$title="Reporte de Intentos";	
	$t1=$CFG->prefix."quiz_fixed_attempt_steps  AS a";
	$c1="DISTINCT a.userid";
	$c2="c.name, AVG(qualify) AS tc";
	$d1="";//usuarios
	$d2="WHERE c.id=b.category AND a.questionid=b.id AND a.quizfixedid=d.id AND d.courseid='$courseid' GROUP BY b.category";//todos los usuarios
	$o1=" a.userid";
	$o2=" a.userid, b.category, b.id";
	$q1=mostrar($t1, $c1, $d1, $o1);
	$q2=mostrar($t1, $c2, $d2, $o1);
	$s1=mysqli_query($conexion, $q1);
	$s2=mysqli_query($conexion, $q2);

	if(mysqli_num_rows($s1)!=0){
		while($r1 = mysqli_fetch_array($s1)){
		$userid=$r1[userid];
		$sqlu=mostrar($CFG->prefix."user", "*", "WHERE id='$userid'", "id");
		$su=mysqli_query($conexion, $sqlu);
		if(mysqli_num_rows($su)!=0){$ru = mysqli_fetch_array($su); $na=$ru[firstname]." ".$ru[lastname];} 
		else $na="";
		$attemp=0;
		$ico='<i class="fa fa-info" data-toggle="tooltip" title="Ver"></i>';
		$nmu = '
		<form id="contact-form" action="control.php?s='.$_GET[s].'&tipo=5&op=i" method="post">
		  <input type="hidden" name="userids" value='.$userid.'>
		  <input type="submit" class="btn btn-list" id="ver_reg" name="ver_reg" value="Ver">
		</form>';
		$nmu='<a id="ver_reg" href="control.php?s='.$_GET[s].'&tipo=5&op=i&userids='.$userid.'" target="_parent" class="btn btn-info  btn-xs pull-center"><i class="fa fa-list" data-toggle="tooltip" title="Ver"></i></a>';
		echo '<tr><td>'.$userid.'</td><td>'.$na.'</td><td>'.$nmu.'</td></tr>';
		}
		
	}else $mu=0;
?>
           </tbody>
           
           <tfoot>
            <tr>
              <th>ID</th>
              <th>Nombre </th>
              <th>Acción</th>
            </tr>
          </tfoot>

        </table>
      </div>
    </div>
  </div>
<?PHP
}
	if($attempt==0){ 
	  //
	 // echo "entre 2<br>";
   
  $qtype = 0;
  $tabl2=$CFG->prefix."quiz_fixed"; $camp2="*";
  $cond2="WHERE qtype='$qtype'"; $orde2="id ASC, name";
  //$cond2="WHERE qtype='$qtype' AND courseid='$courseid'"; $orde2="id ASC, name"; // AND userid='$idu'
  
  $quer2=mostrar($tabl2, $camp2, $cond2, $orde2);
  $soli2=mysqli_query($conexion, $quer2);
  if(mysqli_num_rows($soli2)!=0) {
?>
<h4 class="responsehistoryheader">Resumen de Cuestionarios y sus Intentos</h4>
<hr />   
<?php 
while ($tupl2= mysqli_fetch_array($soli2)){
?>
<?PHP $id=$tupl2[id]; ?>
<?PHP 
	  //buscar nro de intentos
	  $tabl1=$CFG->prefix."quiz_fixed_attempt_steps";
	  $camp1="DISTINCT attempt";
	  $cond1="WHERE quizfixedid='$id' AND userid='$idu'";
	  $orde1="attempt";
	  $sql1=mostrar($tabl1, $camp1, $cond1, $orde1);
	  $sol1=mysqli_query($conexion, $sql1);
	  if(mysqli_num_rows($sol1)!=0) {

?>
      <h5><?PHP echo $tupl2[name]; ?></h5>
 		<div class="panel panel-info">
        <div class="panel-heading">
		<div class="row">
		
        <div class="col-md-2">
		<div class="form-group" align="left">
		<label for="Name">Intento</label>
		</div>
		</div>
		<div class="col-md-4">
		<div class="form-group" align="left">
		<label for="preguntas">Calificaci&oacute;n</label>
		</div>
		</div>
		<div class="col-md-3" align="left">
		<div class="form-group">
		<label for="tiempo">Tiempo Empleado</label>
		</div>
		</div>
		<div class="col-md-3">
		<div class="form-group" align="center">
		<label for="opciones">Opci&oacute;n</label>
		</div>
		</div>
        
		</div>
		</div>
<?php 
		while ($tup1= mysqli_fetch_array($sol1)){
		  $attempt=$tup1["attempt"];
				$tupl3= mysqli_fetch_array($soli3);
					$tsi=0;
					$t1=$CFG->prefix."quiz_fixed_attempt_steps";
					$c1="MAX(timefinish) AS tf";
					$c2="MIN(timestart) AS ts";
					$d1="WHERE quizfixedid='$id' AND userid='$idu' AND attempt='$attempt'";
				   $d2="WHERE quizfixedid='$id' AND userid='$idu' AND timestart > $tsi AND attempt='$attempt'";
					$o1="id,sequencenumber";
					$q1=mostrar($t1, $c1, $d1, $o1);
					$q2=mostrar($t1, $c2, $d2, $o1);
					$s1=mysqli_query($conexion, $q1);
					$s2=mysqli_query($conexion, $q2);
					if(mysqli_num_rows($s2)!=0){$t3= mysqli_fetch_array($s2);$timei=$t3[ts];}else $timei=0;
					if(mysqli_num_rows($s1)!=0){$t4= mysqli_fetch_array($s1);$timef=$t4[tf];}else $timef=0;
				$t=$CFG->prefix."quiz_fixed_attempt_steps";
				$c="SUM(qualify) AS total";
				$d="WHERE quizfixedid='$id' AND userid='$idu' AND attempt='$attempt'";
				$o="id";
				$sql=mostrar($t, $c, $d, $o);
				$s1=mysqli_query($conexion, $sql);
				if(mysqli_num_rows($s1)!=0){$t2= mysqli_fetch_array($s1);}
				//duracion
				$timeseg = $timef - $timei;
				$dur = segundostocadena($timeseg);
			//}
?>
        
        <div class="panel-body">
			<div class="row">
			
            <div class="col-md-2">
			<div class="form-group" align="left">
			<a title="Revisar respuesta"  style="color:#006;"  href="control.php?s=<?PHP echo $_GET[s]; ?>&tipo=5&op=i&id=<?PHP echo $id; ?>&attempt=<?PHP echo $attempt; ?>&userids=<?PHP echo $userids; ?>"><?PHP echo $attempt; ?></a>
			</div>
			</div>
            <div class="col-md-4">
			<div class="form-group" align="left">
			<?PHP 
				//echo " d1 ".$d1." d2 ".$d2;
				if ($t2[total]) {echo number_format($t2[total], 2, ',', '.')." de 100,00 puntos";} 
							else echo "0,00 de 100,00 puntos";
			 ?>
			</div>
			</div>
            <div class="col-md-3">
			<div class="form-group" align="left">
			<?PHP echo $dur; ?>
			</div>
			</div>
            <div class="col-md-3">
			<div class="form-group" align="left">
			 <form id="asig-form" action="control.php?s=<?PHP echo $_GET[s]; ?>&tipo=5&op=i" method="post">
              <input type='hidden' name='id' value='<?PHP echo $id; ?>'>
              <input type='hidden' name='attempt' value='<?PHP echo $attempt; ?>'>
              <input type="hidden" name="userids" value='<?PHP echo $userids; ?>'>
              <input type="submit" class="btn btn-info pull-right" id="asignar_registro" name="asignar_registro" value="Revisar">
            </form>
			</div>
			</div>
            
		  	</div>
		  </div>
          
		          
		<?php }//while ?>
        </div>

<?php  }//while soli2 ?>


<?php	  }//if soli2   
	
		}else{
		echo"<script language='JavaScript'>alert('No Existen Respuestas!')</script>";
		/*echo"<script language='JavaScript'>window.self.location='control.php?s=".$_GET[s]."&tipo=5&op=m';</script>";	*/
	}
	}
	elseif($attempt>=1)
	{		
			$tabla=$CFG->prefix."quiz_fixed";
			$campos="*";
			$condicion="WHERE id='$id'";
			$orden="id";
			$query=mostrar($tabla, $campos, $condicion, $orden);
			$solicitud=mysqli_query($conexion, $query);
			if(mysqli_num_rows($solicitud)!=0)
			{
				$tupla= mysqli_fetch_array($solicitud);
					$tsi=0;
					$t1=$CFG->prefix."quiz_fixed_attempt_steps";
					$c1="MAX(timefinish) AS tf";
					$c2="MIN(timestart) AS ts";
					$d1="WHERE quizfixedid='$id' AND userid='$idu' AND attempt='$attempt'";
				   $d2="WHERE quizfixedid='$id' AND userid='$idu' AND timestart > $tsi AND attempt='$attempt'";
					$o1="id,sequencenumber";
					$q1=mostrar($t1, $c1, $d1, $o1);
					$q2=mostrar($t1, $c2, $d2, $o1);
					$s1=mysqli_query($conexion, $q1);
					$s2=mysqli_query($conexion, $q2);
					if(mysqli_num_rows($s2)!=0){$t3= mysqli_fetch_array($s2);$timei=$t3[ts];}else $timei=0;
					if(mysqli_num_rows($s1)!=0){$t4= mysqli_fetch_array($s1);$timef=$t4[tf];}else $timef=0;
				$t=$CFG->prefix."quiz_fixed_attempt_steps";
				$c="SUM(qualify) AS total";
				$d="WHERE quizfixedid='$id' AND userid='$idu' AND attempt='$attempt'";
				$o="id";
				$sql=mostrar($t, $c, $d, $o);
				$s1=mysqli_query($conexion, $sql);
				if(mysqli_num_rows($s1)!=0){$t2= mysqli_fetch_array($s1);}
				//duracion
				$timeseg = $timef - $timei;
				$dur = segundostocadena($timeseg);
				?>
				<h4>Resumen de <?PHP echo $tupla[name]; ?></h4>
                    <table class="table table-responsive table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th>Intentos</th>
                                <td colspan="4">
								<?php
								  //buscar nro de intentos
									$tabl1=$CFG->prefix."quiz_fixed_attempt_steps";
									$camp1="DISTINCT attempt";
									$cond1="WHERE quizfixedid='$id' AND userid='$idu'";
									$orde1="attempt";
									$sql1=mostrar($tabl1, $camp1, $cond1, $orde1);
									$sol1=mysqli_query($conexion, $sql1);
									if(mysqli_num_rows($sol1)!=0) {
										$ii=1;
										$tt=mysqli_num_rows($sol1);
										while ($tup1= mysqli_fetch_array($sol1)){
									   $attemp=$tup1[attempt];
									   if ($attemp==$attempt) echo "<strong>$attemp</strong>";
									   else echo '<a title="Revisar Respuesta" style="color:#006;" href="control.php?s='.$_GET[s].'&tipo=5&op=i&id='.$id.'&attempt='.$attemp.'&userids='.$userids.'">'.$attemp.'</a>';
									   if ($ii<$tt) echo ", ";
									   $ii++;
										}
									}
								  ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Comenzado el</th>
                                <td colspan="4"><?PHP echo userdate($timei, get_string('strftimedatetime')); ?></td>
                            </tr>
                            <tr>
                                <th>Finalizado en</th>
                                <td><?PHP echo userdate($timef, get_string('strftimedatetime')); ?></td>
                            </tr>
                            <tr>
                                <th>Tiempo empleado</th>
                                <td><?PHP echo $dur; ?></td>
                            </tr>
                            <tr>
                                <th>Calificación General</th>
                                <td><?PHP 
								if ($t2[total]) {echo "<b>".number_format($t2[total], 2, ',', '.')."</b> de 100,00 ";} else echo "<b>0,00</b> de 100,00"; ?> puntos</td>
                            </tr>
                            <tr>
                                <td colspan="2"><a href="control.php?s=<?PHP echo $_GET[s]; ?>&tipo=5&op=i" class="btn btn-warning pull-right">Volver</a></td>
                            </tr>
                        </tbody>
                    </table>
        
 	<?PHP
		$tupla2 = mysqli_fetch_array($soli1);
		  $tabla2=$CFG->prefix."quiz_fixed_attempt_steps";
		  $campo="quizfixedid";
		  $condic="WHERE quizfixedid='$id' and userid='$idu' AND attempt='$attempt'";
		  $sql="SELECT COUNT($campo) AS total FROM $tabla2 $condic";
		  $result = mysqli_query($conexion,$sql); 
		  if ($fil = mysqli_fetch_assoc($result)) {$t = $fil["total"];}else {$t=0;}
		$tabla=$CFG->prefix."quiz_fixed_attempt_steps";
		$campos="*";
		//$condicion="WHERE quizfixedid='$_POST[id]' OR quizfixedid='$_GET[id]' and userid='$idu'";
		$condicion="WHERE quizfixedid='$id' and userid='$idu' AND attempt='$attempt'";
		$orden="id,sequencenumber";
		$query=mostrar($tabla, $campos, $condicion, $orden);
		$soli1=mysqli_query($conexion, $query);
		if(mysqli_num_rows($soli1)!=0)
		{
		  while($tupla2= mysqli_fetch_array($soli1))
		  {
			$tabla3=$CFG->prefix."question";
			$campos2="*";
			$condicion2="WHERE id='$tupla2[questionid]'";
			$orden2="id";
			$query2=mostrar($tabla3, $campos2, $condicion2, $orden2);
			$soli2=mysqli_query($conexion, $query2);
			
			if(mysqli_num_rows($soli2)!=0){$tupla3 = mysqli_fetch_array($soli2);
			}
			?>
<div align="justify">
<div class="row">
<div class="col-md-12">
<div class="panel panel-sky">
  <div class="panel-heading">
      <div class="row">
          <div class="col-xs-2">
              <i class="fa fa-comments fa-5x hidden-xs"></i>
              <i class="fa fa-comments fa-2x hidden-lg hidden-sm hidden-md"></i>
          </div>
          <div class="col-xs-10 text-letf">
              <div class="huge text-right">Pregunta <?PHP echo $tupla2[sequencenumber]; ?> de <?PHP echo $t; ?></div>
              <div align="justify">
              <h3 style="color:#fff;">
			  <?PHP //echo strip_tags($tupla3[questiontext]); 
				// @@PLUGINFILE@@/ 
				$pos = strpos($tupla3[questiontext], '@@/');
				if ($pos > 0){
				$imagen = strstr($tupla3[questiontext], '@@/');
				$im = strstr($imagen, '.png', true);
				$img = substr($im, 3,10);
				
				 if ($q = $DB->get_records('question_attempts', array('questionid' => $tupla2[questionid]))) {
				 foreach ($q as $qu) {
				 $qu->questionusageid."<br />";
				 $qus=$qu->questionusageid;
				 }
				 
				 }
		
				global $CFG, $DB;
				require_once("$CFG->libdir/filelib.php");
				require_once("$CFG->libdir/questionlib.php");
				$courseid=$tupla[courseid];
			
				$questioncontextid = $DB->get_field_sql('
					SELECT qc.contextid
					  FROM {question} q
					  JOIN {question_categories} qc ON qc.id = q.category
					 WHERE q.id = :id', array('id' => $tupla2[questionid]), MUST_EXIST);
				 $path = $qus.'/'.$img.'/'.$tupla2[questionid];
				echo $messagetext = file_rewrite_pluginfile_urls($tupla3[questiontext], 'pluginfile.php',$questioncontextid, 'question', 'questiontext', $path);
				}else echo strip_tags($tupla3[questiontext]);
		?>
              </h3>
              </div>
          </div>
      </div>
  </div>
  <div class="panel-body">
    <div class="funkyradio">
<?php                                    
$fraction=0.00;
$tabla4=$CFG->prefix."question_answers";
$campos4="*";
$campos5="COUNT(fraction) as trc";
//$campos6="SUM(fraction) as sum";
$campos6="fraction";
$condicion4 ="WHERE question='$tupla2[questionid]'";
$condicion5 ="WHERE question='$tupla2[questionid]' AND fraction > '$fraction'";
$orden4="id, fraction";

$query6=mostrar($tabla4, $campos6, $condicion4, $orden4);
$soli6=mysqli_query($conexion, $query6);
$sum=0;
if(mysqli_num_rows($soli6)!=0){
    while($tupla6= mysqli_fetch_array($soli6)){
    //if($tupla6[sum]==1.0) $sum=1;
    if($tupla6[fraction]==1.0) $sum=1;
    }
}

$query4=mostrar($tabla4, $campos4, $condicion4, $orden4);
$query5=mostrar($tabla4, $campos5, $condicion5, $orden4);
$soli4=mysqli_query($conexion, $query4);
$soli5=mysqli_query($conexion, $query5);
if(mysqli_num_rows($soli5)!=0){$tupla5= mysqli_fetch_array($soli5);}
$tr=mysqli_num_rows($soli4);
if(mysqli_num_rows($soli4)!=0){
$i=0;$cont=1;$a=0;$c=$p=0;$r=NULL;$resp='<div class="alert alert-danger"><strong>Respuesta Incorrecta.</strong> <small>La Respuesta Correcta es:</small></div>';
while($tupla4= mysqli_fetch_array($soli4))
{
if ($tupla4[fraction]>$fraction) {if ($r==NULL){}else{$r=$r.'<br /><i class="fa fa-angle-double-right"></i> ';}$r=$r.strip_tags($tupla4[answer]);}
if($tupla3[qtype]=="multichoice"){
if ($sum==1){
     if ($i==0) {$j=$tupla4[id];}
     if ($tupla4[id]==$tupla2[answerid]) {
         if ($tupla4[fraction]>$fraction){
            $resp='<div class="alert alert-success"><strong>Respuesta Correcta.</strong></div>';}
            $s='checked="checked" disabled="disabled"';$c++;}
         else{$s='disabled="disabled"';} 
    if($tupla2[answerid]==NULL){$resp='<div class="alert alert-info"><strong>Sin Contestar.</strong></div>';}
?>
<div class="msg_list">
    <span class="check"><input type="radio" name="r<?PHP echo $j; ?>" id="r<?PHP echo $tupla4[id]; ?>" <?PHP echo $s; ?> /></span>
    <span class="message"><label for="r<?PHP echo $tupla4[id]; ?>"><?PHP echo strip_tags( $tupla4[answer]); ?></label></span>
</div>
<?php 	}else{	
    $answers = $tupla2[answerid];
    $answerid = explode(",", $answers);
    if ($tupla4[id]==$answerid[$a]) {
        if ($tupla4[fraction]>$fraction){$resp='<div class="alert alert-success"><strong>Respuesta Correcta.</strong></div>';$c++;}
         $s='checked="checked" disabled="disabled"';$a++;}
    else{$s='disabled="disabled"';}
 if($cont==$tr){
if($c<$tupla5[trc] && $c==count($answerid)){$resp='<div class="alert alert-warning"><strong>Respuesta Parcialmente Correcta.</strong></div>';}
elseif($cont==count($answerid) && $cont>$c){$resp='<div class="alert alert-danger"><strong>Respuesta Incorrecta.</strong><small>La Respuesta Correcta es:</small></div>';}
elseif($c<count($answerid)){$resp='<div class="alert alert-danger"><strong>Respuesta Incorrecta.</strong><small>La Respuesta Correcta es:</small></div>';}	 
}
if($answers==NULL){$resp='<div class="alert alert-info"><strong>Sin Contestar.</strong></div>';}
 $cont++;
?>
<div class="msg_list">
    <span class="check"><input type="checkbox" name="ch" <?PHP echo $s; ?> /></span>
    <span class="message"><label for="ch"><?PHP echo strip_tags($tupla4[answer]); ?></label></span>
</div>
<?php 	}	?>
<?PHP  }elseif($tupla3[qtype]=="truefalse"){  
     if ($i==0) {$j=$tupla4[id];}
     if ($tupla4[id]==$tupla2[answerid]) {
         if ($tupla4[fraction]>$fraction){
            $resp='<div class="alert alert-success"><strong>Respuesta Correcta.</strong></div>';}
            $s='checked="checked" disabled="disabled"';$c++;}
         else{$s='disabled="disabled"';} 
if($tupla2[answerid]==NULL){$resp='<div class="alert alert-info"><strong>Sin Contestar.</strong></div>';}
?>
<div class="msg_list">
    <span class="check"><input type="radio" name="r<?PHP echo $j; ?>" id="r<?PHP echo $tupla4[id]; ?>" <?PHP echo $s; ?> /></span>
    <span class="message"><label for="r<?PHP echo $tupla4[id]; ?>"><?PHP echo strip_tags( $tupla4[answer]); ?></label></span>
</div>
<?PHP $i++;}}} ?>                                    
                 

      </div>
    </div>
    <div class="panel-footer">
      <div class="feedback">
        <div class="specificfeedback"><?PHP echo $resp; ?></div>
        <div class="generalfeedback"><?PHP echo $tupla3[generalfeedback]; ?></div>
        <div class="rightanswer"><i class="fa fa-angle-double-right"></i> <?PHP echo $r; ?></div>
      </div>
    </div>
</div>
        	</div>
        </div>
                	</div>
			<?PHP
					}
				}else{echo"<img src='img/noencontrado.png'/>";}
			}else{echo"<img src='img/noencontrado.png'/>";}
		}else{/*echo"<img src='img/noencontrado.png'/>";*/}
}else{require"web/valida.php";}			
//echo "attempt ".$attempt."<br>";
?>
