<?php
include("../session.php");



// No llamo a la api por que las variables necesarias ya fueron obtenidas en el login y almacenadas en la sesión asi que ahorramos este llamado.

/*
$url = 'http://localhost/moodle/course/restapi/v1/index.php/gesinpol_usuario_front';
//var_dump($urlexternos);
$header = [
  'Accept: application/json',
  'Content-Type: application/x-www-form-urlencoded',
  'Authorization: 3d524a53c110e4c22463b10ed32cef9d',
]; 
$parametros="user=".$_SESSION['nombre_usuario'];
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
   
//var_dump ($res['usuarios']);

echo "<pre>";
print_r($res["usuarios"]);
echo "</pre>";
die();


*/


// Acá comienza

//validación para que el codigo no entre vacío

if(empty($_POST['code'])){
   echo "<script>";
   echo " alert('El campo codigo no debe estar vacío!');";
   echo " window.history.go(-1); ";
   echo "</script>";
   die();
}

//Si el codigo no esta vacío entra acá

if($_POST['code'])
{

//Tomo de las sesiones creadas el gmail y el codigo de google para hacer la comparación de si es correcto.

$code=$_POST['code'];

$google_auth_code=$_SESSION['google_auth_code'];

//llamo a la libreria para crear el codigo obteniendo el email y el codigo para comparar.

require_once '../lib/googleLib/GoogleAuthenticator.php';

$ga = new GoogleAuthenticator();
$checkResult = $ga->verifyCode($google_auth_code, $code, 2);    // 2 = 2*30seg tolerancia del reloj

//var_dump($google_auth_code);
//var_dump($code);


//Comparamos

if ($checkResult) 
{

// si es correcto redirige a la pagina inicial.

echo "<script>";
echo "window.location.replace('../dashboard.php')";
echo "</script>";

}  
else 
{

// si no es correcto toma la alerta y redirige al lugar anterior para que vuelva ser ingresado.

echo "<script>";
echo " alert('El codigo que has ingresado es incorrecto, por favor intenta nuevamente!');";
echo " window.history.go(-1); ";
echo "</script>";

}

}





/* Este codigo tampoco lo utilizo por que ya las variables necesarias estan guardadas en las sesiones

   $cuerpo="";
   $i=1;
   foreach($res["usuarios"] as $usuario) {
		$token=$usuario["token"];  
		//echo "token" .$usuario["token"];
  
    }   

    // valor  
    if ($token == $_POST["token"]){
        header("Location: ../dashboard.php");
    }else{
        header("Location: ../404.html"); 
    }
 }else{
  echo $err;
 }

*/

?>