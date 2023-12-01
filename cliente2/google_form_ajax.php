<?php
include("session.php");
//https://clon.campusgesinpol.com/webservice/rest/server.php?wstoken=56eb7a5f0fd1b43c34b2e35bd3a1d752&wsfunction=core_course_get_contents&courseid=172
 function url_pdf($curso,$nombre,$nombre_tema){
        $token = '56eb7a5f0fd1b43c34b2e35bd3a1d752';
        $domainname = 'https://campus.gesinpol.academy';
        
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
        foreach($json_output as $contenidos) {
            //if ($nombre===trim($curso["contents"]["name"])){
            //   $id= $curso["contents"]["fileurl"];
           // }
                   // echo $contenidos ["name"];
           if ($contenidos ["name"]==$nombre_tema) {
            foreach($contenidos["modules"] as $modules) {
                //echo $modules ["name"]."<br>";
                    if ($modules ["name"]==$nombre){
                    foreach($modules["contents"] as $item_modules) {
                            $url=$item_modules ["fileurl"];
                      }
                  }
            }

           }        

        }
        $url= str_replace("webservice/", "", $url);
        //die($url);
        $url= str_replace("?forcedownload=1", "", $url);
        return $url;
        }


// obtener el nombre del tema
$url = $_SESSION['url'].'v1/index.php/gesinpol_curso_page_id';
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
print_r($res["curso_page"]);
echo "</pre>";
//die();
*/
   $cuerpo="";
   $i=1;
   $curso_nombre="";
    $categoria =  array();
    foreach($res['curso_page'] as $cursos) {
           //$curso_enrolado =$cursos ['id'];
           $curso_nombre =$cursos ['name'];   
           $curso_iframe =$cursos ['content']; 
     }

 }else{
  echo $err;
 }
 //die($curso_iframe);
//die( $curso_nombre);
 //$urlpdf=url_pdf($_REQUEST['curso'],$_REQUEST['titulo'],$curso_nombre);
//die($urlpdf);

//$_SESSION['pendiente_tema']=$curso_nombre;
//$_SESSION['pendiente_url']="";     
//var_dump($_SESSION);die();

// ==== guardar los datos de seguimiento del usuario
/* 

    $url = 'https://clon.campusgesinpol.com/course/restapi/v1/index.php/gesinpol_pendientes_nuevos';
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
    
    echo "<pre>";
    print_r($res["curso_page"]);
    echo "</pre>";
    die();
    
   
    }else{
      echo $err;
     }
  */  
// end seguimiento
?>
  <!-- https://cybmeta.com/como-hacer-un-iframe-responsive-->
				<!-- https://www.generacodice.com/es/articolo/419460/Insertar-Google-Docs-visor-de-PDF-en-IFRAME -->
                <div class="embed-container">
                <?php echo $curso_iframe;?>
</div>