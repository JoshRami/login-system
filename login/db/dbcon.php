<?php
//Incluir las constantes de conexion
require_once "config.php";

$con=mysqli_connect(host, user, pass, dbname, port);

if($con->connect_errno)
{
    die("Lo sentimos, no se ha podido establecer conexion con MySQL/MariaDB".mysqli_error($con));
}
else
{
    $db=mysqli_select_db($con, dbname);
    if($db == 0)
    {
        die("Lo sentimos, no se ha podido establecer conexion con la base de datos:".dbname);
    }
}

?>