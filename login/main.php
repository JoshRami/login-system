<?php
//Inicializando la session
session_start();

//Si hizo un submit al boton de login, a traves de jQuery se establece una variable 'logueado', si esto viene vacio, no ha llenado el formulario
if (empty($_SESSION['logueado'])) {
   //Se devuelve el mensaje con el codigo HTTP 403 Forbidden que significa que no tiene permisos para acceder a este recurso
   //con la posibilidad de volver al login
   echo  "<!DOCTYPE html>
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
else //Si está logueado lo redirigimos al Index del proyecto
{
    // se carga el template de la pagina main
    $pagina = file_get_contents("templates/main.html");
    //Se reemplazan los placeholders de los datos por los valores de la sesion
    $pagina = preg_replace('/--nombre--/', $_SESSION['nombre'], $pagina);
    $pagina = preg_replace('/--usuario--/', $_SESSION['usuario'], $pagina);
   
    //La DB solo guarda la inicial del rol del user, aca se modifica la variable de sesion a su palabra completa
    $_SESSION['tipoUsuario'] == 'A'? $_SESSION['tipoUsuario'] = 'Administrador':$_SESSION['tipoUsuario'] = 'Cliente'; 
    $pagina = preg_replace('/--rol--/', $_SESSION['tipoUsuario'], $pagina);
   //Utilizamos las variables de session para pasar los valores a los tags de sustitucion
    echo $pagina;
}

?>