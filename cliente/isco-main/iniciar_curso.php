<?php
include("session.php");
if  ($_REQUEST['curso'] != ""){
                    //M1
                    // verifico si tiene test conocimiento
$url = $_SESSION['url'].'v1/index.php/insco_temas_curso_modulo';
//var_dump($urlexternos);
$header = [
  'Accept: application/json',
  'Content-Type: application/x-www-form-urlencoded',
  'Authorization: 3d524a53c110e4c22463b10ed32cef9d',
]; 
$parametros="curso=".$_REQUEST['curso'];
// curso y usuario activo selecionado
$curso_id=$_REQUEST['curso'];
$_SESSION['curso']=$curso_id;
$_SESSION['idmoodle']=$_REQUEST['usuario'];

$curso_nombre="";
//echo $parametros; //die();
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_POST, 1);
//curl_setopt($ch, CURLOPT_POSTFIELDS,'user=admin01&pass=123456');
curl_setopt($ch, CURLOPT_POSTFIELDS,$parametros);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
// pass header variable in curl method
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_HEADER, false);

$result = curl_exec($ch);
$res    = json_decode($result, true);
/*
echo "<pre>";
print_r($res["temas"]);
echo "</pre>";
//die();
*/
$err = curl_error($ch);
curl_close($ch);
if (!$err)
 {
  $modulo1=0;$modulo2=0;$modulo3=0;$modulo4=0;$modulo5=0;$modulo6=0;$modulo7=0;$modulo8=0;$modulo9=0;
  foreach($res['temas'] as $temas) {
    //echo $temas["id"] ."-" . $temas["name"];
    $findme   = 'M1';
		$pos_m1 = strpos($temas["name"], $findme);   
    if (!($pos_m1 === false)) {$modulo1=$temas["id"];}
    $findme   = 'M2';
		$pos_m2 = strpos($temas["name"], $findme);
    if (!($pos_m2 === false)) { $modulo2=$temas["id"];}
    $findme   = 'M3';
		$pos_m3 = strpos($temas["name"], $findme);
    if (!($pos_m3 === false)) { $modulo3=$temas["id"];}
    $findme   = 'M4';
		$pos_m4 = strpos($temas["name"], $findme);
    if (!($pos_m4 === false)) { $modulo4=$temas["id"];}
    $findme   = 'M5';
		$pos_m5 = strpos($temas["name"], $findme);
    if (!($pos_m5 === false)) { $modulo5=$temas["id"];}
    $findme   = 'M6';
		$pos_m6 = strpos($temas["name"], $findme);
    if (!($pos_m6 === false)) { $modulo6=$temas["id"];}
    $findme   = 'M7';
		$pos_m7 = strpos($temas["name"], $findme);
    if (!($pos_m7 === false)) { $modulo7=$temas["id"];}
    $findme   = 'M8';
		$pos_m8 = strpos($temas["name"], $findme);
    if (!($pos_m8 === true)) { $modulo8=$temas["id"];}
    $findme   = 'M9';
		$pos_m9 = strpos($temas["name"], $findme);
    if (!($pos_m9 === false)) { $modulo9=$temas["id"];}
  }
  //echo $modulo1.$modulo2.$modulo3.$modulo4.$modulo5.$modulo6.$modulo7.$modulo8.$modulo9;
  $_SESSION['modulo']="si";
  $_SESSION['tema_cronograma']=$modulo1; 
  $_SESSION['modulo_nombre']=$curso_nombre;  
  $_SESSION['categoria']=1;
  $opcion1="si";     
 // $_SESSION['clase_online']="calendario.php?curso=".$curso_id."&curso=131"; 
  $_SESSION['clase_online']="calendario_full.php?curso=".$curso_id."&tema=".$modulo1;   
  $_SESSION['clase_grabada']="video_clase_off.php?tema=".$modulo2."&curso=".$curso_id;  
  $_SESSION['notificaciones']="notificaciones.php?tema=".$modulo1."&curso=".$curso_id;  
  $_SESSION['calificaciones']="calificacion.php?curso=".$curso_id; 
  //$_SESSION['cronograma']="cronograma.php?tema=131&curso=".$curso_id; 
  
  $_SESSION['encuesta_final']="encuesta_final.php?curso=".$curso_id."&tema=".$modulo5;
  $_SESSION['certificados']="encuesta_final.php?curso=".$curso_id."&tema=".$modulo6;
  $_SESSION['valoracion']="ranking.php?curso=".$curso_id."&tema=".$modulo6;
 
  $_SESSION['foros']="foros.php?curso=".$curso_id;   
  $_SESSION['curso']=$curso_id;    
  $_SESSION['cursos']="cursos.php"; 
  // alumno seleciono curso
  header("Location: empleados.php");    
 }

}