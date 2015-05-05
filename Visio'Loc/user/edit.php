<?php
require_once '../includes/structure.php';
require_once '../includes/crud_User.php';

//Redirection si le compte est en état temporaire
redirectTempAccount();

if (!isConnected()) {
    goHome();
}


//Modification informations utilisateur
if (filter_input(INPUT_POST, 'edit')) {
    $msg = "";
    $valide = true;
    $username = filter_input(INPUT_POST, 'username');

    if (!$username) {
        $valide = FALSE;
        $msg = 'Le nom d\'utilisateur n\'est pas valide.';
    }

    if ($valide && $username != $_SESSION["username"]) {
        updateActualUsername($username);
        $msg = "Votre nom d'utilisateur a été modifié";
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
    <?php getHeaderHtml("Profil - " . $_SESSION["username"]); ?>
    <body>
        <?php
        getHeader();
        ?>
        <!-- CONTAINER -->
        <div class="container">
            <div class="center-block">
                <h2><span class="glyphicon glyphicon-edit"></span> Mon compte - <?php echo $_SESSION["username"]; ?></h2>
                <h5>Modifier vos informations personnelles</h5><hr/>
                <form class="form form-edit" method="POST" action="">
                    <div class="form-group">
                        <label for="Username" class="col-sm-4 control-label">Nom d'utilisateur : </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="username" value="<?php echo $_SESSION["username"]; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Email" class="col-sm-4 control-label">Email : </label>
                        <div class="col-sm-8">
                            <p><?php echo $_SESSION["email"]; ?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Email" class="col-sm-4 control-label">Mot de passe : </label>
                        <div class="col-sm-8">
                            <a class="form-link" href="<?php echo ROOT_SITE . "/user/editPassword.php"; ?>">Modifier votre mot de passe</a>
                        </div>
                    </div>
                    <?php if (isset($valide) && !empty($msg)) { ?>
                        <div class="form-group col-sm-12">
                            <?php
                            if ($valide) {
                                ?>
                                <p class="alert alert-success" role="alert"><?php echo $msg; ?></p>
                                <?php
                            } else {
                                ?>
                                <p class="alert alert-danger" role="alert"><?php echo $msg; ?></p>

                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="form-group-btn">
                        <div class="col-sm-offset-4 col-sm-5">
                            <input name="edit" class="btn btn-primary" type="submit" value="Enregistrer les modifications"/>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </body>
</html>
