<?php
include("session.php");
include_once 'web/fun_varios.php'; 
error_reporting(E_ALL);
/*
$duraseg=vimeoVideoDuration('https://vimeo.com/115134273');
$_SESSION['duracion_seg_videos']=$duraseg;    
    $time = time();
    $_SESSION['inicio_videos']=new DateTime();//fecha inicial;
die();
*/
//https://www.delftstack.com/es/howto/php/php-countdown-timer/
$tiempo=0;
//if $_REQUEST['minutos']=
//$_SESSION['minutos_videos']=$_REQUEST['minutos'];
$contenido_permisos="";
$contenido_bloqueado=0;
//https://clon.campusgesinpol.com/webservice/rest/server.php?wstoken=56eb7a5f0fd1b43c34b2e35bd3a1d752&wsfunction=core_course_get_contents&courseid=172
 
        // ===permisos
        function permisos_contenidos($curso,$nombre){
          $token = 'bba417ad8cf6196775f6aecef0672a56';
          $domainname = 'https://cursos.cuyosoft.me/moodle';
          
          // 2- mostrar las categorias 
          $url = $domainname . '/webservice/rest/server.php'. '?wstoken=' . $token."&wsfunction=core_course_get_contents&moodlewsrestformat=json&courseid=".$curso;
          //die($url);
          $json = file_get_contents($url,0,null,null);
          $json_output =json_decode(utf8_encode($json) ,true);
          // resultado de api crear
          /*
          echo "<pre>";
          var_dump($json_output);
          print_r($json_output);
          echo "</pre>";
          */
          //die();
             
          $url="";  
          foreach($json_output as $contenidos) {
              //if ($nombre===trim($curso["contents"]["name"])){
              //   $id= $curso["contents"]["fileurl"];
             // }
                     // echo $contenidos ["name"];
             //if ($contenidos ["name"]=="CONTENIDOS T1") {
              if ($contenidos ["name"]!="") {
                
              foreach($contenidos["modules"] as $modules) {
                  
                   // echo $modules["availabilityinfo"];
                  

                      if ($modules ["name"]==$nombre){
                       // echo $modules ["name"]."<br>";
                        if (isset($modules["availabilityinfo"])) {
                         //echo  $modules["availabilityinfo"]."<br>";
                         $contenido_bloqueado=1;
                         $contenido_permisos= $modules["availabilityinfo"];
                        }else{$contenido_permisos="";}
                     
                    }
              }
  
             }        
  
          }
          $url= $contenido_permisos;          
          return $url;
          }

//$urlpdf=url_pdf($_REQUEST['curso'],$_REQUEST['titulo']);
//$urlpdf=url_pdf($_REQUEST['curso'],'00. INICIO DEL CURSO');
//$contenido_permisos=permisos_contenidos($_REQUEST['curso'],$_REQUEST['titulo']);
$antes_tema=$_REQUEST['tema'];

// 0 --- si esta completo no deben realizarse los pasosos siguientes
$url = $_SESSION['url'].'v1/index.php/gesinpol_empleado_progreso_modulo';
$parametros="empleado=".$_SESSION['idmoodle']."&curso=".$_REQUEST['curso']."&tema=".$_REQUEST['tema']."&modulo=".$_REQUEST['video'];

$res_completado = resulrow($url, $parametros);
$Yacompletado="0";
  $anterior="";
        foreach($res_completado['completado'] as $quiz) {               
               $Yacompletado=$quiz['completionstate'];      
                }
