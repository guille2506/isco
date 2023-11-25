<?php
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
?>