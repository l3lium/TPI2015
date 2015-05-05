<?php
require_once './includes/crud_User.php';
require_once './includes/structure.php';
//require_once '../includes/struct.php';

if (isConnected()) {
    goHome();
}

if (filter_input(INPUT_POST, 'signup')) {
    $valide = true;
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $pseudo = filter_input(INPUT_POST, 'username');
    $pass = filter_input(INPUT_POST, 'password');
    $passConfirm = filter_input(INPUT_POST, 'passwordConfirm');

    if (!$pseudo) {
        $valide = FALSE;
        $erreur = 'Le nom d\'utilisateur n\'est pas valide.';
    } elseif (!$email) {
        $valide = FALSE;
        $erreur = 'L\'adresse email n\'est pas valide.';
    } elseif (getUserByEmail($email)) {
        $valide = FALSE;
        $erreur = 'Cette addresse email est déjà utilisée.';
    } elseif (!$pass) {
        $valide = FALSE;
        $erreur = 'Le mot de passe n\'est pas valide.';
    } elseif ($pass != $passConfirm) {
        $valide = FALSE;
        $erreur = 'Les mots de passes ne sont pas identiques.';
    }

    if ($valide) {
        $id = createUser($email, $pseudo, $pass);
        if ($id == 0) {
            $valide = FALSE;
            $erreur = 'Une erreur est survenu lors de l\'inscription. Veuillez réessayer ulterieurement.';
        }
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
                    header("refresh:5; url=" . ROOT_SITE . "/signin.php");
                    ?>
                    <div class="alert alert-success" role="alert">
                        <p>Votre inscription a été effectué avec succès. <i>Vous allez être redirigé sur la page de connexion automatiquement.</i></p>
                    </div>
                <?php } else { ?>
                    <!-- CONTAINER LOGIN -->
                    <form class="form form-signin" method="post" action="<?php echo ROOT_SITE . "/signup.php"; ?>">

                        <label class="">Nom utilisateur :</label><input class="form-control" name="username" type="text" value="<?php
                        if (isset($valide) && !$valide) {
                            echo $pseudo;
                        }
                        ?>" placeholder="ex : ''Johndoe''"/>
                        <label>Adresse email :</label><input class="form-control" name="email" type="text" value="<?php
                        if (isset($valide) && !$valide) {
                            echo $email;
                        }
                        ?>" placeholder="ex : ''john.doe@placeholder.com''"/> 
                        <label>Mot de passe :</label><input class="form-control" name="password" type="password"/>
                        <label>Confirmation mot de passe :</label><input class="form-control" name="passwordConfirm" type="password"/>
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
