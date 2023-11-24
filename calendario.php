<?php
//SELECT * FROM `mdl_googlemeet` 
//SELECT * FROM `mdl_googlemeet_events` 
//  googlemeetid 	
/*
select s.name,ss.duration,FROM_UNIXTIME(ss.starttime) as fecha,FROM_UNIXTIME(ss.starttime,'%d') as dia,FROM_UNIXTIME(ss.starttime,'%H:%i') as hora,ss.notes
          from mdl_googlemeet s, mdl_googlemeet_events ss 
          where 
              s.id=ss.googlemeetid and 
              s.course=".$param['curso']. " order by ss.eventdate asc

              select name,url,FROM_UNIXTIME(ss.eventdate) as fecha,FROM_UNIXTIME(ss.eventdate,'%H:%i') as hora
          from mdl_googlemeet s, mdl_googlemeet_events ss 
          where 
              s.id=ss.googlemeetid and 
              s.course=10 order by ss.eventdate asc;
*/	
include("session.php");
$_SESSION['url_app_home']="https://cursos.cuyosoft.me/cliente/dashboard.php";
$url = $_SESSION['url'].'v1/index.php/gesinpol_empleadox1';
//var_dump($urlexternos);
$header = [
  'Accept: application/json',
  'Content-Type: application/x-www-form-urlencoded',
  'Authorization: 3d524a53c110e4c22463b10ed32cef9d',
]; 
$parametros="usuario=".$_SESSION['idmoodle'];
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
   
   //var_dump ($res['usuarios']);
/*
echo "<pre>";
print_r($res["empleado"]);
echo "</pre>";
*/
   $cuerpo="";
   $i=1;
   foreach($res["empleado"] as $usuario) {
		$empleado=$usuario["nombre"];
    $empresa=$usuario["empresa"]; 
    }   
 }else{
  echo $err;
 }
//2--- EMPRESA
$url = $_SESSION['url'].'v1/index.php/gesinpol_empresax1';
$parametros="empresa=".$empresa;
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
   
   //var_dump ($res['usuarios']);
/*
echo "<pre>";
print_r($res["empleados"]);
echo "</pre>";
*/
   $cuerpo="";   
     foreach($res['empresa'] as $empresa) {
         $empresa = $empresa['nombre'];        
         
      }
 }else{
  echo $err;
 }
 //3
 // obtener los cursos contratados por la empresa
$url = $_SESSION['url'].'v1/index.php/gesinpol_empleado_cursos';
$parametros="empleado=".$_SESSION['idmoodle'];
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
   
   //var_dump ($res['usuarios']);
/*
echo "<pre>";
print_r($res["cursos"]);
echo "</pre>";
*/
   $cuerpo="";
   $i=1;
   foreach($res["cursos"] as $usuario) {
		$curso=$usuario["fullname"];
   
	   
    }   
 }else{
  echo $err;
 }
 // obtener calendario
 // obtener los cursos contratados por la empresa
$url = $_SESSION['url'].'v1/index.php/insco_planificacion_cursox1';
$parametros="curso=".$_SESSION['curso'];
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
$res_calendario    = json_decode($result, true);

