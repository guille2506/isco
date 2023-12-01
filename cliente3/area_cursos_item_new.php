<?php
include("session.php");
include_once 'web/fun_varios.php';    
$_SESSION['url_app']="https://cursos.cuyosoft.me/cliente/area_cursos_item_new.php?tema=".$_REQUEST['tema']."&curso=".$_REQUEST['curso'];
// buscar item en array
function buscarvalor ($arraySuperior,$mValue){
    foreach ($arraySuperior as $subArray){
        foreach ($subArray as $k=>$v){
            if ($v==$mValue){
                 return "ok";
            }
        }
    }
    return "nok";
}
// obtener id de la encuesta final
// SELECT cm.id FROM `mdl_course_modules_completion` cmc ,mdl_course_modules cm WHERE cmc.userid=5 and cm.course=13 and cm.id=cmc.coursemoduleid and cm.instance=4; 
// SELECT cm.id FROM mdl_course_modules cm WHERE cm.course=13 and instance=4; 
//SELECT cm.id FROM mdl_course_modules cm WHERE cm.course=13 and instance=6; 
$url = $_SESSION['url'].'v1/index.php/gesinpol_item_modulo';
//var_dump($urlexternos);
$header = [
  'Accept: application/json',
  'Content-Type: application/x-www-form-urlencoded',
  'Authorization: 3d524a53c110e4c22463b10ed32cef9d',
]; 
$parametros="course=".$_REQUEST['curso']."&tema=".$_REQUEST['tema'] ;
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
print_r($res["items_visible"]);
echo "</pre>";
//die();
*/
   $cuerpo="";
   $i=1;
  
    $items_id =  array();

    foreach($res['items_visible'] as $items) {
           $id =$items ['instance'];
           //echo $items_id;
           $items_id[]['id'] = $id;
     }

 }else{
  echo $err;
 }

// var_dump($items_id);
// echo buscarvalor( $items_id,2);
// die("salir");

$url = $_SESSION['url'].'v1/index.php/gesinpol_temas_curso_id';
//var_dump($urlexternos);
$header = [
  'Accept: application/json',
  'Content-Type: application/x-www-form-urlencoded',
  'Authorization: 3d524a53c110e4c22463b10ed32cef9d',
]; 
$parametros="curso=".$_REQUEST['curso']."&id=".$_REQUEST['tema'] ;
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
print_r($res["temas"]);
echo "</pre>";
//die();
*/
   $cuerpo="";
   $i=1;
  
    $categoria =  array();
    foreach($res['temas'] as $cursos) {
           $curso_enrolado =$cursos ['id'];
           $curso_nombre =$cursos ['name'];   
     }

 }else{
  echo $err;
 }
 


