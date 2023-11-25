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
		$tf = $_POST["tf"];
		$qtype=3;
		$userid=intval(trim($_SESSION["idmoodle"])); 
		$url = $uri.'v2/index.php/gesinpol_quiz_fixed_asignar_reg_error';
		$parametros="quizfixedid=".$_POST["quizfixedid"]."&userid=".$userid."&attempt=".$_POST["attempt"]."&tf=".$_POST["tf"];
		$tuplq = resulrow($url, $parametros);	
		if (isset($tuplq["idp"])) {
			$idp=$tuplq["idp"];
			$timeopen=$tuplq["quizfixed"]["timeopen"];
			$timeclose=$tuplq["quizfixed"]["timeclose"];	
		}
	}
	elseif(isset($_POST["actua_regf"]))
	{
		$attempt=$_POST["attempt"];
		$quizfixedid=$_POST["quizfixedid"];
		echo"<script language='JavaScript'>window.self.location='simulacro.php?tipo=".$_GET["tipo"]."&op=a&quizfixedid=".$quizfixedid."&attempt=".$attempt."';</script>";
	}
	elseif(isset($_POST["msg"]))
	{
		if($_POST["msg"]==2)		{
		$url = $uri.'v2/index.php/gesinpol_borrar_test_error';
		$parametros="quizfixedid=".$_POST["quizfixedid"];
		$tupla = resulrow($url, $parametros);
		}
	}
?>