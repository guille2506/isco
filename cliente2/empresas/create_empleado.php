<?php include("includes/header.php")?>
<?php include("db.php")?>

<div class ="card text-center">
    <div class="card-body">
        <h1 class="card-title">CREAR REGISTRO</h1>
        <p class="card-text">Ingrese los datos a continuación</p>

        <form action="save_empleado.php" method="POST">
            <div class="form-group">
            Nombre:    
            <input type="text" name="nombre" clas="form-control" placeholder="Ingrese Nombre" autofocus>
            </div>
            <div class="form-group">
            Etiqueta:    
            <input type="text" name="etiqueta" clas="form-control" placeholder="Ingrese Etiqueta">
            </div>
			<div class="form-group">
            Direccion:    
            <input type="text" name="direccion" clas="form-control" placeholder="Ingrese Direccion">
            </div>
            <div class="form-group">
            E-mail:    
            <input type="text" name="email" clas="form-control" placeholder="Ingrese Email">
            </div>
			 <div class="form-group">
            <input type="text" name="telefono" clas="form-control" placeholder="Ingrese Telefono">
            </div>
            <div class="form-group">
            <input type="text" name="celular" clas="form-control" placeholder="Ingrese Celular">
            </div>
            <div class="form-group">
            Avatar:    
            <input type="text" name="avatar" clas="form-control" placeholder="Ingrese avatar">
            </div>
            <div class="form-group">
			Empresa:
			<select name="empresa"clas="form-control">
			<option value="" selected="selected">Selecione Empresa</option>
			<?php
			$query = "SELECT * FROM tbl_insco_empresas  ORDER BY nombre desc;";
			$result_alumnos = mysqli_query($conn, $query);

                        while($row = mysqli_fetch_array($result_alumnos)){?>
			
	  <option value="<?php echo $row['id']?>"><?php echo $row['nombre']?></option>
						<?php }?>
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

                        while($row = mysqli_fetch_array($result_alumnos)){?>
			
	  <option value="<?php echo $row['id']?>"><?php echo $row['username']?></option>
						<?php }?>
	</select>
    
            </div>
            <input type="submit" class="btn btn-success" name="guardar_registro" value="Guardar">
        </form>
    </div>
</div>

<?php include("includes/footer.php")?>
