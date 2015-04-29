<?php
require_once './includes/crud_User.php';
require_once './includes/structure.php';
//require_once '../includes/struct.php';

if (isConnected()) {
    header('Location: ' . ROOT_SITE . '/index.php');
}

if (filter_input(INPUT_POST, 'signup')) {
    $valide = true;
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $pseudo = filter_input(INPUT_POST, 'username');
    $pass = filter_input(INPUT_POST, 'password');
    $passConfirm = filter_input(INPUT_POST, 'passwordConfirm');

    if (!$pseudo) {
        $valide = FALSE;
        $erreur = 'Le pseudo n\'est pas valide.';
    } else if (!$email) {
        $valide = FALSE;
        $erreur = 'L\'adresse email n\'est pas valide.';
    } else if (getUserByEmail($email)) {
        $valide = FALSE;
        $erreur = 'Cette addresse email est déjà utilisée.';
    } else if (!$pass) {
        $valide = FALSE;
        $erreur = 'Le mot de passe n\'est pas valide.';
    } else if ($pass != $passConfirm) {
        $valide = FALSE;
        $erreur = 'Les mots de passes ne sont pas identiques.';
    }

    if ($valide) {
        createUser($email, $pseudo, $pass);
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
    <?php getHeaderHtml("Inscription"); ?>
    <body>
        <?php getHeader(); ?>
        <!-- CONTAINER -->
        <div class="container">
            <div class="center-block">
                <h2>Inscritpion utilisateur</h2>
                <h5>Inscrivez-vous sur Visio'Loc pour pouvoir acheter et louer des films</h5><hr/>
                <?php
                if (isset($valide) && $valide) {
                    header("refresh:5; url=".ROOT_SITE."/index.php");
                    ?>
                    <div class="alert alert-success" role="alert">
                        <p>Votre inscription a été effectué avec succès. <i>Vous allez être redirigé vers l'accueil automatiquement.</i></p>
                    </div>
                <?php } else { ?>
                    <!-- CONTAINER LOGIN -->
                    <form class="form-signin" method="post" action="">

                        <label class="">Pseudo:</label><input class="form-control" name="username" type="text" value="<?php
                        if (isset($valide) && !$valide) {
                            echo $pseudo;
                        }
                        ?>" placeholder="ex : ''Johndoe''"/><br/>
                        <label>Email:</label><input class="form-control" name="email" type="text" value="<?php
                        if (isset($valide) && !$valide) {
                            echo $email;
                        }
                        ?>" placeholder="ex : ''john.doe@placeholder.com''"/><br/> 
                        <label>Password :</label><input class="form-control" name="password" type="password"/><br/>
                        <label>Password confirm :</label><input class="form-control" name="passwordConfirm" type="password"/><br/>
                        <?php
                        if (isset($valide) && !$valide) {
                            echo '<p class="alert alert-danger" role="alert">' . $erreur . '</p>';
                        }
                        ?>
                        <input name="signup" class="btn btn-lg btn-primary btn-block" type="submit" value="S'inscrire"/>
                    </form>
                <?php } ?>
            </div>
        </div>
    </body>
</html>