$err = curl_error($ch);
curl_close($ch);
if (!$err)
 {
   
   //var_dump ($res['usuarios']);
/*
echo "<pre>";
print_r($res_calendario["videoclase"]);
echo "</pre>";
*/
   $cuerpo="";
   $i=1;
   //echo "total" .count($res_calendario["videoclase"]);
   $total=$res_calendario["videoclase"];
 }else{
  echo $err;
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
    <link href="vendors/leaflet/leaflet.css" rel="stylesheet">
    <link href="vendors/leaflet.markercluster/MarkerCluster.css" rel="stylesheet">
    <link href="vendors/leaflet.markercluster/MarkerCluster.Default.css" rel="stylesheet">
    <link href="vendors/fullcalendar/main.min.css" rel="stylesheet">
    <link href="vendors/flatpickr/flatpickr.min.css" rel="stylesheet">
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
	<!-- calendario-->
	<script type="text/javascript" src="assets/CalenStyle/js/jquery-1.11.1.min.js"></script>
		<script type="text/javascript" src="assets/CalenStyle/js/jquery-ui-custom-1.11.2.min.js"></script>
    	<link rel="stylesheet" type="text/css" href="assets/CalenStyle/css/jquery-ui-custom-1.11.2.min.css" />
    	    
		<link rel="stylesheet" type="text/css" href="assets/CalenStyle/src/calenstyle.css" />
		<link rel="stylesheet" type="text/css" href="assets/CalenStyle/src/calenstyle-jquery-ui-override.css" />
		<link rel="stylesheet" type="text/css" href="assets/CalenStyle/src/calenstyle-iconfont.css" />
		<script type="text/javascript" src="assets/CalenStyle/src/calenstyle.js"></script>
	
		<script type="text/javascript" src="assets/CalenStyle/js/CalJsonGenerator.js"></script>
	
		<style type="text/css">
		
			.calendarContOuter
			{
            	width: 90%;
				height: 600px;
				margin: 0px auto;
            
				font-size: 14px;
			}
			
			.cElemDatePicker
			{
				font-size: 14px;
			}

			.cActionBar
			{
				line-height: 30px;
				background: #F5F5F5;
			}
		
			.reload
			{
				margin-left: 10px;
				padding: 3px 5px;
				border-radius: 2px;
				background: #444444;
                font-size: 80%;
                color: #FFFFFF;

				cursor: pointer;
			}
		
		</style>
	
		<script type="text/javascript">
		
			$(function() 
			{
                
				$(".calendarContOuter").CalenStyle(
				{
				
					sectionsList: ["Header", "ActionBar", "Calendar"],
				
					visibleView: "DetailedMonthView",

					calDataSource: 
					[
					    {
					        sourceFetchType: "ALL",
					        sourceType: "JSON",						
					        source: {

   
  
						        eventSource: [
                      <?php
                  $item=0;    
foreach($res_calendario["videoclase"] as $usuario) {
  $item=$item +1;
  $id=$usuario["id"];
  $name=$usuario["name"];
  $fecha=$usuario["fecha"];
  $hora=$usuario["hora"];
  $hora_end="02:00";
  $url=$usuario["url"];
 ?>
						        	{
						              "identifier": "<?php echo $id;?>", 
						              "isAllDay": false, 
						              "start": "<?php echo $fecha;?> <?php echo $hora;?>",
						              "end": "<?php echo $fecha;?> <?php echo $hora_end;?>",
						              "calendar": "Meeting", 
						              "tag": "Work",
						              "title": "<?php echo $name;?>", 
						              "description": "", 
						              "url": "<?php echo $url;?>", 

						              "icon": "cs-icon-Meeting", 
						              "color": "20DAEC", 
						              "borderColor": "000000", 
						              "textColor": "000000",
						              "nonAllDayEventsTextColor": "000000",

						              "isDragNDropInMonthView": true, 
						              "isDragNDropInDetailView": true, 
						              "isResizeInDetailView": true 
						            }
                        <?php                         
                        if ($item < $total){ echo ", ";}else{ echo " ";}
                      }?>
						        ]
						    }
					        
					    }
					],
				
					modifyActionBarView: function(actionBar, visibleViewName)
					{
						var thisObj = this;
					
						$(actionBar).empty();
						$(actionBar).append("<span class='reload'>Reload</span>");
						$(".reload").click(function()
						{
							thisObj.reloadData();
						});
					}
				
				});
				
			});
		
		</script>
	
	</head>
	<!-- end calendario -->
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
                <a class="dropdown-item" href="<?php echo $_SESSION['url_app_home'];?>">
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
                  <h3>Empleado: <?php echo $empleado;?></h3>
                  <p class="mb-0">Calendario con las video clases online / offline.</p><a class="btn btn-link btn-sm ps-0 mt-2" href="https://getbootstrap.com/docs/5.3/content/tables/" target="_blank">Ver Perfil<span class="fas fa-chevron-right ms-1 fs--2"></span></a>
                </div>
              </div>
            </div>
          </div>

          <div class="card mb-3">
            <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(assets/img/icons/spot-illustrations/corner-4.png);">
            </div>
            <!--/.bg-holder-->

            <div class="card-body position-relative">
              <div class="row">
                <div class="col-lg-8">
                  <h3>Empresa: <?php echo $empresa;?></h3>
                  <p class="mb-0">Calendario con las video clases online / offline.</p>
                </div>
              </div>
            </div>
          </div>
		  <div class="card mb-3">
            <div class="bg-holder d-none d-lg-block bg-card" style="background-image:url(assets/img/icons/spot-illustrations/corner-4.png);">
            </div>
            <!--/.bg-holder-->

            <div class="card-body position-relative">
              <div class="row">
                <div class="col-lg-12">
                  <div class="calendarContOuter"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="card mb-3"><br/><br/><br/><br/><br/><br/><br/><br/><br/></div>
          

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
    <!--
    <script src="vendors/popper/popper.min.js"></script>
    <script src="vendors/bootstrap/bootstrap.min.js"></script>
    <script src="vendors/anchorjs/anchor.min.js"></script>
    <script src="vendors/is/is.min.js"></script>
    <script src="vendors/glightbox/glightbox.min.js"></script>
    <script src="vendors/echarts/echarts.min.js"></script>
    <script src="vendors/fontawesome/all.min.js"></script>
    <script src="vendors/lodash/lodash.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="vendors/list.js/list.min.js"></script>
    <script src="vendors/fullcalendar/main.min.js"></script>
    <script src="assets/js/flatpickr.js"></script>
    <script src="vendors/dayjs/dayjs.min.js"></script>
    <script src="assets/js/theme.js"></script>
          -->
    <script src="vendors/popper/popper.min.js"></script>
    <script src="vendors/bootstrap/bootstrap.min.js"></script>
    <script src="vendors/anchorjs/anchor.min.js"></script>
    <script src="vendors/is/is.min.js"></script>
    <script src="vendors/chart/chart.min.js"></script>
    <script src="vendors/leaflet/leaflet.js"></script>
    <script src="vendors/leaflet.markercluster/leaflet.markercluster.js"></script>
    <script src="vendors/leaflet.tilelayer.colorfilter/leaflet-tilelayer-colorfilter.min.js"></script>
    <script src="vendors/countup/countUp.umd.js"></script>
    <script src="vendors/echarts/echarts.min.js"></script>
    <script src="vendors/fullcalendar/main.min.js"></script>
    <script src="assets/js/flatpickr.js"></script>
    <script src="vendors/dayjs/dayjs.min.js"></script>
    <script src="vendors/fontawesome/all.min.js"></script>
    <script src="vendors/lodash/lodash.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="vendors/list.js/list.min.js"></script>
    <script src="assets/js/theme.js"></script>
  </body>

</html>
