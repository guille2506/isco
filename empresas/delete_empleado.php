<?php include("db.php")?>

<?php
if(isset($_GET['id'])){
        $codigo = $_GET['id'];
        $query = "DELETE FROM tbl_insco_empleados WHERE id = $codigo";
        $result = mysqli_query($conn, $query);
        if(!$result)
        {
            die("El query para eliminar falló");
        }
        else{
            ?>
            <script>alert("Registro Eliminado");</script>
            <?php 
        }
    }
    //si quisiera redireccionar a index directamente: ?>
    <script>
    window.location = "empleados.php";
    </script>
    

