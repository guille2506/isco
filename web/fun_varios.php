<?PHP
//FUNCIONES PARA MOSTRAR
//error_reporting(0);
set_time_limit(36000);
function getRealIP() 
{
	if (!empty($_SERVER['HTTP_CLIENT_IP'])){return $_SERVER['HTTP_CLIENT_IP'];}
	if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){return $_SERVER['HTTP_X_FORWARDED_FOR'];}
	return $_SERVER['REMOTE_ADDR'];
}
function getTipoUS($pf,$rol,$iduser,$categ) 
{
	$sql = "SELECT COUNT(DISTINCT tra.userid) AS total
			FROM ".$pf."course AS c, "
				  .$pf."course_categories AS cats, "
				  .$pf."context AS ctx, "
				  .$pf."role_assignments AS tra
			WHERE c.category = cats.id AND 
				  c.id = ctx.instanceid AND 
				  tra.contextid = ctx.id AND 
				  tra.roleid = ".$rol." AND 
				  tra.userid = ".$iduser;
	$sql .= ($categ != 0) ? " AND (cats.path LIKE '%/" . $categ . "/%' OR cats.path LIKE '%/" . $categ . "') " : "";
	$sql .= " LIMIT 1";
	return $sql;
}

function getCourseID($pf,$rol,$iduser) 
{
	if($rol==1){ 
	$query="SELECT id FROM ".$pf."course ORDER BY id ASC LIMIT 1"; }
	elseif($rol<5){
	$query = "SELECT c.id
			FROM ".$pf."course AS c, "
				  .$pf."course_categories AS cats, "
				  .$pf."context AS ctx, "
				  .$pf."role_assignments AS tra
			WHERE c.category = cats.id AND 
				  c.id = ctx.instanceid AND 
				  tra.contextid = ctx.id AND 
				  tra.roleid = ".$rol." AND 
				  tra.userid = ".$iduser." 
			LIMIT 1"			;
	}
	return $query;
}
function getCourseEst($pf,$rol,$iduser) 
{
	if($rol==1){ 
	$query="SELECT id FROM ".$pf."course ORDER BY id ASC LIMIT 1"; }
	elseif($rol>1){
	$query = "SELECT c.id
			FROM ".$pf."course AS c, "
				  .$pf."course_categories AS cats, "
				  .$pf."context AS ctx, "
				  .$pf."role_assignments AS tra
			WHERE c.category = cats.id AND 
				  c.id = ctx.instanceid AND 
				  tra.contextid = ctx.id AND 
				  tra.roleid = ".$rol." AND 
				  tra.userid = ".$iduser." 
			LIMIT 1"			;
	}
	return $query;
}


function nropreg($id) 
{
		//require "web/conexion.php";
		$tabla=$CFG->prefix."quiz_fixed_categories";
		$campos="*";
		$condicion="WHERE quizfixedid='$id'";
		$orden="quizfixedid,questionscategoriesid";
		$query="SELECT $campos FROM $tabla $condicion ORDER BY $orden ASC";
		$soli1=mysqli_query($conexion, $query);
		$t=0;$j=0;$f=1;$hc=0;
		$qtypevf="truefalse";$qtypemc="multichoice";
		while($tupla1= mysqli_fetch_array($soli1))
		{
		  $qcid=$tupla1[questionscategoriesid];
		  $tabla2=$CFG->prefix."question";
		  $campo="category";
		  //$condic="WHERE category='$tupla1[questionscategoriesid]' AND questiontextformat='$f'  AND (qtype='$qtypemc' OR qtype='$qtypevf')";
		  $condic="WHERE category='$tupla1[questionscategoriesid]' AND hiddenc='$hc' AND hidden='$hc'  AND (qtype='$qtypemc' OR qtype='$qtypevf')";
		  $sql="SELECT COUNT($campo) AS total FROM $tabla2 $condic";
		  $result = mysqli_query($conexion,$sql); 
		  if ($fil = mysqli_fetch_assoc($result)) {$t = $fil["total"];}else {$t=0;}
		  //echo " t ".$t." - ".$tupla1[questionrandom]."<br /> ";
		  if ($t>0 && $t>$tupla1[questionrandom]){$j=$j+$tupla1[questionrandom];}
		  elseif ($t>0 && $t<$tupla1[questionrandom]){$j=$j+$t;}
		  //echo " j ".$j." <br /> ";
		}
		//mysqli_close($conexion); 
		return $j;
}

function resulrow($url, $parametros)
{
	//$url = $uri.'v2/index.php/gesinpol_quiz_fixed';
	$header = [
	  'Accept: application/json',
	  'Content-Type: application/x-www-form-urlencoded',
	  'Authorization: 3d524a53c110e4c22463b10ed32cef9d',
	]; 
	//$parametros="curso=".$curso_enrolado."&quiz=".$quizid."&name=".$name."&userid=".$userid;
	//echo $parametros; //die();
	//$parametros="courseid=132";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_POST, 1);
	//curl_setopt($ch, CURLOPT_POSTFIELDS,'user=admin01&pass=123456');
	curl_setopt($ch, CURLOPT_POSTFIELDS, $parametros);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	// pass header variable in curl method
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_HEADER, false);
	
	$result = curl_exec($ch);
	$resrow = json_decode($result, true);
	$errorr	= curl_error($ch);
	curl_close($ch);
	if (!$errorr){
		return $resrow;
	 }else{
	 	return $errorr;
	 }
}
function convmin($tiempo_en_segundos) {
    $minutos=number_format($tiempo_en_segundos/60,0);
	$segundos= $tiempo_en_segundos % 60;
	$dur = "$minutos minuto(s) $segundos segundo(s)";
    return $dur;
}
function convhoras($tiempo_en_segundos) {
    $horas = floor($tiempo_en_segundos / 3600);
    $minutos = floor(($tiempo_en_segundos - ($horas * 3600)) / 60);
    $segundos = $tiempo_en_segundos - ($horas * 3600) - ($minutos * 60);
	$dur = "$horas $hora(s) $minutos minuto(s) $segundos segundo(s)";
    return $dur;
}
function segundostocadena($segs) {
    $cadena = '';
	if($segs >= 86400) {
	$dias = floor($segs/86400);
	$segs = $segs%86400;
	$cadena = $dias.' d&iacute;a';
	if($dias != 1) $cadena .= 's';
	if($segs >= 0) $cadena .= ', ';
	}
	if($segs>=3600){
	$horas = floor($segs/3600);
	$segs = $segs%3600;
	$cadena .= $horas.' hora';
	if($horas != 1) $cadena .= 's';
	if($segs >= 0) $cadena .= ', ';
	}
	if($segs>=60){
	$minutes = floor($segs/60);
	$segs = $segs%60;
	$cadena .= $minutes.' minuto';
	if($minutes != 1) $cadena .= 's';
	if($segs >= 0) $cadena .= ', ';
	}
	$cadena .= $segs.' segundo';
	if($segs != 1) $cadena .= 's';
	return $cadena;
/*	$dur = "$horas $hora(s) $minutos minuto(s) $segundos segundo(s)";
    return $dur;*/
}
function num_meses($fecha1, $fecha2)
{
	$Date2=strtotime($fecha2);
	$fecha2=date('Y-m-d', strtotime("next day", $Date2));
	
	$fechainicial = new DateTime($fecha1);
	$fechafinal = new DateTime($fecha2);
	$diferencia = $fechainicial->diff($fechafinal);
	$meses = ( $diferencia->y * 12 ) + $diferencia->m;
	return $meses;
}
function edad($fecha1, $fecha2)
{
	/*ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha1, $mifecha1); 
	ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha2, $mifecha2); */
	$mifecha1=explode("-",$fecha1);
	$mifecha2=explode("-",$fecha2);
	
    $n_edad=$mifecha1[0]-$mifecha2[0];
	if($mifecha1[1]<$mifecha2[1])
	{
		$n_edad--;
	}
	if($mifecha1[1]==$mifecha2[1])
	{
		if($mifecha1[2]<$mifecha2[2])
		{
			$n_edad--;
		}
	}
	return $n_edad;
}
function dias_ingreso($fecha1, $fecha2, $fecha3)
{
	$dias_ingreso=((strtotime($fecha1)-strtotime($fecha2))/86400);
	$dias_ingreso++;
	if(strtotime($fecha2)<strtotime($fecha1))
	{
		if(strtotime($fecha3)>strtotime($fecha2))
		{
			return -1;
		}
		else
		{
			$timestamp = strtotime( $fecha1 );
			$diasdelmes = date( "t", $timestamp );
			if($diasdelmes<30)
			{
				$dias_ingreso+=(30-$diasdelmes);
			}
			return $dias_ingreso;
		}
	}
	else
	{
		return -2;
	}
}

