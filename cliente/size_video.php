<?php
 function vimeoVideoDuration($video_url) {
  $video_id = (int)substr(parse_url($video_url, PHP_URL_PATH), 1);  
  $json_url = 'http://vimeo.com/api/v2/video/' . $video_id . '.xml';
  $ch = curl_init($json_url);

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  $data = curl_exec($ch);
  curl_close($ch);

  $data = new SimpleXmlElement($data, LIBXML_NOCDATA);

  if (!isset($data->video->duration)) {
      return null;
  }

  $duration = $data->video->duration; // duracion en segundos
  return $duration;
}
function getVimeoVideoDuration($video_url)
    {
        $authorization = '8cf1525c975e96eee13fd34ca592ac2b';
        $curl = curl_init();
        $vimeoId = (int)substr(parse_url($video_url, PHP_URL_PATH), 1);  
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.vimeo.com/videos/{$vimeoId}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer {$authorization}",
                "cache-control: no-cache",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        if (empty($err)) {
            $info = json_decode($response);
            if(isset($info->duration)){
                return (int)$info->duration;
            }
        }
        return false;
    }

//$duraseg=vimeoVideoDuration('https://vimeo.com/115134273');
//echo $duraseg;
//$duraseg=vimeoVideoDuration($url_video);
//echo "duracion ".getVimeoVideoDuration('https://vimeo.com/641441782/d81da8216a');
?>
