<?php 
include("session.php");
include_once 'web/fun_varios.php'; 
// videos
if ($_SESSION['tipo_contenido']=="video"){
$_SESSION['fin_videos']=new DateTime();//fecha de cierre;
$intervalo = $_SESSION['inicio_videos']->diff($_SESSION['fin_videos']);
$mensaje_tiempo=' Tiempo de ejecución: '.$intervalo->format('%i minutos %s segundos');

$totalminuto= $intervalo->format('%i')* 60  + $intervalo->format('%s');

//die("total=".$totalminuto);
if ($totalminuto >=$_SESSION['duracion_seg_videos']){
 $url = $_SESSION['url'].'v1/index.php/gesinpol_empleado_progreso_modulox1';
 $parametros="empleado=".$_SESSION['id'] ."&idm=".$_REQUEST['modulo'] ;
 $res_completo = resulrow($url, $parametros);
 $completado=0;
 /*
 foreach ($res_completo["Modulocompletado"] as $value) {
   $completado = $value['id'];  
 }       
 */         
//echo "completado";
//header("location:'".$_SESSION['url_app']. "'");//local
?>
<script>alert("Marcado como Hecho");</script>
        <script>
        window.location = "<?php echo $_SESSION['url_app'];?>";
        </script>
<?php }else{?>        
  <script>alert("Debe completar el tiempo de reproduccion.<?php echo $mensaje_tiempo;?>");</script>
  <?php }
  }

  // ==== pdf
if ($_SESSION['tipo_contenido']=="pdf"){
  $url = $_SESSION['url'].'v1/index.php/gesinpol_empleado_progreso_modulox1';
  $parametros="empleado=".$_SESSION['id'] ."&idm=".$_REQUEST['modulo'] ;
  $res_completo = resulrow($url, $parametros);
  $completado=0;
  /*
  foreach ($res_completo["Modulocompletado"] as $value) {
    $completado = $value['id'];  
  }       
  */         
 //echo "completado";
 //header("location:'".$_SESSION['url_app']. "'");//local
 ?>
 <script>alert("Marcado como Hecho");</script>
         <script>
         window.location = "<?php echo $_SESSION['url_app'];?>";
         </script>
<?php } ?>