//die($Yacompletado);
if ($Yacompletado==0){
// 1----- DETERMINO EL ANTERIOR AL MODULO
$url = $_SESSION['url'].'v1/index.php/insco_item_modulo';
//var_dump($urlexternos);
$header = [
  'Accept: application/json',
  'Content-Type: application/x-www-form-urlencoded',
  'Authorization: 3d524a53c110e4c22463b10ed32cef9d',
]; 
$parametros="course=".$_REQUEST['curso']."&tema=".$_REQUEST['tema'];
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
/* 
echo "<pre>";
print_r($res["items_visible"]);
echo "</pre>";
//die();
*/
$antes="";
  $anterior="";
        foreach($res['items_visible'] as $quiz) {                  
                if (trim($_REQUEST['video'])==$quiz['instance']) {
                    $antes=$anterior;
                }  
                $anterior=$quiz['instance'];     
                //echo  $anterior."<br/>";
                }
}else{
  echo $err;
 }
 //echo "modulo anterior" .$antes;
 //die();
 // buscar tema anterior el ultimo
 if ($antes==""){
  // tema anterior
  $url = $_SESSION['url'].'v1/index.php/gesinpol_temas_curso_usuario';
  $parametros="curso=".$_REQUEST['curso'];
  $res_temas = resulrow($url, $parametros);
  $antes_tema="";
  foreach ($res_temas["temas"] as $value) {
    if (trim($_REQUEST['tema'])==$value['id']) {
      $antes_tema=$anterior;
   }  
  $anterior=$value['id'];  
  }
  // ultimo modulo del tema anterior
  if ($antes_tema!=""){    
    $url = $_SESSION['url'].'v1/index.php/insco_item_modulo';
    $parametros="course=".$_REQUEST['curso']."&tema=".$antes_tema;
    $res_modulo = resulrow($url, $parametros);
    $antes_modulo="";
    foreach ($res_modulo["items_visible"] as $value) {     
      $antes_modulo=$value['instance'];  
    }
  }
  //echo "ultimo modulo " .$antes_modulo;
  $antes=$antes_modulo;
 }
 //die($antes_modulo);
 //2 ------ VERIFICO QUE EL ANTERIOR ESTE COMPLETADO
 $url = $_SESSION['url'].'v1/index.php/gesinpol_empleado_progreso_modulo';
//var_dump($urlexternos);
$header = [
  'Accept: application/json',
  'Content-Type: application/x-www-form-urlencoded',
  'Authorization: 3d524a53c110e4c22463b10ed32cef9d',
]; 
$parametros="empleado=".$_SESSION['idmoodle']."&curso=".$_REQUEST['curso']."&tema=".$antes_tema."&modulo=".$antes;
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
/* 
echo "<pre>";
print_r($res["completado"]);
echo "</pre>";
//die();
*/
$anteriorcompletado="";
  $anterior="";
        foreach($res['completado'] as $quiz) {                  
               
                $anteriorcompletado=$quiz['completionstate'];     
                
                }
}else{
  echo $err;
 }
 //die ("completado".$anteriorcompletado);
} // end de Yacompletado cuando es ==0
if ($Yacompletado==1){$anteriorcompletado=1;}

 // 3------- esta completado el anterior permito visualizar
