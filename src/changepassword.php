<?php

	require_once 'config/init.php';

	$user = new User();

	if (!$user->isLoggedIn()) {
		Redirect::to('index.php');
	}

	if (Input::exists()) {

		/** IMPRIMIENDO MENSAJE DE ERROR */
		if (Session::exists('error')) {
			echo '<p class="flash error-flash">' . Session::flash('error') . '</p>';
		}

		if (Token::check(Input::get('token'))) {
			
			$validate = new Validate();
			$validation = $validate->check($_POST, array(
				'password_current' => array(
					'required' => true,
					'min' => 6
				),
				'password_new' => array(
					'required' => true,
					'min' => 6
				),
				'password_new_again' => array(
					'required' => true,
					'min' => 6,
					'matches' => 'password_new'
				)
			));

			if ($validation->passed()) {

				//CHANGE PASSWORD
				if (Hash::make(Input::get('password_current'), $user->data()->salt) !== $user->data()->password) {
					Session::flash('error', 'Tu contraseña actual es incorrecta');
				}else{
					$salt = Hash::salt(32);

					$user->update(array(
						'password' => Hash::make(Input::get('password_new'), $salt),
						'salt' => $salt
					));

					Session::flash('success', 'Actualizaste tu password correctamente');
                    Redirect::to('profile-local-user.php');
				}

			}else{
				foreach ($validation->errors() as $error) {
					echo $error, '<br>';
				}
			}

		}
	}


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="css/estilos.css">
	<title>Change Password</title>
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
					<li><a href="profile-local-user.php" class="btn btn-secundary">Volver</a></li>
				</ul>

			</div>
		</div>
	</nav>
	
	<form action="" method="post" class="form-control">
		<h1 class="title-form"> Cambiar Contraseña </h1>
		<!-- PASSWORD ACTUAL -->
		<div class="input-group">
			<input type="password" name="password_current" id="password_current" placeholder="Contraseña actual">
		</div>

		<!-- PASSWORD NNUEVA -->
		<div class="input-group">
			<input type="password" name="password_new" id="password_new" placeholder="Nueva Contraseña">
		</div>

		<!-- PASSWORD NUEVA OTRA VEZ -->
		<div class="input-group">
			<input type="password" name="password_new_again" id="password_new_again" placeholder="Confirmar nueva Contraseña">
		</div>

		<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">

        <div class="btn-box">
            <input type="reset" value="Borrar Todo" class="btn btn-secundary">
            <input type="submit" value="Entrar" class="btn btn-primary">
        </div>
	</form>

</body>
</html>