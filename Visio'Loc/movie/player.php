<?php
require_once '../includes/structure.php';
require_once '../includes/crud_Movies.php';
require_once '../includes/crud_User.php';

//Redirection si le compte est en état temporaire
redirectTempAccount();

if ($id = filter_input(INPUT_GET, 'id')) {
    if (!$movie = getMovieById($id)) {
        goHome();
    }
}

$available = (isMovieBuy($id) || isMovieRentValide($id));
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <?php getHeaderHtml("Visionnage de $movie->title", 1); ?>
    <body>
        <?php
        getFullHeader();
        ?>
        <!-- CONTAINER -->
        <div class="container">
            <div class="center-block">
                <h2><span class="glyphicon glyphicon-film"></span> Visionnage de <?php echo $movie->title; ?></h2>
                <h5>Information du film</h5><hr/>
                <?php
                if (!$available) {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        <p>Vous n'avez pas accès à ce film, il vous faut d'abord l'acheter ou le louer <a href="<?php echo ROOT_SITE . "movie/detail.php?id=$id"; ?>">ici</a>.</i></p>
                    </div>
                    <?php
                } else {
                    ?>

                    <video id="vloc-video" controls>
                        <source src="<?php echo ROOT_SITE . $movie->videoSrc; ?>" type="video/mp4">
                    </video>

                    <?php
                }
                ?>
            </div>
        </div>
        <?php
        getFooter();
        ?>
    </body>
</html>
