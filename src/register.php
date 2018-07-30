<?php

    require_once 'config/init.php';

    //var_dump(Token::check(Input::get('token')));
  
    if (Input::exists()) {

        if (Token::check(Input::get('token'))) {

            $validate = new Validate();

            $validation = $validate->check($_POST, array(
                'name' => array(
                    'required' => true,
                    'min' => 2,
                    'max' => 20
                ),
                'username' => array(
                    'required' => true,
                    'min' => 2,
                    'max' => 20,
                    'unique' => 'users'
                ),
                'email' => array(
                    'required' => true,
                    'min' => 2,
                    'max' => 20
                ),
                'password' => array(
                    'required' => true,
                    'min' => 6,
                ),
                'password_again' => array(
                    'required' => true,
                    'matches' => 'password'
                )
            ));

            if ($validation->passed()) {

                $user = new User();

                $salt = Hash::salt(32);

                try{

                    //DATOS DEL USUARIO QUE SE VAN A INSERTAR
                    $user->create(array(
                        'name' => Input::get('name'),
                        'username' => Input::get('username'),
                        'email' => Input::get('email'),
                        'password' => Hash::make(Input::get('password'), $salt),
                        'salt' => $salt,
                        'joined' => date('Y-m-d H:i:s'),
                        'type' => 1
                    ));

                    //CREANDO LA VARIABLE home PARA PASARLA AL INDEX.PHP
                    Session::flash('success', 'Registrado Exitosamente! Ahora inicia sesion.');
                    Redirect::to('index.php');

                }catch(Exception $e){
                    die($e->getMessage());
                }



            }else{
                //LISTANDO LOS ERRORES
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
    <title>Register Page</title>
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
        <h1 class="title-form"> Registro de Usuario </h1>
        <!-- NAME -->
        <div class="input-group">
            <input type="text" class ="input-control" name="name" id="name" value="<?php echo escape(Input::get('name')); ?>"  placeholder="Nombre Personal">
        </div>

        <!-- USERNAME -->
        <div class="input-group">
            <input type="text" class ="input-control" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>"  placeholder="Nombre de Usuario">
        </div>

        <!-- EMAIL -->
        <div class="input-group">
            <input type="email" class ="input-control" name="email" id="email" value="<?php echo escape(Input::get('email')); ?>"  placeholder="Email">
        </div>

        <!-- PASSWORD -->
        <div class="input-group">
            <input type="password" class ="input-control" name="password" id="password" value=""  placeholder="Contraseña">
        </div>

        <!-- PASSWORD AGAIN -->
        <div class="input-group">
            <input type="password" class ="input-control" name="password_again" id="password_again" value=""  placeholder="Confirmar Contraseña">
        </div>

        <!-- GUARDA UN TOKEN UNICO PARA CADA USUARIO -->
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">

        <div class="btn-box">
            <input type="reset" value="Borrar Todo" class="btn btn-secundary">
            <input type="submit" value="Registrarme" class="btn btn-primary">
        </div>

    </form>


</body>
</html>