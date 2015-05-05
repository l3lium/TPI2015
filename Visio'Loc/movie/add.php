<?php
require_once '../includes/structure.php';
require_once '../includes/crud_Movies.php';

//Redirection si le compte est en état temporaire
redirectTempAccount();

if (!isAdmin()) {
    goHome();
}

if (filter_input(INPUT_POST, 'addMovie')) {
    debug("in");
    $valide = true;
    $title = filter_input(INPUT_POST, 'title');
    //FILTER_VALIDATE_REGEXP, array("option"=>array("regexp"=>""))
    $date = filter_input(INPUT_POST, 'date');
    $synopsis = filter_input(INPUT_POST, 'synopsis');
    $srcVideo = filter_input(INPUT_POST, 'srcVideo');
    $srcPoster = filter_input(INPUT_POST, 'srcPoster');

    if (!$title) {
        $valide = FALSE;
        $erreur = 'Le titre du film n\'est pas valide.';
    } elseif (!$date) {
        $valide = FALSE;
        $erreur = 'La date n\'est pas valide.';
    } elseif (!$synopsis) {
        $valide = FALSE;
        $erreur = 'Le synopsis ne peut être vide.';
    } elseif (!$srcVideo) {
        $valide = FALSE;
        $erreur = 'La vidéo na pas été uploader.';
    } elseif (!$srcPoster) {
        $valide = FALSE;
        $erreur = 'L\'affiche du film n\'est pas valide.';
    }

    if ($valide) {
        $id = addFilm($title, $date, $srcPoster, $srcVideo, $synopsis);
        if ($id == 0) {
            $valide = FALSE;
            $erreur = 'Une erreur est survenu lors de l\'ajout du film. Veuillez réessayer ulterieurement.';
        }
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
    <?php getHeaderHtml("Ajout de film"); ?>
    <body>
        <?php
        getHeader();
        ?>
        <!-- CONTAINER -->
        <div class="container">
            <div class="center-block">
                <h2><span class="glyphicon glyphicon-plus"></span> Ajout de film</h2>
                <h5>Entrer les informations du films et ajouter-le</h5><hr/>
                <?php
                if (isset($valide) && $valide) {
                    header("refresh:5; url=" . ROOT_SITE . "/movie/fiche.php?id=XX");
                    ?>
                    <div class="alert alert-success" role="alert">
                        <p>Votre inscription a été effectué avec succès. <i>Vous allez être redirigé sur la page de connexion automatiquement.</i></p>
                    </div>
                <?php } else {
                    ?>
                    <!-- CONTAINER ADD MOVIE -->
                    <form class="form form-addMovie" enctype="multipart/form-data" method="post" action="<?php echo ROOT_SITE . "/movie/add.php"; ?>">
                        <label class="">Titre du film :</label>
                        <input class="form-control" name="title" type="text" value="<?php echo (isset($valide) && !$valide) ? $title : ''; ?>" placeholder="ex : ''Titanic''"/>
                        <label class="">Date de sortie :</label>
                        <input class="form-control" name="date" type="date" value="<?php echo (isset($valide) && !$valide) ? $date : ''; ?>" placeholder="ex : ''29/01/1998''"/>
                        <label for="comment">Synopsis:</label>
                        <textarea class="form-control" rows="5" name="synopsis"><?php echo (isset($valide) && !$valide && isset($synopsis)) ? $synopsis : ''; ?></textarea>
                        <input type="hidden" name="srcVideo" value="test">
                        <input type="hidden" name="srcPoster" value="test">

                        <div class="form-inline" id="form-group-upload-poster">
                            <div class="form-group">
                                <label>Affiche du film :</label>
                                <input type="file" name="poster" accept="image/*">
                            </div>
                            <div id="uploadPoster" class="form-group hidden">
                                <button data-url-upload="<?php echo ROOT_SITE . "/up-content/img/upload.php"; ?>" type="button" class="btn btn-sm btn-success">Upload</button>
                            </div>
                            <div id="progressPoster" class="progress hidden">
                                <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="70"
                                     aria-valuemin="0" aria-valuemax="100" style="width:70%">
                                    70%
                                </div>
                            </div>
                        </div>


                        <div id="upload-group-video" class="form-inline">
                            <div class="form-group">
                                <label>Vidéo du film :</label>
                                <input id="input-video" type="file" name="video" accept="video/mp4,video/webm">
                            </div>
                            <div id="uploadVideo" class="form-group hidden">
                                <button type="button" class="btn btn-sm btn-success">Upload</button>
                            </div>
                            <div id="progressVideo"class="progress hidden">
                                <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="70"
                                     aria-valuemin="0" aria-valuemax="100" style="width:70%">
                                    70%
                                </div>
                            </div>
                        </div>
                        <?php
                        if (isset($valide) && !$valide) {
                            echo '<p class="alert alert-danger" role="alert">' . $erreur . '</p>';
                        }
                        ?>
                        <input name="addMovie" class="btn btn-lg btn-primary btn-block" type="submit" value="Ajouter le film"/>
                    </form>
                <?php } ?>
            </div>
        </div>
    </body>
</html>