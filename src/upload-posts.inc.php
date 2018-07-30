<?php

require_once 'config/init.php';

if (Input::exists()) {

    $validate = new Validate();
    $validation = $validate->check($_POST, array(
        'title' => array(
            'required' => true,
            'min' => 2,
            'max' => 100,
        ),
        'category' => array(
            'required' => true,
        ),
        'description' => array(
            'required' => true,
            'min' => 25,
        ),
        'feed' => array(
            'required' => true,
            'min' => 10,
            'max' => 200
        )
    ));

    if ($validation->passed()) {

        $blog = new Blog();

        try {

            //DATOS DEL USUARIO QUE SE VAN A INSERTAR
            $blog->create(array(
                'post_title' => Input::get('title'),
                'post_author_id' => Input::get('author_id'),
                'post_author_name' => Input::get('author_name'),
                'post_author_username' => Input::get('author_username'),
                'post_date' => date('Y-m-d'),
                'post_category' => Input::get('category'),
                'post_description' => Input::get('description'),
                'post_feed' => Input::get('feed')
            ));

            Session::flash('success', 'Post creado con exito!');
            Redirect::to('index.php');

        } catch (Exception $e) {
            die($e->getMessage());
        }

    } else {
        //LISTANDO LOS ERRORES
        foreach ($validation->errors() as $error) {
            echo $error, '<br>';
        }
    }

}
//NOMBRE DEL USUARIO LOGGUEADO
$user_id = Input::get('user'); /* Este valor se le pasa al input 'username' */
$user = new User($user_id);
$data = $user->data();

?>
<link rel="stylesheet" href="css/estilos.css">

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

<form action="" method="post" class="form-control">
    <h1 class="title-form"> Crea tu Post </h1>
    <div class="input-group">
        <input type="text" name="title" id="input-1" value="<?php echo escape(Input::get('title')); ?>"  placeholder="Titulo del post">
    </div>
    <div class="input-group">
        <select name="category" id="category">
            <?php
                /** Trayendo las distintas categorias */
                $categorias = DB::getInstance()->query('SELECT * FROM `post-category`');
                if (!$categorias->count()) {
                    echo 'No hay resultados';
                }else {
                    foreach ($categorias->results() as $key) {
                        echo '<option value="'.$key->idCategory.'">'.$key->category.'</option>';
                    }
                }
            ?>
        </select>
    </div>
    <div class="input-group">
        <textarea name="description" id="input-5" placeholder="Descripcion del post"><?php echo escape(Input::get('description')); ?></textarea>
    </div>
    <div class="input-group">
        <textarea name="feed" id="input-6" placeholder="Resumen del post"><?php echo escape(Input::get('feed')); ?></textarea>
    </div>

    <!-- NOMBRE DE USUARIO -->
    <input type="hidden" name="author_id" id="id" value="<?php echo $data->id; ?>">
    <input type="hidden" name="author_name" id="name" value="<?php echo $data->name; ?>">
    <input type="hidden" name="author_username" id="username" value="<?php echo $data->username; ?>">

    <div class="btn-box">
        <input type="reset" value="Borrar Todo" class="btn btn-secundary">
        <input type="submit" value="Montar Post" class="btn btn-primary">
    </div>
    
</form>



