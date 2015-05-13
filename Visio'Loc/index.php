<?php
require_once '/includes/structure.php';
require_once './includes/crud_Movies.php';

//Redirection si le compte est en état temporaire
redirectTempAccount();
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <?php getHeaderHtml("Accueil"); ?>
    <body>
        <?php
        getFullHeader();
        ?>
        <div class="container">
            <div class="center-block">
                <?php
                $newMovies = getNewMovies();
                if (count($newMovies) > 0) {
                    ?>
                    <h2><span class="glyphicon glyphicon-log-out"></span> Nouveautés</h2>
                    <h5>Récemment sorti sur Visio'Loc</h5><hr/>
                    <div class="row">
                        <?php
                        foreach ($newMovies as $movie) {
                            getMovieItem($movie);
                        }
                        
                        ?> 
                    </div><?php
                }
                ?>
                <?php
                $upMovies = getUpComingMovies();
                if (count($upMovies) > 0) {
                    ?>
                    <h2><span class="glyphicon glyphicon-log-out"></span> Prochainement</h2>
                    <h5>Prochainement sur Visio'Loc</h5><hr/>
                    <div class="row">
                        <?php
                        foreach ($upMovies as $movie) {
                            getMovieItem($movie);
                        }
                        
                        ?> 
                    </div><?php
                }
                ?>
            </div>
        </div>
        <?php getFooter(); ?>
    </body>
</html>
