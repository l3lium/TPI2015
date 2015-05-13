<?php
require_once '../includes/structure.php';
require_once '../includes/crud_User.php';
require_once '../includes/crud_Movies.php';

//Redirection si le compte est en état temporaire
redirectTempAccount();

if (!isConnected() || isAdmin()) {
    goHome();
}

if ($buy = filter_input(INPUT_POST, "buy")) {
    $valide = true;
    $id = filter_input(INPUT_POST, "id");
    $movie = getMovieById($id);

    if (!$movie) {
        goHome();
    }

    if (!isMovieBuy($id) && !isMovieRentValide($id)) {
        buyMovie($id);
        
        $msg = "Merci d'avoir acheté \"$movie->title\". Le film est désormais "
                . "disponible dans votre vidéothèque, vous pouvez le visionner "
                . "dès maintenant.";
    } else {
        $valide = false;
        $msg = "Vous déjà loué ou acheté ce film et vous pouvez encore le visionner.";
    }
} elseif ($rent = filter_input(INPUT_POST, "rent")) {
    $id = filter_input(INPUT_POST, "id");
    $movie = getMovieById($id);

    if (!isMovieRentValide($id) && !isMovieBuy($id)) {
        rentMovie($id);
        $valide = true;
        $msg = "Merci d'avoir loué \"$movie->title\". Le film est désormais "
                . "disponible dans votre vidéothèque, vous avez " .
                RENT_HOUR . " heures pour le visionner.";
    } else {
        $valide = false;
        $msg = "Vous déjà loué ou acheté ce film et vous pouvez encore le visionner.";
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
    <?php getHeaderHtml("Recherche"); ?>
    <body>
        <?php
        getFullHeader();
        ?>
        <!-- CONTAINER -->
        <div class="container">
            <div class="center-block">
                <h2><span class="glyphicon glyphicon-search"></span> Achat / Location</h2>
                <h5></h5><hr/>
                <?php
                header("refresh:10; url=" . ROOT_SITE . "user/videolibrary.php");
                ?>
                <div class="alert alert-<?php echo ($valide) ? "success" : "danger"?>" role="alert">
                    <p><?php echo $msg;?> <i>Vous allez être redirigé sur <a href="<?php echo ROOT_SITE . "user/videolibrary.php";?>">votre vidéothèque</a>.</i></p>
                </div>
            </div>
        </div>
    </body>
</html>
