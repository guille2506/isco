<?php

//definimos variables que contendrán los parámetros de conexión a la bdd
$mysql_host = "mysql.cuyosoft.me"; 
$mysql_user = "cuyosoft_mobil"; 
$mysql_pass = "1220feCS"; 
$mysql_dbname = "cuyosoft_moodle"; 

/* 
la variable "conn" se suele nomenclar en Php: $conn. 
En esta variable se guarda la función de conexión a la base de datos.
*/

 $conn = mysqli_connect($mysql_host,$mysql_user,$mysql_pass,$mysql_dbname);
    if (!$conn){
        echo "Error: No se pudo conectar a MySQL.";
        echo "error: " . mysqli_connect_error();
        exit;
    }

//comprobar si la variable ha sido creada correctamente:
/*
if (isset($conn))
{
    echo "la bdd está conectada";
 }
*/

?>