function edad_meses($fecha1, $fecha2)
{
	/*ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha1, $mifecha1); 
	ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha2, $mifecha2); */
	$mifecha1=explode("-",$fecha1);
	$mifecha2=explode("-",$fecha2);
	
    $n_edad=$mifecha1[0]-$mifecha2[0];
	if($mifecha1[1]<$mifecha2[1])
	{
		$n_edad--;
	}
	if($mifecha1[1]==$mifecha2[1])
	{
		if($mifecha1[2]<$mifecha2[2])
		{
			$n_edad--;
		}
	}
	if($n_edad<=0)
	{
		$meses=$mifecha1[1]-$mifecha2[1];
		if($meses<0)
		{
			$meses+=12;
		}
		if($meses==0)
		{
			$dias=30-$mifecha2[2]+1;
			if($n_edad<0)
			{
				return -2;
			}
			else
			{
				return $dias;
			}
		}
		else
		{
			return -1;
		}		
	}
	else
	{
		return -1;
	}
}
function getRealIP_libre() 
{
	if (!empty($_SERVER['HTTP_CLIENT_IP'])){return $_SERVER['HTTP_CLIENT_IP'];}
	if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){return $_SERVER['HTTP_X_FORWARDED_FOR'];}
	return $_SERVER['REMOTE_ADDR'];
}
/*function incluir_historial_libre($valores)
{
	require "conexion.php";
	$ip=getRealIP_libre();
	date_default_timezone_set('America/Caracas');
	$fecha=date("Y-m-d H:i:s");
	$query="INSERT INTO saga_historial (id_usu, acc_usu, mod_usu, deta_accion, deta_usu, fec_usu, ip_usu) VALUES ($valores, '$fecha', '$ip')";
	mysqli_query($conexion, $query); 
	mysqli_close($conexion); 
}*/
function mostrarfoto($PAGE,$USER)
{
	//echo "La ruta de la imagen es: 1";
        if (is_null($renderer)) {
            $renderer = $PAGE->get_renderer('core');
        }
			//echo "<br /><br />".$renderer."<br /><br />";
	   if ($USER->picture > 0) {
            if (!empty($USER->contextid)) {
                $contextid = $USER->contextid;
            } else {
                $context = context_user::instance($USER->id, IGNORE_MISSING);
                if (!$context) {
                     //This must be an incorrectly deleted user, all other users have context.
                    //return $defaulturl;
					echo $defaulturl;
                }
                $contextid = $context->id;
            }

            $path = '/';
            if (clean_param($PAGE->theme->name, PARAM_THEME) == $PAGE->theme->name) {
                /* We append the theme name to the file path if we have it so that
                 in the circumstance that the profile picture is not available
                 when the user actually requests it they still get the profile
                 picture for the correct theme.*/
                $path .= $PAGE->theme->name.'/';
            }
            // Set the image URL to the URL for the uploaded file and return.
			//echo "contextid ".$contextid;
			$filename='f2';
			$url = moodle_url::make_pluginfile_url($contextid, 'user', 'icon', NULL, $path, $filename);
            $url->param('rev', $USER->picture);
			//echo "La ruta de la imagen es: $url";
            //echo '<span style="color:#0000ff;">$url</span>';
			$foto='<img src="'.$url.'" title="Imagen de '.$USER->firstname." ".$USER->lastname.'" class="userpicture" width="100" height="100" />';
			
        }else{
					$foto='<img src="img/avatar_person.gif" title="Imagen de '.$USER->firstname." ".$USER->lastname.'" class="userpicture" width="100" height="100"/>';}
	 return $foto;
}
function mostrar_paginas($tabla, $campos, $condicion, $orden, $limite)
{
	//require "conexion.php"; 
	$query="SELECT $campos FROM $tabla $condicion ORDER BY $orden ASC $limite";
	return $query;
	//mysqli_close($conexion); 
}
function mostrar_paginas_inver($tabla, $campos, $condicion, $orden, $limite)
{
	//require "conexion.php"; 
	$query="SELECT $campos FROM $tabla $condicion ORDER BY $orden DESC $limite";
	return $query;
	//mysqli_close($conexion); 
}
function mostrar($tabla, $campos, $condicion, $orden)
{
	//require "conexion.php"; 
	$query="SELECT $campos FROM $tabla $condicion ORDER BY $orden ASC";
	return $query;
	//mysqli_close($conexion); 
}
/*function mostrar_semanas($tabla, $campo1, $campo2, $condicion)
{
	require "conexion.php"; 
	$query="SELECT yearweek($campo2) - yearweek($campo1) as semanas FROM $tabla $condicion";
	return mysqli_query($conexion, $query);
	mysqli_close($conexion); 
}*/

function mostrar_inver($tabla, $campos, $condicion, $orden)
{
	//require "conexion.php"; 
	$query="SELECT $campos FROM $tabla $condicion ORDER BY $orden DESC";
	return $query;
	//return mysqli_query($conexion, $query);
	//mysqli_close($conexion); 
}
function mostrar_ultimo($tabla, $campos, $condicion, $orden)
{
	//require "conexion.php"; 
	$query="SELECT $campos FROM $tabla $condicion ORDER BY $orden DESC LIMIT 1";
	return $query;
	//return mysqli_query($conexion, $query);
	//mysqli_close($conexion); 
}
function cambiaf_a_mysql($fecha){ 
    /*ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $fecha, $mifecha); */
	$mifecha=explode("/",$fecha);
    $lafecha=$mifecha[2]."-".$mifecha[1]."-".$mifecha[0]; 
    return $lafecha; }
	
function cambiaf_noticias($fecha){ 
    $meses=array('Ene.', 'Feb.', 'Mar.', 'Abr.', 'May.', 'Jun.', 'Jul.', 'Ago.', 'Sept.', 'Oct.', 'Nov.', 'Dic.');
	/*ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha); */
	$mifecha=explode("-",$fecha);
    for($i=0; $i<12; ++$i)
	{
		if($mifecha[1]==$i+1)
		{
			echo"&nbsp;<font color='#FFFFFF'><b>$meses[$i]</b></font><br>&nbsp;&nbsp;&nbsp;$mifecha[2]";	
		}
	}
}
function cambiaf_agenda($fecha){ 
    $meses=array('Ene.', 'Feb.', 'Mar.', 'Abr.', 'May.', 'Jun.', 'Jul.', 'Ago.', 'Sept.', 'Oct.', 'Nov.', 'Dic.');
	/*ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha); */
	$mifecha=explode("-",$fecha);
    for($i=0; $i<12; ++$i)
	{
		if($mifecha[1]==$i+1)
		{
			echo"$mifecha[2] <b>$meses[$i]</b> ";	
		}
	}
}

function cambiaf_a_normal_punto($fecha){ 
    /*ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha); */
	$mifecha=explode("-",$fecha);
    $lafecha=$mifecha[2].".".$mifecha[1].".".$mifecha[0]; 
    return $lafecha; }

function ver_mi_mes($fecha){ 
    /*ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha); */
	$mifecha=explode("-",$fecha);
    $mes_fn = array('VACIO', 'ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE');
	for($verm=1; $verm<13; $verm++)
	{
		if($mifecha[1]==$verm)
		{
			$lafecha="$mes_fn[$verm] $mifecha[0]";
		}
	}
	return $lafecha;
}


function cambiaf_a_normal($fecha){ 
    /*ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha); */
	$mifecha=explode("-",$fecha);
    $lafecha=$mifecha[2]."/".$mifecha[1]."/".$mifecha[0]; 
    return $lafecha; }
function cambiah_a_normal($hora){ 
    /*ereg( "([0-9]{2,4}):([0-9]{1,2}):([0-9]{1,2})", $hora, $mihora); */
	$mihora=explode(":",$hora);
    $turno="AM";
	$hora_real=$mihora[0];
	if($mihora[0]>12)
	{
		$hora_real-=12;
		$turno="PM";
		if($hora_real<10){$hora_real="0$hora_real";}
	}	
	$lahora=$hora_real.":".$mihora[1]." ".$turno; 
    return $lahora; }
function convertir_fecha($fecha_datetime){
	//Esta función convierte la fecha del formato DATETIME de SQL a formato DD-MM-YYYY HH:mm:ss
	$fecha = explode("-",$fecha_datetime);
	$hora = explode(":",$fecha[2]);
	$fecha_hora = explode(" ",$hora[0]);

	$fecha_convertida = $fecha_hora[0].'/'.$fecha[1].'/'.$fecha[0].' '.$fecha_hora[1].':'.$hora[1].':'.$hora[2];
	return $fecha_convertida;
}
function valida_correo($mail)
{
	if(strpos($mail, "@") == false || strpos($mail, ".") == false)
	{
		return 0;
	}
	else
	{
		return 1;
	}
}

