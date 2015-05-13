<?php
require_once '../../includes/structure.php';
require_once '../../includes/crud_Movies.php';

//Redirection si le compte est en état temporaire
redirectTempAccount();

if ($id = filter_input(INPUT_GET, 'id')) {
    if (!$movie = getMovieById($id)) {
        goHome();
    }
}
?>
<html>
    <?php getHeaderHtml("Gestion Sous-titres"); ?>
    <body>
        <?php
        getFullHeader();
        ?>
        <!-- CONTAINER -->
        <div class="container">
            <div class="center-block">
                <h2><span class="glyphicon glyphicon-cog"></span> Gestion des sous-titres - <?php echo $movie->title; ?></h2>
                <button id="btn-add-sub" class="btn btn-default btn-admin pull-right" data-toggle="modal" data-target="#modal-add-sub"><span class="glyphicon glyphicon-plus"></span> Ajouter un sous-titre</button>
                <h5>Liste des sous-titres</h5>
                <hr/>
                <table class="table table-striped table-condensed table-responsive table-subs">
                    <thead>
                        <tr>
                            <th class="hidden">id Film</th>
                            <th class="hidden">id langue</th>
                            <th>Langue</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $subs = getMovieSubs($id);
                        foreach ($subs as $value) {
                            ?>
                            <tr>
                                <th class="cell-id-movie hidden"><?php echo $value->idMovie; ?></th>
                                <th class="cell-id-lang hidden"><?php echo $value->idLang; ?></th>                           
                                <th class="cell-lang"><?php echo $value->label; ?></th>                           
                                <th class="cell-action">
                                    <a class="btn btn-delete-sub" data-toggle="tooltip" data-placement="bottom" title="Supprimer le sous-titre"><span class="glyphicon glyphicon-trash"></span></a>
                                </th> 
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                <!-- Modal ajout sous-titre -->
                <div class="modal fade" id="modal-add-sub" tabindex="1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="post" action="<?php echo ROOT_SITE . "movie/subtitles/add.php" ?>">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h3 class="modal-title" id="myModalLabel">Ajout de sous-titre</h3>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="idMovie" value="<?php echo $id; ?>">
                                    <!--<p id="modal-msg">Êtes vous sur de vouloir supprimer le sous-titre </p>-->

                                    <?php
                                    if (isset($valide) && !$valide && $srcVideo) {
                                        ?>
                                        <label>La vidéo a été envoyée</label>
                                        <input type="hidden" name="srcSub" value="<?php echo $srcVideo; ?>">
                                        <?php
                                    } else {
                                        ?>
                                        <div id="upload-group-sub" class="form-inline">
                                            <div class="form-group">
                                                <label>Vidéo du film :</label>
                                                <input id="input-sub" type="file" name="sub" accept="text/vtt">
                                            </div>
                                            <div id="upload-sub" class="form-group hidden">
                                                <button data-url-upload="<?php echo ROOT_SITE . "up-content/uploadSub.php"; ?>" type="button" class="btn btn-sm btn-success">Upload</button>
                                            </div>
                                            <div class="progress hidden">
                                                <div id="progress-bar-sub" class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="0"
                                                     aria-valuemin="0" aria-valuemax="100" style="width:0%">
                                                    0%
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <label>Langue du sous-titre :</label>
                                    <?php getSelectLanguage(); ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                                    <input name="addSub" class="btn btn-success" type="submit" value="Ajouter le sous-titre"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Modal suppression -->
                <div class="modal fade" id="modal-delete-sub" tabindex="1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="post" action="<?php echo ROOT_SITE . "movie/subtitles/delete.php" ?>">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h3 class="modal-title" id="myModalLabel">Suppression</h3>
                                </div>
                                <div class="modal-body">
                                    <p id="modal-msg">Êtes vous sur de vouloir supprimer le sous-titre </p>
                                    <input id="input-delete-id" type="hidden" name="idMovie" value="">
                                    <input id="input-delete-id" type="hidden" name="idLang" value="">
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
