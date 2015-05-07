<?php
require_once '../includes/structure.php';
require_once '../includes/crud_Movies.php';

//Redirection si le compte est en état temporaire
redirectTempAccount();

if (!isAdmin()) {
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
    <?php getHeaderHtml("Gestion films"); ?>
    <body>
        <?php
        getHeader();
        ?>
        <!-- CONTAINER -->
        <div class="container">
            <div class="center-block">
                <h2><span class="glyphicon glyphicon-cog"></span> Gestion des films</h2>
                <h5>Liste de tous les films</h5><hr/>
                <a class="btn btn-default btn-admin" href="add.php"><span class="glyphicon glyphicon-plus"></span> Ajouter un film</a>
                <table class="table table-striped table-condensed table-movie">
                    <thead>
                        <tr>
                            <th >id</th>
                            <th class="col-md-4">Titre</th>
                            <th>Date de sortie</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $dada = getAllMovies();

                        foreach ($dada as $value) {
                            ?>
                            <tr>
                                <th class="cell-id"><?php echo $value->id; ?></th>
                                <th class="cell-title"><?php echo $value->title; ?></th>
                                <th class="cell-date"><?php echo $value->date; ?></th>                            
                                <th class="cell-action">
                                    <a class="btn" data-toggle="tooltip" data-placement="bottom" title="Modifier le film" href="<?php echo ROOT_SITE . "/movie/edit.php?id=" . $value->id; ?>"><span class="glyphicon glyphicon-pencil"></span></a>
                                    <a class="btn btn-delete-movie" data-toggle="tooltip" data-placement="bottom" title="Supprimer le film"><span class="glyphicon glyphicon-remove"></span></a>
                                    <a class="btn" data-toggle="tooltip" data-placement="bottom" title="Voir la fiche du film" href="<?php echo ROOT_SITE . "/movie/fiche.php?id=" . $value->id; ?>"><span class="glyphicon glyphicon-eye-open"></span></a>
                                </th> 
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>

                <!-- Modal suppression -->
                <div class="modal fade" id="delete-modal" tabindex="1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="post" action="">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h3 class="modal-title" id="myModalLabel">Suppression</h3>
                                </div>
                                <div class="modal-body">
                                    <p>Êtes vous sur de vouloir supprimer le produit suivant : "<?php echo $product->title ?>" ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                    <input name="delete" class="btn btn-danger" type="submit" value="Supprimer"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