function bloquear_boton()
{
	echo"<script>
	function deshabilita(form)
	{
	if (form.activar.checked)
	{
	form.Validar.disabled = false; 
	}
	else 
	{
	form.Validar.disabled = true; 
	}
	}
	
	  function anularBotonDerecho() {
	  if (event.button==2) {
	 alert('Boton derecho deshabilitado');
	}
	}
	document.onmousedown=anularBotonDerecho; 
	</script>
	<script type='text/javascript' language='Javascript'>
	document.oncontextmenu = function(){return false}
	</script>";
}
function tipos_usuarios($nivel_usu){ 
     $tipos=array('vacio', 'Administrador', 'Operador', 'Periodista');
	for($i=1; $i<4; ++$i)
	{
		if($nivel_usu==$i)
		{
			echo"$tipos[$i]";	
		}
	}
}
function tipos_perfiles($tipo_perf){ 
     $tipos=array('vacio', 'Correo Secundario', 'P&aacute;gina Web', 'Direcci&oacute;n de Blog', 'Cuenta de Twitter', 'Cuenta de Red Social', 'Canal en Videos', 'Otras Cuentas');
	for($i=1; $i<8; ++$i)
	{
		if($tipo_perf==$i)
		{
			echo"$tipos[$i]";	
		}
	}
}
function dibujar_fecha($fecha_nac, $clave_fun)
{
	$ano = substr($fecha_nac, 0, 4);
	$mes = substr($fecha_nac, 5, 2); //2008-10-01
	$dia = substr($fecha_nac, 8, 2);
	for($i=0; $i<31; ++$i)
	{
		$dia_fn[$i]=$i+1;	
	}
	$mes_fn = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
	$n=0;
	if($clave_fun==1)
	{
		$anio0=$ano;
		$anio1=$ano+11;
	}
	if($clave_fun==2)
	{
		$anio0=$ano-10;
		$anio1=$ano+11;
	}
	if($clave_fun==3)
	{
		$anio0=1900;
		$anio1=$ano+2;
	}
	if($clave_fun==4)
	{
		$anio0=1912;
		$anio1=$ano+1;
	}
	if($clave_fun==5)
	{
		$anio0=1900;
		$anio1=$ano+30;
	}
	for($i=$anio0; $i<$anio1; ++$i)
	{
		$anio_fn[$n]=$i;
		$n++;	
	}
	echo"<select name='dia_fn' id='dia_fn' class='text_formulario'>";
	for($i=0; $i<31; ++$i)
	{
		if($dia_fn[$i]==$dia)
		{
			$seleted="selected";
		}
		else
		{
			$seleted="";
		}
		echo"<option value='$dia_fn[$i]' $seleted>$dia_fn[$i]</option>";
	}
	echo"</select> - ";
	echo"<select name='mes_fn' id='mes_fn' class='text_formulario'>";
	for($i=0; $i<12; ++$i)
	{
		if($i+1==$mes)
		{
			$seleted="selected";
		}
		else
		{
			$seleted="";
		}
		$mes_real=$i+1;
		echo"<option value='$mes_real' $seleted>$mes_fn[$i]</option>";
	}
	echo"</select> - ";
	echo"<select name='anio_fn' id='anio_fn' class='text_formulario'>";
	for($i=0; $i<$n; ++$i)
	{
		if($anio_fn[$i]==$ano)
		{
			$seleted="selected";
		}
		else
		{
			$seleted="";
		}
		echo"<option value='$anio_fn[$i]' $seleted>$anio_fn[$i]</option>";
	}
	echo"</select>";
}
function dibujar_fechai($fecha_nac, $clave_fun)
{
	$ano = substr($fecha_nac, 0, 4);
	$mes = substr($fecha_nac, 5, 2); //2008-10-01
	$dia = substr($fecha_nac, 8, 2);
	for($i=0; $i<31; ++$i)
	{
		$dia_fn[$i]=$i+1;	
	}
	$mes_fn = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
	$n=0;
	if($clave_fun==1)
	{
		$anio0=$ano;
		$anio1=$ano+11;
	}
	if($clave_fun==2)
	{
		$anio0=$ano-10;
		$anio1=$ano+11;
	}
	if($clave_fun==3)
	{
		$anio0=1900;
		$anio1=$ano+2;
	}
	if($clave_fun==4)
	{
		$anio0=1912;
		$anio1=$ano+1;
	}
	for($i=$anio0; $i<$anio1; ++$i)
	{
		$anio_fn[$n]=$i;
		$n++;	
	}
	echo"<select name='dia_fi' id='dia_fi' class='text_formulario'>";
	for($i=0; $i<31; ++$i)
	{
		if($dia_fn[$i]==$dia)
		{
			$seleted="selected";
		}
		else
		{
			$seleted="";
		}
		echo"<option value='$dia_fn[$i]' $seleted>$dia_fn[$i]</option>";
	}
	echo"</select> - ";
	echo"<select name='mes_fi' id='mes_fi' class='text_formulario'>";
	for($i=0; $i<12; ++$i)
	{
		if($i+1==$mes)
		{
			$seleted="selected";
		}
		else
		{
			$seleted="";
		}
		$mes_real=$i+1;
		echo"<option value='$mes_real' $seleted>$mes_fn[$i]</option>";
	}
	echo"</select> - ";
	echo"<select name='anio_fi' id='anio_fi' class='text_formulario'>";
	for($i=0; $i<$n; ++$i)
	{
		if($anio_fn[$i]==$ano)
		{
			$seleted="selected";
		}
		else
		{
			$seleted="";
		}
		echo"<option value='$anio_fn[$i]' $seleted>$anio_fn[$i]</option>";
	}
	echo"</select>";
}

