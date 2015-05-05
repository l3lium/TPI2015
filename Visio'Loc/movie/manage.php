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
                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Titre</th>
                            <th>Date de sortie</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                            <th>Fiche</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $dada = getAllFilms();

                        foreach ($dada as $value) {
                            ?>
                            <tr>
                                <th><?php echo $value->id; ?></th>
                                <th><?php echo $value->title; ?></th>
                                <th><?php echo $value->date; ?></th>                            
                                <th><a class="btn" href="<?php echo ROOT_SITE."/movie/edit.php?id=".$value->id;?>"><span class="glyphicon glyphicon-pencil"></span></a></th> 
                                <th><a class="btn"><span class="glyphicon glyphicon-remove"></span></a></th> 
                                <th><a class="btn" href="<?php echo ROOT_SITE."/movie/fiche.php?id=".$value->id;?>"><span class="glyphicon glyphicon-eye-open"></span></a></th> 
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
