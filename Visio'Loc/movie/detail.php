<?php
require_once '../includes/structure.php';
require_once '../includes/crud_Movies.php';
require_once '../includes/crud_Actors.php';
require_once '../includes/specific_funtions.php';

//Redirection si le compte est en état temporaire
redirectTempAccount();

$id = filter_input(INPUT_GET, 'id');
if ($id) {
    if (!$movie = getMovieById($id)) {
        goHome();
    } else {
        //Création de la liste des mots clés
        $keys = getKeysByMovieId($movie->id, PDO::FETCH_ASSOC);
        $listKeys = implode(', ', array_column($keys, "label"));

        //Création de la liste des acteurs
        $actors = array_column(getActorsByMovieId($movie->id, PDO::FETCH_ASSOC), "firstName", "lastName");
        $listActors = getStrList($actors, true);

        //Création de la liste des réalisateurs
        $creators = array_column(getCreatorsByMovieId($movie->id, PDO::FETCH_ASSOC), "firstName", "lastName");
        $listCreators = getStrList($creators, true);
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
    <?php getHeaderHtml("Fiche $movie->title"); ?>
    <body>
        <?php
        getFullHeader();
        ?>
        <!-- CONTAINER -->
        <div class="container">
            <div class="center-block">
                <h2><span class="glyphicon glyphicon-film"></span> Fiche - <?php echo $movie->title; ?></h2>
                <h5>Informations du film</h5><hr/>
                <div class="container container-detail">
                    <div class="col-sx-12 col-sm-5 col-lg-5">
                        <img class="detail-poster img-responsive" src="<?php echo ROOT_SITE . $movie->imgSrc; ?>" alt="<?php echo "Affiche du film " . $movie->title; ?>" >
                    </div>
                    <div class="col-sx-12 col-sm-5 col-lg-5">
                        <dl class="dl-horizontal detail">
                            <dt>Titre du film :</dt>
                            <dd><?php echo $movie->title; ?></dd>
                            <dt>Date de sortie :</dt>
                            <dd><?php
                                echo formatDate($movie->date);
                                ?></dd>
                            <dt>Réalisateur(s) :</dt>
                            <dd><?php echo $listCreators; ?></dd>
                            <dt>Acteur(s) :</dt>
                            <dd><?php echo $listActors; ?></dd>
                            <dt>Mots clés :</dt>
                            <dd><?php echo $listKeys; ?></dd>
                            <dt>Synopsis :</dt>
                            <dd><?php echo $movie->synopsis; ?></dd>
                        </dl>
                        <div class="container-fluid container-buy-buttons">
                            <form action="<?php echo ROOT_SITE. "movie/buy.php"?>" method="post">
                                <input type="hidden" name="id" value="<?php echo $id;?>">
                                <button class="btn btn-primary" type="submit" name="buy" value="true">Acheter le film</button>
                                <button class="btn btn-primary" type="submit" name="rent" value="true">Louer le film</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php getFooter(); ?>
    </body>
</html>