function dibujar_anio($ano, $clave_fun)
{
	$n=0;
	if($clave_fun==1)
	{
		$anio0=$ano;
		$anio1=$ano+11;
	}
	if($clave_fun==2)
	{
		$anio0=$ano-30;
		$anio1=$ano+11;
	}
	if($clave_fun==3)
	{
		$anio0=1900;
		$anio1=$ano+2;
	}
	if($clave_fun==4)
	{
		$anio0=1880;
		$anio1=$ano;
	}
	for($i=$anio0; $i<$anio1; ++$i)
	{
		$anio_fn[$n]=$i;
		$n++;	
	}
	echo"<select name='anio' id='anio' class='text_formulario'>";
	for($i=0; $i<$n; ++$i)
	{
		if($anio_fn[$i]==$ano)
		{
			$seleted="selected";
		}
		else
		{
			$seleted="";
		}
		echo"<option value='$anio_fn[$i]' $seleted>$anio_fn[$i]</option>";
	}
	echo"</select>";
}
function ver_hora($hora){ 
    /*ereg( "([0-9]{2,4}):([0-9]{1,2}):([0-9]{1,2})", $hora, $mihora); */
	$mihora=explode(":",$hora);
    $turno="AM";
	$hora_real=$mihora[0];
	if($mihora[0]=="12")
	{
		$turno="PM";
	}	
	if($mihora[0]=="00")
	{
		$hora_real=12;
	}	
	if($mihora[0]>12)
	{
		$hora_real-=12;
		$turno="PM";
		if($hora_real<10){$hora_real="0$hora_real";}
	}	
	$lahora=$hora_real.":".$mihora[1]." ".$turno; 
	return $lahora;
}
function dibujar_hora($hora){ 
    /*ereg( "([0-9]{2,4}):([0-9]{1,2}):([0-9]{1,2})", $hora, $mihora); */
	$mihora=explode(":",$hora);
    $turno="AM";
	$hora_real=$mihora[0];
	if($mihora[0]=="12")
	{
		$turno="PM";
	}	
	if($mihora[0]=="00")
	{
		$hora_real=12;
	}	
	if($mihora[0]>12)
	{
		$hora_real-=12;
		$turno="PM";
		if($hora_real<10){$hora_real="0$hora_real";}
	}	
	$lahora=$hora_real.":".$mihora[1]." ".$turno; 
    $hora_fn = array('01','02','03','04','05','06','07','08','09','10','11','12');
	echo"
	<div class='col-md-4'>
	<div class='form-group'>
	<select name='hora_fn' class='form-control'>";
	for($i=0; $i<12; ++$i)
	{
		if($hora_fn[$i]==$hora_real)
		{
			$seleted="selected";
		}
		else
		{
			$seleted="";
		}
		echo"<option value='$hora_fn[$i]' $seleted>$hora_fn[$i]</option>";
	}
	echo"</select>
	</div></div>
	<div class='col-md-4'>
	<div class='form-group'>";
	$min_fn = array('00','05','10','15','20','25','30','35','40','45','50','55');
	echo"<select name='min_fn' class='form-control'>";
	for($i=0; $i<12; ++$i)
	{
		if($min_fn[$i]==$mihora[1])
		{
			$seleted="selected";
		}
		else
		{
			$seleted="";
		}
		echo"<option value='$min_fn[$i]' $seleted>$min_fn[$i]</option>";
	}
	echo"</select>
	</div></div>
	<div class='col-md-4'>
	<div class='form-group'>";
	 $tur_fn = array('AM','PM');
	echo"<select name='tur_fn' class='form-control'>";
	for($i=0; $i<2; ++$i)
	{
		if($tur_fn[$i]==$turno)
		{
			$seleted="selected";
		}
		else
		{
			$seleted="";
		}
		echo"<option value='$tur_fn[$i]' $seleted>$tur_fn[$i]</option>";
	}
	echo"</select>
	</div></div>";
}
function dibujar_hora2($hora){ 
    /*ereg( "([0-9]{2,4}):([0-9]{1,2}):([0-9]{1,2})", $hora, $mihora); */
	$mihora=explode(":",$hora);
    $turno="AM";
	$hora_real=$mihora[0];
	if($mihora[0]=="12")
	{
		$turno="PM";
	}	
	if($mihora[0]=="00")
	{
		$hora_real=12;
	}	
	if($mihora[0]>12)
	{
		$hora_real-=12;
		$turno="PM";
		if($hora_real<10){$hora_real="0$hora_real";}
	}	
	$lahora=$hora_real.":".$mihora[1]." ".$turno; 
    $hora_fn = array('01','02','03','04','05','06','07','08','09','10','11','12');
	echo"
	<div class='col-md-4'>
	<div class='form-group'>
	<select name='hora_fn2' class='form-control'>";
	for($i=0; $i<12; ++$i)
	{
		if($hora_fn[$i]==$hora_real)
		{
			$seleted="selected";
		}
		else
		{
			$seleted="";
		}
		echo"<option value='$hora_fn[$i]' $seleted>$hora_fn[$i]</option>";
	}
	echo"</select>
	</div></div>
	<div class='col-md-4'>
	<div class='form-group'>";
	$min_fn = array('00','05','10','15','20','25','30','35','40','45','50','55');
	echo"<select name='min_fn2' class='form-control'>";
	for($i=0; $i<12; ++$i)
	{
		if($min_fn[$i]==$mihora[1])
		{
			$seleted="selected";
		}
		else
		{
			$seleted="";
		}
		echo"<option value='$min_fn[$i]' $seleted>$min_fn[$i]</option>";
	}
	echo"</select>
	</div></div>
	<div class='col-md-4'>
	<div class='form-group'>";
	 $tur_fn = array('AM','PM');
	echo"<select name='tur_fn2' class='form-control'>";
	for($i=0; $i<2; ++$i)
	{
		if($tur_fn[$i]==$turno)
		{
			$seleted="selected";
		}
		else
		{
			$seleted="";
		}
		echo"<option value='$tur_fn[$i]' $seleted>$tur_fn[$i]</option>";
	}
	echo"</select>
	</div></div>";
}
function dibujar_nfecha($fecha_nac, $clave_fun, $v, $stilo)
{
	$ano = substr($fecha_nac, 0, 4);
	$mes = substr($fecha_nac, 5, 2); //2008-10-01
	$dia = substr($fecha_nac, 8, 2);
	for($i=0; $i<31; ++$i)
	{
		$dia_fn[$i]=$i+1;	
	}
	$mes_fn = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
	$n=0;
	if($clave_fun==1)
	{
		$anio0=$ano;
		$anio1=$ano+11;
	}
	if($clave_fun==2)
	{
		$anio0=$ano-10;
		$anio1=$ano+11;
	}
	if($clave_fun==3)
	{
		$anio0=1900;
		$anio1=$ano+2;
	}
	if($clave_fun==4)
	{
		$anio0=1912;
		$anio1=$ano+1;
	}
	if($clave_fun==5)
	{
		$anio0=1912;
		$anio1=$ano+30;
	}
	if($clave_fun==6)
	{
		$anio0=1492;
		$anio1=$ano+1;
	}
	for($i=$anio0; $i<$anio1; ++$i)
	{
		$anio_fn[$n]=$i;
		$n++;	
	}
	echo"
	<div class='col-md-3'>
	<div class='form-group'>
	<select name='di".$v."a' class='$stilo'>";
	for($i=0; $i<31; ++$i)
	{
		if($dia_fn[$i]==$dia)
		{
			$seleted="selected";
		}
		else
		{
			$seleted="";
		}
		echo"<option value='$dia_fn[$i]' $seleted>$dia_fn[$i]</option>";
	}
	echo"</select></div></div>";
	echo"	<div class='col-md-6'>
	<div class='form-group'>
	<select name='me".$v."s' class='$stilo'>";
	for($i=0; $i<12; ++$i)
	{
		if($i+1==$mes)
		{
			$seleted="selected";
		}
		else
		{
			$seleted="";
		}
		$mes_real=$i+1;
		echo"<option value='$mes_real' $seleted>$mes_fn[$i]</option>";
	}
	echo"</select></div></div>";
	echo"	<div class='col-md-3'>
	<div class='form-group'>
	<select name='ani".$v."o' class='$stilo'>";
	for($i=0; $i<$n; ++$i)
	{
		if($anio_fn[$i]==$ano)
		{
			$seleted="selected";
		}
		else
		{
			$seleted="";
		}
		echo"<option value='$anio_fn[$i]' $seleted>$anio_fn[$i]</option>";
	}
	echo"</select></div></div>";
}
function ultimo_domingo($fecha)
{
	/*ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);*/
	$mifecha=explode("-",$fecha); 
    $dia=strftime("%d", mktime(0, 0, 0, $mifecha[1]+1, 0, $mifecha[0]));
	$marca=date("w", mktime(0, 0, 0, $mifecha[1], $dia, $mifecha[0]));
	$lafecha=$mifecha[0]."-".$mifecha[1]."-".($dia-$marca); 
	return $lafecha;	
}
function ultimo_domingo_anterior($fecha)
{
	/*ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);*/
	$mifecha=explode("-",$fecha); 
    if($mifecha[1]=='01')
	{
		$mifecha[1]=12;
		$mifecha[0]--;
	}
	else
	{
		if($mifecha[1]=='02')
		{
			$mifecha[1]='01';
		}
		else
		{
			$mifecha[1]-=2;
		}
	}
	$dia=strftime("%d", mktime(0, 0, 0, $mifecha[1]+1, 0, $mifecha[0]));
	$marca=date("w", mktime(0, 0, 0, $mifecha[1], $dia, $mifecha[0]));
	$lafecha=$mifecha[0]."-".$mifecha[1]."-".($dia-$marca); 
	return $lafecha;	
}
function ultima_nomina($fecha, $piv)
{
	/*ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha); */
	$mifecha=explode("-",$fecha);
    if($piv==2)
	{
		if($mifecha[1]=='01')
		{
			$mifecha[1]=12;
			$mifecha[0]--;
		}
		else
		{
			if($mifecha[2]=='02')
			{
				$mifecha[1]='01';
			}
			else
			{
				$mifecha[1]-=2;
			}
		}
		
	}
	$dia=strftime("%d", mktime(0, 0, 0, $mifecha[1]+1, 0, $mifecha[0]));
	$lafecha=$mifecha[0]."-".$mifecha[1]."-".$dia;
	return $lafecha;
}
function primer_lunes($fecha_base, $fecha_inicio)
{
	/*ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha_base, $fnomina); */
	$fnomina=explode("-",$fecha_base);
	/*ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha_inicio, $fingreso);*/
	$fingreso=explode("-",$fecha_inicio);
	
	$diap=date("w", mktime(0,0,0,$fingreso[1],$fingreso[2],$fingreso[0]));
	$diau=date("w", mktime(0,0,0,$fnomina[1],$fnomina[2],$fnomina[0]));
	
	$Date1 = strtotime($fecha_inicio);
	$Date2 = strtotime($fecha_base);
	
	$lunes1=$fecha_inicio;
	if($diap!=1)
	{
		$lunes1=date('Y-m-d', strtotime("next Monday", $Date1));
	}
	$lunes2=$fecha_base;
	if($diau!=1)
	{
		$lunes2=date('Y-m-d', strtotime("last Monday", $Date2));
	}
	$nlunes=((strtotime($lunes2)-strtotime($lunes1))/86400);
	$nlunes/=7;
	$nlunes++;
	
	return $nlunes;
}
function subir_imagen($action, $nom_dato, $semilla, $valor_x, $ubica_img, $nom_dato2, $tipo_img)
{
	$status = "";
	if ($_POST[$action] == "upload") 
	{
		$tamano = $_FILES[$nom_dato]['size'];
		$tipo = $_FILES[$nom_dato]['type'];
		$archivo = $_FILES[$nom_dato]['name'];
		$prefijo = substr(md5(uniqid(rand())),0,4);

		if ($archivo != "") 
		{
			$mTmpFile = $_FILES[$nom_dato]["tmp_name"];
			$mTipo = exif_imagetype($mTmpFile);
			if (($mTipo != IMAGETYPE_JPEG) && ($mTipo != IMAGETYPE_PNG))
			{
				echo"<script language='JavaScript'>alert('Tipo de archivo imagen incorrecto!!! (Use JPEG o PNG)')</script>";
			}
			else
			{
				$foo = new Upload($_FILES[$nom_dato]);
				if ($foo->uploaded) 
				{
					$foo->file_new_name_body = $semilla."_".$prefijo;
					$foo->image_resize = true;
					$foo->image_convert = $tipo_img;
					$foo->image_x = $valor_x;
					$foo->image_ratio_y = true;
					$foo->Process($ubica_img);
					if ($foo->processed) 
					{
						$dir=$_POST[$nom_dato2];
						if(file_exists($dir) && $dir!='img/avatar.png'  && $dir!='img/avatar_person.gif' && $dir!='img/imagen_no_disponible.gif' && $dir!='img/imagen_no_disponible_peque.gif')
						{
							unlink($dir);
						}
						$foo->Clean();
						$status = "Archivo subido: <b>".$archivo."</b>";
					} 
					else
					{
						echo 'error : ' . $foo->error;
						$status = "Error";
	
					}
				}
				
				
				$img_peque="$ubica_img".$semilla."_".$prefijo.".".$tipo_img;
				$foto_nueva="$nom_dato='$img_peque',";
			}			
		}
		else
		{
			$foto_nueva="";
		}
		return $foto_nueva;
	}
	if($status=="Error")
	{
		echo"<script language='JavaScript'>alert('Error al subir el archivo $archivo!')</script>";
	}
	
}
function subir_documento($action, $nom_dato, $ubica_img, $nom_dato2)
{
	$status = "";
	if ($_POST[$action] == "upload") 
	{
		$tamano = $_FILES[$nom_dato]['size'];
		$tipo = $_FILES[$nom_dato]['type'];
		$archivo = $_FILES[$nom_dato]['name'];
		  
		$prefijo = substr(md5(uniqid(rand())),0,20);
		  
		if ($archivo != "") 
		{
			$tipoFile = $_FILES[$nom_dato]['type']; 
			if($tipoFile!="application/pdf") 
			{
				echo"<script language='JavaScript'>alert('Tipo de archivo incorrecto!!! (Use archivos PDF)')</script>";
				return FALSE;
			}
			else
			{
				$archivo=preg_replace("/ /",'',$archivo);
				$archivo=cambio_texto_acento ($archivo);
				$destino =  "$ubica_img".$prefijo."_".$archivo;
				if (copy($_FILES[$nom_dato]['tmp_name'],$destino))
				{
					$status = "Archivo subido: <b>".$archivo."</b>";
					if($_POST[$nom_dato2])
					{
						$url_nueva="$nom_dato='$destino',";
					}
					else
					{
						$url_nueva="$destino";				
					}
					$dir=$_POST[$nom_dato2]; //puedes usar dobles comillas si quieres
					if(file_exists($dir) && $dir!='../../img/avatar_person.gif' && $dir!='img/imagen_no_disponible.gif' && $dir!='img/imagen_no_disponible_peque.gif')
					{
						unlink($dir);
					}
				}
				else
				{
					$status = "Error";
				}
			}
		}
		else
		{
			$url_nueva="";
		}
	return $url_nueva;
	}
	if($status=="Error")
	{
		echo"<script language='JavaScript'>alert('Error al subir el archivo $archivo!')</script>";
	}
}
function subir_imagen_nueva($action, $nom_dato, $semilla, $valor_x, $ubica_img, $tipo_img)
{
	$status = "";
	if ($_POST[$action] == "upload") 
	{
		$tamano = $_FILES[$nom_dato]['size'];
		$tipo = $_FILES[$nom_dato]['type'];
		$archivo = $_FILES[$nom_dato]['name'];
		$prefijo = substr(md5(uniqid(rand())),0,4);

		if ($archivo != "") 
		{
			$mTmpFile = $_FILES[$nom_dato]["tmp_name"];
			$mTipo = exif_imagetype($mTmpFile);
			if (($mTipo != IMAGETYPE_JPEG) && ($mTipo != IMAGETYPE_PNG))
			{
				echo"<script language='JavaScript'>alert('Tipo de archivo imagen incorrecto!!! (Use JPEG o PNG)')</script>";
			}
			else
			{
				$foo = new Upload($_FILES[$nom_dato]);
				if ($foo->uploaded) 
				{
					$foo->file_new_name_body = $semilla."_".$prefijo;
					$foo->image_resize = true;
					$foo->image_convert = $tipo_img;
					$foo->image_x = $valor_x;
					$foo->image_ratio_y = true;
					$foo->Process($ubica_img);
					if ($foo->processed) 
					{
						$foo->Clean();
						$status = "Archivo subido: <b>".$archivo."</b>";
					} 
					else
					{
						echo 'error : ' . $foo->error;
						$status = "Error";
	
					}
				}
				$img_peque="$ubica_img".$semilla."_".$prefijo.".".$tipo_img;
				$foto_nueva="$img_peque";
			}
		}
		else
		{
			$foto_nueva="img/imagen_no_disponible.gif";
		}
		return $foto_nueva;
	}
	if($status=="Error")
	{
		echo"<script language='JavaScript'>alert('Error al subir el archivo $archivo!')</script>";
	}
}
function subir_imagen_normal($action, $nom_dato, $semilla, $ubica_img, $nom_dato2)
{
	$status = "";
	if ($_POST[$action] == "upload") 
	{
		$tamano = $_FILES[$nom_dato]['size'];
		$tipo = $_FILES[$nom_dato]['type'];
		$archivo = $_FILES[$nom_dato]['name'];
		$prefijo = substr(md5(uniqid(rand())),0,4);
		
		if ($archivo != "") 
		{
			$mTmpFile = $_FILES[$nom_dato]["tmp_name"];
			$mTipo = exif_imagetype($mTmpFile);
			if (($mTipo != IMAGETYPE_JPEG) && ($mTipo != IMAGETYPE_PNG))
			{
				echo"<script language='JavaScript'>alert('Tipo de archivo imagen incorrecto!!! (Use JPEG o PNG)')</script>";
			}
			else
			{
				$destino =  $ubica_img.$prefijo."_".$archivo;
				copy($_FILES[$nom_dato]['tmp_name'],$destino);
				
				$img_peque=$destino;
				$foto_nueva="$nom_dato='$img_peque',";	
				
				$dir=$_POST[$nom_dato2];
				if(file_exists($dir) && $dir!='../../img/avatar_person.gif' && $dir!='img/imagen_no_disponible.gif' && $dir!='img/imagen_no_disponible_peque.gif')
				{
					unlink($dir);
				}
			}		
		}
		else
		{
			$foto_nueva="";
		}
		return $foto_nueva;
	}
	if($status=="Error")
	{
		echo"<script language='JavaScript'>alert('Error al subir el archivo $archivo!')</script>";
	}
}
function fecha_nombre($fecha_datetime){ 
	//Esta función convierte la fecha del formato DATETIME de SQL a formato DD-MM-YYYY HH:mm:ss
	$fecha = explode("-",$fecha_datetime);
	$hora = explode(":",$fecha[2]);
	$fecha_hora = explode(" ",$hora[0]);
	$fecha_convertida = $fecha_hora[0].$fecha[1].$fecha[0].$fecha_hora[1].$hora[1].$hora[2];
	return $fecha_convertida;
}
function cambio_texto_acento ($texto)
{
$n_texto=preg_replace("/á/","a",$texto);
$n_texto=preg_replace("/é/","e",$n_texto);
$n_texto=preg_replace("/í/","i",$n_texto);
$n_texto=preg_replace("/ó/","o;",$n_texto);
$n_texto=preg_replace("/ú/","u;",$n_texto);

$n_texto=preg_replace("/Á/","A",$n_texto);
$n_texto=preg_replace("/É/","E",$n_texto);
$n_texto=preg_replace("/Í/","I;",$n_texto);
$n_texto=preg_replace("/Ó/","O",$n_texto);
$n_texto=preg_replace("/Ú/","U",$n_texto);

$n_texto=preg_replace("/ñ/", "n", $n_texto);
$n_texto=preg_replace("/Ñ/", "N", $n_texto);
$n_texto=preg_replace("/¿/", " ", $n_texto);

$n_texto=preg_replace('/"/','', $n_texto);
$n_texto=preg_replace("/'/"," ", $n_texto);

return $n_texto;
}
function cambio_texto_html ($texto)
{
$n_texto=preg_replace("/&aacute;/", "á",$texto);
$n_texto=preg_replace("/&eacute;/", "é",$n_texto);
$n_texto=preg_replace("/&iacute;/","í",$n_texto);
$n_texto=preg_replace("/&oacute;/","ó",$n_texto);
$n_texto=preg_replace("/&uacute;/","ú",$n_texto);

$n_texto=preg_replace("/&Aacute;/","Á",$n_texto);
$n_texto=preg_replace("/&Eacute;/","É",$n_texto);
$n_texto=preg_replace("/&Iacute;/","Í",$n_texto);
$n_texto=preg_replace("/&Oacute;/","Ó",$n_texto);
$n_texto=preg_replace("/&Uacute;/","Ú",$n_texto);

$n_texto=preg_replace("/&ntilde;/","ñ", $n_texto);
$n_texto=preg_replace("/&Ntilde;/","Ñ", $n_texto);
$n_texto=preg_replace("/&iquest;/","¿", $n_texto);

$n_texto=preg_replace('/&quot;/', '"', $n_texto);

return $n_texto;
}
function cambio_texto_parahtml ($texto)
{
$n_texto=preg_replace("/á/","&aacute;", $texto);
$n_texto=preg_replace("/é/","&eacute;", $n_texto);
$n_texto=preg_replace("/í/","&iacute;",$n_texto);
$n_texto=preg_replace("/ó/","&oacute;",$n_texto);
$n_texto=preg_replace("/ú/","&uacute;",$n_texto);

$n_texto=preg_replace("/Á/","&Aacute;",$n_texto);
$n_texto=preg_replace("/É/","&Eacute;",$n_texto);
$n_texto=preg_replace("/Í/","&Iacute;",$n_texto);
$n_texto=preg_replace("/Ó/","&Oacute;",$n_texto);
$n_texto=preg_replace("/Ú/","&Uacute;",$n_texto);

$n_texto=preg_replace("/ñ/","&ntilde;", $n_texto);
$n_texto=preg_replace("/Ñ/","&Ntilde;", $n_texto);
$n_texto=preg_replace("/¿/","&iquest;", $n_texto);

$n_texto=preg_replace('/"/','&quot;', $n_texto);
$n_texto=preg_replace("/'/","&quot;", $n_texto);

return $n_texto;
}

