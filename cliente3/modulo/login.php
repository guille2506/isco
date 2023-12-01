<?php
function do_post($url, $data)
{
  $ch = curl_init($url);

  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  $response = curl_exec($ch);
  curl_close($ch);
  return $response;
}

//var_dump($_POST);

ini_set('display_errors',1);	

error_reporting(E_ALL);

ini_set('memory_limit','712M');

ini_set('max_execution_time','10000'); 

ini_set('max_input_time','10000');



//include_once '../restapi/include/conexion.php'; 



// 1 ==== crear usuario obtenidos del sistema erp  

//$url = 'http://proyectos.cuyosoft.com.ar/frax/app/restapi/v1/fraxall';



// servidor
//$url = 'https://campus.gesinpol.academy/course/restapi/v1/index.php/gesinpol_login_moodle';
$url ='https://cursos.cuyosoft.me/moodle/course/restapi/v1/index.php/gesinpol_login_moodle';
//$urlexternos = 'http://localhost:81/2021/frax/app/restapi/v1/fraxcantexternos';



$data_an = array(

    "user"=>"admin01",

    "pass"=>"1234556"

);



$data = array(

   "Content-Type" => "application/x-www-form-urlencoded",

   "user"=>"admin01",

   "pass"=>"1234556"

);



$header = [

    'Accept: application/json',

    'Content-Type: application/x-www-form-urlencoded',

    'Authorization: 3d524a53c110e4c22463b10ed32cef9d',

]; 



$_POST['token']="";

$parametros="user=".$_POST['user']."&pass=".$_POST['pass']."&token=".$_POST['token'];

$parametros="user=".$_POST['user']."&pass=".$_POST['pass'];

$user=$_POST['user'];

$pass=$_POST['pass'];



//$query=mysqli_query($con,"SELECT * FROM login_servicio_web where usuario = '$user' and clave = '$pass' ");


$url_verifico = 'https://cursos.cuyosoft.me/moodle/login/token.php';
$parametros_verifico="username=".$user."&password=".urlencode($pass)."&service=moodle_mobile_app";

$header = [
  'Accept: application/json',
  'Content-Type: application/x-www-form-urlencoded',
  'Authorization: 3d524a53c110e4c22463b10ed32cef9d',
]; 
//$parametros="usuario=".$_SESSION['idmoodle'];
$curso_nombre="";
//echo $parametros; //die();
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url_verifico);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_POST, 1);
//curl_setopt($ch, CURLOPT_POSTFIELDS,'user=admin01&pass=123456');
curl_setopt($ch, CURLOPT_POSTFIELDS,$parametros_verifico);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
// pass header variable in curl method
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_HEADER, false);

$result = curl_exec($ch);
$res    = json_decode($result, true);

$err = curl_error($ch);
curl_close($ch);
if (!$err)
 {
/* 
echo "<pre>datos";
print_r($res[token]);
print_r($res[error]);
echo "</pre>";
*/
}
/*
$cadena_de_texto = $err;//$res[error];
$cadena_buscada   = 'Fatal error:';
$posicion_coincidencia = strpos($cadena_de_texto, $cadena_buscada);
 */
//se puede hacer la comparacion con 'false' o 'true' y los comparadores '===' o '!=='
//if ($posicion_coincidencia === false) {
 // $token="";
 // $res['token']=$token;
//}

//if ($err==""){$token="";$res['token']=$token;}

try {
  if (strlen($res['token']) >0 ){
    //echo "credenciales validas".$res['token'];
    $token=$res['token'];
 } else{
    //echo "no credenciales validas".$res['error'];
    $token="";
   }
} catch (Exception $e) {
  //echo("Error no se recibieron los datos");
  $token = "";
}



//echo $token; //die($token);



//die();

