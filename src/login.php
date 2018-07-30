<?php

    require_once 'config/init.php';

    if (Input::exists()) {
        /* Variables POST */
        $token = Input::get('token');
        $username = Input::get('username');
        $password = Input::get('password');
        
        if (Token::check($token)) {

            $user = new User();

            $login = $user->login($username, $password, $remember);

            if ($login) {
                Redirect::to('home.php');
            }else{
                echo '<p class="flash error-flash"> Datos inválidos </p>';
            }
            
            /*$validate = new Validate();

            $validation = $validate->check($_POST, array(
                'username' => array(
                    'required' => true
                ),
                'password' => array(
                    'required' => true
                )
            ));

            if ($validation->passed()) {

                //LOG USER IN
                $user = new User();

                $remember = (Input::get('remember') === 'on') ? true : false;

                $login = $user->login(Input::get('username'), Input::get('password'), $remember);

                if ($login) {
                    Redirect::to('home.php');
                }else{
                    echo '<p class="flash error-flash"> Datos inválidos </p>';
                }

            }else{
                //LISTANDO LOS ERRORES
                foreach ($validation->errors() as $error) {
                    echo $error . '<br>';
                }

            } */
        }
    }


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/estilos.css">
    <title>Inicia Sesion</title>
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
                    <li><a href="index.php" class="btn btn-secundary">Volver</a></li>			
                </ul>

            </div>
        </div>
    </nav>
    
    <form action="" method="post" class="form-control">
        <h1 class="title-form"> Inicio de Sesion </h1>
        <!-- USERNAME -->
        <div class="input-group">
            <input type="text" name="username" placeholder="Nombre de Usuario">          
        </div>

        <!-- PASSWORD -->
        <div class="input-group">
            <input type="password" name="password" placeholder="Contraseña">
        </div>

        <div class="input-group">
            <input type="checkbox" name="remember" id="remember">
            <label for="remember" class="checkbox-control">Remember Me</label>
        </div>

        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">

        <div class="btn-box">
            <input type="reset" value="Borrar Todo" class="btn btn-secundary">
            <input type="submit" value="Entrar" class="btn btn-primary">
        </div>

    </form>    

</body>
</html>