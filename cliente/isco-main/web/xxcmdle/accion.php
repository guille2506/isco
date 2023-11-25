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
		$qtype=4;
		$userid=intval(trim($_SESSION["idmoodle"])); 
		$url = $uri.'v2/index.php/gesinpol_quiz_fixed_asignar_reg';
		$parametros="courseid=".$_POST["courseid"]."&quizid=".$_POST["quizid"]."&qtype=".$qtype."&name=".$_POST["name"]."&userid=".$userid."&tf=".$_POST["tf"]."&tp=".$_POST["tp"]."&attempt=".$_POST["attempt"]; 
		$tuplq = resulrow($url, $parametros);
		if (isset($tuplq["quizfixed"])) {
			$idp=$tuplq["idp"];
			$timeopen=$tuplq["quizfixed"]["timeopen"];
			$timeclose=$tuplq["quizfixed"]["timeclose"];
			if ($_POST["attempt"]==1){$_POST["quizfixedid"]=$tuplq["quizfixed"]["id"];}	
		}	
	}
	elseif(isset($_POST["actua_regf"]))
	{
		$attempt=$_POST["attempt"];
		$quizfixedid=$_POST["quizfixedid"];
		echo"<script language='JavaScript'>window.self.location='simulacro.php?tipo=".$_GET["tipo"]."&op=a&quizfixedid=".$quizfixedid."&attempt=".$attempt."';</script>";
	}

?>