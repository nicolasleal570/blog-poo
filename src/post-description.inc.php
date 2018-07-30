<?php

	require_once 'config/init.php';

	if (!Input::exists('get')) {

		Redirect::to('index.php');

	}else{

		//ID DEL POST QUE SE VA A LEER
		$post_id = Input::get('id');
		
		$blog = new Blog($post_id);

		if (!$blog->exists()) {
			Redirect::to(404);
		}else{

			$blogData = $blog->data();

			$user = new User($blogData->post_author_id);
			$userData = $user->data();
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="css/estilos.css">
	<title><?php echo escape($blogData->post_title); ?></title>
</head>
<body>

	<!-- MENU -->
	<nav class="navbar">
		<div class="wrap">
			<!-- LOGO DE PARVIS -->
            <div class="logo">
                <img src="img/logo.png" alt="Logo Parvis">
			</div>

			<!-- ITEMS -->
			<div class="menu">
				<ul>
					<li><a href="home.php" class="btn btn-secundary">Volver al inicio</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="wrap description-post">
		<!-- IMPRIMIENDO EL TITULO DEL POST -->
		<h1 class="title"><?php echo escape($blogData->post_title); ?></h1>
		<!-- AUTOR DEL POST -->
		<a href="profile-remote-user.php?user=<?php echo escape($userData->id); ?>" class="user-a"> <?php echo escape($blogData->post_author_name).' <p>@'.escape($blogData->post_author_username).'</p>'; ?> </a>
		<!-- FECHA DEL POST -->
		<p class="date"><?php echo escape($blogData->post_date); ?></p>
		<!-- RESUMEN DEL POST - FEED -->
		<p class="feed"><span>Resumen: </span> <?php echo escape($blogData->post_feed); ?></p>
		<!-- DESCRIPCION DEL POST -->
		<p class="description"><?php echo escape($blogData->post_description); ?></p>
	</div>
<?php }

} ?>
	
</body>
</html>