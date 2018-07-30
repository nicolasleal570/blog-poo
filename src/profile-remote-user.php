<?php

require_once 'config/init.php';

$userR = new User();

if (Input::exists('get') && Input::get('user')) {

	$userP_id = Input::get('user');

	$userP = new User($userP_id); //USUARIO DEL PERFIL
	$dataP = $userP->data();

}else if (empty(Input::get('user'))) {
	Redirect::to('home.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="css/estilos.css">
	<title>Perfil de <?php echo escape($dataP->name); ?></title>
</head>
<body>
	
	<nav class="navbar">
        <div class="wrap">
            <!-- LOGO DE PARVIS -->
            <div class="logo">
                <img src="img/logo.png" alt="Logo Parvis">
			</div>
		</div>
	</nav>

	<div class="wrap">
		<!-- FILA -->
		<div class="row">
			<!-- COLUMNA 1 -->
			<div class="col-1">
				<section class="side-top">
					<h2><?php echo escape($dataP->name); ?></h2>
					<p>@<?php echo escape($dataP->username); ?></p>
				</section>
				<section class="description">
					<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed maxime iste repellendus ullam, quasi natus corporis ratione quae dolorum, molestiae quam asperiores nemo sit deleniti veniam qui esse doloremque perferendis adipisci. Error rem animi neque provident dolorem. Fugit, consequuntur vitae!</p>
				</section>
				<section class="contact">
					<ul>
						<li>
							<div class="item">
								<span class="fas "></span>
								<p>+58-424-159-35-62</p>
							</div>
						</li>
						<li>
							<div class="item">
								<span class="fas "></span>
								<p><?php echo escape($dataP->email); ?></p>
							</div>
						</li>
						<li>
							<div class="item">
								<span class="fas "></span>
								<p>192 William Street PD Box Chicago, USA. </p>
							</div>
						</li>
					</ul>
				</section>
			</div>

			<!-- COLUMNA 2 -->
			<div class="col-2">

				<div class="post-count">
					<h2>Posts Creados: </h2>
				</div>

			</div>
		</div>
	</div>



</body>
</html>