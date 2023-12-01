
<nav class="navbar navbar-light navbar-vertical navbar-expand-xl">
          <script>
            var navbarStyle = localStorage.getItem("navbarStyle");
            if (navbarStyle && navbarStyle !== 'transparent') {
              document.querySelector('.navbar-vertical').classList.add(`navbar-${navbarStyle}`);
            }
          </script>
          <div class="d-flex align-items-center">
            <div class="toggle-icon-wrapper">

              <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-bs-toggle="tooltip" data-bs-placement="left" title=""><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>

            </div><a class="navbar-brand" href="index.html">
              <div class="d-flex align-items-center py-3"><img class="me-2" src="./assets/images/logoS/Logo-marzo-2022-(RGB-web-transparente).png" alt="" width="100" height="auto" /><span class="font-sans-serif"></span>
              </div>
            </a>
          </div>
          <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
  <div class="navbar-vertical-content scrollbar">
    <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
      <ul class="nav collapse show" id="dashboard">
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">
            <div class="d-flex align-items-center">
              <span class="nav-link-text ps-1">Home</span>
            </div>
          </a>
                      <!-- more inner pages-->
                    </li>
                    <?php if ($_SESSION['cursos']!="") {?>
                        <li class="nav-item"><a class="nav-link" href="cursos.php" target="new">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Cursos</span>
                        </div>
                      </a>
                      <!-- more inner pages-->
                    </li>
                    <?php }?>

                    <?php if ($_SESSION['tipo_usuario']=="Alumno") {?>                
                    <li class="nav-item"><a class="nav-link" href="<?php echo $_SESSION['clase_online'];?>">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Video Clase Online</span><span class="badge rounded-pill ms-2 badge-subtle-success">(3)</span>
                        </div>
                      </a>
                      <!-- more inner pages-->
                    </li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $_SESSION['clase_grabada'];?>">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Video Clase Off</span><span class="badge rounded-pill ms-2 badge-subtle-success">(3)</span>
                        </div>
                      </a>
                      <!-- more inner pages-->
                    </li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $_SESSION['notificaciones'];?>">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Notificaciones</span><span class="badge rounded-pill ms-2 badge-subtle-success">(2)</span>
                        </div>
                      </a>
                      <!-- more inner pages-->
                    </li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $_SESSION['calificaciones'];?>">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Calificaciones</span><span class="badge rounded-pill ms-2 badge-subtle-success">(2)</span>
                        </div>
                      </a>
                      <!-- more inner pages-->
                    </li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $_SESSION['encuesta_final'];?>">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Encuesta final</span><span class="badge rounded-pill ms-2 badge-subtle-success">(1)</span>
                        </div>
                      </a>
                      <!-- more inner pages-->
                    </li>            
                    <li class="nav-item"><a class="nav-link" href="<?php echo $_SESSION['certificados'];?>">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Certificado</span><span class="badge rounded-pill ms-2 badge-subtle-success">(1)</span>
                        </div>
                      </a>
                      <!-- more inner pages-->
                    </li>    
                    <!--        
                    <li class="nav-item"><a class="nav-link" href="<?php echo $_SESSION['valoracion'];?>">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Estrellas</span><span class="badge rounded-pill ms-2 badge-subtle-success">(1)</span>
                        </div>
                      </a>
                      
                    </li>     
                    --> 
                  <!--
                    <li class="nav-item"><a class="nav-link" href="inbox_mail.php">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">E-mail</span><span class="badge rounded-pill ms-2 badge-subtle-success">(2)</span>
                        </div>
                      </a>
                      
                    </li>
          -->
                    <li class="nav-item"><a class="nav-link" href="<?php echo  $_SESSION['foros'];?>">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Foros</span>
                        </div>
                      </a>
                      <!-- more inner pages-->
                    </li>
                    <?php }?>
                      <?php if ($_SESSION['tipo_usuario']=="empresa") {?>
                        <li class="nav-item"><a class="nav-link" href="https://cursos.cuyosoft.me/moodle/report/loglive/index_pp.php?id=13" target="new">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Reporte1</span>
                        </div>
                      </a>
                      <!-- more inner pages-->
                    </li>
                    <li class="nav-item"><a class="nav-link" href="https://cursos.cuyosoft.me/moodle/report/outline/index_pp.php?id=13" target="new">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Reporte2</span>
                        </div>
                      </a>
                      <!-- more inner pages-->
                    </li>
                    <li class="nav-item"><a class="nav-link" href="https://cursos.cuyosoft.me/moodle/report/progress/index_pp.php?course=13" target="new">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Reporte3</span>
                        </div>
                      </a>
                      <!-- more inner pages-->
                    </li>
                        <?php }?>
                    <li class="nav-item"><a class="nav-link" href="#">
                        <div class="d-flex align-items-center"><span class="nav-link-text ps-1">Soporte</span>
                        </div>
                      </a>
                      <!-- more inner pages-->
                    </li>

                  </ul>
                  </ul>
                
              
            </div>
          </div>
        </nav>