function cambio_texto_titular ($texto)
{
	$n_texto=cambio_texto_parahtml($texto);
	$n_texto=preg_replace(' />','/>', $n_texto);
	$n_texto=strip_tags($n_texto);
	
	return $n_texto;
}

function ver_lapso($fecha1, $fecha2, $fecha3)
{
	//echo"(".strtotime($fecha1).")(".strtotime($fecha2).")(".strtotime($fecha3).")";
	if(strtotime($fecha1)>=strtotime($fecha2) && strtotime($fecha1)<=strtotime($fecha3))
	{
		return 1;
	}
	else
	{
		return 0;
	}
}

function subir_imagen_nueva_emp($action, $nom_dato, $semilla, $valor_x, $ubica_img)
{
	$status = "";
	if ($_POST[$action] == "upload") 
	{
		$tamano = $_FILES[$nom_dato]['size'];
		$tipo = $_FILES[$nom_dato]['type'];
		$archivo = $_FILES[$nom_dato]['name'];
		$prefijo = substr(md5(uniqid(rand())),0,4);
		if ($archivo != "") 
		{
			$mTmpFile = $_FILES[$nom_dato]["tmp_name"];
			$mTipo = exif_imagetype($mTmpFile);
			if (($mTipo != IMAGETYPE_JPEG) && ($mTipo != IMAGETYPE_PNG))
			{
				echo"<script language='JavaScript'>alert('Tipo de archivo imagen incorrecto!!! (Use JPEG o PNG)')</script>";
			}
			else
			{
				$foo = new Upload($_FILES[$nom_dato]);
				if ($foo->uploaded) 
				{
					$foo->file_new_name_body = $semilla."_".$prefijo;
					$foo->image_resize = true;
					$foo->image_convert = jpg;
					$foo->image_x = $valor_x;
					$foo->image_ratio_y = true;
					$foo->Process($ubica_img);
					if ($foo->processed) 
					{
						$foo->Clean();
						$status = "Archivo subido: <b>".$archivo."</b>";
					} 
					else
					{
						echo 'error : ' . $foo->error;
						$status = "Error";
	
					}
				}
				$img_peque="$ubica_img".$semilla."_".$prefijo.".jpg";
				$foto_nueva="$img_peque";
			}			
		}
		else
		{
			$foto_nueva="img/avatar.png";
		}
		return $foto_nueva;
	}
	if($status=="Error")
	{
		echo"<script language='JavaScript'>alert('Error al subir el archivo $archivo!')</script>";
	}
}

