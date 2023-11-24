<?PHP
//error_reporting(0);
$qtype=2;
require"accion.php";
?>
<div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>SIMULACRO TEST</h2>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">                
                </div>
            </div>
        </div>

<div class="container-fluid">
<!-- Basic Examples -->
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <div class="header">
                <h2><strong>Mis</strong> Simulacros</h2>
<?PHP if($_GET["op"]=='m') { ?>                
               <?php /*?> <ul class="header-dropdown">
                    <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                        <ul class="dropdown-menu dropdown-menu-right slideUp">
                            <li><a href="javascript:void(0);">Action</a></li>
                            <li><a href="javascript:void(0);">Another action</a></li>
                            <li><a href="javascript:void(0);">Something else</a></li>
                        </ul>
                    </li>
                    <li class="remove">
                        <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                        <a href="modulo.php?op=n" target="_parent" class="boxs-close"><i class="zmdi zmdi-plus" data-toggle="tooltip" title="Agregar"></i></a>
                    </li>
                </ul><?php */?>
<?PHP } ?>                  
            </div>
            <div class="body">
<?PHP
if($_GET["op"]=='m')
{
	require"reporte.php";
}
elseif($_GET["op"]=='e' || isset($_POST["cambia_registro"]))
{
	require"web/xxcmdle/ver.php";
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