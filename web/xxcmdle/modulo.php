<?PHP
//error_reporting(0);
$qtype=4;
require"accion.php";
?>
<div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>TEST</h2>
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
                <h2><strong>Mis</strong> Test</h2>
            </div>
            <div class="body">
<?PHP
if($_GET["op"]=='m')
{
	require"reporte.php";
}
elseif($_GET["op"]=='e' || isset($_POST["cambia_registro"]))
{
	require"ver.php";
}
elseif($_GET["op"]=='a' || isset($_POST["regresa_reg"]))
{
	require"asigna.php";
}
elseif($_GET["op"]=='i')
{
	require"intentos.php";
}
?>
        </div>

</div>