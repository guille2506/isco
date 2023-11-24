<?php include("db.php")?>
<?php 

if (isset($_POST['guardar_registro'])){
    $nombre = $_POST['nombre'];
    $etiqueta = $_POST['etiqueta'];
  
    $direccion = $_POST['direccion'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
	$celular = $_POST['celular'];
    $idmoodle = $_POST['celular'];
    $avatar=$_POST['avatar'];
    $empresa=$_POST['empresa'];
    $idmoodle=$_POST['idmoodle'];
    $cif = $_POST['cif'];
}

    $query = "INSERT INTO tbl_insco_empleados(nombre,etiqueta, direccion,telefono,celular,email,avatar,idmoodle,empresa) VALUES ('$nombre','$nombre','$direccion','$telefono','$celular','$email','$avatar',$idmoodle,$empresa)";
    //die($query);
    echo $query ;
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
    window.location = "empleados.php";
    </script>
