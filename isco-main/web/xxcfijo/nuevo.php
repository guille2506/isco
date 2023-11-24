<?PHP
	error_reporting(0);
	if(($c_tipo_usu==1 || $c_tipo_usu==3) || $c_tipo_usu==5)
	{		
?>
<div class="boxed-grey">
<form id="categories" action="control.php?s=<?PHP echo $_GET[s]; ?>&tipo=5" method="post">
<div class="row">
<div class="col-md-6">
<div class="form-group">
<label for="name">Nombre</label>
<input type="text" class="form-control" id="name" name="name" placeholder="Nombre" required="required" />
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<label for="intro">Descripción</label>
<input type="text" class="form-control" id="intro" name="intro" placeholder="Descripción" required="required" />
</div>
</div>
<div class="col-md-12">
<div class="form-group">
<label for="timelimit">Limite de Tiempo entre Preguntas</label>
<select id="timelimit" name="timelimit" class="form-control" required="required">
<?PHP 
echo"<option value='0' $selected>Sin Tiempo</option>";
	for($i=30; $i<=120; $i++)
	{
		if($tupla[timelimit]==$i)
		{
			$selected="selected='selected'";
		}
		else
		{
			$selected="";
		}
		echo"<option value='$i' $selected>".$i."</option>";
		$i=$i+29;
	}
?>
</select>
</div>
</div>
<div class="form-group">
<input type="submit" class="btn btn-skin pull-right" id="guardar_reg" name="guardar_reg" value="Guardar Registro">
</div>
</div>
</form>
</div>
<?PHP
}
else
{
	require"web/valida.php";
}
?>