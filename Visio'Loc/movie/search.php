<?php
require_once '../includes/structure.php';
require_once '../includes/crud_Movies.php';
require_once '../includes/crud_Actors.php';

//Redirection si le compte est en état temporaire
redirectTempAccount();

if ($key=filter_input(INPUT_GET, 'key')) {
    if (!$movie = getFilmById($id)){
        goHome();
    }
}
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <?php getHeaderHtml("Visionnage de $movie->title"); ?>
    <body>
        <?php
        getHeader();
        ?>
        <!-- CONTAINER -->
        <div class="container">
            <div class="center-block">
                <h2><span class="glyphicon glyphicon-film"></span> Visionnage de <?php echo $movie->title; ?></h2>
                <h5>Information du film</h5><hr/>
                <?php debug($movie);?>
            </div>
        </div>
    </body>
</html>