//die("salir");
//var_dump($categoria);
$curso_enrolado=$_REQUEST['curso'];
// obtener el contenido del curso enrolado
if ($curso_enrolado >0 ){
    $url = $_SESSION['url'].'v1/index.php/gesinpol_items_tema_curso';
//var_dump($urlexternos);
$header = [
  'Accept: application/json',
  'Content-Type: application/x-www-form-urlencoded',
  'Authorization: 3d524a53c110e4c22463b10ed32cef9d',
]; 
$parametros="curso=".$curso_enrolado."&tema=".$_REQUEST['tema'];
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
print_r($res["items"]);
echo "</pre>";
//die();
*/
   $cuerpo="";
   $i=1;
  
    $tema=  array();
    $tema_id=array();
    $tema_url=array();
    //var_dump($res['items']);die();
    $temaurl=  array();
    $temaurl_id=array();
    $temaurl_url=array();
    $temaquiz=  array();
    $temaquiz_id=array();
    $temaquiz_url=array();
    $temafeedback=  array();
    $temafeedback_id=array();
    $temafeedback_url=array();
    $temaassign=  array();
    $temaassign_id=array();
    $temaassign_url=array();
  
    $codigo_cuestionario=0;
    $codigo_encuesta=0;
    $codigo_tarea=0;
    $recurso0="";$recurso1="";$recurso2="";$recurso3="";$recurso4="";$recurso5="";$recurso6="";$recurso7="";
    foreach($res['items'] as $items_tema) {

      if ($items_tema['name']=="quiz"){
        $nombre="";$id="";
        $codigo_cuestionario=$items_tema['instance'];
  $url = $_SESSION['url'].'v1/index.php/gesinpol_curso_quizvisble';	
  $parametros="course=".$curso_enrolado."&id=".$items_tema['section'];
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
print_r($res["curso_quiz"]);
echo "</pre>";
die();
*/
  $err = curl_error($ch);
  curl_close($ch);
  if (!$err)
  { 				
      foreach($res['curso_quiz'] as $quiz) {
            $nombre=$quiz['name'];
            $id==$quiz['id'];
            $temaquiz[]['nombre'] = $nombre;
            $temaquiz_id[]['id'] = $id;
            $temaquiz_url[]['url'] = $url;
            }
            $recurso6=$items_tema['name'];
  }
     }

if ($items_tema['name']=="feedback"){
        $nombre="";$id="";
        $codigo_encuesta=$items_tema['instance'];      
  $url = $_SESSION['url'].'v1/index.php/gesinpol_curso_feedbackvisble';	
  $parametros="course=".$curso_enrolado."&id=".$items_tema['section'];
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
print_r($res["curso_feedback"]);
echo "</pre>";
//die();
*/
  $err = curl_error($ch);
  curl_close($ch);
  if (!$err)
  { 				
      foreach($res['curso_feedback'] as $quiz) {
            $nombre=$quiz['name'];
            $id==$quiz['id'];
            $temafeedback[]['nombre'] = $nombre;
            $temafeedback_id[]['id'] = $id;
            $temafeedback_url[]['url'] = $url;
            }
            $recurso7=$items_tema['name'];
  }
     }
     if ($items_tema['name']=="assign"){
      $nombre="";$id="";
      $codigo_tarea=$items_tema['instance'];      
$url = $_SESSION['url'].'v1/index.php/insco_curso_assignvisble';	
$parametros="course=".$curso_enrolado."&id=".$items_tema['section'];
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
print_r($res["curso_assign"]);
echo "</pre>";
//die();
*/
$err = curl_error($ch);
curl_close($ch);
if (!$err)
{ 				
    foreach($res['curso_assign'] as $quiz) {
          $nombre=$quiz['name'];
          $id==$quiz['id'];
          $temaassign[]['nombre'] = $nombre;
          $temaassign_id[]['id'] = $id;
          $temaassign_url[]['url'] = $url;
          }
          $recurso8=$items_tema['name'];
}
   }
        // nuevo para componente file de moodle 2023
        if ($items_tema['name']=="resource"){
            $nombre="";$id="";
            $url = $_SESSION['url'].'v1/index.php/gesinpol_curso_resourcevisible';	
            $parametros="course=".$_REQUEST['curso']."&id=".$_REQUEST['tema'];
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
/*     
echo "<pre>";
print_r($res["curso_resource"]);
echo "</pre>";
die();
*/

            if (!$err)
            { 				
                $temaresource=  array();
                $temaresource_id=array();
                $temaresource_url=array();	

                foreach($res['curso_resource'] as $quiz) {
                        $nombre=$quiz['name'];
                $id=$quiz['id'];
               // $url=$quiz['content'];
                $temaresource[]['nombre'] = $nombre;
                $temaresource_id[]['id'] = $id;
                $temaresource_url[]['url'] = $url;
                }
                $recurso5=$items_tema['name'];
            }
        }
        
        if ($items_tema['name']=="videotime"){
            $nombre="";$id="";
            $url = $_SESSION['url'].'v1/index.php/gesinpol_curso_videotimevisible';	
            $parametros="course=".$_REQUEST['curso']."&id=".$_REQUEST['tema'];
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
/*   
echo "<pre>";
print_r($res["curso_page"]);
echo "</pre>";
die();
*/

            if (!$err)
            { 				
                $temavideo=  array();
                $temavideo_id=array();
                $temavideo_url=array();	
                $temavideo_minutos=array();	
                foreach($res['curso_page'] as $quiz) {
                        $nombre=$quiz['name'];
                        $id=$quiz['id'];
                        $minutos=$quiz['intro'];
               // $url=$quiz['content'];
                $temavideo[]['nombre'] = $nombre;
                $temavideo_id[]['id'] = $id;
                $temavideo_url[]['url'] = $url;
                $temavideo_minutos[]['minutos'] = $minutos;
                }
                $recurso0=$items_tema['name'];
            }
         }	  

         if ($items_tema['name']=="page"){
            $nombre="";$id="";
			$url = $_SESSION['url'].'v1/index.php/gesinpol_curso_pagevisible';	
			$parametros="course=".$curso_enrolado."&id=".$_REQUEST['tema'];
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
/*   
echo "<pre>";
print_r($res["curso_page"]);
echo "</pre>";
die();
*/

			if (!$err)
			{ 				
    			foreach($res['curso_page'] as $quiz) {
				        $nombre=$quiz['name'];
                $id=$quiz['id'];
                $url=$quiz['content'];
                $tema[]['nombre'] = $nombre;
                $tema_id[]['id'] = $id;
                $tema_url[]['url'] = $url;
                }
                $recurso1=$items_tema['name'];
			}
         }	
         
         
         /*
         select * from mdl_url where course=126;
         select * from mdl_book where course=126;
         */
         if ($items_tema['name']=="url"){
            $nombre="";$id="";
			$url = $_SESSION['url'].'v1/index.php/gesinpol_curso_urlvisible';	
			$parametros="course=".$curso_enrolado."&id=".$_REQUEST['tema'];
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
/*    
echo "<pre>";
print_r($res["curso_url"]);
echo "</pre>";
die();
*/

			if (!$err)
			{ 				
    			foreach($res['curso_url'] as $quiz) {
				        $nombre=$quiz['name'];
                $id=$quiz['id'];
                $url=$quiz['externalurl'];
                $temaurl[]['nombre'] = $nombre;
                $temaurl_id[]['id'] = $id;
                $temaurl_url[]['url'] = $url;
                }
                $recurso2=$items_tema['name'];
			}
         }		

         if ($items_tema['name']=="book"){
            $nombre="";$id="";
            $url = $_SESSION['url'].'v1/index.php/gesinpol_curso_bookvisible';	
            $parametros="course=".$_REQUEST['curso']."&id=".$_REQUEST['tema'];
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
/*      
echo "<pre>";
print_r($res["curso_page"]);
echo "</pre>";
die();
*/

            if (!$err)
            { 				
                $temabook=  array();
                $temabook_id=array();
                $temabook_url=array();	

                foreach($res['curso_book'] as $quiz) {
                        $nombre=$quiz['name'];
                $id=$quiz['id'];
               // $url=$quiz['content'];
                $temabook[]['nombre'] = $nombre;
                $temabook_id[]['id'] = $id;
                $temabook_url[]['url'] = $url;
                }
                $recurso4=$items_tema['name'];
            }
         }	  
         
         
		
		 $recurso=$items_tema['name'];
        //$tema[]['nombre'] = $items_tema['name'];
     }
        
//var_dump($tema[]['nombre'] );die();
 }else{
  echo $err;
 }
//var_dump($tema);
//die();
}



?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en-US" dir="ltr">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Falcon | Dashboard &amp; Web App Template</title>


    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicons/favicon-16x16.png">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicons/favicon.ico">
    <link rel="manifest" href="assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">
    <script src="assets/js/config.js"></script>
    <script src="vendors/simplebar/simplebar.min.js"></script>


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link href="vendors/glightbox/glightbox.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">
    <link href="vendors/simplebar/simplebar.min.css" rel="stylesheet">
    <link href="assets/css/theme-rtl.css" rel="stylesheet" id="style-rtl">
    <link href="assets/css/theme.css" rel="stylesheet" id="style-default">
    <link href="assets/css/user-rtl.css" rel="stylesheet" id="user-style-rtl">
    <link href="assets/css/user.css" rel="stylesheet" id="user-style-default">
    <script>
      var isRTL = JSON.parse(localStorage.getItem('isRTL'));
      if (isRTL) {
        var linkDefault = document.getElementById('style-default');
        var userLinkDefault = document.getElementById('user-style-default');
        linkDefault.setAttribute('disabled', true);
        userLinkDefault.setAttribute('disabled', true);
        document.querySelector('html').setAttribute('dir', 'rtl');
      } else {
        var linkRTL = document.getElementById('style-rtl');
        var userLinkRTL = document.getElementById('user-style-rtl');
        linkRTL.setAttribute('disabled', true);
        userLinkRTL.setAttribute('disabled', true);
      }
    </script>
  </head>


  <body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
      <div class="container" data-layout="container">
        <script>
          var isFluid = JSON.parse(localStorage.getItem('isFluid'));
          if (isFluid) {
            var container = document.querySelector('[data-layout]');
            container.classList.remove('container');
            container.classList.add('container-fluid');
          }
        </script>
        <!-- nav -->
