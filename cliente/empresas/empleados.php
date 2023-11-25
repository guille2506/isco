<?php include("includes/header.php")?>
<?php include("db.php")?>

    <div class ="card text-center">
        <div class="card-body">
            <h1 class="card-title">LISTADO DE EMPLEADOS</h1>
            <p class="card-text">Los siguientes son los datos guardados hasta el momento:</p>
         
            <div class="table-responsive-sm">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Telefono</th>
							 <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM tbl_insco_empleados  ORDER BY nombre desc;";
						
                        $result_alumnos = mysqli_query($conn, $query);

                        while($row = mysqli_fetch_array($result_alumnos)){?>
                            <tr>
                                <td><?php echo $row['nombre']?></td>
                                <td><?php echo $row['email']?></td>
                                <td><?php echo $row['telefono']?></td>
								<td>
                                    <a href="update_empleado.php?id=<?php echo $row['id']?>">
                                    <button type="button" class="btn btn-warning" name="update">Modificar</button>
									</a>
									 <a href="delete_empleado.php?id=<?php echo $row['id']?>">
                                    <button type="button" class="btn btn-warning" name="update">Quitar</button>
									</a>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                                <td></td>
                                <td></td>
                                <td></td>
								<td>
                                    <a href="create_empleado.php">
                                    <button type="button" class="btn btn-warning" name="update">Nuevo</button>
									</a>
									
                                </td>
                            </tr>
                    </tbody>
					 
                </table>
            </div>
        </div>
    </div> 

<?php include("includes/footer.php")?>