function subir_imagen_logo($action, $nom_dato, $semilla, $valor_x, $ubica_img)
{
	$status = "";
	if ($_POST[$action] == "upload") 
	{
		$tamano = $_FILES[$nom_dato]['size'];
		$tipo = $_FILES[$nom_dato]['type'];
		$archivo = $_FILES[$nom_dato]['name'];
		//$prefijo = substr(md5(uniqid(rand())),0,4);
		if ($archivo != "") 
		{
			$dir=$ubica_img.$semilla.".png";
			if(file_exists($dir)){ unlink($dir);}
			$mTmpFile = $_FILES[$nom_dato]["tmp_name"];
			$mTipo = exif_imagetype($mTmpFile);
			if (($mTipo != IMAGETYPE_JPEG) && ($mTipo != IMAGETYPE_PNG))
			{
				echo"<script language='JavaScript'>alert('Tipo de archivo imagen incorrecto!!! (Use JPEG o PNG)')</script>";
			}
			else
			{
				$foo = new Upload($_FILES[$nom_dato]);
				if ($foo->uploaded) 
				{
					//$foo->file_new_name_body = $semilla."_".$prefijo;
					$foo->file_new_name_body = $semilla;
					$foo->image_resize = true;
					$foo->image_convert = png;
					$foo->image_x = $valor_x;
					$foo->image_ratio_y = true;
					$foo->Process($ubica_img);
					if ($foo->processed) 
					{
						
						$foo->Clean();
						$status = "Archivo subido: <b>".$archivo."</b>";
					} 
					else
					{
						echo 'error : ' . $foo->error;
						$status = "Error";
	
					}
				}
				//$img_peque="$ubica_img".$semilla."_".$prefijo.".jpg";
				$img_peque=$ubica_img.$semilla.".png";
				$foto_nueva="$img_peque";
			}			
		}
		else
		{
			//$foto_nueva="img/avatar.png";
			$foto_nueva="";
		}
		return $foto_nueva;
	}
	if($status=="Error")
	{
		echo"<script language='JavaScript'>alert('Error al subir el archivo $archivo!')</script>";
	}
}