<?php include("componentes/nav_left.php");?>
<!-- end nav -->
        <div class="content">
      <!-- menu top-->
      <?php include("componentes/nav_top.php");?>
      <!-- end top-->
      <div class="card mb-3">
      <div class="row">  
      <div class="card">
                <div class="card-header d-flex flex-between-center">
                <a class="dropdown-item" href="<?php echo $_SESSION['url_app_temas'];?>">
                <button class="btn btn-falcon-default btn-sm" type="button"><svg class="svg-inline--fa fa-arrow-left fa-w-14" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="arrow-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M257.5 445.1l-22.2 22.2c-9.4 9.4-24.6 9.4-33.9 0L7 273c-9.4-9.4-9.4-24.6 0-33.9L201.4 44.7c9.4-9.4 24.6-9.4 33.9 0l22.2 22.2c9.5 9.5 9.3 25-.4 34.3L136.6 216H424c13.3 0 24 10.7 24 24v32c0 13.3-10.7 24-24 24H136.6l120.5 114.8c9.8 9.3 10 24.8.4 34.3z"></path></svg><!-- <span class="fas fa-arrow-left"></span> Font Awesome fontawesome.com --></button>
                </a>
                <div class="d-flex">
                    
                    <div class="dropdown font-sans-serif ms-2">
                      <button class="btn btn-falcon-default text-600 btn-sm dropdown-toggle dropdown-caret-none" type="button" id="preview-dropdown" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><svg class="svg-inline--fa fa-ellipsis-v fa-w-6 fs--2" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis-v" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512" data-fa-i2svg=""><path fill="currentColor" d="M96 184c39.8 0 72 32.2 72 72s-32.2 72-72 72-72-32.2-72-72 32.2-72 72-72zM24 80c0 39.8 32.2 72 72 72s72-32.2 72-72S135.8 8 96 8 24 40.2 24 80zm0 352c0 39.8 32.2 72 72 72s72-32.2 72-72-32.2-72-72-72-72 32.2-72 72z"></path></svg><!-- <span class="fas fa-ellipsis-v fs--2"></span> Font Awesome fontawesome.com --></button>
                      <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="preview-dropdown"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a><a class="dropdown-item d-sm-none" href="#!">Delete</a>
                        <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#!">Remove</a>
                      </div>
                    </div>
            </div>
            </div>
          <!-- comienza-->
          <div class="card mb-3">
            <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(assets/img/icons/spot-illustrations/corner-4.png);">
            </div>
            <!--/.bg-holder-->

            <div class="card-body position-relative">
              <div class="row">
                <div class="col-lg-8">
                  <h2><?php echo $curso_nombre;?></h2>
                </div>
              </div>
            </div>
          </div>

         
          <div class="row g-3 mb-3">
 <!-- nuevo diseño -->
 <div class="row g-3 mb-3">
            <div class="col-lg-8">
              <div class="card h-100">
                <div class="card-header">
                 <!-- <h5 class="mb-0">Visor: Selecione item a visualizar.</h5>-->
                </div>
                <div class="card-body bg-light">
                <div class="ratio ratio-16x9">
                <div class="loading-overlay" style="display: none;"><div class="overlay-content">cargando.....</div></div>
                <div id="userData"><div style="padding-top:56.250%;position:relative;"><iframe src="https://gifer.com/embed/OjNE" width="100%" height="100%" style='position:absolute;top:0;left:0;' frameBorder="0" allowFullScreen></iframe></div><p><a href="https://gifer.com"></a></p></div> 
               </div>
                  </div>
                </div>              
            </div>
            <div class="col-lg-4">
              <div class="card h-100">
                <div class="card-header">
                  <h5 class="mb-0">ACTIVIDADES</h5>
                </div>
                <div class="card-body bg-light">
                  <!-- aqui item -->
                  <div class="card-body pb-0">
                  <?php if ($recurso0=="videotime"){
                            for ( $i = 0; $i < count($temavideo); $i++ ) {  
                              $url = $_SESSION['url'].'v1/index.php/gesinpol_empleado_progreso_modulo';
                              $parametros="empleado=".$_SESSION['idmoodle'] ."&curso=".$_REQUEST['curso']."&tema=".$_REQUEST['tema']."&modulo=".$temavideo_id[$i]['id'] ;
                              $res_completo = resulrow($url, $parametros);
                              $completado=0;
                              $idm=0;
                              $idmc=0;
                              foreach ($res_completo["completado"] as $value) {
                                $completado = $value['completionstate'];  
                                $idm= $value['idm'];
                                $idmc= $value['idmc'];
                              }
                              $url = $_SESSION['url'].'v1/index.php/gesinpol_empleado_sin_progreso_modulo';
                              $parametros="curso=".$_REQUEST['curso']."&tema=".$_REQUEST['tema']."&modulo=".$temavideo_id[$i]['id'] ;
                              $res_completo = resulrow($url, $parametros);                         
                              
                              foreach ($res_completo["sin_completado"] as $value) {                                
                                $idm= $value['idm'];                                
                              }
                              
                  ?>
                  <div class="d-flex mb-3 hover-actions-trigger align-items-center">
                    <div class="file-thumbnail">
                     <img class="border h-100 w-100 object-fit-cover rounded-2" src="assets/img/otro_icons/video.png" alt="">

                  </div>
                    <div class="ms-3 flex-shrink-1 flex-grow-1">
                      <h6 class="mb-1">
                      <a class="stretched-link text-900 fw-semi-bold" onclick="getContenidosvideo(<?php echo $temavideo_id[$i]['id'];?>,<?php echo $_REQUEST['curso'];?>,'<?php echo $temavideo[$i]['nombre'];?>');">                        
                        <?php echo $temavideo[$i]['nombre'];?> 
                        </a>                        
                      </h6>
                     
                     
                        <div class="fs--1"></div>
                          <div class="hover-actions end-0 top-50 translate-middle-y">
                          <?php if ($completado==1){?>
                            <a  class="btn btn-light border-300 btn-sm me-1 text-600" data-bs-toggle="tooltip" data-bs-placement="top"  download="Hecho" aria-label="Hecho" data-bs-original-title="Hecho">                                           
                          <img src="assets/img/otro_icons/check-verde.png" alt="" width="15">                          
                          </a>
                        <?php }else{ ?>
                          <a  class="btn btn-light border-300 btn-sm me-1 text-600" data-bs-toggle="tooltip" data-bs-placement="top" onclick="getHechovideo(<?php echo $_SESSION['idmoodle'];?>,<?php echo $idm;?>);" download="Marcar como Hecho" aria-label="Marcar como Hecho" data-bs-original-title="Marcar como Hecho">                                           
                          <img src="assets/img/otro_icons/check-negro.png" alt="" width="15">                          
                          </a>
                          <?php }?>
                          </div>

                      </div>                   
                    
                  </div>
                 
                  <hr class="text-200">
                  <?php }}?> 

                  <?php if ($recurso5=="resource"){
                    for ( $i = 0; $i < count($temaresource); $i++ ) {   
                      $url = $_SESSION['url'].'v1/index.php/gesinpol_empleado_progreso_modulo';
                      $parametros="empleado=".$_SESSION['idmoodle'] ."&curso=".$_REQUEST['curso']."&tema=".$_REQUEST['tema']."&modulo=".$temaresource_id[$i]['id'] ;
                      $res_completo = resulrow($url, $parametros);
                      $completado=0;
                      $idm=0;
                      $idmc=0;
                      foreach ($res_completo["completado"] as $value) {
                        $completado = $value['completionstate'];  
                      }     
                      $url = $_SESSION['url'].'v1/index.php/gesinpol_empleado_sin_progreso_modulo';
                      $parametros="curso=".$_REQUEST['curso']."&tema=".$_REQUEST['tema']."&modulo=".$temaresource_id[$i]['id'] ;
                      $res_completo = resulrow($url, $parametros);                         
                              
                      foreach ($res_completo["sin_completado"] as $value) {                                
                                $idm= $value['idm'];                                
                      }                 
                      ?>
                  <div class="d-flex mb-3 hover-actions-trigger align-items-center">
                    <div class="file-thumbnail">
                      <img class="border h-100 w-100 object-fit-cover rounded-2" src="assets/img/otro_icons/pdf.png" alt="">
                    </div>
                    <div class="ms-3 flex-shrink-1 flex-grow-1">
                      <h6 class="mb-1">
                        <a class="stretched-link text-900 fw-semi-bold" onclick="getContenidospdf(<?php echo $temaresource_id[$i]['id'];?>,<?php echo $_REQUEST['curso'];?>,'<?php echo $temaresource[$i]['nombre'];?>');"><?php echo $temaresource[$i]['nombre'];?> 
                        </a>
                      </h6>
                      <div class="fs--1"></div>
                      <div class="hover-actions end-0 top-50 translate-middle-y">
                          <?php if ($completado==1){?>
                            <a  class="btn btn-light border-300 btn-sm me-1 text-600" data-bs-toggle="tooltip" data-bs-placement="top"  download="Hecho" aria-label="Hecho" data-bs-original-title="Hecho">                                           
                          <img src="assets/img/otro_icons/check-verde.png" alt="" width="15">                          
                          </a>
                        <?php }else{ ?>
                          <a  class="btn btn-light border-300 btn-sm me-1 text-600" data-bs-toggle="tooltip" data-bs-placement="top" onclick="getHechovideo(<?php echo $_SESSION['idmoodle'];?>,<?php echo $idm;?>);" download="Marcar como Hecho" aria-label="Marcar como Hecho" data-bs-original-title="Marcar como Hecho">                                           
                          <img src="assets/img/otro_icons/check-negro.png" alt="" width="15">                          
                          </a>
                          <?php }?>
                          </div>
                      
                    </div>
                  </div>
                  <hr class="text-200">
                  <?php }}?> 
                  <?php if ($recurso1=="page"){
                    for ( $i = 0; $i < count($tema); $i++ ) {   
                      $url = $_SESSION['url'].'v1/index.php/gesinpol_empleado_progreso_modulo';
                      $parametros="empleado=".$_SESSION['idmoodle'] ."&curso=".$_REQUEST['curso']."&tema=".$_REQUEST['tema']."&modulo=".$tema_id[$i]['id'] ;
                      $res_completo = resulrow($url, $parametros);
                      $completado=0;
                      $idm=0;
                      $idmc=0;
                      foreach ($res_completo["completado"] as $value) {
                        $completado = $value['completionstate'];  
                      }    
                      $url = $_SESSION['url'].'v1/index.php/gesinpol_empleado_sin_progreso_modulo';
                      $parametros="curso=".$_REQUEST['curso']."&tema=".$_REQUEST['tema']."&modulo=".$tema_id[$i]['id'] ;
                      $res_completo = resulrow($url, $parametros);                         
                              
                      foreach ($res_completo["sin_completado"] as $value) {                                
                                $idm= $value['idm'];                                
                      }                                   
                      ?>
                  <div class="d-flex mb-3 hover-actions-trigger align-items-center">
                    <div class="file-thumbnail">
                      <img class="border h-100 w-100 object-fit-cover rounded-2" src="assets/img/otro_icons/png-transparent-student-higtest-thumbnail.png" alt="">
                    </div>
                    <div class="ms-3 flex-shrink-1 flex-grow-1">
                      <h6 class="mb-1">
                        <a class="stretched-link text-900 fw-semi-bold" onclick="getContenidosMoodle(<?php echo $id_cuestionario;?>,<?php echo $_REQUEST['curso'];?>,'<?php echo $tipo;?>');"><?php echo $name_cuestionario;?> </a></h6>
                      <div class="fs--1"></div>
                      <div class="hover-actions end-0 top-50 translate-middle-y">
                          <?php if ($completado==1){?>
                            <a  class="btn btn-light border-300 btn-sm me-1 text-600" data-bs-toggle="tooltip" data-bs-placement="top"  download="Hecho" aria-label="Hecho" data-bs-original-title="Hecho">                                           
                          <img src="assets/img/otro_icons/check-verde.png" alt="" width="15">                          
                          </a>
                        <?php }else{ ?>
                          <a  class="btn btn-light border-300 btn-sm me-1 text-600" data-bs-toggle="tooltip" data-bs-placement="top" onclick="getHechovideo(<?php echo $_SESSION['idmoodle'];?>,<?php echo $idm;?>);" download="Marcar como Hecho" aria-label="Marcar como Hecho" data-bs-original-title="Marcar como Hecho">                                           
                          <img src="assets/img/otro_icons/check-negro.png" alt="" width="15">                          
                          </a>
                          <?php }?>
                          </div>
                    </div>
                  </div>
                  <hr class="text-200">
                  
                  <?php }}?> 
                  <?php if ($recurso6=="quiz"){
                    for ( $i = 0; $i < count($temaquiz); $i++ ) {   
                      $url = $_SESSION['url'].'v1/index.php/gesinpol_empleado_progreso_modulo';
                      $parametros="empleado=".$_SESSION['idmoodle'] ."&curso=".$_REQUEST['curso']."&tema=".$_REQUEST['tema']."&modulo=".$temaquiz_id[$i]['id'] ;
                      $res_completo = resulrow($url, $parametros);
                      $completado=0;
                      $idm=0;
                      $idmc=0;
                      foreach ($res_completo["completado"] as $value) {
                        $completado = $value['completionstate'];  
                      }     
                      $url = $_SESSION['url'].'v1/index.php/gesinpol_empleado_sin_progreso_modulo';
                      $parametros="curso=".$_REQUEST['curso']."&tema=".$_REQUEST['tema']."&modulo=".$temaquiz[$i]['id'] ;
                      $res_completo = resulrow($url, $parametros);                         
                              
                      foreach ($res_completo["sin_completado"] as $value) {                                
                                $idm= $value['idm'];                                
                      }       
                      if ($codigo_cuestionario !=""){
                        $url = $_SESSION['url'].'v1/index.php/insco_cuestionario_curso';
                        $parametros="curso=".$_REQUEST['curso']."&quiz=". $codigo_cuestionario."&tema=". $_REQUEST['tema'];
                        $res_cuestionario = resulrow($url, $parametros);                         
                                
                        foreach ($res_cuestionario["cuestionario"] as $value) {                                
                                  $id_cuestionario= $value['id']; 
                                  $name_cuestionario= $value['name'];  
                                  $tipo="quiz";                                
                        }  
                      }                    
                        // end cuestionario             
                      ?>
                  <div class="d-flex mb-3 hover-actions-trigger align-items-center">
                    <div class="file-thumbnail">
                    <img class="border h-100 w-100 object-fit-cover rounded-2" src="assets/img/otro_icons/png-transparent-student-higtest-thumbnail.png" alt="">
                    </div>
                    <div class="ms-3 flex-shrink-1 flex-grow-1">
                      <h6 class="mb-1">
                      <a class="stretched-link text-900 fw-semi-bold" onclick="getContenidosMoodle(<?php echo $id_cuestionario;?>,<?php echo $_REQUEST['curso'];?>,'<?php echo $tipo;?>');"><?php echo $name_cuestionario;?> </a></h6>
                     </h6>
                      <div class="fs--1"></div>
                      <div class="hover-actions end-0 top-50 translate-middle-y">
                          <?php if ($completado==1){?>
                            <a  class="btn btn-light border-300 btn-sm me-1 text-600" data-bs-toggle="tooltip" data-bs-placement="top"  download="Hecho" aria-label="Hecho" data-bs-original-title="Hecho">                                           
                          <img src="assets/img/otro_icons/check-verde.png" alt="" width="15">                          
                          </a>
                        <?php }else{ ?>
                          <a  class="btn btn-light border-300 btn-sm me-1 text-600" data-bs-toggle="tooltip" data-bs-placement="top" onclick="getHechovideo(<?php echo $_SESSION['idmoodle'];?>,<?php echo $idm;?>);" download="Marcar como Hecho" aria-label="Marcar como Hecho" data-bs-original-title="Marcar como Hecho">                                           
                          <img src="assets/img/otro_icons/check-negro.png" alt="" width="15">                          
                          </a>
                          <?php }?>
                          </div>
                      
                    </div>
                  </div>
                  <hr class="text-200">
                  <?php }}?> 
                  <?php if ($recurso7=="feedback"){
                    for ( $i = 0; $i < count($temafeedback); $i++ ) {   
                      $url = $_SESSION['url'].'v1/index.php/gesinpol_empleado_progreso_modulo';
                      $parametros="empleado=".$_SESSION['idmoodle'] ."&curso=".$_REQUEST['curso']."&tema=".$_REQUEST['tema']."&modulo=".$temafeedback_id[$i]['id'] ;
                      $res_completo = resulrow($url, $parametros);
                      $completado=0;
                      $idm=0;
                      $idmc=0;
                      foreach ($res_completo["completado"] as $value) {
                        $completado = $value['completionstate'];  
                      }     
                      $url = $_SESSION['url'].'v1/index.php/gesinpol_empleado_sin_progreso_modulo';
                      $parametros="curso=".$_REQUEST['curso']."&tema=".$_REQUEST['tema']."&modulo=".$temafeedback_id[$i]['id'] ;
                      $res_completo = resulrow($url, $parametros);                         
                              
                      foreach ($res_completo["sin_completado"] as $value) {                                
                                $idm= $value['idm'];                                
                      }       
                      if ($recurso7=="feedback"){
                        //leer cuestionarios y encuesta
                        // cuestionario
                             
                         // encuesta
                         if ($codigo_encuesta !=""){
                         $url = $_SESSION['url'].'v1/index.php/insco_encuesta_curso';
                         $parametros="curso=".$_REQUEST['curso']."&encuesta=". $codigo_encuesta;
                         $res_encuesta = resulrow($url, $parametros);                         
                                 
                         foreach ($res_encuesta["encuesta"] as $value) { 
                                   $tipo="feedback";                               
                                   $id_cuestionario= $value['id']; 
                                   $name_cuestionario= $value['name'];                                
                         } 
                       }      
                     }               
                         // end encuesta             
                      ?>
                  <div class="d-flex mb-3 hover-actions-trigger align-items-center">
                    <div class="file-thumbnail">
                    <img class="border h-100 w-100 object-fit-cover rounded-2" src="assets/img/otro_icons/png-transparent-student-higtest-thumbnail.png" alt="">
                    </div>
                    <div class="ms-3 flex-shrink-1 flex-grow-1">
                      <h6 class="mb-1">
                      <a class="stretched-link text-900 fw-semi-bold" onclick="getContenidosMoodle(<?php echo $id_cuestionario;?>,<?php echo $_REQUEST['curso'];?>,'<?php echo $tipo;?>');"><?php echo $name_cuestionario;?> </a></h6>
                     </h6>
                      <div class="fs--1"></div>
                      <div class="hover-actions end-0 top-50 translate-middle-y">
                          <?php if ($completado==1){?>
                            <a  class="btn btn-light border-300 btn-sm me-1 text-600" data-bs-toggle="tooltip" data-bs-placement="top"  download="Hecho" aria-label="Hecho" data-bs-original-title="Hecho">                                           
                          <img src="assets/img/otro_icons/check-verde.png" alt="" width="15">                          
                          </a>
                        <?php }else{ ?>
                          <a  class="btn btn-light border-300 btn-sm me-1 text-600" data-bs-toggle="tooltip" data-bs-placement="top" onclick="getHechovideo(<?php echo $_SESSION['idmoodle'];?>,<?php echo $idm;?>);" download="Marcar como Hecho" aria-label="Marcar como Hecho" data-bs-original-title="Marcar como Hecho">                                           
                          <img src="assets/img/otro_icons/check-negro.png" alt="" width="15">                          
                          </a>
                          <?php }?>
                          </div>
                      
                    </div>
                  </div>
                  <hr class="text-200">
                  <?php }}?> 
                  <?php if ($recurso8=="assign"){
                    for ( $i = 0; $i < count($temaassign); $i++ ) {   
                      $url = $_SESSION['url'].'v1/index.php/gesinpol_empleado_progreso_modulo';
                      $parametros="empleado=".$_SESSION['idmoodle'] ."&curso=".$_REQUEST['curso']."&tema=".$_REQUEST['tema']."&modulo=".$temaassign_id[$i]['id'] ;
                      $res_completo = resulrow($url, $parametros);
                      $completado=0;
                      $idm=0;
                      $idmc=0;
                      foreach ($res_completo["completado"] as $value) {
                        $completado = $value['completionstate'];  
                      }     
                      $url = $_SESSION['url'].'v1/index.php/gesinpol_empleado_sin_progreso_modulo';
                      $parametros="curso=".$_REQUEST['curso']."&tema=".$_REQUEST['tema']."&modulo=".$temaassign_id[$i]['id'] ;
                      $res_completo = resulrow($url, $parametros);                         
                              
                      foreach ($res_completo["sin_completado"] as $value) {                                
                                $idm= $value['idm'];                                
                      }       
                      if ($recurso8=="assign"){
                        //leer cuestionarios y encuesta
                        // cuestionario
                             
                         // encuesta
                         if ($codigo_tarea !=""){
                         $url = $_SESSION['url'].'v1/index.php/insco_tarea_curso';
                         $parametros="curso=".$_REQUEST['curso']."&encuesta=". $codigo_tarea;
                         $res_encuesta = resulrow($url, $parametros);                         
                                 
                         foreach ($res_encuesta["tarea"] as $value) { 
                                   $tipo="assign";                               
                                   $id_cuestionario= $value['id']; 
                                   $name_cuestionario= $value['name'];                                
                         } 
                       }      
                     }               
                         // end encuesta             
                      ?>
                  <div class="d-flex mb-3 hover-actions-trigger align-items-center">
                    <div class="file-thumbnail">
                    <img class="border h-100 w-100 object-fit-cover rounded-2" src="assets/img/otro_icons/png-transparent-student-higtest-thumbnail.png" alt="">
                    </div>
                    <div class="ms-3 flex-shrink-1 flex-grow-1">
                      <h6 class="mb-1">
                      <a class="stretched-link text-900 fw-semi-bold" onclick="getContenidosMoodle(<?php echo $id_cuestionario;?>,<?php echo $_REQUEST['curso'];?>,'<?php echo $tipo;?>');"><?php echo $name_cuestionario;?> </a></h6>
                     </h6>
                      <div class="fs--1"></div>
                      <div class="hover-actions end-0 top-50 translate-middle-y">
                          <?php if ($completado==1){?>
                            <a  class="btn btn-light border-300 btn-sm me-1 text-600" data-bs-toggle="tooltip" data-bs-placement="top"  download="Hecho" aria-label="Hecho" data-bs-original-title="Hecho">                                           
                          <img src="assets/img/otro_icons/check-verde.png" alt="" width="15">                          
                          </a>
                        <?php }else{ ?>
                          <a  class="btn btn-light border-300 btn-sm me-1 text-600" data-bs-toggle="tooltip" data-bs-placement="top" onclick="getHechovideo(<?php echo $_SESSION['idmoodle'];?>,<?php echo $idm;?>);" download="Marcar como Hecho" aria-label="Marcar como Hecho" data-bs-original-title="Marcar como Hecho">                                           
                          <img src="assets/img/otro_icons/check-negro.png" alt="" width="15">                          
                          </a>
                          <?php }?>
                          </div>
                      
                    </div>
                  </div>
                  <hr class="text-200">
                  <?php }}?>                   
                  <div class="loading-overlay1" style="display: none;"><div class="overlay-content">cargando.....</div></div>
                  <div id="userData1"></div>
                  <!-- end -->
                </div>
              </div>
            </div>
          </div>
 <!-- end -->

