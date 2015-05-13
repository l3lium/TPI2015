<?php
require_once '../includes/structure.php';
require_once '../includes/crud_Movies.php';
require_once '../includes/crud_User.php';

//Redirection si le compte est en état temporaire
redirectTempAccount();

if (!isConnected() || isAdmin()) {
    goHome();
}
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <?php getHeaderHtml("Ma vidéothèque"); ?>
    <body>
        <?php
        getFullHeader();
        ?>
        <!-- CONTAINER -->
        <div class="container">
            <div class="center-block">
                <h2><span class="glyphicon glyphicon-film"></span> Ma vidéothèque</h2>
                <h5></h5><hr/>
                <div>
                    <div class="container container-videotheque ">
                        <h3>Films loués</h3><hr/>
                        <div class="row">
                            <?php
                            //debug(getMoviesRent());
                            foreach (getMoviesRent() as $value) {
                                getVideothequeItem($value);
                            }
                            ?>
                        </div>
                    </div>
                    <div class="container container-videotheque">
                        <h3>Films achetés</h3><hr/>
                        <div class="row">
                            <?php
                            foreach (getMoviesBuy() as $value) {
                                getVideothequeItem($value);
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php getFooter(); ?>
    </body>
</html>
