<?php

require_once 'config/init.php';

$user = new User();

if (!$user->isLoggedIn()) {
	Redirect::to('index.php');
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/fontawesome.min.css">
	<link rel="stylesheet" href="css/estilos.css">
	<title>Inicio</title>
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

                <ul>
					<li><a href="home.php"> Inicio </a></li>
					<li><a href="includes/errors/404.php"> Explorar </a></li>
					<li><a href="upload-posts.inc.php?user=<?php echo escape($user->data()->username); ?>" class="btn btn-primary"> Nuevo Post </a></li>
					<li><a href="profile-local-user.php" class="btn-user"><i class="fas fa-user-circle"></i></a></li>	
                </ul>

            </div>

		</div>
	</nav>

	<div class="wrap dgrid">
		<?php
			$sql = DB::getInstance()->query("SELECT * FROM posts ORDER BY post_id DESC ");

			if (!$sql->count()) {
				echo '<h2 class="title span">No hay entradas disponibles aún</h2>';
			} else {
				echo '<h1 class="title span"> Últimas Noticas </h1>';
			}
		?>
		<div class="col-1">
			<?php include 'print-posts.inc.php'; ?>
		</div>
		<div class="col-2">
			<?php include 'sidebar.inc.php'; ?>
		</div>
	</div>

</body>
</html>