<!-- tabla doble empleados y cursos -->
<div class="card mb-3">

          </div>
          <!--end-->
          <footer class="footer">
            <div class="row g-0 justify-content-between fs--1 mt-4 mb-3">
              <div class="col-12 col-sm-auto text-center">
                <p class="mb-0 text-600">Thank you for creating with Falcon <span class="d-none d-sm-inline-block">| </span><br class="d-sm-none" /> 2023 &copy; <a href="https://themewagon.com">Themewagon</a></p>
              </div>
              <div class="col-12 col-sm-auto text-center">
                <p class="mb-0 text-600">v3.17.0</p>
              </div>
            </div>
          </footer>
        </div>
        <div class="modal fade" id="authentication-modal" tabindex="-1" role="dialog" aria-labelledby="authentication-modal-label" aria-hidden="true">
          <div class="modal-dialog mt-6" role="document">
            <div class="modal-content border-0">
              <div class="modal-header px-5 position-relative modal-shape-header bg-shape">
                <div class="position-relative z-1" data-bs-theme="light">
                  <h4 class="mb-0 text-white" id="authentication-modal-label">Mensaje</h4>
                  <p class="fs--1 mb-0 text-white">lea con atencion</p>
                </div>
                <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body py-4 px-5">
                <form>
                 
                  <div class="mb-3">
                    <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">Register</button>
                  </div>
                </form>
                <div class="position-relative mt-5">
                  <hr />                  
                </div>
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->


    <div class="offcanvas offcanvas-end settings-panel border-0" id="settings-offcanvas" tabindex="-1" aria-labelledby="settings-offcanvas">
      <div class="offcanvas-header settings-panel-header bg-shape">
        <div class="z-1 py-1" data-bs-theme="light">
          <div class="d-flex justify-content-between align-items-center mb-1">
            <h5 class="text-white mb-0 me-2"><span class="fas fa-palette me-2 fs-0"></span>Settings</h5>
            <button class="btn btn-primary btn-sm rounded-pill mt-0 mb-0" data-theme-control="reset" style="font-size:12px"> <span class="fas fa-redo-alt me-1" data-fa-transform="shrink-3"></span>Reset</button>
          </div>
          <p class="mb-0 fs--1 text-white opacity-75"> Set your own customized style</p>
        </div>
        <button class="btn-close btn-close-white z-1 mt-0" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body scrollbar-overlay px-x1 h-100" id="themeController">
        <h5 class="fs-0">Color Scheme</h5>
        <p class="fs--1">Choose the perfect color mode for your app.</p>
        <div class="btn-group d-block w-100 btn-group-navbar-style">
          <div class="row gx-2">
            <div class="col-6">
              <input class="btn-check" id="themeSwitcherLight" name="theme-color" type="radio" value="light" data-theme-control="theme" />
              <label class="btn d-inline-block btn-navbar-style fs--1" for="themeSwitcherLight"> <span class="hover-overlay mb-2 rounded d-block"><img class="img-fluid img-prototype mb-0" src="assets/img/generic/falcon-mode-default.jpg" alt=""/></span><span class="label-text">Light</span></label>
            </div>
            <div class="col-6">
              <input class="btn-check" id="themeSwitcherDark" name="theme-color" type="radio" value="dark" data-theme-control="theme" />
              <label class="btn d-inline-block btn-navbar-style fs--1" for="themeSwitcherDark"> <span class="hover-overlay mb-2 rounded d-block"><img class="img-fluid img-prototype mb-0" src="assets/img/generic/falcon-mode-dark.jpg" alt=""/></span><span class="label-text"> Dark</span></label>
            </div>
          </div>
        </div>
        <hr />
        <div class="d-flex justify-content-between">
          <div class="d-flex align-items-start"><img class="me-2" src="assets/img/icons/left-arrow-from-left.svg" width="20" alt="" />
            <div class="flex-1">
              <h5 class="fs-0">RTL Mode</h5>
              <p class="fs--1 mb-0">Switch your language direction </p><a class="fs--1" href="documentation/customization/configuration.html">RTL Documentation</a>
            </div>
          </div>
          <div class="form-check form-switch">
            <input class="form-check-input ms-0" id="mode-rtl" type="checkbox" data-theme-control="isRTL" />
          </div>
        </div>
        <hr />
        <div class="d-flex justify-content-between">
          <div class="d-flex align-items-start"><img class="me-2" src="assets/img/icons/arrows-h.svg" width="20" alt="" />
            <div class="flex-1">
              <h5 class="fs-0">Fluid Layout</h5>
              <p class="fs--1 mb-0">Toggle container layout system </p><a class="fs--1" href="documentation/customization/configuration.html">Fluid Documentation</a>
            </div>
          </div>
          <div class="form-check form-switch">
            <input class="form-check-input ms-0" id="mode-fluid" type="checkbox" data-theme-control="isFluid" />
          </div>
        </div>
        <hr />
        <div class="d-flex align-items-start"><img class="me-2" src="assets/img/icons/paragraph.svg" width="20" alt="" />
          <div class="flex-1">
            <h5 class="fs-0 d-flex align-items-center">Navigation Position</h5>
            <p class="fs--1 mb-2">Select a suitable navigation system for your web application </p>
            <div>
              <select class="form-select form-select-sm" aria-label="Navbar position" data-theme-control="navbarPosition">
                <option value="vertical" data-page-url="modules/components/navs-and-tabs/vertical-navbar.html">Vertical</option>
                <option value="top" data-page-url="modules/components/navs-and-tabs/top-navbar.html">Top</option>
                <option value="combo" data-page-url="modules/components/navs-and-tabs/combo-navbar.html">Combo</option>
                <option value="double-top" data-page-url="modules/components/navs-and-tabs/double-top-navbar.html">Double Top</option>
              </select>
            </div>
          </div>
        </div>
        <hr />
        <h5 class="fs-0 d-flex align-items-center">Vertical Navbar Style</h5>
        <p class="fs--1 mb-0">Switch between styles for your vertical navbar </p>
        <p> <a class="fs--1" href="modules/components/navs-and-tabs/vertical-navbar.html#navbar-styles">See Documentation</a></p>
        <div class="btn-group d-block w-100 btn-group-navbar-style">
          <div class="row gx-2">
            <div class="col-6">
              <input class="btn-check" id="navbar-style-transparent" type="radio" name="navbarStyle" value="transparent" data-theme-control="navbarStyle" />
              <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-transparent"> <img class="img-fluid img-prototype" src="assets/img/generic/default.png" alt="" /><span class="label-text"> Transparent</span></label>
            </div>
            <div class="col-6">
              <input class="btn-check" id="navbar-style-inverted" type="radio" name="navbarStyle" value="inverted" data-theme-control="navbarStyle" />
              <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-inverted"> <img class="img-fluid img-prototype" src="assets/img/generic/inverted.png" alt="" /><span class="label-text"> Inverted</span></label>
            </div>
            <div class="col-6">
              <input class="btn-check" id="navbar-style-card" type="radio" name="navbarStyle" value="card" data-theme-control="navbarStyle" />
              <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-card"> <img class="img-fluid img-prototype" src="assets/img/generic/card.png" alt="" /><span class="label-text"> Card</span></label>
            </div>
            <div class="col-6">
              <input class="btn-check" id="navbar-style-vibrant" type="radio" name="navbarStyle" value="vibrant" data-theme-control="navbarStyle" />
              <label class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-vibrant"> <img class="img-fluid img-prototype" src="assets/img/generic/vibrant.png" alt="" /><span class="label-text"> Vibrant</span></label>
            </div>
          </div>
        </div>
        <div class="text-center mt-5"><img class="mb-4" src="assets/img/icons/spot-illustrations/47.png" alt="" width="120" />
          <h5>Like What You See?</h5>
          <p class="fs--1">Get Falcon now and create beautiful dashboards with hundreds of widgets.</p><a class="mb-3 btn btn-primary" href="https://themes.getbootstrap.com/product/falcon-admin-dashboard-webapp-template/" target="_blank">Purchase</a>
        </div>
      </div>
    </div><a class="card setting-toggle" href="#settings-offcanvas" data-bs-toggle="offcanvas">
      <div class="card-body d-flex align-items-center py-md-2 px-2 py-1">
        <div class="bg-primary-subtle position-relative rounded-start" style="height:34px;width:28px">
          <div class="settings-popover"><span class="ripple"><span class="fa-spin position-absolute all-0 d-flex flex-center"><span class="icon-spin position-absolute all-0 d-flex flex-center">
                  <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.7369 12.3941L19.1989 12.1065C18.4459 11.7041 18.0843 10.8487 18.0843 9.99495C18.0843 9.14118 18.4459 8.28582 19.1989 7.88336L19.7369 7.59581C19.9474 7.47484 20.0316 7.23291 19.9474 7.03131C19.4842 5.57973 18.6843 4.28943 17.6738 3.20075C17.5053 3.03946 17.2527 2.99914 17.0422 3.12011L16.393 3.46714C15.6883 3.84379 14.8377 3.74529 14.1476 3.3427C14.0988 3.31422 14.0496 3.28621 14.0002 3.25868C13.2568 2.84453 12.7055 2.10629 12.7055 1.25525V0.70081C12.7055 0.499202 12.5371 0.297594 12.2845 0.257272C10.7266 -0.105622 9.16879 -0.0653007 7.69516 0.257272C7.44254 0.297594 7.31623 0.499202 7.31623 0.70081V1.23474C7.31623 2.09575 6.74999 2.8362 5.99824 3.25599C5.95774 3.27861 5.91747 3.30159 5.87744 3.32493C5.15643 3.74527 4.26453 3.85902 3.53534 3.45302L2.93743 3.12011C2.72691 2.99914 2.47429 3.03946 2.30587 3.20075C1.29538 4.28943 0.495411 5.57973 0.0322686 7.03131C-0.051939 7.23291 0.0322686 7.47484 0.242788 7.59581L0.784376 7.8853C1.54166 8.29007 1.92694 9.13627 1.92694 9.99495C1.92694 10.8536 1.54166 11.6998 0.784375 12.1046L0.242788 12.3941C0.0322686 12.515 -0.051939 12.757 0.0322686 12.9586C0.495411 14.4102 1.29538 15.7005 2.30587 16.7891C2.47429 16.9504 2.72691 16.9907 2.93743 16.8698L3.58669 16.5227C4.29133 16.1461 5.14131 16.2457 5.8331 16.6455C5.88713 16.6767 5.94159 16.7074 5.99648 16.7375C6.75162 17.1511 7.31623 17.8941 7.31623 18.7552V19.2891C7.31623 19.4425 7.41373 19.5959 7.55309 19.696C7.64066 19.7589 7.74815 19.7843 7.85406 19.8046C9.35884 20.0925 10.8609 20.0456 12.2845 19.7729C12.5371 19.6923 12.7055 19.4907 12.7055 19.2891V18.7346C12.7055 17.8836 13.2568 17.1454 14.0002 16.7312C14.0496 16.7037 14.0988 16.6757 14.1476 16.6472C14.8377 16.2446 15.6883 16.1461 16.393 16.5227L17.0422 16.8698C17.2527 16.9907 17.5053 16.9504 17.6738 16.7891C18.7264 15.7005 19.4842 14.4102 19.9895 12.9586C20.0316 12.757 19.9474 12.515 19.7369 12.3941ZM10.0109 13.2005C8.1162 13.2005 6.64257 11.7893 6.64257 9.97478C6.64257 8.20063 8.1162 6.74905 10.0109 6.74905C11.8634 6.74905 13.3792 8.20063 13.3792 9.97478C13.3792 11.7893 11.8634 13.2005 10.0109 13.2005Z" fill="#2A7BE4"></path>
                  </svg></span></span></span></div>
        </div><small class="text-uppercase text-primary fw-bold bg-primary-subtle py-2 pe-2 ps-1 rounded-end">customize</small>
      </div>
    </a>


    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="vendors/popper/popper.min.js"></script>
    <script src="vendors/bootstrap/bootstrap.min.js"></script>
    <script src="vendors/anchorjs/anchor.min.js"></script>
    <script src="vendors/is/is.min.js"></script>
    <script src="vendors/glightbox/glightbox.min.js"></script>
    <script src="vendors/fontawesome/all.min.js"></script>
    <script src="vendors/lodash/lodash.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="vendors/list.js/list.min.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script> 
  function getContenidosvideo(video,curso,titulo){
    $.ajax({
        type: 'POST',
        url: 'reproductor_ajax.php',
        data: 'video='+video+'&curso='+curso+'&titulo='+titulo+'&tema='+<?php echo $_REQUEST['tema'];?>,
        beforeSend:function(html){
            $('.loading-overlay').show();
        },
        success:function(html){
            $('.loading-overlay').hide();
            var pantalla="#userData";
            //console.log(pantalla);
            //if (item=1){$('#userData1').html(html);}
            //if (item=2){$('#userData2').html(html);}
            //$('#userData').html(html);
            $(pantalla).html(html);
        }
    });
}
</script>

