<?php
include("session.php");
include_once 'web/fun_varios.php'; 
$contenido_permisos="";
$contenido_bloqueado=0;
$_SESSION['tipo_contenido']="pdf";
//https://clon.campusgesinpol.com/webservice/rest/server.php?wstoken=56eb7a5f0fd1b43c34b2e35bd3a1d752&wsfunction=core_course_get_contents&courseid=172
 function url_pdf($curso,$nombre){
        $token = 'bba417ad8cf6196775f6aecef0672a56';
        $token = '417c5c06676817a52f84f26198003f03'; // creado 13/09/2023
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
        die();
         */  
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
                      }
                    foreach($modules["contents"] as $item_modules) {                     
                            $url=$item_modules ["fileurl"];
                      }
                  }
            }

           }        

        }
        $url= str_replace("webservice/", "", $url);
        $url= str_replace("?forcedownload=1", "", $url);
        return $url;
        }
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

// 0 --- si esta completo no deben realizarse los pasosos siguientes
$url = $_SESSION['url'].'v1/index.php/gesinpol_empleado_progreso_modulo';
$parametros="empleado=".$_SESSION['idmoodle']."&curso=".$_REQUEST['curso']."&tema=".$_REQUEST['tema']."&modulo=".$_REQUEST['id'];

$res_completado = resulrow($url, $parametros);
$Yacompletado="0";
  $anterior="";
        foreach($res_completado['completado'] as $quiz) {               
               $Yacompletado=$quiz['completionstate'];      
                }
//die($Yacompletado);
if ($Yacompletado==0){
$antes_tema=$_REQUEST['tema'];
$antes_modulo=$_REQUEST['id'];
// 1----- DETERMINO EL ANTERIOR AL MODULO
$url = $_SESSION['url'].'v1/index.php/insco_item_modulo';
$parametros="course=".$_REQUEST['curso']."&tema=".$_REQUEST['tema'];
$res_items_visible = resulrow($url, $parametros);
$antes="";
  $anterior="";
        foreach($res_items_visible['items_visible'] as $quiz) {                  
                if (trim($_REQUEST['id'])==$quiz['instance']) {
                    $antes=$anterior;
                }  
                $anterior=$quiz['instance'];     
                //echo  $anterior;
          }

 echo "modulo anterior" .$antes;
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
  echo "ultimo modulo " .$antes_modulo;
  $antes=$antes_modulo;
 }
 //die($antes_modulo);

 //2 ------ VERIFICO QUE EL ANTERIOR ESTE COMPLETADO
 $url = $_SESSION['url'].'v1/index.php/gesinpol_empleado_progreso_modulo';
 $parametros="empleado=".$_SESSION['idmoodle']."&curso=".$_REQUEST['curso']."&tema=".$antes_tema."&modulo=".$antes;
 $res_completado = resulrow($url, $parametros);
 $anteriorcompletado="";
  $anterior="";
        foreach($res_completado['completado'] as $quiz) {                  
               
                $anteriorcompletado=$quiz['completionstate'];     
                
                }


 //die ("completado".$anteriorcompletado);

 // 3------- esta completado el anterior permito visualizar
//$contenido_permisos=permisos_contenidos($_REQUEST['curso'],$_REQUEST['titulo']);
//if ($contenido_permisos==""){
  if ($anteriorcompletado=="1"){
      $urlpdf1=url_pdf($_REQUEST['curso'],$_REQUEST['titulo']);
}

//die($urlpdf);
$url = $_SESSION['url'].'v1/index.php/gesinpol_curso_urlx1';
//var_dump($urlexternos);
$header = [
  'Accept: application/json',
  'Content-Type: application/x-www-form-urlencoded',
  'Authorization: 3d524a53c110e4c22463b10ed32cef9d',
]; 
$parametros="course=".$_REQUEST['curso']."&id=".$_REQUEST['id'];
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
print_r($res["curso_url"]);
echo "</pre>";
die();
*/
   $cuerpo="";
   $i=1;
   $curso_nombre="";
   foreach($res['curso_url'] as $quiz) {
    $urlpdf=$quiz['externalurl'];
    $curso_nombre=trim($quiz['name']);
    }
   
 }else{
  echo $err;
 }


//die($urlpdf);
?>

          <!-- comienza-->
          <style>
    .embed-container {
    position: relative;
    padding-bottom: 56.25%;
    height: 0;
    overflow: hidden;
}
.16by9 {
    padding-bottom: 56.25%;
}
.4by3 {
    padding-bottom: 75%;
}
.embed-container iframe {
    position: absolute;
    top:0;
    left: 0;
    width: 100%;
    height: 100%;
}
    </style>
    
<?php 
   } // end de Yacompletado cuando es ==0
   if ($Yacompletado==1){$anteriorcompletado=1;
        if ($anteriorcompletado=="1"){
          $urlpdf1=url_pdf($_REQUEST['curso'],$_REQUEST['titulo']);
        }
    }
   //echo $anteriorcompletado.$urlpdf1; 
     if ($anteriorcompletado==""){ ?>

<div class="alert alert-success" role="alert">
  <h4 class="alert-heading fw-semi-bold">No Disponible</h4>  
  <hr />
  <p class="mb-0">No disponible hasta que la actividad anterior sea marcada como realizada.</p>
</div>

<?php exit();}else {?>

  <!-- https://cybmeta.com/como-hacer-un-iframe-responsive-->
				<!-- https://www.generacodice.com/es/articolo/419460/Insertar-Google-Docs-visor-de-PDF-en-IFRAME -->
                <div class="embed-container">
                <iframe src="<?php echo $urlpdf1;?>" style="width:100%; height:400px" frameborder="0"></iframe>
</div>
            </div>
          <!--end-->
 <?php }?>        