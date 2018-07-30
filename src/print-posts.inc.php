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

        <?php

        $sql = DB::getInstance()->query("SELECT * FROM posts ORDER BY post_id DESC ");

        if (!$sql->count()) {
            echo '<h2 class="alert span">No hay entradas disponibles aún</h2>';
        } else {
            //echo '<h1 class="title span"> Últimas Noticas </h1>';
            //OBTENIENDO RESULTADOS SEGUN EL CAMPO QUE SE QUIERA
            foreach ($sql->results() as $post) {?>

                <div class="post-box">
                    <!-- IMPRIMIENDO EL TITULO DEL POST -->
                    <h3> <?php echo escape($post->post_title); ?> </h3>
                    <!-- IMPRIMIENDO EL FEED DEL POST -->
                    <p> <?php echo escape($post->post_feed); ?> </p>
                    <!-- IMPRIMIENDO EL AUTOR -->
                    <div class="user-box-a">
                        <a href="profile-remote-user.php?user=<?php echo $post->post_author_id ?>" class="user-a"> <?php echo escape($post->post_author_name).' @'.escape($post->post_author_username); ?> </a>
                    </div>

                    <!-- CAJA PARA LEER EL POST, COMPARTIR, LIKE O DISLIKE -->
                    <div class="btn-box">
                        <a href="post-description.inc.php?id=<?php echo escape($post->post_id); ?>" class="btn btn-secundary"> Leer Más </a>
                        <a href="#"><i class="fas fa-share-alt"></i></a>
                        <a href="#"><i class="far fa-thumbs-up"></i></a>
                        <a href="#"><i class="far fa-thumbs-down"></i></a>
                    </div>
                </div> <?php
            }
        }

        ?>


    </body>
</html>