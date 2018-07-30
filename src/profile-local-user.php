<?php

    require_once 'config/init.php';

    $user = new User();

    /** IMPRIMIENDO MENSAJE DE ERROR */
	if (Session::exists('error')) {
        echo '<p class="flash error-flash">' . Session::flash('error') . '</p>';
    }

    /** IMPRIMIENDO MENSAJE DE SUCCESS */
    if (Session::exists('success')) {
        echo '<p class="flash success-flash">' . Session::flash('success') . '</p>';
    }


    if (!$user->isLoggedIn()) {
        Redirect::to('index.php');
    }

    if (Input::exists()) {
        if (Token::check(Input::get('token'))) {
            //Validacion
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'name' => array(
                    'require' => true,
                    'min' => 2,
                    'max' => 60 
                )
            ));

            if ($validation->passed()) {
                //update
                try{

                    $user->update(array(
                        'name' => Input::get('name')
                    ));

                    Session::flash('success', 'Actualizaste tu perfil correctamente');
                    Redirect::to('index.php');

                }catch(Exception $e){
                    die($e->getMessage());
                }
            }else {
                //error
                foreach ($validation->errors() as $error) {
                    echo $error, '<br>';
                }
            }
        }
    }

    $data = $user->data();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/estilos.css">
    <title>Perfil de <?php echo escape($data->name); ?></title>
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
                    <li><a href="home.php" class="btn btn-secundary">Volver</a></li>			
                </ul>

            </div>
        </div>
    </nav>

    <div class="wrap">
        <div class="main-profile">
            <!-- CAMBIAR NOMBRE PERSONAL -->
            <form action="" method="post" class="form-control">
                <!-- NOMBRE PERSONA -->
                <div class="input-group">
                    <input type="text" name="name" id="name" value="<?php echo escape($data->name); ?>" placeholder="Cambiar Nombre Personal">
                </div>

                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">

                <div class="btn-box">
                    <input type="submit" value="Cambiar" class="btn btn-primary">
                </div>
            </form>

            <ul>
                <li><a href="changepassword.php" class="btn btn-primary">Cambiar contraseña</a></li>
                <li><a href="logout.php" class="btn btn-secundary">Cerrar Sesión</a></li>
            </ul>
            
        </div>
    </div>
    
    
</body>
</html>