function fecha_fide($fecha_ingre, $fecha_de_nomina)
{
	$fecha1="2012-05-07";
	$mes_nomi= substr($fecha_de_nomina, 5, 2);
	$mes_ingre= substr($fecha_ingre, 5, 2);
	$piv=0;
	
	if(strtotime($fecha_ingre)<=strtotime($fecha1))
	{
		if($mes_nomi==7 || $mes_nomi==10 || $mes_nomi==1 || $mes_nomi==4)
		{
			$piv++;
		}
	}
	else
	{
		for($i=1; $i<5; $i++)
		{
			if(($mes_ingre+($i*3)-1)<=12)
			{
				$mes_ingre_fide[($i-1)]=$mes_ingre+($i*3)-1;
			}
			else
			{
				$mes_ingre_fide[($i-1)]=$mes_ingre+($i*3)-1-12;
			}
		}
		if($mes_nomi==$mes_ingre_fide[0] || $mes_nomi==$mes_ingre_fide[1] || $mes_nomi==$mes_ingre_fide[2] || $mes_nomi==$mes_ingre_fide[3])
		{
			$piv++;
		}
	}
	return $piv;
}
function fecha_fide_dos($fecha_ingre, $fecha_de_nomina)
{
	$mes_nomi= substr($fecha_de_nomina, 5, 2);
	$mes_ingre= substr($fecha_ingre, 5, 2);
	
	if($mes_nomi==$mes_ingre)
	{
		return 1;
	}
	else
	{
		return 0;
	}
}
function getUltimoDiaMes($elAnio,$elMes) {
  return date("d",(mktime(0,0,0,$elMes+1,1,$elAnio)-1));
}
/*Funcion que devuelve el Navegador Actual*/
function obtenerNavegadorWeb()
{
	$agente = $_SERVER['HTTP_USER_AGENT'];
	$navegador = 'Unknown';
	$platforma = 'Unknown';
	$version= "";

	//Obtenemos la Plataforma
	if (preg_match('/linux/i', $agente)) 
	{
		$platforma = 'linux';
	}
	elseif (preg_match('/macintosh|mac os x/i', $agente)) 
	{
		$platforma = 'mac';
	}
	elseif (preg_match('/windows|win32/i', $agente)) 
	{
		$platforma = 'windows';
	}

	//Obtener el UserAgente
	if(preg_match('/MSIE/i',$agente) && !preg_match('/Opera/i',$agente))
	{
		$navegador = 'Internet Explorer';
		$navegador_corto = "MSIE";
	}
	elseif(preg_match('/Firefox/i',$agente))
	{
		$navegador = 'Mozilla Firefox';
		$navegador_corto = "Firefox";
	}
	elseif(preg_match('/Chrome/i',$agente))
	{
		$navegador = 'Google Chrome';
		$navegador_corto = "Chrome";
	}
	elseif(preg_match('/Safari/i',$agente))
	{
		$navegador = 'Apple Safari';
		$navegador_corto = "Safari";
	}
	elseif(preg_match('/Opera/i',$agente))
	{
		$navegador = 'Opera';
		$navegador_corto = "Opera";
	}
	elseif(preg_match('/Netscape/i',$agente))
	{
		$navegador = 'Netscape';
		$navegador_corto = "Netscape";
	}

	// Obtenemos la Version
	$known = array('Version', $navegador_corto, 'other');
	$pattern = '#(?' . join('|', $known) .
	')[/ ]+(?[0-9.|a-zA-Z.]*)#';
	if (!preg_match_all($pattern, $agente, $matches)) 
	{
	//No se obtiene la version simplemente continua
	}

	$i = count($matches['browser']);
	if ($i != 1) {
	if (strripos($agente,"Version") < strripos($agente,$navegador_corto)){ $version= $matches['version'][0]; } else { $version= $matches['version'][1]; } } else { $version= $matches['version'][0]; } /*Verificamos si tenemos Version*/ if ($version==null || $version=="") {$version="?";} /*Resultado final del Navegador Web que Utilizamos*/ 
	
	return array('agente' => $agente,'nombre'=>$navegador,'version'=>$version,'platforma'=>$platforma);

}
function sendTweet($mensaje, $mi_access_token, $mi_access_token_secret, $mi_key, $mi_secret)
{
	echo $mensaje."<br>";

	ini_set('display_errors', 1);
	require_once('TwitterAPIExchange.php');
	/** Set access tokens here - see: https://dev.twitter.com/apps/ **/ 
	$settings = array(
	'oauth_access_token' => $mi_access_token,
	'oauth_access_token_secret' => $mi_access_token_secret,
	'consumer_key' => $mi_key,
	'consumer_secret' => $mi_secret	
	);
	
	$url = 'https://api.twitter.com/1.1/statuses/update.json';
	$requestMethod = 'POST';
	/** POST fields required by the URL above. See relevant docs as above **/
	$postfields = array( 'status' => $mensaje );
	/** Perform a POST request and echo the response **/
	$twitter = new TwitterAPIExchange($settings);
	return $twitter->buildOauth($url, $requestMethod)->setPostfields($postfields)->performRequest();
}
function validar_imagen($archivo, $maxpeso, $maxancho, $maxalto, $campo)
{
	$Ok = $_FILES[$archivo];
	$archivook = $_FILES[$archivo]['name'];
	if($archivook=="")
	{
		echo"<script language='JavaScript'>alert('El campo ".$campo." esta vacio!')</script>";
		echo"<script language='JavaScript'>location.href='javascript:history.go(-1)'</script>";
		return FALSE;
	}
	else
	{
		$url = $_FILES[$archivo]["tmp_name"];
		list($anchura, $altura, $tipoImagen, $atributos) = getimagesize($url);
		if(isset($atributos))
		{$error = 0;}else{$error = 1;}
		
		if($tipoImagen!=1 && $tipoImagen!=2 && $tipoImagen!=3)
		{
			echo"<script language='JavaScript'>alert('El archivo ".$campo." debe ser de tipo: GIF, JPG o PNG')</script>";
			echo"<script language='JavaScript'>location.href='javascript:history.go(-1)'</script>";	
			return FALSE;		
		}
		else
		{ 
			if(filesize($url)>$maxpeso)
			{
				echo"<script language='JavaScript'>alert('El archivo ".$campo." no debe pesar mas de ".$maxpeso."bytes')</script>";
				echo"<script language='JavaScript'>location.href='javascript:history.go(-1)'</script>";	
				return FALSE;
			}
			else
			{
				if($anchura<$maxancho || $altura<$maxalto)
				{
					echo"<script language='JavaScript'>alert('El campo ".$campo." no posee las dimesiones adecuadas (".$maxancho." x ".$maxalto." px)')</script>";
					echo"<script language='JavaScript'>location.href='javascript:history.go(-1)'</script>";	
					return FALSE;
				}
				else
				{
					return TRUE;
				}
			}
		}
	}
}
function subir_imagen_dos($action, $nom_dato, $semilla, $valor_x, $valor_y, $ubica_img, $nom_dato2, $tipo_img)
{
	$status = "";
	if ($_POST[$action] == "upload") 
	{
		$tamano = $_FILES[$nom_dato]['size'];
		$tipo = $_FILES[$nom_dato]['type'];
		$archivo = $_FILES[$nom_dato]['name'];
		$prefijo = substr(md5(uniqid(rand())),0,8);

		if ($archivo != "") 
		{
			$mTmpFile = $_FILES[$nom_dato]["tmp_name"];
			$mTipo = exif_imagetype($mTmpFile);
			if (($mTipo != IMAGETYPE_JPEG) && ($mTipo != IMAGETYPE_PNG))
			{
				echo"<script language='JavaScript'>alert('Tipo de archivo imagen incorrecto!!! (Use JPEG o PNG)')</script>";
			}
			else
			{
				$foo = new Upload($_FILES[$nom_dato]);
				if ($foo->uploaded) 
				{
					$foo->file_new_name_body = $semilla."_".$prefijo;
					//$foo->image_resize = true;
					$foo->image_convert = $tipo_img;
					//$foo->image_x = $valor_x;
					//$foo->image_ratio_y = true;
					
					$foo->image_resize          = true;
					$foo->image_ratio_crop      = 'L';
					$foo->image_y               = $valor_y;
					$foo->image_x               = $valor_x;
					
					$foo->Process($ubica_img);
					if ($foo->processed) 
					{
						$dir=$_POST[$nom_dato2];
						if(file_exists($dir) && $dir!='img/avatar_person.gif' && $dir!='img/imagen_no_disponible.gif')
						{
							unlink($dir);
						}
						$foo->Clean();
						$status = "Archivo subido: <b>".$archivo."</b>";
					} 
					else
					{
						echo 'error : ' . $foo->error;
						$status = "Error";
	
					}
				}
				
				
				$img_peque="$ubica_img".$semilla."_".$prefijo.".".$tipo_img;
				$foto_nueva="$nom_dato='$img_peque',";
			}			
		}
		else
		{
			$foto_nueva="";
		}
		return $foto_nueva;
	}
	if($status=="Error")
	{
		echo"<script language='JavaScript'>alert('Error al subir el archivo $archivo!')</script>";
	}
}
function subir_imagen_nueva_dos($action, $nom_dato, $semilla, $valor_x, $valor_y, $ubica_img, $tipo_img)
{
	$status = "";
	if ($_POST[$action] == "upload") 
	{
		$tamano = $_FILES[$nom_dato]['size'];
		$tipo = $_FILES[$nom_dato]['type'];
		$archivo = $_FILES[$nom_dato]['name'];
		$prefijo = substr(md5(uniqid(rand())),0,8);

		if ($archivo != "") 
		{
			$mTmpFile = $_FILES[$nom_dato]["tmp_name"];
			$mTipo = exif_imagetype($mTmpFile);
			if (($mTipo != IMAGETYPE_JPEG) && ($mTipo != IMAGETYPE_PNG))
			{
				echo"<script language='JavaScript'>alert('Tipo de archivo imagen incorrecto!!! (Use JPEG o PNG)')</script>";
			}
			else
			{
				$foo = new Upload($_FILES[$nom_dato]);
				if ($foo->uploaded) 
				{
					$foo->file_new_name_body = $semilla."_".$prefijo;
					//$foo->image_resize = true;
					$foo->image_convert = $tipo_img;
					
					$foo->image_resize          = true;
					$foo->image_ratio_crop      = 'L';
					$foo->image_y               = $valor_y;
					$foo->image_x               = $valor_x;
					
					//$foo->image_x = $valor_x;
					//$foo->image_ratio_y = true;
					$foo->Process($ubica_img);
					if ($foo->processed) 
					{
						$foo->Clean();
						$status = "Archivo subido: <b>".$archivo."</b>";
					} 
					else
					{
						echo 'error : ' . $foo->error;
						$status = "Error";
	
					}
				}
				$img_peque="$ubica_img".$semilla."_".$prefijo.".".$tipo_img;
				$foto_nueva="$img_peque";
			}
		}
		else
		{
			$foto_nueva="img/imagen_no_disponible.gif";
		}
		return $foto_nueva;
	}
	if($status=="Error")
	{
		echo"<script language='JavaScript'>alert('Error al subir el archivo $archivo!')</script>";
	}
}
function subir_archivo_nuevo($action, $nom_dato, $ubica_img, $nom_dato2)
{
	
	$status = "";
	if ($_POST[$action] == "upload") 
	{
		$tamano = $_FILES[$nom_dato]['size'];
		$tipo = $_FILES[$nom_dato]['type'];
		$archivo = $_FILES[$nom_dato]['name'];
		
		$prefijo = substr(md5(uniqid(rand())),0,20);
		  
		if ($archivo != "") 
		{
			$tipoFile = $_FILES[$nom_dato]['type']; 
			if($tipoFile!="application/pdf") 
			{
				echo"<script language='JavaScript'>alert('Tipo de archivo incorrecto!!! (Use archivos PDF)')</script>";
				return FALSE;
			}
			else
			{
				$archivo=preg_replace("/ /",'',$archivo);
				$archivo=cambio_texto_acento ($archivo);
				$destino =  "$ubica_img".$prefijo."_".$archivo;
				if (copy($_FILES[$nom_dato]['tmp_name'],$destino))
				{
					$status = "Archivo subido: <b>".$archivo."</b>";
					/*if($_POST[$nom_dato2])
					{
						$url_nueva="$nom_dato='$destino',";
					}
					else
					{
						$url_nueva="$destino";				
					}*/
					$url_nueva="$destino";
					$dir=$_POST[$nom_dato2]; //puedes usar dobles comillas si quieres
					if(file_exists($dir) && $dir!='../../img/avatar_person.gif' && $dir!='img/imagen_no_disponible.gif' && $dir!='img/imagen_no_disponible_peque.gif')
					{
						unlink($dir);
					}
				}
				else
				{
					$status = "Error";
				}
			}
		}
		else
		{
			$url_nueva=$_POST[$nom_dato2];
		}
		return $url_nueva;
	}
	if($status=="Error")
	{
		echo"<script language='JavaScript'>alert('Error al subir el archivo $archivo!')</script>";
	}
}
function limpiarString($string) //función para limpiar strings
{
  $string = strip_tags($string);
  $string = htmlentities($string);
  return stripslashes($string);  
}
function mid1($mi_fecha_ini, $mi_lapso_anio)
{
	date_default_timezone_set('America/Caracas');
	$fecha=date("Y-m-d");
	$anios=edad($fecha, $mi_fecha_ini);
	if($anios<$mi_lapso_anio){$circ="usu_act.png";}
	if($anios>=$mi_lapso_anio){$circ="usu_bloq.png";}
	echo"<img src='img/".$circ."' border='0' />";
}
function incrementa_hora($hora_base, $num_minuto)
{
	$minutoAnadir=$num_minuto;
	$segundos_horaInicial=strtotime($hora_base);
	$segundos_minutoAnadir=$minutoAnadir*60;
	$nuevaHora=date("H:i",$segundos_horaInicial+$segundos_minutoAnadir);
	return $nuevaHora;
}
function RestarHoras($horaini,$horafin)
{
	$horai=substr($horaini,0,2);
	$mini=substr($horaini,3,2);
	$segi=substr($horaini,6,2);
 
	$horaf=substr($horafin,0,2);
	$minf=substr($horafin,3,2);
	$segf=substr($horafin,6,2);
 
	$ini=((($horai*60)*60)+($mini*60)+$segi);
	$fin=((($horaf*60)*60)+($minf*60)+$segf);
 
	$dif=$fin-$ini;
 
	$difh=floor($dif/3600);
	$difm=floor(($dif-($difh*3600))/60);
	$difs=$dif-($difm*60)-($difh*3600);
	$cadena=date("H:i:s",mktime($difh,$difm,$difs))/*." en minutos: ".($difh*60+$difm)." en horas clase: ".(($difh*60+$difm)/45)." Horas"*/;
	return $cadena;
}
function enviar_correo($destino, $asunto, $remite, $sitio, $cuerpo)
{
	  $aviso = "";
	  if ($destino != "") {
		  // email de destino
		  $email = $remite;
		  // asunto del email
		  $subject = $asunto;
		  // Cuerpo del mensaje
		  $mensaje = $cuerpo;
		  $mensaje.= "FECHA:    ".date("d/m/Y")."\n";
		  $mensaje.= "HORA:     ".date("h:i:s a")."\n";
		  $mensaje.= "Enviado desde ".$sitio."\n";
		  $headers = "From: ".$email."\r\n";
		  if (mail($destino, $subject, $mensaje, $headers)) {
			  $aviso = "Su mensaje fue enviado.";
		  } else {
			  $aviso = "Error de envío.";
		  }
	  }
}
function fecha_tres($fecha_base, $incre){
	$fecha = $fecha_base;
	$anios="+".$incre." year";
	$nuevafecha = strtotime ( $anios , strtotime ( $fecha ) ) ;
	$nuevafecha = date ( 'Y-m-j' , $nuevafecha );
	return $nuevafecha;
}
function cambiaf_a_fecha($fecha_nac)
{
	$anio = substr($fecha_nac, 0, 4);
	$mes = substr($fecha_nac, 5, 2); //2008-10-01
	$dia = substr($fecha_nac, 8, 2);
	$mes_fn = array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
	$dia_sem = array('domingo', 'lunes', 'martes', 'mi&eacute;rcoles', 'jueves', 'viernes', 's&aacute;bado');
	echo $dia_sem[date("w",strtotime($fecha_nac))]." ".$dia." de ".$mes_fn[(int)$mes]." del ".$anio;
}
function sagafiltro($n_fil, $area_fil, $vble_fil, $tipo_fil)
{
	$cfiltro=$tipo_fil." (";
	for($i=0; $i<$n_fil; $i++)
	{
		if($i>0){$cfiltro.=" OR ";}
		$cfiltro.=$vble_fil."='".$area_fil[$i]."'";
	}
	$cfiltro.=")";
	return $cfiltro;
}