if ($anteriorcompletado=="1"){
  //$urlpdf=url_pdf($_REQUEST['curso'],$_REQUEST['titulo']);

//die($urlpdf);
/*
https://vimeo.com/log_in
jalvaromeca@gmail.com
elisabeth2
*/
$url = $_SESSION['url'].'v1/index.php/gesinpol_curso_videotimex1';
//var_dump($urlexternos);
$header = [
  'Accept: application/json',
  'Content-Type: application/x-www-form-urlencoded',
  'Authorization: 3d524a53c110e4c22463b10ed32cef9d',
]; 
$parametros="course=".$_REQUEST['curso']."&id=".$_REQUEST['video'];
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
 /* 
echo "<pre>";
print_r($res["curso_page"]);
echo "</pre>";
die();
*/
        foreach($res['curso_page'] as $quiz) {
                $url_video=$quiz['vimeo_url'];      
                $curso_nombre =trim($quiz['name']);      
                }
}else{
  echo $err;
 }
      //echo $url_video.'<br/>';
      //$url_video= str_replace('vimeo.com/', "player.vimeo.com/video/", $url_video);
      // die($url_video);
      // https://player.vimeo.com/video/641441749?h=a5c01b1513
       //$url_video= str_replace('<p><a href="', "", $url_video);
       // $url_video= str_replace('">', "#", $url_video);
        
        //echo "1-".$url_video;
        $url_video_original=$url_video;
        $url_video= str_replace('vimeo.com/', "player.vimeo.com/video/", $url_video);
        $url_item = explode("#", $url_video);
        $url_video= $url_item[0]; // porción1
        $url_item = explode("/", $url_video);
        $parte1= $url_item[3]; // porción1
        $parte2= $url_item[4]; // porción1
        $parte3= $url_item[5]; // porción1
        $url_video="https://player.vimeo.com/".$parte1."/".$parte2."?h=".$parte3;
        //echo "2-".$url_video;
       // $url_video="https://vimeo.com/".$parte1."/".$parte2."?h=".$parte3;
        
   //https://vimeo.com/841297873/6841f94ee2?share=copy     
 /// correcto       
// https://player.vimeo.com/video/462562336        
// original
// https://vimeo.com/607269505/4ce3e70525
//creado
//https://player.vimeo.com/video/607269505

//$url_video="https://player.vimeo.com/video/607269505";
//https://vimeo.com/607269505/4ce3e70525    
//die($url_video); 
//https://player.vimeo.com/video/462562336
//https://vimeo.com/462562336/258a3523a4
//$url_video="https://player.vimeo.com/video/462562336";
$_SESSION['pendiente_tema']=$curso_nombre;
//$_SESSION['pendiente_url']="";     
//var_dump($_SESSION);die();

// ==== guardar los datos de seguimiento del usuario
// 

    $url = $_SESSION['url'].'v1/index.php/gesinpol_pendientes_nuevos';
    //var_dump($urlexternos);
    $header = [
      'Accept: application/json',
      'Content-Type: application/x-www-form-urlencoded',
      'Authorization: 3d524a53c110e4c22463b10ed32cef9d',
    ]; 
    $parametros="user=".$_SESSION['idmoodle']."&categoriaid=".$_SESSION['pendiente_categoria']."&cursoid=".$_REQUEST['curso']."&curso=".$_SESSION['pendiente_curso']."&modulo=".$_SESSION['pendiente_modulo']."&temario=".$_SESSION['pendiente_tema'];
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
    /*   
    echo "<pre>";
    print_r($res["curso_page"]);
    echo "</pre>";
    die();
    */
   
    }else{
      echo $err;
     }
  //$url_video="https://player.vimeo.com/video/641441749?h=a5c01b1513";
// end seguimiento
//die($url_video);
    }
    include("size_video.php");
    $_SESSION['tipo_contenido']="video";
    $_SESSION['duracion_seg_videos']=getVimeoVideoDuration($url_video_original);    
    $time = time();
    $_SESSION['inicio_videos']=new DateTime();//fecha inicial;
    
   // var_dump($_SESSION);
   // die();
?>
<?php if ($anteriorcompletado==""){ ?>

<div class="alert alert-success" role="alert">
  <h4 class="alert-heading fw-semi-bold">No Disponible</h4>  
  <hr />
  <p class="mb-0">No disponible hasta que la actividad anterior sea marcada como realizada.</p>
</div>

<?php exit();}else {?>

          <!-- comienza-->
          <div style="padding:56.25% 0 0 0;position:relative;"><iframe src="<?php echo $url_video; ?>&amp;badge=0&amp;autopause=0&amp;player_id=0&amp" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="position:absolute;top:0;left:0;width:100%;height:100%;" title="I vuelta. T1 (17-09-2021)"></iframe>
      </div><script src="https://player.vimeo.com/api/player.js"></script>
    </div>
          <!--end-->        
<?php }?>         
