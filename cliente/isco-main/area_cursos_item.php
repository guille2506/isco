<?php
include("session.php");
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
die();
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
    $recurso0="";$recurso1="";$recurso2="";$recurso3="";$recurso4="";$recurso5="";
    foreach($res['items'] as $items_tema) {
        
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

                foreach($res['curso_page'] as $quiz) {
                        $nombre=$quiz['name'];
                $id=$quiz['id'];
               // $url=$quiz['content'];
                $temavideo[]['nombre'] = $nombre;
                $temavideo_id[]['id'] = $id;
                $temavideo_url[]['url'] = $url;
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
          <!-- comienza-->
          <div class="card mb-3">
            <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(assets/img/icons/spot-illustrations/corner-4.png);">
            </div>
            <!--/.bg-holder-->

            <div class="card-body position-relative">
              <div class="row">
                <div class="col-lg-8">
                  <h2>Área estudio</h2>
                  <p class="mb-0">Documentation and examples for opt-in styling of tables with Falcon.</p><a class="btn btn-link btn-sm ps-0 mt-2" href="https://getbootstrap.com/docs/5.3/content/tables/" target="_blank">Tables on Bootstrap<span class="fas fa-chevron-right ms-1 fs--2"></span></a>
                </div>
              </div>
            </div>
          </div>

         
          <div class="row g-3 mb-3">
 

<!-- tabla doble empleados y cursos -->
<div class="card mb-3">
<div class="panel-body">
            <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card" >
                        <div class="table-responsive">
                        <table class="table table-hover c_table themee-color " >
                            <thead style="background-color: #d1d1d1 !important;">
                                <tr>
                                    <th>#</th>
                                    <th>CONTENIDOS</th>
                                    <th></th>
                                    <th></th>
                                    <th>ACCEDER </th>
                                </tr>
                            </thead>
                            <tbody>
                            <!-- video -->    
                            <?php 
                            //echo count($temas);
                            if ($recurso0=="videotime"){
                            for ( $i = 0; $i < count($temavideo); $i++ ) {   ?>
                                                 
                            <tr>                               
                                    <td><?php echo $i+1;?></td>
                                    <td><strong><a href="javascript:void(0);" style="color:black;"><?php echo $temavideo[$i]['nombre'];?></a></strong></td>
                                    <td></td>
                                    <td></td>
                                    <td>
									<?php if ($recurso0=="videotime"){?>
                                        <a href="reproductor.php?video=<?php echo $temavideo_id[$i]['id'];?>&curso=<?php echo $_REQUEST['curso'];?>"><button class="btn" style="color:white;background-color: #004c45;">Visualizar video <img src="assets/images/videoicon.png" height="25"></button></a>
									<?php }?>
                                    </td>
                                </tr>
                                <?php ?>
                            <?php }
                        }?>        

                            <!-- page video -->    
                            <?php 
                            //echo count($temas);
                            if ($recurso1=="page"){
                            for ( $i = 0; $i < count($tema); $i++ ) {   ?>
                                                 
                            <tr>                               
                                    <td><?php echo $i+1;?></td>
                                    <td><strong><a href="javascript:void(0);"  style="color:black;"><?php echo $tema[$i]['nombre'];?></a></strong></td>
                                    <td></td>
                                    <td></td>
                                    <td>
									<?php if ($recurso1=="page"){?>
                                    <a href="reproductor22.php?video=<?php echo $tema_id[$i]['id'];?>&curso=<?php echo $_REQUEST['curso'];?>"><button class="btn" style="color:white;background-color: #004c45;">Visualizar video <img src="assets/images/videoicon.png" height="25"></button></a>
									<?php }?>
                                    </td>
                                </tr>
                                <?php ?>
                            <?php }
                        }?>        
  <!-- pdf-->
  <?php 
                            //echo count($temas);
                            if ($recurso2=="url"){

                            for ( $i = 0; $i < count($temaurl); $i++ ) {   ?>
                            <tr>
                                    <td><?php echo $i+1;?></td>
                                    <td><strong><a href="javascript:void(0);"  style="color:black;"><?php echo $temaurl[$i]['nombre'];?></a></strong></td>

                                    <td></td>
                                    <td></td>
                                    <td>
                                    <?php if ($recurso2=="url"){?>
                                    <a href="visorpdf22.php?id=<?php echo $temaurl_id[$i]['id'];?>&curso=<?php echo $_REQUEST['curso'];?>"><button class="btn" style="color:white;background-color: #004c45;">Visualizar pdf <img src="assets/images/pdf.png" height="25" style="margin-left:6px;"></button></a>
									<?php } ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            <?php 
                                    }?>    

                            <?php        
                            if ($recurso4=="book"){

for ( $i = 0; $i < count($temabook); $i++ ) {   ?>
<tr>
        <td><?php echo $i+1;?></td>
        <td><strong><a href="javascript:void(0);"  style="color:black;"><?php echo $temabook[$i]['nombre'];?></a></strong></td>

        <td></td>
        <td></td>
        <td>
        <?php if ($recurso4=="book"){?>
        <a href="visorpdf_book.php?id=<?php echo $temabook_id[$i]['id'];?>&curso=<?php echo $_REQUEST['curso'];?>"><button class="btn" style="color:white;background-color: #004c45;">Visualizar pdf <img src="assets/images/pdf.png" height="25" style="margin-left:6px;"></button></a>
        <?php } ?>
        </td>
    </tr>
    <?php } ?>
<?php 
        }?>    
        <?php 
                            //echo count($temas);
                            if ($recurso5=="resource"){

                            for ( $i = 0; $i < count($temaresource); $i++ ) {   ?>
                            <tr>
                                    <td><?php echo $i+1;?></td>
                                    <td><strong><a href="javascript:void(0);"  style="color:black;"><?php echo $temaresource[$i]['nombre'];?></a></strong></td>

                                    <td></td>
                                    <td></td>
                                    <td>
                                    <?php if ($recurso5=="resource"){?>
                                    <a href="visorpdf.php?id=<?php echo $temaresource_id[$i]['id'];?>&curso=<?php echo $_REQUEST['curso'];?>&titulo=<?php echo $temaresource[$i]['nombre'];?>"><button class="btn" style="color:white;background-color: #004c45;">Visualizar pdf <img src="assets/images/pdf.png" height="25" style="margin-left:6px;"></button></a>
									<?php } ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            <?php 
                                    }?>    

                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         </div>
                                    </div>
                                </div>
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
                  <h4 class="mb-0 text-white" id="authentication-modal-label">Register</h4>
                  <p class="fs--1 mb-0 text-white">Please create your free Falcon account</p>
                </div>
                <button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body py-4 px-5">
                <form>
                  <div class="mb-3">
                    <label class="form-label" for="modal-auth-name">Name</label>
                    <input class="form-control" type="text" autocomplete="on" id="modal-auth-name" />
                  </div>
                  <div class="mb-3">
                    <label class="form-label" for="modal-auth-email">Email address</label>
                    <input class="form-control" type="email" autocomplete="on" id="modal-auth-email" />
                  </div>
                  <div class="row gx-2">
                    <div class="mb-3 col-sm-6">
                      <label class="form-label" for="modal-auth-password">Password</label>
                      <input class="form-control" type="password" autocomplete="on" id="modal-auth-password" />
                    </div>
                    <div class="mb-3 col-sm-6">
                      <label class="form-label" for="modal-auth-confirm-password">Confirm Password</label>
                      <input class="form-control" type="password" autocomplete="on" id="modal-auth-confirm-password" />
                    </div>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="modal-auth-register-checkbox" />
                    <label class="form-label" for="modal-auth-register-checkbox">I accept the <a href="#!">terms </a>and <a href="#!">privacy policy</a></label>
                  </div>
                  <div class="mb-3">
                    <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">Register</button>
                  </div>
                </form>
                <div class="position-relative mt-5">
                  <hr />
                  <div class="divider-content-center">or register with</div>
                </div>
                <div class="row g-2 mt-2">
                  <div class="col-sm-6"><a class="btn btn-outline-google-plus btn-sm d-block w-100" href="#"><span class="fab fa-google-plus-g me-2" data-fa-transform="grow-8"></span> google</a></div>
                  <div class="col-sm-6"><a class="btn btn-outline-facebook btn-sm d-block w-100" href="#"><span class="fab fa-facebook-square me-2" data-fa-transform="grow-8"></span> facebook</a></div>
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

  </body>

</html>