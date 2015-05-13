<?php
require_once '../includes/structure.php';
require_once '../includes/specific_funtions.php';
require_once '../includes/crud_User.php';

if (isConnected()) {
    goHome();
}

//Envoie nouveau mail
if (filter_input(INPUT_POST, 'recovery')) {
    $msg = "";
    $valide = true;
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    if (!$email) {
        $valide = FALSE;
        $msg = 'L\'adresse email n\'est pas valide.';
    }

    if ($user = getUserByEmail($email)) {
        $pass = generatePassword(10);
        updatePasswordById($user->id, hashPerso($pass, $user->id), true);
        $msg = getMsgTempPass($user->username, $pass);
        //mail($email, "Modification mot de passe", $msg);
    } else {
        $valide = FALSE;
        $msg = "Aucun utilisateur n'existe avec cette addresse mail: $email.";
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
    <?php getHeaderHtml("Réinitialiser mot de passe"); ?>
    <body>
        <?php
        getFullHeader();
        ?>
        <!-- CONTAINER -->
        <div class="container">
            <div class="center-block">
                <h2><span class="glyphicon glyphicon-plus"></span> Récupération de mot de passe</h2>
                <h5>Veuillez saisir une adresse e-mail</h5><hr/>
                <!-- CONTAINER Form -->
                <form class="form form-recovery" method="post" action="">
                    <label>Email :</label>
                    <input class="form-control" name="email" type="text" value="" placeholder="ex : ''john.doe@placeholder.com''"/>
                    <?php
                    if (isset($valide)) {
                        if (!$valide) {
                            ?>
                            <p class="alert alert-danger" role="alert"><?php echo $msg; ?></p>
                            <?php
                        } else {
                            ?>
                            <div class="alert alert-info">
                                <p><?php echo "TO: " . $email; ?></p>
                                <p><?php echo "Object: Modification mot de passe"; ?></p>
                                <p><?php echo $msg; ?></p>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <input name="recovery" class="btn btn-lg btn-primary btn-block" type="submit" value="Envoyer le nouveau mot de passe"/>
                </form>
            </div>
        </div>
        <?php getFooter(); ?>
    </body>
</html>
