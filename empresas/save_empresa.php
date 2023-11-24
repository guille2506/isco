<?php include("db.php")?>
<?php 

if (isset($_POST['guardar_registro'])){
    $nombre = $_POST['nombre'];
    $cif = $_POST['cif'];
    $direccion = $_POST['direccion'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
	$logo = $_POST['logo'];
    $idmoodle = $_POST['idmoodle'];
}

    $query = "INSERT INTO tbl_insco_empresas(nombre, direccion,telefono,email,cif,logo,idmoodle) VALUES ('$nombre','$direccion','$telefono','$email','$cif','$logo',$idmoodle)";
    //die($query);
    $result = mysqli_query($conn, $query);
    if(!$result){
        die("Fallo en el query. Existe un problema en la base de datos.");
    }
    else{
        ?>
        <script>alert("Registro Guardado");</script>
        <?php 
        
    }

    //si quisiera redireccionar a index directamente:
    ?>
    <script>
    window.location = "empresas.php";
    </script>
