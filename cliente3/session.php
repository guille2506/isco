<?php
session_start();
if(empty($_SESSION['nombre_usuario'])){
	//header('Location: http://localhost/gesinpol/cliente/salir.php');//local
	header('Location: https://cursos.cuyosoft.me/cliente/salir.php');//server
  }
?>