//die($token);
if($token!="") {
// === obtener datos de usuario valido
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



$err = curl_error($ch);

curl_close($ch);

/*
echo "<pre>";

print_r($res['usuarios']);

echo "</pre>";
die();
*/

// agregue en los campos lo siguiente: id, email, google_auth_code para poder utilizarlo en la creación de qr en un futuro.

 foreach($res['usuarios'] as $usuarios) {
  $id = $usuarios['id'];
  $usuario = $usuarios['username'];
  $idmoodle=$usuarios['id'];
  $email=$usuarios['email'];
  $primer_nombre=$usuarios['firstname'];
  $primer_apellido=$usuarios['lastname'];
  $rol=5;//$usuarios['rol'];
  //$temail=$usuarios['tmail'];
  //$tnotificacion=$usuarios['tnotificacion'];
  //$google_auth_code=$usuarios['google_auth_code'];
 }
// ==== end
session_start();
$temail="";
$tnotificacion="";
// 1-- usuario valido y activo en el sistema
$_SESSION['id']=$id;
$_SESSION['nombre_usuario']=$usuario;
$_SESSION['email']=$email;
$_SESSION['nombre']=$primer_nombre;
$_SESSION['fullname']=$primer_nombre." ".$primer_apellido;
$_SESSION['rol']=$rol;
$_SESSION['idmoodle']=$idmoodle;
$_SESSION['tmail']=$temail;
$_SESSION['tnotificacion']=$tnotificacion;	
$_SESSION['tmail_ahora']=$temail;
$_SESSION['tnotificacion_ahora']=$tnotificacion;	
$_SESSION['pendiente_categoria']="";
$_SESSION['pendiente_curso']="";
$_SESSION['pendiente_modulo']="";
$_SESSION['pendiente_tema']="";
$_SESSION['pendiente_url']="";
	
$_SESSION['url']='https://cursos.cuyosoft.me/moodle/course/restapi/';
$_SESSION['titulo_portal']='CUYOSOFT - CURSOS';
$_SESSION['admin_avatar_chico']="https://campus.gesinpol.academy/pluginfile.php/42/user/icon/lambda/f2?rev=77820";

// === obtener avatar del alumno

$url = $_SESSION['url'].'v1/index.php/gesinpol_avatar_moodle';
//var_dump($urlexternos);
$header = [
  'Accept: application/json',
  'Content-Type: application/x-www-form-urlencoded',
  'Authorization: 3d524a53c110e4c22463b10ed32cef9d',
]; 
$parametros="id=".$idmoodle;
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

$err = curl_error($ch);
curl_close($ch);
if (!$err)
 {
   
  // var_dump ($res['proveedor']);

//echo "<pre>";
//print_r($res["profileimageurl1"]);
//echo "</pre>";
//die();

   $cuerpo="";
   $i=1;
   $_SESSION['avatar_grande']=$res['profileimageurl1'];
   $_SESSION['avatar_chico']= $res['profileimageurl2'];
  
}else{
  echo $err;
 }
// die();
//===== end

// verifico si tiene test conocimiento
$url = $_SESSION['url'].'v1/index.php/insco_usuario_cursos_unico';
//var_dump($urlexternos);
$header = [
  'Accept: application/json',
  'Content-Type: application/x-www-form-urlencoded',
  'Authorization: 3d524a53c110e4c22463b10ed32cef9d',
]; 
$parametros="usuario=".$_SESSION['idmoodle'];
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

$err = curl_error($ch);
curl_close($ch);
if (!$err)
 {
   
  // var_dump ($res['proveedor']);
/*
echo "<pre>";
print_r($res["curso_activo"]);
echo "</pre>";
die();
*/
   $cuerpo="";
   $i=1;
   $opcion1=""; $opcion2=""; $opcion3="";
   $_SESSION['categoria']="";
   $_SESSION['modulo']="";
   $_SESSION['capsula']="";
   $_SESSION['modulonew']="";
   
  //https://stackoverflow.com/questions/2306159/array-as-session-variable
   $_SESSION['cursos']=array(); // Makes the session an array
   foreach($res['curso_activo'] as $cursos) {
                 $curso_id =$cursos ['id'];
                 $curso_nombre =$cursos ['fullname']; 
                 $curso_categoria =$cursos ['category']; 
                 $curso_datos =$cursos ['summary']; 
                
                 // == solo un cursos activo insco
                 if ($curso_id==1010){
                  $_SESSION['modulo']="si";
                  $_SESSION['modulo_nombre']=$curso_nombre;  
                  $_SESSION['categoria']=1;
                  $opcion1="si";     
                  $_SESSION['clase_online']="calendario.php?curso=".$curso_id;  
                  $_SESSION['clase_grabada']="video_clase_off.php?tema=98&curso=".$curso_id;  
                  $_SESSION['notificaciones']="notificaciones.php?tema=96&curso=".$curso_id;  
                  $_SESSION['calificaciones']="calificacion.php?curso=".$curso_id; 
                  $_SESSION['cronograma']="cronograma.php?tema=117&curso=".$curso_id;    
                  $_SESSION['foros']="foros.php?curso=".$curso_id;   
                  $_SESSION['curso']=$curso_id;   
                  $_SESSION['tema_cronograma']="117";                             
                }

                if ($curso_id==1313){
                  $_SESSION['modulo']="si";
                  $_SESSION['modulo_nombre']=$curso_nombre;  
                  $_SESSION['categoria']=1;
                  $opcion1="si";     
                 // $_SESSION['clase_online']="calendario.php?curso=".$curso_id."&curso=131"; 
                  $_SESSION['clase_online']="calendario_full.php?curso=".$curso_id."&tema=131";   
                  $_SESSION['clase_grabada']="video_clase_off.php?tema=129&curso=".$curso_id;  
                  $_SESSION['notificaciones']="notificaciones.php?tema=128&curso=".$curso_id;  
                  $_SESSION['calificaciones']="calificacion.php?curso=".$curso_id; 
                  $_SESSION['cronograma']="cronograma.php?tema=131&curso=".$curso_id; 
                  
                  $_SESSION['encuesta_final']="encuesta_final.php?curso=".$curso_id."&tema=132";
                  $_SESSION['certificados']="encuesta_final.php?curso=".$curso_id."&tema=133";
                  $_SESSION['valoracion']="ranking.php?curso=".$curso_id."&tema=134";
                 
                  $_SESSION['foros']="foros.php?curso=".$curso_id;   
                  $_SESSION['curso']=$curso_id;    
                  $_SESSION['tema_cronograma']="131";                      
                }
                if ($curso_id==1515){
                  $_SESSION['modulo']="si";
                  $_SESSION['modulo_nombre']=$curso_nombre;  
                  $_SESSION['categoria']=1;
                  $opcion1="si";     
                 // $_SESSION['clase_online']="calendario.php?curso=".$curso_id."&curso=131"; 
                  $_SESSION['clase_online']="calendario_full.php?curso=".$curso_id."&tema=182";   
                  $_SESSION['clase_grabada']="video_clase_off.php?tema=180&curso=".$curso_id;  
                  $_SESSION['notificaciones']="notificaciones.php?tema=179&curso=".$curso_id;  
                  $_SESSION['calificaciones']="calificacion.php?curso=".$curso_id; 
                  $_SESSION['cronograma']="cronograma.php?tema=131&curso=".$curso_id; 
                  
                  $_SESSION['encuesta_final']="encuesta_final.php?curso=".$curso_id."&tema=183";
                  $_SESSION['certificados']="encuesta_final.php?curso=".$curso_id."&tema=184";
                  $_SESSION['valoracion']="ranking.php?curso=".$curso_id."&tema=185";
                 
                  $_SESSION['foros']="foros.php?curso=".$curso_id;   
                  $_SESSION['curso']=$curso_id;    
                  $_SESSION['tema_cronograma']="182";                      
                }                
                // ==== end insco
                if  ($curso_id > 10){
                    //M1
                    // verifico si tiene test conocimiento
$url = $_SESSION['url'].'v1/index.php/insco_temas_curso_modulo';
//var_dump($urlexternos);
$header = [
  'Accept: application/json',
  'Content-Type: application/x-www-form-urlencoded',
  'Authorization: 3d524a53c110e4c22463b10ed32cef9d',
]; 
$parametros="curso=".$curso_id;
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
  $_SESSION['certificados']="certificados.php.php?curso=".$curso_id."&tema=".$modulo6;
  $_SESSION['valoracion']="ranking.php?curso=".$curso_id."&tema=".$modulo6;
 
  $_SESSION['foros']="foros.php?curso=".$curso_id;   
  $_SESSION['curso']=$curso_id;    
  $_SESSION['cursos']=""; 
      
 }
 //M2
                }
                //== modulos unicos  
                if ($curso_id==365){
                  $_SESSION['modulo']="si";
                  $_SESSION['modulo_nombre']=$curso_nombre;  
                  $_SESSION['categoria']=74;
                  $opcion1="si";            
                }
                if ($curso_id==369){
                  $_SESSION['modulo']="si";
                  $_SESSION['modulo_nombre']=$curso_nombre;  
                  $_SESSION['categoria']=76;
                  $opcion2="si";          
                }

                if ($curso_id==370){
                  $_SESSION['modulo']="si";
                  $_SESSION['modulo_nombre']=$curso_nombre;  
                  $_SESSION['categoria']=75;
                  $opcion3="si";
                }
                // nuevo modulo unico de test
                if ($curso_id==391){
                  $_SESSION['modulo']="si";
                  $_SESSION['modulo_nombre']=$curso_nombre;  
                  $_SESSION['categoria']=74;
                  $opcion3="si";
                  $_SESSION['modulonew']="1";
                }
                // end modulo unico

                // capsulas 1- 23
                if ($curso_id==362){
                  $_SESSION['capsula']="si";
                  $_SESSION['capsula_nombre']=$curso_nombre;  
                  $_SESSION['capsula_item']=$curso_datos;
                  $_SESSION['categoria']=74;                            
                }
                if ($curso_id==363){
                  $_SESSION['capsula']="si";
                  $_SESSION['capsula_nombre']=$curso_nombre;  
                  $_SESSION['capsula_item']=$curso_datos;
                  $_SESSION['categoria']=74;                            
                }
                if ($curso_id==364){
                  $_SESSION['capsula']="si";
                  $_SESSION['capsula_nombre']=$curso_nombre;  
                  $_SESSION['capsula_item']=$curso_datos;
                  $_SESSION['categoria']=74;                            
                }
                if ($curso_id==371){
                  $_SESSION['capsula']="si";
                  $_SESSION['capsula_nombre']=$curso_nombre;  
                  $_SESSION['capsula_item']=$curso_datos;
                  $_SESSION['categoria']=74;                            
                }
                if ($curso_id==372){
                  $_SESSION['capsula']="si";
                  $_SESSION['capsula_nombre']=$curso_nombre;  
                  $_SESSION['capsula_item']=$curso_datos;
                  $_SESSION['categoria']=74;                            
                }
                if ($curso_id==373){
                  $_SESSION['capsula']="si";
                  $_SESSION['capsula_nombre']=$curso_nombre;  
                  $_SESSION['capsula_item']=$curso_datos;
                  $_SESSION['categoria']=74;                            
                }
                if ($curso_id==374){
                  $_SESSION['capsula']="si";
                  $_SESSION['capsula_nombre']=$curso_nombre;  
                  $_SESSION['capsula_item']=$curso_datos;
                  $_SESSION['categoria']=74;                            
                }
                if ($curso_id==375){
                  $_SESSION['capsula']="si";
                  $_SESSION['capsula_nombre']=$curso_nombre;  
                  $_SESSION['capsula_item']=$curso_datos;
                  $_SESSION['categoria']=74;                            
                }
                if ($curso_id==376){
                  $_SESSION['capsula']="si";
                  $_SESSION['capsula_nombre']=$curso_nombre;  
                  $_SESSION['capsula_item']=$curso_datos;
                  $_SESSION['categoria']=74;                            
                }
                if ($curso_id==377){
                  $_SESSION['capsula']="si";
                  $_SESSION['capsula_nombre']=$curso_nombre;  
                  $_SESSION['capsula_item']=$curso_datos;
                  $_SESSION['categoria']=74;                            
                }
                if ($curso_id==378){
                  $_SESSION['capsula']="si";
                  $_SESSION['capsula_nombre']=$curso_nombre;  
                  $_SESSION['capsula_item']=$curso_datos;
                  $_SESSION['categoria']=74;                            
                }
                if ($curso_id==379){
                  $_SESSION['capsula']="si";
                  $_SESSION['capsula_nombre']=$curso_nombre;  
                  $_SESSION['capsula_item']=$curso_datos;
                  $_SESSION['categoria']=74;                            
                }
                if ($curso_id==380){
                  $_SESSION['capsula']="si";
                  $_SESSION['capsula_nombre']=$curso_nombre;  
                  $_SESSION['capsula_item']=$curso_datos;
                  $_SESSION['categoria']=74;                            
                }
                if ($curso_id==381){
                  $_SESSION['capsula']="si";
                  $_SESSION['capsula_nombre']=$curso_nombre;  
                  $_SESSION['capsula_item']=$curso_datos;
                  $_SESSION['categoria']=74;                            
                }
                if ($curso_id==382){
                  $_SESSION['capsula']="si";
                  $_SESSION['capsula_nombre']=$curso_nombre;  
                  $_SESSION['capsula_item']=$curso_datos;
                  $_SESSION['categoria']=74;                            
                }
                if ($curso_id==383){
                  $_SESSION['capsula']="si";
                  $_SESSION['capsula_nombre']=$curso_nombre;  
                  $_SESSION['capsula_item']=$curso_datos;
                  $_SESSION['categoria']=74;                            
                }    
                if ($curso_id==384){
                  $_SESSION['capsula']="si";
                  $_SESSION['capsula_nombre']=$curso_nombre;  
                  $_SESSION['capsula_item']=$curso_datos;
                  $_SESSION['categoria']=74;                            
                }        
                if ($curso_id==385){
                  $_SESSION['capsula']="si";
                  $_SESSION['capsula_nombre']=$curso_nombre;  
                  $_SESSION['capsula_item']=$curso_datos;
                  $_SESSION['categoria']=74;                            
                } 
                if ($curso_id==386){
                  $_SESSION['capsula']="si";
                  $_SESSION['capsula_nombre']=$curso_nombre;  
                  $_SESSION['capsula_item']=$curso_datos;
                  $_SESSION['categoria']=74;                            
                }  
                // psicotecnico       
                if ($curso_id==387){
                  $_SESSION['capsula']="si";
                  $_SESSION['capsula_nombre']=$curso_nombre;  
                  $_SESSION['capsula_item']=$curso_datos;
                  $_SESSION['categoria']=77;                            
                } 
                 // ingles       
                 if ($curso_id==388){
                  $_SESSION['capsula']="si";
                  $_SESSION['capsula_nombre']=$curso_nombre;  
                  $_SESSION['capsula_item']=$curso_datos;
                  $_SESSION['categoria']=75;                            
                }       
                 // Ortografía       
                 if ($curso_id==389){
                  $_SESSION['capsula']="si";
                  $_SESSION['capsula_nombre']=$curso_nombre;  
                  $_SESSION['capsula_item']=$curso_datos;
                  $_SESSION['categoria']=76;                            
                }                                                                                 
                 // Ortografía       
                 if ($curso_id==390){
                  $_SESSION['capsula']="si";
                  $_SESSION['capsula_nombre']=$curso_nombre;  
                  $_SESSION['capsula_item']=$curso_datos;
                  $_SESSION['categoria']=74;                            
                }                                                                                 

                // end capsulas

               
 
    }
    // modulo unico  
    if ($opcion1=="si" || $opcion2=="si" || $opcion3=="si"){
      $_SESSION['modulo']="si";
    }

    // recuperar los item de la capsula
  
    if (!empty($_SESSION['capsula'])){
    if ($_SESSION['capsula']=="si") {
      $_SESSION['item-capsula-id']=array(); // Makes the session an array
      $_SESSION['item-capsula-nombre']=array();
      $itemcurso = explode(":",  $_SESSION['capsula_item']);
      //var_dump ( $itemcurso);
      //die();
      foreach($itemcurso as $ic) {
       // recuperar item de la capsula..
       $url = $_SESSION['url'].'v1/index.php/gesinpol_cursosxcurso';
          //var_dump($urlexternos);
          $header = [
            'Accept: application/json',
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: 3d524a53c110e4c22463b10ed32cef9d',
          ]; 
          $parametros="curso=".$ic;
          echo $parametros; //die();
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
          $resitem = json_decode($result, true);

          $err = curl_error($ch);
          curl_close($ch);
          if (!$err)
          {
                      
            
          }else{
            echo $err;
          }
          foreach($resitem['cursos'] as $items) {    
            $item_nombre= $items['fullname'];           
        }
        array_push($_SESSION['item-capsula-id'],$ic);   
        array_push($_SESSION['item-capsula-nombre'],$item_nombre);  

        }   
       // end     
         
        
        
      }
    } 
    //var_dump($_SESSION['item-capsula-id']);die();

     // Acceso total no modulo, no capsula
     if (($_SESSION['modulo']=="")&&($_SESSION['capsula']=="")){
      $_SESSION['modulo']="completo";
    }

  }else{
  echo $err;
 }

