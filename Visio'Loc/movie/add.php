<?php
require_once '../includes/structure.php';
require_once '../includes/crud_Movies.php';

//Redirection si le compte est en état temporaire
redirectTempAccount();

if (!isAdmin()) {
    goHome();
}

//TEST des parametres
if (filter_input(INPUT_POST, 'addMovie')) {
    $valide = true;
    $title = filter_input(INPUT_POST, 'title');
    //FILTER_VALIDATE_REGEXP, array("option"=>array("regexp"=>""))
    $date = filter_input(INPUT_POST, 'date');
    $synopsis = filter_input(INPUT_POST, 'synopsis');
    $srcVideo = filter_input(INPUT_POST, 'srcVideo');
    $srcPoster = filter_input(INPUT_POST, 'srcPoster');
    $keywords = filter_input(INPUT_POST, "keywords", FILTER_DEFAULT, FILTER_FORCE_ARRAY);
    $actors = filter_input(INPUT_POST, "actors", FILTER_DEFAULT, FILTER_FORCE_ARRAY);
    $creators = filter_input(INPUT_POST, "creators", FILTER_DEFAULT, FILTER_FORCE_ARRAY);

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
    } elseif (!$keywords) {
        $valide = FALSE;
        $erreur = 'Le film doit posséder au minimum un mot clé.';
    } elseif (!$actors) {
        $valide = FALSE;
        $erreur = 'Le film doit posséder au minimum un acteur.';
    } elseif (!$creators) {
        $valide = FALSE;
        $erreur = 'Le film doit posséder au minimum un réalisateur.';
    }

    if ($valide) {
        $id = addMovie($title, $date, $srcPoster, $srcVideo, $synopsis);
        if ($id == 0) {
            $valide = FALSE;
            $erreur = 'Une erreur est survenu lors de l\'ajout du film. Veuillez réessayer ulterieurement.';
        } else {
            addCreatorsMovie($id, $creators);
            addActorsMovie($id, $actors);
            addKeywordsMovie($id, $keywords);
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
        getFullHeader();
        ?>
        <!-- CONTAINER -->
        <div class="container">
            <div class="center-block">
                <h2><span class="glyphicon glyphicon-plus"></span> Ajout de film</h2>
                <h5>Entrer les informations du films et ajouter-le</h5><hr/>
                <?php
                if (isset($valide) && $valide) {
                    header("refresh:5; url=" . ROOT_SITE . "movie/detail.php?id=$id");
                    ?>
                    <div class="alert alert-success" role="alert">
                        <p>Le film a été ajouter dans la base de données. <i>Vous allez être redirigé sur la fiche du film automatiquement.</i></p>
                    </div>
                <?php } else {
                    ?>
                    <!-- CONTAINER ADD MOVIE -->
                    <form id="form-add-movie"class="form" enctype="multipart/form-data" method="post" action="<?php echo ROOT_SITE . "movie/add.php"; ?>">
                        <?php
                        if (isset($valide) && !$valide) {
                            echo '<p class="alert alert-danger" role="alert">' . $erreur . '</p>';
                        }
                        ?>
                        <label class="">Titre du film :</label>
                        <button id="input-help" type="button" class="btn btn-default btn-xs pull-right">aide à la saisie</button>
                        <input class="form-control" name="title" type="text" value="<?php echo (isset($valide) && !$valide) ? $title : ''; ?>" placeholder="ex : ''Titanic''"/>
                        <p id="input-help-msg"></p>
                        <label class="">Date de sortie :</label>
                        <input class="form-control" name="date" type="date" value="<?php echo (isset($valide) && !$valide) ? $date : ''; ?>" placeholder="ex : ''29/01/1998''"/>
                        <label for="comment">Synopsis:</label>
                        <textarea id="2" class="form-control" rows="5" name="synopsis"><?php echo (isset($valide) && !$valide && isset($synopsis)) ? $synopsis : ''; ?></textarea>
                        <div class="form-group-upload well">
                            <?php if (isset($valide) && !$valide && $srcPoster) { ?>
                                <label>Le poster a été envoyé</label></br>
                                <input type="hidden" name="srcPoster" value="<?php echo $srcPoster; ?>">
                                <?php
                            } else {
                                ?>
                                <div class="form-inline" id="form-group-upload-poster">
                                    <div class="form-group">
                                        <label>Affiche du film :</label>
                                        <input id="input-poster" type="file" name="poster" accept="image/*">
                                    </div>
                                    <div id="upload-poster" class="form-group hidden">
                                        <button data-url-upload="<?php echo ROOT_SITE . "up-content/uploadPoster.php"; ?>" type="button" class="btn btn-sm btn-success">Upload</button>
                                    </div>
                                    <div class="progress hidden">
                                        <div id="progress-bar-poster" class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="0"
                                             aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                            0%
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            if (isset($valide) && !$valide && $srcVideo) {
                                ?>
                                <label>La vidéo a été envoyée</label>
                                <input type="hidden" name="srcVideo" value="<?php echo $srcVideo; ?>">
                                <?php
                            } else {
                                ?>
                                <div id="upload-group-video" class="form-inline">
                                    <div class="form-group">
                                        <label>Vidéo du film :</label>
                                        <input id="input-video" type="file" name="video" accept="video/mp4,video/webm">
                                    </div>
                                    <div id="upload-video" class="form-group hidden">
                                        <button data-url-upload="<?php echo ROOT_SITE . "up-content/uploadVideo.php"; ?>" type="button" class="btn btn-sm btn-success">Upload</button>
                                    </div>
                                    <div class="progress hidden">
                                        <div id="progress-bar-video" class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="0"
                                             aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                            0%
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <label>Mots clés du film :</label>
                        <?php
                        if (isset($keywords))
                            getSelectKeywords($keywords);
                        else
                            getSelectKeywords();
                        ?>
                        <label>Réalisateurs du film :</label>
                        <?php
                        if (isset($creators))
                            getSelectCreators($creators);
                        else
                            getSelectCreators();
                        ?>
                        <label>Acteurs du film :</label>
                        <?php
                        if (isset($actors))
                            getSelectActors($actors);
                        else
                            getSelectActors();
                        ?>
                        <input name="addMovie" class="btn btn-lg btn-primary btn-block" type="submit" value="Ajouter le film"/>
                    </form>
                <?php } ?>
            </div>
        </div>
        <?php getFooter(); ?>
    </body>
</html>