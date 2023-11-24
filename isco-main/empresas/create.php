<?php include("includes/header.php")?>
<?php include("db.php")?>

<div class ="card text-center">
    <div class="card-body">
        <h1 class="card-title">CREAR REGISTRO</h1>
        <p class="card-text">Ingrese los datos a continuación</p>

        <form action="save.php" method="POST">
            <div class="form-group">
            <input type="text" name="nombres" clas="form-control" placeholder="Ingrese Nombres" autofocus>
            </div>

            <div class="form-group">
            <input type="text" name="direccion" clas="form-control" placeholder="Ingrese Dirección">
            </div>
            <div class="form-group">
            <input type="text" name="pais" clas="form-control" placeholder="Ingrese pais">
            </div>
            <div class="form-group">
			
			<select name="idpais"clas="form-control">
			<option value="" selected="selected">Selecione Pais</option>
			<?php
			$query = "SELECT * FROM tbl_pais  ORDER BY nombre desc;";
			$result_alumnos = mysqli_query($conn, $query);

                        while($row = mysqli_fetch_array($result_alumnos)){?>
			
	  <option value="<?php echo $row['id']?>"><?php echo $row['nombre']?></option>
						<?php }?>
	</select>
    
            </div>
            <input type="submit" class="btn btn-success" name="guardar_registro" value="Guardar">
        </form>
    </div>
</div>

<?php include("includes/footer.php")?>
