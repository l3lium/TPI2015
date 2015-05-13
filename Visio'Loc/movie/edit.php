<?php
require_once '../includes/structure.php';
require_once '../includes/crud_Movies.php';
require_once '../includes/crud_Actors.php';

//Redirection si le compte est en état temporaire
redirectTempAccount();

if (!isAdmin()) {
    goHome();
}

if ($id = filter_input(INPUT_GET, 'id')) {
    if (!$movie = getMovieById($id)) {
        goHome();
    }
}

//debug($movie);

if (filter_input(INPUT_POST, 'editMovie')) {
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
        $oldImg = $_SERVER["DOCUMENT_ROOT"] . $movie->imgSrc;
        $oldVideo = $_SERVER["DOCUMENT_ROOT"] . $movie->videoSrc;

        if (empty($srcPoster)) {
            $img = $movie->imgSrc;
        } else {
            if (file_exists($oldImg) && strlen($movie->imgSrc)) {
                unlink($oldImg);
            }

            $img = $srcPoster;
        }
        if (empty($srcVideo)) {
            $video = $movie->videoSrc;
        } else {
            if (file_exists($oldVideo) && strlen($movie->videoSrc)) {
                unlink($oldVideo);
            }

            $video = $srcVideo;
        }

        //Mis à jour du film
        updateMovie($id, $title, $date, $img, $video, $synopsis);

        deleteAllKeywordsByMovieId($id); //Suppresion de tous les mots clés
        deleteAllActorsByMovieId($id); //Suppresion de tous les acteurs
        deleteAllCreatorsByMovieId($id); //Suppresion de tous les réalisateurs

        addKeywordsMovie($id, $keywords); //Ajout des nouveaux mots clés
        addActorsMovie($id, $actors); //Ajout des nouveaux créateurs
        addCreatorsMovie($id, $creators); //Ajout des novueaux réalisateurs
    }
} else {
    $keywords = getKeysIdByMovieId($id);
    $actors = getActorsIdByMovieId($id);
    $creators = getCreatorsIdByMovieId($id);
}
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <?php getHeaderHtml("Modification de $movie->title"); ?>
    <body>
        <?php
        getFullHeader();
        ?>
        <!-- CONTAINER -->
        <div class="container">
            <div class="center-block">
                <h2><span class="glyphicon glyphicon-film"></span> Modification de <?php echo $movie->title; ?></h2>
                <h5>Information du film</h5><hr/>
                <?php
                if (isset($valide) && $valide) {
                    header("refresh:5; url=" . ROOT_SITE . "movie/detail.php?id=$id");
                    ?>
                    <div class="alert alert-success" role="alert">
                        <p>Le film a été modifié. <i>Vous allez être redirigé sur la fiche du film automatiquement.</i></p>
                    </div>
                <?php } else { ?>
                    <!-- CONTAINER ADD MOVIE -->
                    <form id="form-edit-movie"class="form" enctype="multipart/form-data" method="post" action="<?php echo ROOT_SITE . "movie/edit.php?id=$id"; ?>">
                        <?php
                        if (isset($valide) && !$valide) {
                            echo '<p class="alert alert-danger" role="alert">' . $erreur . '</p>';
                        }
                        ?>
                        <label class="">Titre du film :</label>
                        <input class="form-control" name="title" type="text" value="<?php echo (isset($valide) && !$valide) ? $title : $movie->title; ?>" placeholder="ex : ''Titanic''"/>
                        <label class="">Date de sortie :</label>
                        <input class="form-control" name="date" type="date" value="<?php echo (isset($valide) && !$valide) ? $date : $movie->date; ?>" placeholder="ex : ''29/01/1998''"/>
                        <label for="comment">Synopsis:</label>
                        <textarea id="2" class="form-control" rows="5" name="synopsis"><?php echo (isset($valide) && !$valide && isset($synopsis)) ? $synopsis : $movie->synopsis; ?></textarea>
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
                        getSelectKeywords($keywords);
                        ?>
                        <label>Réalisateurs du film :</label>
                        <?php
                        getSelectCreators($creators);
                        ?>
                        <label>Acteurs du film :</label>
                        <?php
                        getSelectActors($actors);
                        ?>
                        <input name="editMovie" class="btn btn-lg btn-primary btn-block" type="submit" value="Enregistrer les modifications"/>
                    </form>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php getFooter(); ?>
    </body>
</html>
