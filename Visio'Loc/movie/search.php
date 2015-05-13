<?php
require_once '../includes/structure.php';
require_once '../includes/crud_Movies.php';
require_once '../includes/crud_Actors.php';

//Redirection si le compte est en état temporaire
redirectTempAccount();

if ($keys = filter_input(INPUT_GET, 'keys')) {
    $strKeys = "*" . implode("* *", explode(' ', $keys)) . "*";
    $movies = multipleSearch($strKeys);
} else {
    $keys = "";
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
        getFullHeader($keys);
        ?>
        <!-- CONTAINER -->
        <div class="container">
            <div class="center-block">
                <h2><span class="glyphicon glyphicon-search"></span> Recherche - "<?php echo $keys; ?>"</h2>
                <h5>Résultat de la recherche</h5><hr/>
                <div class="container container-search">

                    <?php $movies = multipleSearch($strKeys);
                    if (count($movies) > 0) {
                        ?>
                        <p><?php echo count($movies); ?> résultat(s) trouvé(s):</p> <?php
                        foreach ($movies as $movie) {
                            getSearchItem($movie);
                        }
                    }else{ ?>
                        <p>Désolé aucun films n'a été trouvés.</p> <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php getFooter(); ?>
    </body>
</html>
