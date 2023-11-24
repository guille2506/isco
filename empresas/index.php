<?php include("includes/header.php")?>
<div class="container p-12">
    <div class = "row">
        <div class="col-md-12">
            <div class ="card text-center">
                <div class="card-body">
                    <h1 class="card-title">Sistema CRUD</h5>
                    <p class="card-text">Un sistema CRUD permite ejecutar las operaciones básicas de trabajo en PHP y MySQL</p>
                    <p class="card-text">Seleccione la operación en el menú de navegación ó en las siguientes cards:</p>                    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">EMPRESAS</h5>
                                    <p class="card-text">Esta opción permite CREAR un registro en la BDD</p>
                                    <a href="empresas.php" class="btn btn-primary">Ver</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">EMPLEADOS</h5>
                                    <p class="card-text">Esta opción permite LEER un registro de la BDD</p>
                                    <a href="empleados.php" class="btn btn-primary">Ver</a>
                                </div>
                            </div>

                        <div class="col-sm-6"> <br> </div>
                    
                    </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("includes/footer.php")?>
