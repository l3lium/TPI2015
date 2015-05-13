<?php
/*
  ======Structure PHP======
  Auteur: 	Oliveira Stéphane
  Classe: 	I.IN-P4B
  Date:		06/05/2015
  Version:	0.3
  Description:  Script permettant de définir quel include a utiliser dépendamment de l'utilisateur
 */
require_once 'specific_funtions.php';

function getHeaderHtml($pageName, $option = 0) {
    ?>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo $pageName; ?> - Visio'Loc</title>
        <link rel="icon" type="image/png" href="<?php echo ROOT_SITE . "favicon.png"; ?>" />

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <link href="<?php echo ROOT_SITE . "css/bootstrap.min.css"; ?>" rel="stylesheet">
        <script src="<?php echo ROOT_SITE . "js/bootstrap.min.js"; ?>"></script>

        <link href="<?php echo ROOT_SITE . "css/style.css"; ?>" rel="stylesheet">
        <?php if ($option == 1) { ?>
            <link href="<?php echo ROOT_SITE . "css/vlocPlayer.css"; ?>" rel="stylesheet">
            <script src="<?php echo ROOT_SITE . "js/vlocPlayer.js"; ?>"></script>
            <?php
        }
        ?>
        <script src="<?php echo ROOT_SITE . "js/form.js"; ?>"></script>
    </head>
    <?php
}

function getHeaderSearch($keys = "") {
    ?>
    <!-- Recherche-->
    <form role="search" class="navbar-form navbar-left" method="get" action="<?php echo ROOT_SITE . "movie/search.php" ?>">
        <div class="input-group search-bar">
            <input class="form-control" name="keys" type="search" value="<?php echo $keys; ?>" placeholder="Rechercher">
            <span class="input-group-btn">
                <button class="btn btn-success" name="search" type="submit" id="searchsubmit" value="search"><span class="glyphicon glyphicon-search"></span></button>
            </span>
        </div>
    </form>
    <?php
}

function getHeaderNav($keys = "") {
    ?>
    <div id="navbar" role="navigation" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;">
        <ul class="nav navbar-nav">
            <li><a href="<?php echo ROOT_SITE; ?>">Accueil</a></li>
            <li><a href="<?php echo ROOT_SITE . "movie/"; ?>">Films</a></li>
        </ul>

        <?php
        getHeaderSearch($keys);
        include 'struct/header_nav.php';
        ?>
    </div>
    <?php
}

function getFullHeader($keys = "") {
    ?>
    <!-- HEADER -->
    <header>
        <!-- NAVBAR -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo ROOT_SITE . "index.php"; ?>">Visio'Loc</a>
                </div>
                <?php getHeaderNav($keys); ?>
            </div>
        </nav>
        <!-- END NAVBAR -->
    </header>
    <!-- END HEADER -->
    <?php
}

function getFooter() {
    ?>
    <footer class="footer">
        <div class="container">
            <p class="text-right">Copyright &COPY; <?php echo date("Y"); ?> OLIVEIRA PAREDES Stéphane</p>
        </div>
    </footer>
    <?php
}

function getSelectKeywords($id = null) {
    echo "<select multiple name=\"keywords[]\" class=\"form-control\">";
    foreach (getAllKeywords() as $value) {
        if (in_array($value->idKeyword, $id))
            echo "<option selected value=\"$value->idKeyword\">$value->label</option>";
        else
            echo "<option value=\"$value->idKeyword\">$value->label</option>";
    }
    echo "</select>";
}

function getSelectLanguage($id = null) {
    echo "<select name=\"lang\" class=\"form-control\">";
    foreach (getAllLanguages() as $value) {
        if ($value->id == $id)
            echo "<option selected value=\"$value->id\">$value->label</option>";
        else
            echo "<option value=\"$value->id\">$value->label</option>";
    }
    echo "</select>";
}

function getSelectActors($id = NULL) {
    getSelectPerson(getAllActors(), "actors", $id);
}

function getSelectCreators($id = null) {
    getSelectPerson(getAllCreators(), "creators", $id);
}

function getSelectPerson($array, $name, $id = null) {
    echo "<select multiple name=\"" . $name . "[]\" class=\"form-control\">";
    foreach ($array as $value) {
        if (in_array($value->id, $id))
            echo "<option selected value=\"$value->id\">$value->firstName $value->lastName</option>";
        else
            echo "<option value=\"$value->id\">$value->firstName $value->lastName</option>";
    }
    echo "</select>";
}

function getMovieItem($movie) {
    ?>
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
        <div class="thumbnail thumbnail-movie">
            <a class="item-movie" href="<?php echo ROOT_SITE . "movie/detail.php?id=$movie->id"; ?>">
                <img class="img-responsive" src="<?php echo ROOT_SITE . $movie->imgSrc; ?>" alt="<?php echo "Affiche du film " . $movie->title; ?>" >
                <h3><?php echo $movie->title; ?></h3>
            </a>
        </div>
    </div>
    <?php
}

function getSearchItem($movie) {
    $link = ROOT_SITE . "movie/detail.php?id=$movie->id";
    ?>
    <div class="media media-search">
        <div class="media-left">
            <a href="<?php echo $link; ?>">
                <img class="media-object" src="<?php echo ROOT_SITE . $movie->imgSrc; ?>" alt="<?php echo "Affiche du film " . $movie->title; ?>">
            </a>
        </div>
        <div class="media-body">
            <a href="<?php echo $link; ?>"><h4 class="media-heading"><?php echo "$movie->title - " . formatDate($movie->date); ?></h4></a>
            <p><?php echo $movie->synopsis; ?></p>
        </div>
    </div>
    <?php
}

function getVideothequeItem($movie) {
    ?>
    <div class="col-sm-4 col-md-3 col-lg-2">
        <div class="thumbnail">
            <h4><?php echo $movie->title; ?></h4>
            <img class="<?php echo (($movie->rent) && (!$movie->valide)) ? "item-grey" : ""; ?>" src="<?php echo ROOT_SITE . $movie->imgSrc ?>" alt="<?php echo "Affiche du film " . $movie->title ?>">
            <div class="caption">
                <?php
                if ($movie->rent) {//Affichage item Location
                    if ($movie->valide) {//Visionnage valide
                        ?>
                        <p><?php echo "$movie->timeLeft"; ?> </p>
                        <a href="<?php echo ROOT_SITE . "movie/player.php?id=$movie->id" ?>" class="btn btn-primary" role="button">Visionner <span class="glyphicon glyphicon-play"></span></a>
                        <?php
                    } else {//Visionnage plus disponible
                        ?>
                        <p>Plus disponible</p>
                        <?php
                    }
                } else {//Affichage item achat 
                    ?>
                    <a href="<?php echo ROOT_SITE . "movie/player.php?id=$movie->id" ?>" class="btn btn-primary" role="button">Visionner <span class="glyphicon glyphicon-play"></span></a>
                        <?php
                    }
                    ?>
            </div>
        </div>
    </div>
    <?php
}

function getStrList($array, $showKey = false, $separator = ", ") {
    $list = "";

    foreach ($array as $key => $value) {

        if ($value != array_values($array)[0]) {
            $list .= $separator;
        }
        $list .= ($showKey) ? $value . " " . $key : $value;
    }

    return $list;
}
