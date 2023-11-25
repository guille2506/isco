<?php
include("session.php");
$url = $_SESSION['url'].'v1/index.php/insco_usuario';
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
print_r($res["usuario_insco"]);
echo "</pre>";
die();
*/
   $cuerpo="";
   $i=1;
   foreach($res["usuario_insco"] as $usuario) {
		$tipo_usuario=$usuario["rol"];   
    }   
 }else{
  echo $err;
 }
 $_SESSION['tipo_usuario']=$tipo_usuario;
 if ($tipo_usuario=='Alumno'){
  header("Location: empleados.php");
  }
  if ($tipo_usuario=='empresa'){
    header("Location: empresa.php");
    }
exit();
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
            <div class="card-body px-xxl-0 pt-4">
              <div class="row g-0">
                <div class="col-xxl-3 col-md-6 px-3 text-center border-end-md border-bottom border-bottom-xxl-0 pb-3 p-xxl-0 ps-md-0">
                  <div class="icon-circle icon-circle-primary"><span class="fs-2 fas fa-user-graduate text-primary"></span></div>
                  <h4 class="mb-1 font-sans-serif"><span class="text-700 mx-2" data-countup='{"endValue":"4968"}'>0</span><span class="fw-normal text-600">New Learners</span></h4>
                  <p class="fs--1 fw-semi-bold mb-0">4203 <span class="text-600 fw-normal">last month</span></p>
                </div>
                <div class="col-xxl-3 col-md-6 px-3 text-center border-end-xxl border-bottom border-bottom-xxl-0 pb-3 pt-4 pt-md-0 pe-md-0 p-xxl-0">
                  <div class="icon-circle icon-circle-info"><span class="fs-2 fas fa-chalkboard-teacher text-info"></span></div>
                  <h4 class="mb-1 font-sans-serif"><span class="text-700 mx-2" data-countup='{"endValue":"324"}'>0</span><span class="fw-normal text-600">New Trainers</span></h4>
                  <p class="fs--1 fw-semi-bold mb-0">301 <span class="text-600 fw-normal">last month</span></p>
                </div>
                <div class="col-xxl-3 col-md-6 px-3 text-center border-end-md border-bottom border-bottom-md-0 pb-3 pt-4 p-xxl-0 pb-md-0 ps-md-0">
                  <div class="icon-circle icon-circle-success"><span class="fs-2 fas fa-book-open text-success"></span></div>
                  <h4 class="mb-1 font-sans-serif"><span class="text-700 mx-2" data-countup='{"endValue":"3712"}'>0</span><span class="fw-normal text-600">New Courses</span></h4>
                  <p class="fs--1 fw-semi-bold mb-0">2779 <span class="text-600 fw-normal">last month</span></p>
                </div>
                <div class="col-xxl-3 col-md-6 px-3 text-center pt-4 p-xxl-0 pb-0 pe-md-0">
                  <div class="icon-circle icon-circle-warning"><span class="fs-2 fas fa-dollar-sign text-warning"></span></div>
                  <h4 class="mb-1 font-sans-serif"><span class="text-700 mx-2" data-countup='{"endValue":"1054"}'>0</span><span class="fw-normal text-600">Refunds</span></h4>
                  <p class="fs--1 fw-semi-bold mb-0">1201 <span class="text-600 fw-normal">last month</span></p>
                </div>
              </div>
            </div>
          </div>
          <div class="row g-3 mb-3">
            <div class="col-xxl-4">
              <div class="card h-100">
               
               
                

              </div>
            </div>
            <div class="col-xxl-8">
              <div class="row g-3 h-100">
                <div class="col-md-6">
                  <div class="card font-sans-serif h-100">
                    <div class="card-header pb-0">
                      <h6 class="mb-0">
                        Monthly Revenue Target</h6>
                    </div>
                    <div class="card-body pt-0">
                      <div class="row align-items-end h-100 mb-n1">
                        <div class="col-5 pe-md-0 pe-lg-3">
                          <div class="row g-0">
                            <div class="col-7">
                              <h6 class="text-600">Target:</h6>
                            </div>
                            <div class="col-5">
                              <h6 class="text-800">$1.2M</h6>
                            </div>
                          </div>
                          <div class="row g-0">
                            <div class="col-7">
                              <h6 class="mb-0 text-600">Reached:</h6>
                            </div>
                            <div class="col-5">
                              <h6 class="mb-0 text-800">$823K</h6>
                            </div>
                          </div>
                        </div>
                        <div class="col-7">
                          <div class="lms-half-doughnut mt-n3 ms-auto">
                            <canvas class="pe-none" data-half-doughnut='{"data":{"labels":["Target","Reached"],"datasets":[{"data":[1200000,823000],"backgroundColor":["primary","gray-300"]}]}}'></canvas>
                            <p class="mb-0 mt-n6 text-center fs-1 fw-medium" data-countup='{"endValue":"69","suffix":"%"}'>0</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="card font-sans-serif h-100">
                    <div class="card-header pb-0">
                      <h6 class="mb-0">Monthly Visitor Target</h6>
                    </div>
                    <div class="card-body pt-0">
                      <div class="row align-items-end h-100 mb-n1">
                        <div class="col-5 pe-md-0 pe-lg-3">
                          <div class="row g-0">
                            <div class="col-7">
                              <h6 class="text-600">Target:</h6>
                            </div>
                            <div class="col-5">
                              <h6 class="text-800">$7.5M</h6>
                            </div>
                          </div>
                          <div class="row g-0">
                            <div class="col-7">
                              <h6 class="mb-0 text-600">Reached:</h6>
                            </div>
                            <div class="col-5">
                              <h6 class="mb-0 text-800">$4.8M</h6>
                            </div>
                          </div>
                        </div>
                        <div class="col-7">
                          <div class="lms-half-doughnut mt-n3 ms-auto">
                            <canvas class="pe-none" data-half-doughnut='{"data":{"labels":["Target","Reached"],"datasets":[{"data":[7500000,4800000],"backgroundColor":["info","gray-300"]}]}}'></canvas>
                            <p class="mb-0 mt-n6 text-center fs-1 fw-medium" data-countup='{"endValue":"64","suffix":"%"}'>0</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
              </div>
            </div>
          </div>
          <div class="card overflow-hidden mb-3">
            <div class="card-header p-0 scrollbar">
              <ul class="nav nav-tabs border-0 top-courses-tab flex-nowrap" role="tablist">
                <li class="nav-item" role="presentation"><a class="nav-link p-x1 mb-0 active" role="tab" id="popularPaid-tab" data-bs-toggle="tab" href="#popularPaid" aria-controls="popularPaid" aria-selected="false">
                    <div class="d-flex gap-1 py-1 pe-3">
                      <div class="d-flex flex-column flex-between-center"><span class="fas fa-crown fs--2 text-warning" data-fa-transform="shrink-4"></span><span class="mt-auto fas fa-fire fs-2"></span>
                      </div>
                      <div class="ms-2">
                        <h6 class="mb-1 text-700 fs--2 text-nowrap">Most Popular</h6>
                        <h5 class="mb-0 lh-1">Paid</h5>
                      </div>
                    </div>
                  </a></li>
                <li class="nav-item" role="presentation"><a class="nav-link p-x1 mb-0 false" role="tab" id="popularFree-tab" data-bs-toggle="tab" href="#popularFree" aria-controls="popularFree" aria-selected="true">
                    <div class="d-flex gap-1 py-1 pe-3">
                      <div class="d-flex flex-column flex-between-center"><span class="mt-auto fas fa-fire fs-2"></span>
                      </div>
                      <div class="ms-2">
                        <h6 class="mb-1 text-700 fs--2 text-nowrap">Most Popular</h6>
                        <h5 class="mb-0 lh-1">Free</h5>
                      </div>
                    </div>
                  </a></li>
                <li class="nav-item" role="presentation"><a class="nav-link p-x1 mb-0 false" role="tab" id="topPaid-tab" data-bs-toggle="tab" href="#topPaid" aria-controls="topPaid" aria-selected="false">
                    <div class="d-flex gap-1 py-1 pe-3">
                      <div class="d-flex flex-column flex-between-center"><span class="fas fa-crown fs--2 text-warning" data-fa-transform="shrink-4"></span><span class="mt-auto fas fa-star fs-2"></span>
                      </div>
                      <div class="ms-2">
                        <h6 class="mb-1 text-700 fs--2 text-nowrap">Top Rated</h6>
                        <h5 class="mb-0 lh-1">Paid</h5>
                      </div>
                    </div>
                  </a></li>
                <li class="nav-item" role="presentation"><a class="nav-link p-x1 mb-0 false" role="tab" id="topFree-tab" data-bs-toggle="tab" href="#topFree" aria-controls="topFree" aria-selected="false">
                    <div class="d-flex gap-1 py-1 pe-3">
                      <div class="d-flex flex-column flex-between-center"><span class="mt-auto fas fa-star fs-2"></span>
                      </div>
                      <div class="ms-2">
                        <h6 class="mb-1 text-700 fs--2 text-nowrap">Top Rated</h6>
                        <h5 class="mb-0 lh-1">Free</h5>
                      </div>
                    </div>
                  </a></li>
              </ul>
            </div>
            <div class="card-body p-0">
              <div class="tab-content">
                <div class="tab-pane active" id="popularPaid" role="tabpanel" aria-labelledby="popularPaid-tab">
                  <div class="z-1" id="popularPaidCourses" data-list='{"valueNames":["title","name","published","enrolled","price"],"page":4}'>
                    <div class="px-0 py-0">
                      <div class="table-responsive scrollbar">
                        <table class="table fs--1 mb-0 overflow-hidden">
                          <thead class="bg-light text-900">
                            <tr class="font-sans-serif">
                              <th class="fw-medium sort pe-1 align-middle" data-sort="title">Course Title</th>
                              <th class="fw-medium sort pe-1 align-middle" data-sort="name">Trainer</th>
                              <th class="fw-medium sort pe-1 align-middle text-end" data-sort="published">Published on</th>
                              <th class="fw-medium sort pe-1 align-middle text-end" data-sort="enrolled">Enrolled</th>
                              <th class="fw-medium sort pe-1 align-middle text-end text-end" data-sort="price">Price</th>
                              <th class="fw-medium no-sort pe-1 align-middle data-table-row-action"></th>
                            </tr>
                          </thead>
                          <tbody class="list">
                            <tr class="btn-reveal-trigger fw-semi-bold">
                              <td class="align-middle white-space-nowrap title"><a href="app/e-learning/course/course-details.html">Advanced Design Tools for Modern Designs</a></td>
                              <td class="align-middle text-nowrap name"><a class="text-800" href="app/e-learning/trainer-profile.html">Bill finger</a></td>
                              <td class="align-middle white-space-nowrap text-end published">01/10/21</td>
                              <td class="align-middle text-end enrolled">47,726</td>
                              <td class="align-middle text-end price">$39.99</td>
                              <td class="align-middle white-space-nowrap text-end">
                                <div class="dropstart font-sans-serif position-static d-inline-block">
                                  <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-popularPaidCourses-1" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                  <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-popularPaidCourses-1"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item" href="#!">Refund</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-warning" href="#!">Archive</a><a class="dropdown-item text-danger" href="#!">Delete</a>
                                  </div>
                                </div>
                              </td>
                            </tr>
                            <tr class="btn-reveal-trigger fw-semi-bold">
                              <td class="align-middle white-space-nowrap title"><a href="app/e-learning/course/course-details.html">Photograpy Basics: Get Familiar Standing Behind Lens</a></td>
                              <td class="align-middle text-nowrap name"><a class="text-800" href="app/e-learning/trainer-profile.html">Bruce Timm</a></td>
                              <td class="align-middle white-space-nowrap text-end published">11/12/21</td>
                              <td class="align-middle text-end enrolled">38,541</td>
                              <td class="align-middle text-end price">$19.99</td>
                              <td class="align-middle white-space-nowrap text-end">
                                <div class="dropstart font-sans-serif position-static d-inline-block">
                                  <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-popularPaidCourses-2" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                  <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-popularPaidCourses-2"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item" href="#!">Refund</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-warning" href="#!">Archive</a><a class="dropdown-item text-danger" href="#!">Delete</a>
                                  </div>
                                </div>
                              </td>
                            </tr>
                            <tr class="btn-reveal-trigger fw-semi-bold">
                              <td class="align-middle white-space-nowrap title"><a href="app/e-learning/course/course-details.html">Abstract Painting: Zero to Mastery in Traditional Medium</a></td>
                              <td class="align-middle text-nowrap name"><a class="text-800" href="app/e-learning/trainer-profile.html">J. H. Williams III</a></td>
                              <td class="align-middle white-space-nowrap text-end published">03/09/21</td>
                              <td class="align-middle text-end enrolled">35,666</td>
                              <td class="align-middle text-end price">$45.49</td>
                              <td class="align-middle white-space-nowrap text-end">
                                <div class="dropstart font-sans-serif position-static d-inline-block">
                                  <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-popularPaidCourses-3" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                  <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-popularPaidCourses-3"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item" href="#!">Refund</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-warning" href="#!">Archive</a><a class="dropdown-item text-danger" href="#!">Delete</a>
                                  </div>
                                </div>
                              </td>
                            </tr>
                            <tr class="btn-reveal-trigger fw-semi-bold">
                              <td class="align-middle white-space-nowrap title"><a href="app/e-learning/course/course-details.html">Character Design Masterclass: Your First Supervillain</a></td>
                              <td class="align-middle text-nowrap name"><a class="text-800" href="app/e-learning/trainer-profile.html">Bill finger</a></td>
                              <td class="align-middle white-space-nowrap text-end published">31/12/21</td>
                              <td class="align-middle text-end enrolled">29,988</td>
                              <td class="align-middle text-end price">$99.99</td>
                              <td class="align-middle white-space-nowrap text-end">
                                <div class="dropstart font-sans-serif position-static d-inline-block">
                                  <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-popularPaidCourses-4" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                  <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-popularPaidCourses-4"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item" href="#!">Refund</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-warning" href="#!">Archive</a><a class="dropdown-item text-danger" href="#!">Delete</a>
                                  </div>
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane" id="popularFree" role="tabpanel" aria-labelledby="popularFree-tab">
                  <div class="z-1" id="popularFreeCourses" data-list='{"valueNames":["title","name","published","enrolled","price"],"page":4}'>
                    <div class="px-0 py-0">
                      <div class="table-responsive scrollbar">
                        <table class="table fs--1 mb-0 overflow-hidden">
                          <thead class="bg-light text-900">
                            <tr class="font-sans-serif">
                              <th class="fw-medium sort pe-1 align-middle" data-sort="title">Course Title</th>
                              <th class="fw-medium sort pe-1 align-middle" data-sort="name">Trainer</th>
                              <th class="fw-medium sort pe-1 align-middle text-end" data-sort="published">Published on</th>
                              <th class="fw-medium sort pe-1 align-middle text-end" data-sort="enrolled">Enrolled</th>
                              <th class="fw-medium sort pe-1 align-middle text-end text-end" data-sort="price">Price</th>
                              <th class="fw-medium no-sort pe-1 align-middle data-table-row-action"></th>
                            </tr>
                          </thead>
                          <tbody class="list">
                            <tr class="btn-reveal-trigger fw-semi-bold">
                              <td class="align-middle white-space-nowrap title"><a href="app/e-learning/course/course-details.html">Script Writing Masterclass: Introdution to Industry Cliches</a></td>
                              <td class="align-middle text-nowrap name"><a class="text-800" href="app/e-learning/trainer-profile.html">Bill finger</a></td>
                              <td class="align-middle white-space-nowrap text-end published">31/08/21</td>
                              <td class="align-middle text-end enrolled">92,632</td>
                              <td class="align-middle text-end price">$69.50</td>
                              <td class="align-middle white-space-nowrap text-end">
                                <div class="dropstart font-sans-serif position-static d-inline-block">
                                  <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-popularFreeCourses-1" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                  <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-popularFreeCourses-1"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item" href="#!">Refund</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-warning" href="#!">Archive</a><a class="dropdown-item text-danger" href="#!">Delete</a>
                                  </div>
                                </div>
                              </td>
                            </tr>
                            <tr class="btn-reveal-trigger fw-semi-bold">
                              <td class="align-middle white-space-nowrap title"><a href="app/e-learning/course/course-details.html">Composition in Comics: Easy to Read Between Panels</a></td>
                              <td class="align-middle text-nowrap name"><a class="text-800" href="app/e-learning/trainer-profile.html">Bill finger</a></td>
                              <td class="align-middle white-space-nowrap text-end published">14/05/21</td>
                              <td class="align-middle text-end enrolled">92,603</td>
                              <td class="align-middle text-end price">$39.50</td>
                              <td class="align-middle white-space-nowrap text-end">
                                <div class="dropstart font-sans-serif position-static d-inline-block">
                                  <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-popularFreeCourses-2" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                  <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-popularFreeCourses-2"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item" href="#!">Refund</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-warning" href="#!">Archive</a><a class="dropdown-item text-danger" href="#!">Delete</a>
                                  </div>
                                </div>
                              </td>
                            </tr>
                            <tr class="btn-reveal-trigger fw-semi-bold">
                              <td class="align-middle white-space-nowrap title"><a href="app/e-learning/course/course-details.html">Comic Page Layout: Analysing The Classics</a></td>
                              <td class="align-middle text-nowrap name"><a class="text-800" href="app/e-learning/trainer-profile.html">Bill finger</a></td>
                              <td class="align-middle white-space-nowrap text-end published">09/06/21</td>
                              <td class="align-middle text-end enrolled">32,106</td>
                              <td class="align-middle text-end price">$49.50</td>
                              <td class="align-middle white-space-nowrap text-end">
                                <div class="dropstart font-sans-serif position-static d-inline-block">
                                  <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-popularFreeCourses-3" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                  <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-popularFreeCourses-3"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item" href="#!">Refund</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-warning" href="#!">Archive</a><a class="dropdown-item text-danger" href="#!">Delete</a>
                                  </div>
                                </div>
                              </td>
                            </tr>
                            <tr class="btn-reveal-trigger fw-semi-bold">
                              <td class="align-middle white-space-nowrap title"><a href="app/e-learning/course/course-details.html">Inking: Choosing Between Analog vs Digital</a></td>
                              <td class="align-middle text-nowrap name"><a class="text-800" href="app/e-learning/trainer-profile.html">Bill finger</a></td>
                              <td class="align-middle white-space-nowrap text-end published">09/06/21</td>
                              <td class="align-middle text-end enrolled">9,312</td>
                              <td class="align-middle text-end price">$39.99</td>
                              <td class="align-middle white-space-nowrap text-end">
                                <div class="dropstart font-sans-serif position-static d-inline-block">
                                  <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-popularFreeCourses-4" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                  <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-popularFreeCourses-4"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item" href="#!">Refund</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-warning" href="#!">Archive</a><a class="dropdown-item text-danger" href="#!">Delete</a>
                                  </div>
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane" id="topPaid" role="tabpanel" aria-labelledby="topPaid-tab">
                  <div class="z-1" id="topPaidCourses" data-list='{"valueNames":["title","name","published","enrolled","price"],"page":4}'>
                    <div class="px-0 py-0">
                      <div class="table-responsive scrollbar">
                        <table class="table fs--1 mb-0 overflow-hidden">
                          <thead class="bg-light text-900">
                            <tr class="font-sans-serif">
                              <th class="fw-medium sort pe-1 align-middle" data-sort="title">Course Title</th>
                              <th class="fw-medium sort pe-1 align-middle" data-sort="name">Trainer</th>
                              <th class="fw-medium sort pe-1 align-middle text-end" data-sort="published">Published on</th>
                              <th class="fw-medium sort pe-1 align-middle text-end" data-sort="enrolled">Enrolled</th>
                              <th class="fw-medium sort pe-1 align-middle text-end text-end" data-sort="price">Price</th>
                              <th class="fw-medium no-sort pe-1 align-middle data-table-row-action"></th>
                            </tr>
                          </thead>
                          <tbody class="list">
                            <tr class="btn-reveal-trigger fw-semi-bold">
                              <td class="align-middle white-space-nowrap title"><a href="app/e-learning/course/course-details.html">Character Art School: Character Drawing Course</a></td>
                              <td class="align-middle text-nowrap name"><a class="text-800" href="app/e-learning/trainer-profile.html">Bruce Timm</a></td>
                              <td class="align-middle white-space-nowrap text-end published">01/09/21</td>
                              <td class="align-middle text-end enrolled">3,625</td>
                              <td class="align-middle text-end price">$65.99</td>
                              <td class="align-middle white-space-nowrap text-end">
                                <div class="dropstart font-sans-serif position-static d-inline-block">
                                  <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-topPaidCourses-1" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                  <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-topPaidCourses-1"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item" href="#!">Refund</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-warning" href="#!">Archive</a><a class="dropdown-item text-danger" href="#!">Delete</a>
                                  </div>
                                </div>
                              </td>
                            </tr>
                            <tr class="btn-reveal-trigger fw-semi-bold">
                              <td class="align-middle white-space-nowrap title"><a href="app/e-learning/course/course-details.html">User Experience Design Essentials</a></td>
                              <td class="align-middle text-nowrap name"><a class="text-800" href="app/e-learning/trainer-profile.html">Bill finger</a></td>
                              <td class="align-middle white-space-nowrap text-end published">15/12/21</td>
                              <td class="align-middle text-end enrolled">1,202</td>
                              <td class="align-middle text-end price">$25.20</td>
                              <td class="align-middle white-space-nowrap text-end">
                                <div class="dropstart font-sans-serif position-static d-inline-block">
                                  <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-topPaidCourses-2" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                  <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-topPaidCourses-2"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item" href="#!">Refund</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-warning" href="#!">Archive</a><a class="dropdown-item text-danger" href="#!">Delete</a>
                                  </div>
                                </div>
                              </td>
                            </tr>
                            <tr class="btn-reveal-trigger fw-semi-bold">
                              <td class="align-middle white-space-nowrap title"><a href="app/e-learning/course/course-details.html">The Art &amp; Science of Drawing</a></td>
                              <td class="align-middle text-nowrap name"><a class="text-800" href="app/e-learning/trainer-profile.html">J. H. Williams III</a></td>
                              <td class="align-middle white-space-nowrap text-end published">03/09/21</td>
                              <td class="align-middle text-end enrolled">35,666</td>
                              <td class="align-middle text-end price">$45.49</td>
                              <td class="align-middle white-space-nowrap text-end">
                                <div class="dropstart font-sans-serif position-static d-inline-block">
                                  <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-topPaidCourses-3" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                  <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-topPaidCourses-3"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item" href="#!">Refund</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-warning" href="#!">Archive</a><a class="dropdown-item text-danger" href="#!">Delete</a>
                                  </div>
                                </div>
                              </td>
                            </tr>
                            <tr class="btn-reveal-trigger fw-semi-bold">
                              <td class="align-middle white-space-nowrap title"><a href="app/e-learning/course/course-details.html">Abstract Painting: One-to-One</a></td>
                              <td class="align-middle text-nowrap name"><a class="text-800" href="app/e-learning/trainer-profile.html">Bill finger</a></td>
                              <td class="align-middle white-space-nowrap text-end published">03/09/21</td>
                              <td class="align-middle text-end enrolled">6,356</td>
                              <td class="align-middle text-end price">$20.49</td>
                              <td class="align-middle white-space-nowrap text-end">
                                <div class="dropstart font-sans-serif position-static d-inline-block">
                                  <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-topPaidCourses-4" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                  <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-topPaidCourses-4"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item" href="#!">Refund</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-warning" href="#!">Archive</a><a class="dropdown-item text-danger" href="#!">Delete</a>
                                  </div>
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane" id="topFree" role="tabpanel" aria-labelledby="topFree-tab">
                  <div class="z-1" id="topFreeCourses" data-list='{"valueNames":["title","name","published","enrolled","price"],"page":4}'>
                    <div class="px-0 py-0">
                      <div class="table-responsive scrollbar">
                        <table class="table fs--1 mb-0 overflow-hidden">
                          <thead class="bg-light text-900">
                            <tr class="font-sans-serif">
                              <th class="fw-medium sort pe-1 align-middle" data-sort="title">Course Title</th>
                              <th class="fw-medium sort pe-1 align-middle" data-sort="name">Trainer</th>
                              <th class="fw-medium sort pe-1 align-middle text-end" data-sort="published">Published on</th>
                              <th class="fw-medium sort pe-1 align-middle text-end" data-sort="enrolled">Enrolled</th>
                              <th class="fw-medium sort pe-1 align-middle text-end text-end" data-sort="price">Price</th>
                              <th class="fw-medium no-sort pe-1 align-middle data-table-row-action"></th>
                            </tr>
                          </thead>
                          <tbody class="list">
                            <tr class="btn-reveal-trigger fw-semi-bold">
                              <td class="align-middle white-space-nowrap title"><a href="app/e-learning/course/course-details.html">Portrait Drawing Fundamentals Made Simple</a></td>
                              <td class="align-middle text-nowrap name"><a class="text-800" href="app/e-learning/trainer-profile.html">Bill finger</a></td>
                              <td class="align-middle white-space-nowrap text-end published">05/10/20</td>
                              <td class="align-middle text-end enrolled">10,356</td>
                              <td class="align-middle text-end price">$36.49</td>
                              <td class="align-middle white-space-nowrap text-end">
                                <div class="dropstart font-sans-serif position-static d-inline-block">
                                  <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-topFreeCourses-1" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                  <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-topFreeCourses-1"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item" href="#!">Refund</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-warning" href="#!">Archive</a><a class="dropdown-item text-danger" href="#!">Delete</a>
                                  </div>
                                </div>
                              </td>
                            </tr>
                            <tr class="btn-reveal-trigger fw-semi-bold">
                              <td class="align-middle white-space-nowrap title"><a href="app/e-learning/course/course-details.html">Anatomy for Figure Drawing</a></td>
                              <td class="align-middle text-nowrap name"><a class="text-800" href="app/e-learning/trainer-profile.html">J. H. Williams</a></td>
                              <td class="align-middle white-space-nowrap text-end published">26/10/20</td>
                              <td class="align-middle text-end enrolled">12,386</td>
                              <td class="align-middle text-end price">$30.99</td>
                              <td class="align-middle white-space-nowrap text-end">
                                <div class="dropstart font-sans-serif position-static d-inline-block">
                                  <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-topFreeCourses-2" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                  <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-topFreeCourses-2"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item" href="#!">Refund</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-warning" href="#!">Archive</a><a class="dropdown-item text-danger" href="#!">Delete</a>
                                  </div>
                                </div>
                              </td>
                            </tr>
                            <tr class="btn-reveal-trigger fw-semi-bold">
                              <td class="align-middle white-space-nowrap title"><a href="app/e-learning/course/course-details.html">Complete Perspective Drawing Course</a></td>
                              <td class="align-middle text-nowrap name"><a class="text-800" href="app/e-learning/trainer-profile.html">Bruce Timm</a></td>
                              <td class="align-middle white-space-nowrap text-end published">26/09/21</td>
                              <td class="align-middle text-end enrolled">6,757</td>
                              <td class="align-middle text-end price">$23.99</td>
                              <td class="align-middle white-space-nowrap text-end">
                                <div class="dropstart font-sans-serif position-static d-inline-block">
                                  <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-topFreeCourses-3" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                  <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-topFreeCourses-3"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item" href="#!">Refund</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-warning" href="#!">Archive</a><a class="dropdown-item text-danger" href="#!">Delete</a>
                                  </div>
                                </div>
                              </td>
                            </tr>
                            <tr class="btn-reveal-trigger fw-semi-bold">
                              <td class="align-middle white-space-nowrap title"><a href="app/e-learning/course/course-details.html">The Ultimate Animal Drawing Course</a></td>
                              <td class="align-middle text-nowrap name"><a class="text-800" href="app/e-learning/trainer-profile.html">Bruce Timm</a></td>
                              <td class="align-middle white-space-nowrap text-end published">06/12/21</td>
                              <td class="align-middle text-end enrolled">7,658</td>
                              <td class="align-middle text-end price">$19.99</td>
                              <td class="align-middle white-space-nowrap text-end">
                                <div class="dropstart font-sans-serif position-static d-inline-block">
                                  <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal float-end" type="button" id="dropdown-topFreeCourses-4" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent"><span class="fas fa-ellipsis-h fs--1"></span></button>
                                  <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="dropdown-topFreeCourses-4"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Edit</a><a class="dropdown-item" href="#!">Refund</a>
                                    <div class="dropdown-divider"></div><a class="dropdown-item text-warning" href="#!">Archive</a><a class="dropdown-item text-danger" href="#!">Delete</a>
                                  </div>
                                </div>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer bg-light py-2">
              <div class="row flex-between-center g-0">
                <div class="col-auto">
                  <select class="form-select form-select-sm">
                    <option value="week" selected="selected">Last 7 days</option>
                    <option value="month">Last month</option>
                  </select>
                </div>
                <div class="col-auto"><a class="btn btn-link btn-sm px-0 fw-medium" href="app/e-learning/course/course-list.html">All Courses<span class="fas fa-chevron-right ms-1 fs--2"></span></a></div>
              </div>
            </div>
          </div>
          <div class="row g-3 mb-3">
            <div class="col-lg-6 col-xxl-7">
              <div class="card" id="LmsUserByLocationTable" data-list='{"valueNames":["country","users","revenue","native-support"],"page":4}'>
                <div class="card-header d-flex flex-between-center bg-light py-2">
                  <h6 class="mb-0">User Location</h6>
                  <div class="dropdown font-sans-serif btn-reveal-trigger">
                    <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal" type="button" id="lms-user-by-location" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--2"></span></button>
                    <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="lms-user-by-location"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                      <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#!">Remove</a>
                    </div>
                  </div>
                </div>
                <div class="card-body pb-0 position-relative">
                  <!-- Find the JS file for the following chart at: src/js/charts/echarts/user-by-location-lms.js-->
                  <!-- If you are not using gulp based workflow, you can find the transpiled code at: public/assets/js/theme.js-->
                  <div class="echart-user-by-location-map" data-echart-responsive="true" style="height:302px;"></div>
                  <div class="position-absolute top-0 border mt-3 border-200 rounded-3 bg-light">
                    <button class="btn btn-link btn-sm bg-100 rounded-bottom-0 px-2 user-by-location-map-zoom text-700" type="button"><span class="fas fa-plus fs--1"></span></button>
                    <hr class="text-200 m-0" />
                    <button class="btn btn-link btn-sm bg-100 rounded-top-0 px-2 user-by-location-map-zoomOut text-700" type="button"><span class="fas fa-minus fs--1"></span></button>
                  </div>
                  <div class="mt-3">
                    <div class="bar-indicator-gradient mb-1"></div>
                    <div class="d-flex flex-between-center fs--2">
                      <p class="mb-0">less than 1k</p>
                      <p class="mb-0">more than 100k</p>
                    </div>
                  </div>
                  <div class="table-responsive scrollbar mx-nx1 mt-3">
                    <table class="table fs--1 mb-0">
                      <thead class="bg-light text-800">
                        <tr class="font-sans-serif">
                          <th class="sort" data-sort="country" style="width: 40%">Country</th>
                          <th class="sort text-end" data-sort="users">User Count</th>
                          <th class="sort text-end" data-sort="revenue">Revenue</th>
                          <th class="sort text-end w-25" data-sort="native-support">Language Support</th>
                        </tr>
                      </thead>
                      <tbody class="list">
                        <tr class="fw-semi-bold">
                          <td class="align-middle py-3"><a href="#!">
                              <p class="mb-0 text-primary country">Bahrain</p>
                            </a></td>
                          <td class="align-middle text-end users">900</td>
                          <td class="align-middle text-end revenue">$3997</td>
                          <td class="align-middle pe-x1 text-end native-support"><span class="badge badge rounded-pill fw-medium fs--2 badge-subtle-danger">Unavailable</span>
                          </td>
                        </tr>
                        <tr class="fw-semi-bold">
                          <td class="align-middle py-3"><a href="#!">
                              <p class="mb-0 text-primary country">Bangladesh</p>
                            </a></td>
                          <td class="align-middle text-end users">123k</td>
                          <td class="align-middle text-end revenue">$6700</td>
                          <td class="align-middle pe-x1 text-end native-support"><span class="badge badge rounded-pill fw-medium fs--2 badge-subtle-warning">Early Beta</span>
                          </td>
                        </tr>
                        <tr class="fw-semi-bold">
                          <td class="align-middle py-3"><a href="#!">
                              <p class="mb-0 text-primary country">Belarus</p>
                            </a></td>
                          <td class="align-middle text-end users">6.5k</td>
                          <td class="align-middle text-end revenue">$5949</td>
                          <td class="align-middle pe-x1 text-end native-support"><span class="badge badge rounded-pill fw-medium fs--2 badge-subtle-danger">Unavailable</span>
                          </td>
                        </tr>
                        <tr class="fw-semi-bold">
                          <td class="align-middle py-3"><a href="#!">
                              <p class="mb-0 text-primary country">Belgium</p>
                            </a></td>
                          <td class="align-middle text-end users">27k</td>
                          <td class="align-middle text-end revenue">$73000</td>
                          <td class="align-middle pe-x1 text-end native-support"><span class="badge badge rounded-pill fw-medium fs--2 badge-subtle-success">Available</span>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="card-footer bg-light text-end py-2"><a class="btn btn-link btn-sm px-0 fw-medium" href="#!">View all<span class="fas fa-chevron-right ms-1 fs--2"></span></a></div>
              </div>
            </div>
            <div class="col-lg-6 col-xxl-5">
              <div class="card h-100">
                <div class="card-header bg-light d-flex flex-between-center py-2">
                  <h6 class="mb-0">Marketing Expenses</h6>
                  <div class="ms-auto"><a class="btn btn-link btn-sm px-0 fw-medium" href="#!">Full Report<span class="fas fa-external-link-alt ms-1 fs--2"></span></a></div>
                </div>
                <div class="card-body d-flex flex-column justify-content-between">
                  <div class="position-relative">
                    <!-- Find the JS file for the following chart at: src/js/charts/echarts/marketing-expenses.js-->
                    <!-- If you are not using gulp based workflow, you can find the transpiled code at: public/assets/js/theme.js-->
                    <div class="echart-marketing-expenses" data-echart-responsive="true"></div>
                    <div class="absolute-centered">
                      <div class="rounded-circle d-flex flex-center marketing-exp-circle">
                        <h4 class="mb-0 text-900">$1.1M</h4>
                      </div>
                    </div>
                  </div>
                  <div class="row g-3 font-sans-serif">
                    <div class="col-sm-6">
                      <div class="rounded-3 border p-3">
                        <div class="d-flex align-items-center mb-4"><span class="dot bg-info bg-opacity-25"></span>
                          <h6 class="mb-0 fw-bold">Digital Marketing</h6>
                        </div>
                        <ul class="list-unstyled mb-0">
                          <li class="d-flex align-items-center fs--2 fw-medium pt-1 mb-3"><span class="dot bg-info bg-opacity-100"></span>
                            <p class="lh-sm mb-0 text-700">Generate Backlinks<span class="text-900 ps-2">$91.6k</span></p>
                          </li>
                          <li class="d-flex align-items-center fs--2 fw-medium pt-1 mb-3"><span class="dot bg-info bg-opacity-75"></span>
                            <p class="lh-sm mb-0 text-700">Email Marketing<span class="text-900 ps-2">$183k</span></p>
                          </li>
                          <li class="d-flex align-items-center fs--2 fw-medium pt-1 mb-3"><span class="dot bg-info bg-opacity-50"></span>
                            <p class="lh-sm mb-0 text-700">Influencer Marketing<span class="text-900 ps-2">$138k</span></p>
                          </li>
                          <li class="d-flex align-items-center fs--2 fw-medium pt-1 mb-3"><span class="dot bg-info bg-opacity-25"></span>
                            <p class="lh-sm mb-0 text-700">Google Ads<span class="text-900 ps-2">$45.9k</span></p>
                          </li>
                          <li class="d-flex align-items-center fs--2 fw-medium pt-1 false"><span class="dot bg-info bg-opacity-10"></span>
                            <p class="lh-sm mb-0 text-700">Social Media<span class="text-900 ps-2">$183k</span></p>
                          </li>
                        </ul>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="rounded-3 border p-3 h-100">
                        <div class="d-flex align-items-center mb-4"><span class="dot bg-primary"></span>
                          <h6 class="mb-0 fw-bold">Offline Marketing</h6>
                        </div>
                        <ul class="list-unstyled mb-0">
                          <li class="d-flex align-items-center fs--2 fw-medium pt-1 mb-3"><span class="dot bg-primary bg-opacity-75"></span>
                            <p class="lh-sm mb-0 text-700">Event Sponsorship<span class="text-900 ps-2">$91.6k</span></p>
                          </li>
                          <li class="d-flex align-items-center fs--2 fw-medium pt-1 mb-3"><span class="dot bg-primary bg-opacity-50"></span>
                            <p class="lh-sm mb-0 text-700">Outrich Event<span class="text-900 ps-2">$183k</span></p>
                          </li>
                          <li class="d-flex align-items-center fs--2 fw-medium pt-1"><span class="dot bg-primary bg-opacity-25"></span>
                            <p class="lh-sm mb-0 text-700">Ad Campaign<span class="text-900 ps-2">$138k</span></p>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer bg-light py-2 d-flex">
                  <div class="ms-auto">
                    <select class="form-select form-select-sm">
                      <option value="3months" selected="selected">Last 3 months</option>
                      <option value="1month">Last month</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row g-3">
            <div class="col-lg-6 col-xxl-5">
              <div class="card h-100">
                <div class="card-header bg-light d-flex flex-between-center py-2">
                  <h6 class="mb-0">Weekly Goal</h6>
                  <div class="dropdown font-sans-serif btn-reveal-trigger">
                    <button class="btn btn-link text-600 btn-sm dropdown-toggle dropdown-caret-none btn-reveal" type="button" id="lms-weekly-goal" data-bs-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h fs--2"></span></button>
                    <div class="dropdown-menu dropdown-menu-end border py-2" aria-labelledby="lms-weekly-goal"><a class="dropdown-item" href="#!">View</a><a class="dropdown-item" href="#!">Export</a>
                      <div class="dropdown-divider"></div><a class="dropdown-item text-danger" href="#!">Remove</a>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-sm-4">
                      <div class="pb-3 mb-3 border-bottom border-200">
                        <div class="position-relative ps-3">
                          <div class="position-absolute h-100 start-0 rounded bg-info" style="width: 4px;"></div>
                          <h6 class="fs--2 text-600 mb-1">Site Visit</h6>
                          <div class="d-flex align-items-center">
                            <h5 class="fs-2 text-700 mb-0 me-2" data-countup='{"endValue":79,"suffix":"%"}'>0</h5><span class="badge rounded-pill fs--2 fw-medium badge-subtle-success"><span class="fas fa-check"></span> On par</span>
                          </div>
                        </div>
                      </div>
                      <div class="pb-3 mb-3 border-bottom border-200">
                        <div class="position-relative ps-3">
                          <div class="position-absolute h-100 start-0 rounded bg-primary" style="width: 4px;"></div>
                          <h6 class="fs--2 text-600 mb-1">Support</h6>
                          <div class="d-flex align-items-center">
                            <h5 class="fs-2 text-700 mb-0 me-2" data-countup='{"endValue":85,"suffix":"%"}'>0</h5><span class="badge rounded-pill fs--2 fw-medium badge-subtle-primary"><span class="fas fa-caret-up"></span> Ahead</span>
                          </div>
                        </div>
                      </div>
                      <div>
                        <div class="position-relative ps-3">
                          <div class="position-absolute h-100 start-0 rounded bg-success" style="width: 4px;"></div>
                          <h6 class="fs--2 text-600 mb-1">Revenue</h6>
                          <div class="d-flex align-items-center">
                            <h5 class="fs-2 text-700 mb-0 me-2" data-countup='{"endValue":70,"suffix":"%"}'>0</h5><span class="badge rounded-pill fs--2 fw-medium badge-subtle-danger"><span class="fas fa-caret-down"></span> Behind</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-8 h-100">
                      <!-- Find the JS file for the following chart at: src/js/charts/echarts/weekly-goals-lms.js-->
                      <!-- If you are not using gulp based workflow, you can find the transpiled code at: public/assets/js/theme.js-->
                      <div class="echart-weekly-goals-lms" data-echart-responsive="true"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-xxl-7">
              <div class="card h-100">
                <div class="card-header bg-light d-flex flex-between-center py-2">
                  <h6 class="mb-0">Course Enrollment</h6>
                  <div class="ms-auto">
                    <select class="form-select form-select-sm">
                      <option value="week" selected="selected">Last 7 days</option>
                      <option value="month">Last month</option>
                    </select>
                  </div>
                </div>
                <div class="card-body">
                  <!-- Find the JS file for the following chart at: src/js/charts/echarts/course-enrollments.js-->
                  <!-- If you are not using gulp based workflow, you can find the transpiled code at: public/assets/js/theme.js-->
                  <div class="echart-bar-course-enrollments" data-echart-responsive="true"></div>
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