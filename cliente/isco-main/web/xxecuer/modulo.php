 <?PHP
//error_reporting(0);
$qtype=3;
require"accion.php";
?>
<div class="body_scroll">
<div class="block-header">
    <div class="row">
        <div class="col-lg-7 col-md-6 col-sm-12">
            <h2>TEST ERRORES</h2>
            <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
        </div>
        <div class="col-lg-5 col-md-6 col-sm-12">                
         </div>
    </div>
</div>

<div class="container-fluid">
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
               <h2><strong>Mis</strong> Test Errores </h2>
                <?PHP if($_GET["op"]=='m') { ?> 
                 <ul class="header-dropdown">
                    <li class="dropdown"> <?php /*?><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                        <ul class="dropdown-menu dropdown-menu-right slideUp">
                            <li><a href="javascript:void(0);">Action</a></li>
                            <li><a href="javascript:void(0);">Another action</a></li>
                            <li><a href="javascript:void(0);">Something else</a></li>
                        </ul><?php */?>
                    </li>
                    <li class="text-white">
                       <?php /*?> <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a><?php */?>
                        <a href="simulacro.php?tipo=<?PHP echo $_GET["tipo"]; ?>&op=n" target="_parent" class="btn btn-success btn-lg float-right right_icon_toggle_btn m-r-20"  title="Crear Test Errores">Agregar<?php /*?><i class="zmdi zmdi-plus text-white" data-toggle="tooltip" title="Crear Test Errores"></i><?php */?></a>
                    </li>
                </ul>
               <?PHP } ?>                   
            </div>
            <div class="body">
<?PHP
if($_GET["op"]=='m')
{
	require"reporte.php";
}
elseif($_GET["op"]=='n')
{
	require"nuevo.php";
}
elseif($_GET["op"]=='e' || isset($_POST["cambia_registro"]))
{
	require"ver.php";
}
elseif($_GET["op"]=='a' || isset($_POST["regresa_reg"]))
{
	//require"asigna.php";
	require"web/xxcmdle/asigna.php";
}
elseif($_GET["op"]=='i')
{
	require"intentos.php";
}
?>
 </div>
        </div>
    </div>
</div>
</div>
</div>