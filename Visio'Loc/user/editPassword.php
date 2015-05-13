<?php
require_once '../includes/structure.php';
require_once '../includes/crud_User.php';

if (!isConnected()) {
    goHome();
}

if (filter_input(INPUT_POST, 'editPassword')) {
    $valide = true;

    
    $oldPass = filter_input(INPUT_POST, 'oldPass');
    $newPass = filter_input(INPUT_POST, 'newPass');
    $confirmPass = filter_input(INPUT_POST, 'confirmPass');

    //Vérification des parametres
    if (!$oldPass && !isAccountTemp()) {// pas besoin de l'ancien mot de passe si temporaire
        $valide = FALSE;
        $erreur = 'L\'ancien mot de passe n\'est pas valide.';
    } elseif (!$newPass) {
        $valide = FALSE;
        $erreur = 'Le nouveau mot de passe n\'est pas valide.';
    } elseif (!$confirmPass) {
        $valide = FALSE;
        $erreur = 'La confirmation de nouveau mot de passe n\'est pas valide.';
    } elseif ($oldPass == $newPass) {
        $valide = FALSE;
        $erreur = 'Le nouveau mot de passe doit être différent de l\'ancien.';
    } elseif ($newPass != $confirmPass) {
        $valide = FALSE;
        $erreur = 'Les nouveaux mots de passes ne sont pas identiques.';
    }

    //Test ancien mot de passe
    $user = getUserById($_SESSION["id"]);

    if (!isAccountTemp() && $user->password != hashPerso($oldPass, $_SESSION["id"])) {
        $valide = FALSE;
        $erreur = 'L\'ancien mot de passe n\'est pas correct.';
    }

    //modificaiton du mot de passe
    if ($valide) {
        updateActualUserPassword(hashPerso($newPass, $_SESSION["id"]));
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
    <?php getHeaderHtml("Modification mot de passe"); ?>
    <body>
        <?php
        getFullHeader();
        ?>
        <!-- CONTAINER -->
        <div class="container">
            <div class="center-block">
                <h2><span class="glyphicon glyphicon-wrench"></span> Modification du mot de passe</h2>
                <h5><?php
                    if (isAccountTemp()) {
                        echo "Votre mot de passe est temporaire. Vous devez le modifier.";
                    }
                    ?>
                </h5><hr/>
                <?php
                if (isset($valide) && $valide) {
                    header("refresh:5; url=" . ROOT_SITE . "/user/edit.php");
                    ?>
                    <div class="alert alert-success" role="alert">
                        <p>Votre mot de passe a été modifié. <i>Vous allez être redirigé sur votre page de profil automatiquement.</i></p>
                    </div>
                <?php } else { ?>
                    <!-- CONTAINER CHANGE PASSWORD -->
                    <form class="form form-edit-password" method="post" action="<?php echo ROOT_SITE . "/user/editPassword.php"; ?>">
                        <?php if (!isAccountTemp()) { ?>
                            <label>Ancien mot de passe :</label>
                            <input class = "form-control" name = "oldPass" type = "password"/>
                        <?php
                        }
                        ?>
                        <label>Nouveau mot de passe :</label>
                        <input class = "form-control" name = "newPass" type = "password"/>
                        <label>Confirmation mot de passe :</label>
                        <input class = "form-control" name = "confirmPass" type = "password"/>
                        <?php
                        if (isset($valide) && !$valide) {
                            echo '<p class="alert alert-danger" role="alert">' . $erreur . '</p>';
                        }
                        ?>
                        <div class="form-group-btn">
                            <input name="editPassword" class="btn btn-lg btn-primary col-sm-6" type="submit" value="Modifier le mot de passe"/>
                            <input name="reset" class="btn btn-lg btn-primary col-sm-6" type="reset" value="Annuler"/>
                        </div>

                    </form>
                <?php } ?>
            </div>
        </div>
        <?php getFooter(); ?>
    </body>
</html>
