<?PHP
//error_reporting(0);
date_default_timezone_set('Europe/Madrid');

//listado.php para mostrar los cuestionarios por cada usuario y curso	
	if(isset($_POST["mostrar_reg"]))
	{
		echo"<script language='JavaScript'>window.self.location='simulacro.php?tipo=".$_GET["tipo"]."&op=m';</script>";
	}
//ver.php 	Cuestionarios
	elseif(isset($_POST["asigna_reg"]))
	{
		$idp=$_POST["idp"];
		$qtype=1;
		$userid=intval(trim($_SESSION["idmoodle"])); 
		$url = $uri.'v2/index.php/gesinpol_quiz_fixed_asignar_reg';
		$parametros="courseid=".$_POST["courseid"]."&quizid=".$_POST["quizid"]."&qtype=".$qtype."&name=".$_POST["name"]."&userid=".$userid."&tf=".$_POST["tf"]."&tp=".$_POST["tp"]."&attempt=".$_POST["attempt"];
		$tuplq = resulrow($url, $parametros);
		if (isset($tuplq["idp"])) {
			$idp=$tuplq["idp"];
			$timeopen=$tuplq["quizfixed"]["timeopen"];
			$timeclose=$tuplq["quizfixed"]["timeclose"];
			if ($_POST["attempt"]==1){$_POST["quizfixedid"]=$tuplq["quizfixed"]["id"];}		
		}	
		/*$solicitud=$tupla["idp"];
		if($solicitud>0){ $idp=$tupla["idp"]; }*/
		/*if ($idp==1){
		echo"<script language='JavaScript'>window.self.location='simulacro.php?tipo=".$_GET["tipo"]."&op=e&courseid=".$_POST["courseid"]."&quizid=".$_POST["quizid"]."&name=".$_POST["name"]."&quizfixedid=".$tupla["quizfixedid"]."&idp=".$idp."&attempt=".$_POST["attempt"]."';</script>";
		}else{
		echo"<script language='JavaScript'>alert('Cuestionario Alcanzó Máximo de Intentos Permitidos!')</script>";
		echo"<script language='JavaScript'>window.self.location='simulacro.php?tipo=".$_GET["tipo"]."&op=m';</script>";	
		}*/
	}
	elseif(isset($_POST["actua_regf"]))
	{
		$attempt=$_POST["attempt"];
		$quizfixedid=$_POST["quizfixedid"];
		echo"<script language='JavaScript'>window.self.location='simulacro.php?tipo=".$_GET["tipo"]."&op=a&quizfixedid=".$quizfixedid."&attempt=".$attempt."';</script>";
	}
	/*elseif(isset($_POST["actua_reg_old"]))
	{
		$qtype=2;
		$userid=3;
		$ide=$_POST["ide"];
		$idmp=$_POST["idp"];
		$mp=$_POST["mp"];
		$t=$_POST["tp"];
		$attempt=$_POST["attempt"];
		$quizfixedid=$_POST["quizfixedid"];
		$ti=$_POST["ti"];
		$timelimit=$_POST["timelimit"];
		$timeclose=$_POST["timeclose"];
		$tf=strtotime("now");
		$cont1=0;
		$idr=""; $idch="";
		if ($timelimit>0){
		if ($_POST["timeclose"] <= $tf) {$cont1=1;}
		}
		if($cont1==1){$idp=$t+1;}
		else{
		  for ($idp=$idmp;$idp<=$mp;$idp++){
			  $ij="r".$idp;
			  if (isset($_POST[$ij])){
				$idr.="&".$ij."=".$_POST[$ij];
			  }
		  }//end for
		  $ur1 = $uri.'v2/index.php/gesinpol_quiz_fixed_actua_reg_ch';
		  $parametro1="userid=".$userid."&quizfixedid=".$_POST["quizfixedid"]."&idp=".$_POST["idp"]."&mp=".$_POST["mp"]."&attempt=".$_POST["attempt"];
		  $tupl1 = resulrow($ur1, $parametro1);	
		  $solicitu1=count($tupl1["ich"]);
			if($solicitu1>0){ 
			  for ($i=0;$i<=$solicitu1;$i++){
			  $ich=$tupl1["ich"][$i];
			  if(isset($_POST[$ich])){
				$idch.="&".$ich."=".$_POST[$ich];
			  }
			  }//for
		  	}//if
	
		$ur2 = $uri.'v2/index.php/gesinpol_quiz_fixed_actua_reg'; 
		$parametro2="userid=".$userid."&quizfixedid=".$_POST["quizfixedid"]."&ide=".$_POST["ide"]."&idp=".$_POST["idp"]."&mp=".$_POST["mp"]."&ti=".$_POST["ti"]."&t=".$_POST["tp"]."&attempt=".$_POST["attempt"]."&timelimit=".$_POST["timelimit"]."&timeclose=".$_POST["timeclose"].$idr.$idch;
		$tupl2 = resulrow($ur2, $parametro2);	
		$solicitud=count($tupl2);
		if($solicitud>0){ $idp=$tupl2["idp"]; }

		}//else
		if($idp<=$t){
		//echo"<script language='JavaScript'>window.self.location='simulacro.php?tipo=".$_GET["tipo"]."&op=e&courseid=".$_POST["courseid"]."&quizid=".$_POST["quizid"]."&name=".$_POST["name"]."&quizfixedid=".$_POST["quizfixedid"]."&idp=".$idp."&attempt=".$_POST["attempt"]."';</script>";//
		}else{
		//echo"<script language='JavaScript'>alert('Cuestionario Finalizado!')</script>";//
		echo"<script language='JavaScript'>window.self.location='simulacro.php?tipo=".$_GET["tipo"]."&op=a&quizfixedid=".$quizfixedid."&attempt=".$attempt."';</script>";
		}
		
	}*/
//revisar si utilizar este paso	
	/*elseif(isset($_POST["elimi_reg"]))
	{
		require"web/conexion.php";
		$qtype = 2;
		//Número de Cuestionarios
		$t1=$CFG->prefix."quiz_fixed_categories"; $c1="COUNT(quizfixedid) AS tc"; 
		$d1="WHERE quizfixedid='".$_POST["id"]."'"; $o1="quizfixedid";
		$q1="SELECT $c1 FROM $t1 $d1 ORDER BY $o1 ASC";
		$s1=mysqli_query($conexion, $q1);
		if(mysqli_num_rows($s1)==0){
		$tabla=$CFG->prefix."quiz_fixed";
		$condicion="id='".$_POST["id"]."'";
		$query="DELETE FROM $tabla WHERE $condicion";
		mysqli_query($conexion, $query);
		echo"<script language='JavaScript'>alert('Registros Eliminados!')</script>";
		}else{
		echo"<script language='JavaScript'>alert('Este registro NO puede ser eliminado!')</script>";
		}
		echo"<script language='JavaScript'>window.self.location='simulacro.php?tipo=".$_GET["tipo"]."&op=m&id=".$_POST["id"]."';</script>";
	}*/
?>