<script>
function getContenidospdf(pdf,curso,titulo){
    $.ajax({
        type: 'POST',
        url: 'pdf_ajax.php',
        data: 'id='+pdf+'&curso='+curso+'&titulo='+titulo+'&tema='+<?php echo $_REQUEST['tema'];?>,
        beforeSend:function(html){
            $('.loading-overlay').show();
        },
        success:function(html){
            $('.loading-overlay').hide();
            var pantalla="#userData";
            //console.log(pantalla);
            //if (item=1){$('#userData1').html(html);}
            //if (item=2){$('#userData2').html(html);}
            //$('#userData').html(html);
            $(pantalla).html(html);
        }
    });
}
</script>
<script>
function getContenidosform(pdf,curso,titulo){
    $.ajax({
        type: 'POST',
        url: 'google_form_ajax.php',
        data: 'id='+pdf+'&curso='+curso+'&tema='+titulo,
        beforeSend:function(html){
            $('.loading-overlay').show();
        },
        success:function(html){
            $('.loading-overlay').hide();
            var pantalla="#userData";
            //console.log(pantalla);
            //if (item=1){$('#userData1').html(html);}
            //if (item=2){$('#userData2').html(html);}
            //$('#userData').html(html);
            $(pantalla).html(html);
        }
    });
}
</script>
<script>
function getHechovideo(empleado,modulo){
    $.ajax({
        type: 'POST',
        url: 'hecho_ajax.php',
        data: 'id='+empleado+'&modulo='+modulo,
        beforeSend:function(html){
            $('.loading-overlay1').show();
        },
        success:function(html){
            $('.loading-overlay1').hide();
            var pantalla="#userData1";
            //console.log(pantalla);
            //if (item=1){$('#userData1').html(html);}
            //if (item=2){$('#userData2').html(html);}
            //$('#userData').html(html);
            $(pantalla).html(html);
        }
    });
}
</script>
<script>
function getContenidosMoodle(id,curso,tipo){
    $.ajax({
        type: 'POST',
        url: 'componentes_moodle.php',
        data: 'id='+id+'&curso='+curso+'&tipo='+tipo,
        beforeSend:function(html){
            $('.loading-overlay').show();
        },
        success:function(html){
            $('.loading-overlay').hide();
            var pantalla="#userData";
            //console.log(pantalla);
            //if (item=1){$('#userData1').html(html);}
            //if (item=2){$('#userData2').html(html);}
            //$('#userData').html(html);
            $(pantalla).html(html);
        }
    });
}
</script>
  </body>

</html>