/**
 * Funcion que muestra la estructura de carpetas a partir de la ruta dada.
 */
function directorios($ruta,$tipo){
    // Se comprueba que realmente sea la ruta de un directorio
    if (is_dir($ruta)){
        // Abre un gestor de directorios para la ruta indicada
        $gestor = opendir($ruta);
        //echo "<ul>";
		$i=0;
        // Recorre todos los elementos del directorio
		if ($tipo==1){
		}
        while (($archivo = readdir($gestor)) !== false)  {
             
            $ruta_completa = $ruta . "/" . $archivo;

            // Se muestran todos los archivos y carpetas excepto "." y ".."
            if ($archivo != "." && $archivo != ".."  && $archivo != "_notes") {
                 $i++;  
				// Si es un directorio se recorre recursivamente
                if (is_dir($ruta_completa)) {
                    echo '<tr><td align="left">'.$i.'</td><td align="left">'.$archivo.'</td>';
					if ($tipo==1){
					echo '<td>
					<form id="restauraform" action="control.php?s='.$_GET[s].'&tipo=32&op=m" method="post">
					<input type="hidden" name="archivo" value="'.$archivo.'"><input type="submit" class="btn btn-skin pull-left" id="cambia_registro" name="cambia_registro" value="Restaurar"></form></td>';
					}else{
					echo'<td align="left"><a  href="backupbd/'.$archivo.'" target="_blank"><img src="img/menu/mostrar2.png" border="0" title="descargar archivo"></a></td></tr>';}
					//echo '<li><a  href="'.$archivo.'" target="_blank">' . $archivo . '</a></li>';
                    //obtener_estructura_directorios($ruta_completa);
                } else {
					echo '<tr><td align="left">'.$i.'</td><td align="left">'.$archivo.'</td>';
					if ($tipo==1){
					echo '<td>
					<form id="restauraform" action="control.php?s='.$_GET[s].'&tipo=32&op=m" method="post">
					<input type="hidden" name="archivo" value="'.$archivo.'"><input type="submit" class="btn btn-skin pull-left" id="cambia_registro" name="cambia_registro" value="Restaurar"></form></td>';	
					}else{
					echo'<td align="left"><a  href="backupbd/'.$archivo.'" target="_blank"><img src="img/menu/mostrar2.png" border="0" title="descargar archivo"></a></td></tr>';}
                   // echo '<li><a  href="'.$archivo.'" target="_blank">' . $archivo . '</a></li>';
                }
            }
        }
		if ($tipo==1){
		}
        
        // Cierra el gestor de directorios
        closedir($gestor);
        //echo "</ul>";
    } else {
        echo "No es una ruta de directorio valida<br/>";
    }
}

?>