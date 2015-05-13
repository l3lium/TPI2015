<?php
require_once '../includes/structure.php';
require_once '../includes/specific_funtions.php';
require_once '../includes/crud_Movies.php';

//Redirection si le compte est en état temporaire
redirectTempAccount();

if (!isAdmin()) {
    goHome();
}

$sortCol = filter_input(INPUT_GET, "sort");
$desc = filter_input(INPUT_GET, "desc");
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <?php getHeaderHtml("Gestion films"); ?>
    <body>
        <?php
        getFullHeader();
        ?>
        <!-- CONTAINER -->
        <div class="container">
            <div class="center-block">
                <h2><span class="glyphicon glyphicon-cog"></span> Gestion des films</h2>
                <a class="btn btn-default btn-admin pull-right" href="add.php"><span class="glyphicon glyphicon-plus"></span> Ajouter un film</a>
                <h5>Liste de tous les films</h5>
                <hr/>

                <table class="table table-striped table-condensed table-responsive table-movie">
                    <thead>
                        <tr>
                            <th><a href="?sort=1<?php echo ($sortCol == 1 && !$desc) ? "&desc=true" : ""; ?>">id</a></th>
                            <th class="col-md-4"><a href="?sort=2<?php echo ($sortCol == 2 && !$desc) ? "&desc=true" : ""; ?>">Titre</a></th>
                            <th><a href="?sort=3<?php echo ($sortCol == 3 && !$desc) ? "&desc=true" : ""; ?>">Date de sortie</a></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $col = ($sortCol) ? $sortCol : 1;
                        $dada = getAllMovies($col, !$desc);

                        foreach ($dada as $value) {
                            ?>
                            <tr>
                                <th class="cell-id"><?php echo $value->id; ?></th>
                                <th class="cell-title"><?php echo $value->title; ?></th>
                                <th class="cell-date"><?php echo formatDate($value->date); ?></th>                            
                                <th class="cell-action">
                                    <a class="btn" data-toggle="tooltip" data-placement="bottom" title="Modifier les sous-titres du film" href="<?php echo ROOT_SITE . "movie/subtitles/manage.php?id=" . $value->id; ?>"><span class="glyphicon glyphicon-comment"></span></a>
                                    <a class="btn" data-toggle="tooltip" data-placement="bottom" title="Modifier le film" href="<?php echo ROOT_SITE . "movie/edit.php?id=" . $value->id; ?>"><span class="glyphicon glyphicon-pencil"></span></a>
                                    <a class="btn btn-delete-movie" data-toggle="tooltip" data-placement="bottom" title="Supprimer le film"><span class="glyphicon glyphicon-trash"></span></a>
                                    <a class="btn" data-toggle="tooltip" data-placement="bottom" title="Voir la fiche du film" href="<?php echo ROOT_SITE . "movie/detail.php?id=" . $value->id; ?>"><span class="glyphicon glyphicon-eye-open"></span></a>
                                    <a class="btn" data-toggle="tooltip" data-placement="bottom" title="Vissionner le film" href="<?php echo ROOT_SITE . "movie/player.php?id=" . $value->id; ?>"><span class="glyphicon glyphicon-play"></span></a>
                                </th> 
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>

                <!-- Modal suppression -->
                <div class="modal fade" id="modal-delete-movie" tabindex="1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="post" action="<?php echo ROOT_SITE . "movie/delete.php" ?>">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h3 class="modal-title" id="myModalLabel">Suppression</h3>
                                </div>
                                <div class="modal-body">
                                    <p id="modal-msg">Êtes vous sur de vouloir supprimer le film suivant : </p>
                                    <input id="input-delete-id" type="hidden" name="id" value="">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                    <input name="delete" class="btn btn-danger" type="submit" value="Supprimer"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php getFooter(); ?>
    </body>
</html>
