<?php include("includes/header.php")?>
<?php include("db.php")?>

<?php
if(isset($_GET['id'])){
$codigo = $_GET['id'];
$query = "SELECT * FROM tbl_insco_empleados WHERE id = $codigo";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) ==1) {
    $row = mysqli_fetch_array($result);
    $nombre = $row['nombre'];
    $etiqueta = $row['etiqueta'];
    $direccion = $row['direccion'];
	$email = $row['email'];
    $telefono = $row['telefono'];
    $celular = $row['celular'];
	$avatar = $row['avatar'];
    $idmoodle = $row['idmoodle'];
    $empresa = $row['empresa'];
    }
}
if (isset($_POST['update2'])){
    $codigo = $_GET['id'];
    $nombre = $_POST['nombre'];
    $etiqueta =$_POST['etiqueta'];
   
    $direccion = $_POST['direccion'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $celular = $_POST['celular'];
	$avatar = $_POST['avatar'];
    $idmoodle = $_POST['idmoodle'];
    $empresa = $_POST['empresa'];
    $query = "UPDATE tbl_insco_empleados SET nombre = '$nombre', etiqueta = '$etiqueta',direccion = '$direccion', email='$email',telefono='$telefono',celular='$celular',avatar='$avatar',idmoodle='$idmoodle',empresa=$empresa WHERE id = $codigo";
    echo $query ;
    $result = mysqli_query($conn,$query);
    if (!$result){
        echo "El query de actualizar falló";
    }else{
        ?>
        <script>alert("Registro actualizado");</script>
        <script>
        window.location = "empleados.php";
        </script>
        <?php 
    }
}
?>
<div class ="card text-center">
        <div class="card-body">
            <h1 class="card-title">ACTUALIZAR DATOS</h1>
            <p class="card-text">Los siguientes son los datos seleccionados para actualizar:</p>
         
            <form action="update_empleado.php?id=<?php echo $_GET['id']; ?>" method="POST">
            <div class="form-group">
            Nombre:    
            <input type="text" name="nombre" value="<?php print $nombre;?>"
            class = "form-control" >
            </div>
            <div class="form-group">
            Etiqueta:    
            <input type="text" name="etiqueta" value="<?php print $etiqueta;?>"
            class = "form-control" >
            </div>
            <div class="form-group">
            cif:    
            <input type="text" name="cif" clas="form-control"  value="<?php print $cif;?>">
            </div>
            <div class="form-group">
            Direccion:    
            <input type="text" name="direccion" clas="form-control" value="<?php print $direccion;?>">
            </div>
            <div class="form-group">
            E-mail:    
            <input type="text" name="email" clas="form-control" value="<?php print $email;?>">
            </div>
			 <div class="form-group">
             Telefono:    
            <input type="text" name="telefono" clas="form-control" value="<?php print $telefono;?>">
            </div>
            <div class="form-group">
            Celular:    
            <input type="text" name="celular" clas="form-control" value="<?php print $celular;?>">
            </div>
            <div class="form-group">
            Avatar:    
            <input type="text" name="avatar" clas="form-control" value="<?php print $avatar;?>">
            </div>
            <div class="form-group">
		     Empresa:
			<select name="empresa"clas="form-control">
			<option value="" selected="selected">Selecione Empleado</option>
			<?php
			$query = "SELECT * FROM tbl_insco_empresas  ORDER BY nombre desc;";
			$result_alumnos = mysqli_query($conn, $query);

                        while($row = mysqli_fetch_array($result_alumnos)){
							if ($row['id']==$empresa){
							?>			
	  <option value="<?php echo $row['id']?>" selected="selected"><?php echo $row['nombre']?></option>
						<?php }else {?>
						  <option value="<?php echo $row['id']?>"><?php echo $row['nombre']?></option>
						<?php }
						}?>
	</select>
    
            </div>
            <div class="form-group">
            Moodle:    			
			<select name="idmoodle"clas="form-control">
			<option value="" selected="selected">Selecione Usuarios moodle</option>
			<?php
            //select * from mdl_enrol e , mdl_user_enrolments ue,mdl_user u where e.id=ue.enrolid and ue.userid= u.id; 
			$query = "select username,id from mdl_user";
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
     
    
    