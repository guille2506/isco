<?php include("includes/header.php")?>
<?php include("db.php")?>

<?php
if(isset($_GET['id'])){
$codigo = $_GET['id'];
$query = "SELECT * FROM tbl_insco_empresas WHERE id = $codigo";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) ==1) {
    $row = mysqli_fetch_array($result);
    $nombre = $row['nombre'];
    $cif = $row['cif'];
    $direccion = $row['direccion'];
	$email = $row['email'];
    $telefono = $row['telefono'];
	$logo = $row['logo'];
    $idmoodle = $row['idmoodle'];
    }
}
if (isset($_POST['update2'])){
    $codigo = $_GET['id'];
    $nombre = $_POST['nombre'];
    $cif = $_POST['cif'];
    $direccion = $_POST['direccion'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
	$logo = $_POST['logo'];
    $idmoodle = $_POST['idmoodle'];
    $query = "UPDATE tbl_insco_empresas SET nombre = '$nombre', direccion = '$direccion', email='$email',telefono='$telefono',cif='$cif',logo='$logo',idmoodle='$idmoodle' WHERE id = $codigo";
    //echo $query ;
    $result = mysqli_query($conn,$query);
    if (!$result){
        echo "El query de actualizar falló";
    }else{
        ?>
        <script>alert("Registro actualizado");</script>
        <script>
        window.location = "empresas.php";
        </script>
        <?php 
    }
}
?>
<div class ="card text-center">
        <div class="card-body">
            <h1 class="card-title">ACTUALIZAR DATOS</h1>
            <p class="card-text">Los siguientes son los datos seleccionados para actualizar:</p>
         
            <form action="update_empresa.php?id=<?php echo $_GET['id']; ?>" method="POST">
            <div class="form-group">
            Nombre:    
            <input type="text" name="nombre" value="<?php print trim($nombre);?>"
            class = "form-control" >
            </div>
            <div class="form-group">
            cif:    
            <input type="text" name="cif" clas="form-control"  value="<?php print $cif;?>">
            </div>
            <div class="form-group">
            <input type="text" name="direccion" clas="form-control" value="<?php print $direccion;?>">
            </div>
            <div class="form-group">
            Direccion:    
            <input type="text" name="email" clas="form-control" value="<?php print $email;?>">
            </div>
			 <div class="form-group">
             Telefono    
            <input type="text" name="telefono" clas="form-control" value="<?php print $telefono;?>">
            </div>
            <div class="form-group">
            Logo:   
            <input type="text" name="logo" clas="form-control" value="<?php print $logo;?>">
            </div>
            <div class="form-group">
		     Moodle:
			<select name="idmoodle"clas="form-control">
			<option value="" selected="selected">Selecione Empleado</option>
			<?php
			$query = "select username,id from mdl_user where not id in(select u.id from mdl_enrol e , mdl_user_enrolments ue,mdl_user u where e.id=ue.enrolid and ue.userid= u.id); ";
			$result_alumnos = mysqli_query($conn, $query);

                        while($row = mysqli_fetch_array($result_alumnos)){
							if ($row['id']==$idmoodle){
							?>			
	  <option value="<?php echo $row['id']?>" selected="selected"><?php echo $row['username']?></option>
						<?php }else {?>
						  <option value="<?php echo $row['id']?>"><?php echo $row['username']?></option>
						<?php }
						}?>
	</select>
    
            </div>
            <button class="btn btn-success" name="update2">Actualizar</button>
            </form>
        </div>
    </div>    

<?php include("includes/footer.php")?>
     
    
    