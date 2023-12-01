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
$url = 'https://clon.campusgesinpol.com/course/restapi/v1/index.php/gesinpol_login';

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



$user=$_POST['user'];

$pass=$_POST['pass'];



//$query=mysqli_query($con,"SELECT * FROM login_servicio_web where usuario = '$user' and clave = '$pass' ");




//echo $parametros; die();

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
*/

// agregue en los campos lo siguiente: id, email, google_auth_code para poder utilizarlo en la creación de qr en un futuro.

 foreach($res['usuarios'] as $usuarios) {
  $id = $usuarios['id'];
  $usuario = $usuarios['usuario'];
  $idmoodle=$usuarios['idmoodle'];
  $email=$usuarios['email'];
  $primer_nombre=$usuarios['nombre'];
  $rol=$usuarios['rol'];
  $google_auth_code=$usuarios['google_auth_code'];
 }

//die();


if (isset($usuario))

 {

session_start();

$_SESSION['id']=$id;
$_SESSION['nombre_usuario']=$usuario;
$_SESSION['email']=$email;
$_SESSION['nombre']=$primer_nombre;
$_SESSION['rol']=$rol;
$_SESSION['idmoodle']=$idmoodle;
$_SESSION['google_auth_code']=$google_auth_code;

//$_SESSION['id_session_usuario']=$res['autos']['id_session'];

//$_SESSION['ID_SESSION']=session_id();
//var_dump($_SESSION);

//==== Inicio en moodle
header("Location:https://clon.campusgesinpol.com/course/gesinpol_root.php?token=3d524a53c110e4c22463b10ed32cef9d");
//header("Location: ../dashboard.php"); 
//header("Location: ../actualizar_registro.php"); 
}else{

    //echo $err;
    header("Location: ../505.html"); 

}







//== imprime

/*

echo "<pre>";

print_r($res);

echo "</pre>";

*/



//die("salir");



?>

