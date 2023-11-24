<?php include("includes/header.php")?>
<?php include("db.php")?>

<?php
if(isset($_GET['id'])){
$codigo = $_GET['id'];
$query = "SELECT * FROM tbl_insco_empresas WHERE id = $codigo";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) ==1) {
    $row = mysqli_fetch_array($result);
    $nombres = $row['nombre'];
    $direccion = $row['direccion'];
	$paisnombre = $row['pais'];
	$pais = $row['idpais'];
    }
}
if (isset($_POST['update2'])){
    $codigo = $_GET['id'];
    $nombres = $_POST['nombre'];
    $direccion = $_POST['direccion'];
	$paisnombre = $_POST['pais'];
	$pais = $_POST['idpais'];
    $query = "UPDATE tbl_insco_empresas SET nombres = '$nombres', direccion = '$direccion', pais='$paisnombre',idpais=$pais WHERE codigo = $codigo";
    $result = mysqli_query($conn,$query);
    if (!$result){
        echo "El query de actualizar falló";
    }else{
        ?>
        <script>alert("Registro actualizado");</script>
        <script>
        window.location = "index.php";
        </script>
        <?php 
    }
}
?>
<div class ="card text-center">
        <div class="card-body">
            <h1 class="card-title">ACTUALIZAR DATOS</h1>
            <p class="card-text">Los siguientes son los datos seleccionados para actualizar:</p>
         
            <form action="updateData.php?id=<?php echo $_GET['id']; ?>" method="POST">
            <div class="form-group">
            <input type="text" name="nombres" value="<?php print $nombres;?>"
            class = "form-control" placeholder="Actualizar Nombres">
            </div>
            <div class = "form-group">
            <textarea name="direccion" rows="2" class="form-control" placeholder="Actualizar Direccion"><?php echo $direccion;?></textarea>
            </div>
            <div class="form-group">
            <input type="text" name="pais" clas="form-control" placeholder="Ingrese pais" value="<?php print $paisnombre;?>">
            </div>
            <div class="form-group">
		
			<select name="idpais"clas="form-control">
			<option value="" selected="selected">Selecione Pais</option>
			<?php
			$query = "SELECT * FROM tbl_pais  ORDER BY nombre desc;";
			$result_alumnos = mysqli_query($conn, $query);

                        while($row = mysqli_fetch_array($result_alumnos)){
							if ($row['id']==$pais){
							?>			
	  <option value="<?php echo $row['id']?>" selected="selected"><?php echo $row['nombre']?></option>
						<?php }else {?>
						  <option value="<?php echo $row['id']?>"><?php echo $row['nombre']?></option>
						<?php }
						}?>
	</select>
    
            </div>
            <button class="btn btn-success" name="update2">Actualizar</button>
            </form>
        </div>
    </div>    

<?php include("includes/footer.php")?>
     
    
    