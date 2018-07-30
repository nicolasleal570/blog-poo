<?php 

require_once 'config/init.php';

// RECIBIENDO EL REGISTRO EXITOSO 
if (Session::exists('success')) {
	echo '<p class="flash success-flash">' . Session::flash('success') . '</p>';
}
if (Session::exists('error')) {
	echo '<p class="flash error-flash">' . Session::flash('error') . '</p>';
}

$user = new User();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/fontawesome.min.css">
	<link rel="stylesheet" href="css/estilos.css">
    <title>Home Page - Blog</title>
</head>
<body>
    <nav class="navbar">
        <div class="wrap">
            <!-- LOGO DE PARVIS -->
            <div class="logo">
                <img src="img/logo.png" alt="Logo Parvis">
            </div>

            <!-- MENU DE LA PAG -->
            <div class="menu">

                <ul> <?php 
                    if (!$user->isLoggedIn()) { ?>

                        <!-- REGISTRATE -->
                        <li><a href="register.php" class=" btn btn-primary"> <i class="fas fa-user-plus"></i> Registrarse </a></li>
                    <?php } else {
                        Redirect::to('home.php');
                    } ?>			
                </ul>

            </div>
        </div>
	</nav>

    <div class="bg">
        <div class="wrap">
            <div class="info">
                <h1> Sumate a la comunidad  y lee los mejores posts sobre todo lo que te imaginas! </h1>
                <p> Y si no existe, pues crealo. </p>
                <a href="login.php" class="btn btn-secundary"><i class="fas fa-sign-in-alt"></i> Iniciar Sesion </a>
            </div>
        </div>
    </div>

</body>
</html>