// end de permiso
/*
if 	($_SESSION['idmoodle']==3){
$_SESSION['avatar_chico']="https://clon.campusgesinpol.com/pluginfile.php/42/user/icon/lambda/f2?rev=77820";
$_SESSION['avatar_grande']="https://clon.campusgesinpol.com/pluginfile.php/42/user/icon/lambda/f1?rev=77820";
}else{
$_SESSION['avatar_chico']="https://clon.campusgesinpol.com/pluginfile.php/30450/user/icon/boost/f2?rev=193476";
$_SESSION['avatar_grande']="https://clon.campusgesinpol.com/pluginfile.php/30450/user/icon/boost/f1?rev=193476";
}
*/
$_SESSION['google_auth_code']="";//$google_auth_code;
// 2--grabar informacion del usuario en el sistema

//$_SESSION['id_session_usuario']=$res['autos']['id_session'];

//$_SESSION['ID_SESSION']=session_id();
//var_dump($_SESSION);

//==== Inicio en moodle
//header("Location:https://clon.campusgesinpol.com/course/gesinpol_root.php?token=3d524a53c110e4c22463b10ed32cef9d");
header("Location:https://cursos.cuyosoft.me/moodle/course/cuyosoft_root_multiusuariov2.php?token=3d524a53c110e4c22463b10ed32cef9d&usuario=".$usuario);
//var_dump($_SESSION);die();
//header("Location: ../dashboard.php"); 
//header("Location: ../actualizar_registro.php"); 
}else{

    //echo $err;
    //header("Location: ../505.html"); 
	echo "<script>window.location.href = 'https://cursos.cuyosoft.me/cliente/505.html';</script>";

}





//== imprime

/*

echo "<pre>";

print_r($res);

echo "</pre>";

*/



//die("salir");



?>

