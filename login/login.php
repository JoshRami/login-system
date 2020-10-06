<?php
//Cargamos nuestro archivo que contiene la conexion a la DB Empresa
require_once "db/dbcon.php";
//Evaluamos los valores enviados por peticiones HTTP
$usuario = (isset($_REQUEST['txtClave']) ? $_REQUEST['txtClave'] : '');
$password = (isset($_REQUEST['txtClave']) ? $_REQUEST['txtClave'] : '');
//Evaluamos si se reciben datos de una peticion HTTP
if($usuario == "" && $password== "")
{
    //Si viene una peticion para salir de la aplicacion
    if(isset($_REQUEST['acc']) == 'salir')
    {
        //Destruimos la sesion y limpiamos las variables de sesion
        session_start();
        session_unset();
        session_destroy();
        session_write_close();
        setcookie(session_name(),'',0,'/');
        session_regenerate_id(true);
        //Redirigimos al Index
        header("Location: index.html");
    }
    else
    {
        //No ha pasado por el login
        //Se devuelve el mensaje con el codigo HTTP 403 Forbidden que significa que no tiene permisos para acceder a este recurso
        //con la posibilidad de volver al login
        echo "<!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <meta http-equiv='X-UA-Compatible' content='ie=edge'>
            <title>Usuario no autorizado</title>
            <!-- Bootstrap CSS -->
            <link href=\"//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css\" rel=\"stylesheet\" id=\"bootstrap-css\">
            <link rel=\"stylesheet\" href=\"//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css\">
            <link rel='stylesheet' href='assets/css/style403.scss'>
        </head>
        <body>
        
        <div id='app' class='mx-auto d-flex justify-content-center flex-column col-4'>
            <div>403</div>
            <div class='txt'>
            Forbidden<span class='blink'>_</span>
            </div>
            <img src='assets/img/403.png' alt='Usuario no autorizado'><br>
            <button type='button' class='btn btn-danger btn-lg' onclick=\"location.href='index.html'\"><i class='fa fa-chevron-circle-left'></i> Regresar</button>
        </div>                        
        </body>
        </html>";
    }
}
else
{
    //La variable de conexion a la DB
    global $con;
    //Aca se obtienen los datos de usuario y clave ingresados por el usuario final
    $usuario = mysqli_real_escape_string($con,(strip_tags($_REQUEST["txtUsuario"],ENT_QUOTES)));//Escanpando caracteres 
    $clave	= mysqli_real_escape_string($con,(strip_tags($_REQUEST["txtClave"],ENT_QUOTES)));//Escanpando caracteres 
    
    // En este caso el id se asigna por la DB el usuario no conoce su id, la unica forma es evaluar que no haya un usuario con un mismo carnet
    $query = mysqli_query($con, "SELECT * FROM usuario WHERE usuario='$usuario' AND clave='$clave'");
    // Si el querie retorna un solo registro, que se espera que sera asi, se crean las variables de sesion y se imprime "Bienvenido" que es usado por jQuery para mostrar el mensaje 
    // final del proceso de login, y nos redigira a la pagina main.php
    if(mysqli_num_rows($query) == 1)
    {
        $row = mysqli_fetch_assoc($query);
        session_start();
            //Cargamos las variables de sesion con los datos obtenidos de la tabla de usuarios
            //Inicio variables de session
            $_SESSION['logueado'] = true;
            $_SESSION['nombre'] = htmlentities($row['nombre'], ENT_QUOTES);
            $_SESSION['usuario'] = htmlentities($row['usuario'], ENT_QUOTES);
            $_SESSION['clave'] = htmlentities($row['clave'], ENT_QUOTES);
            $_SESSION['estado'] =htmlentities($row['estado'], ENT_QUOTES);
            $_SESSION['tipoUsuario'] =htmlentities($row['tipoUsuario'], ENT_QUOTES);

            //Devuelvo un mensaje de bienvenida
            echo "Bienvenido";
    }else{
        echo "Denegado";
    }
}
?>