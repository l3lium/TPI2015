<?php
require_once './includes/crud_User.php';
require_once './includes/structure.php';
//require_once '../includes/struct.php';

if (isConnected()) {
    header('Location: ' . ROOT_SITE . '/index.php');
}

//Connexion utilisateur
if (filter_input(INPUT_POST, 'login')) {
    $erreur = "";
    $valide = true;
    $email = filter_input(INPUT_POST, 'email');
    $pass = filter_input(INPUT_POST, 'password');

    if (!$email) {
        $valide = FALSE;
        $erreur = 'L\'adresse email n\'est pas valide.';
    } elseif (!$pass) {
        $valide = FALSE;
        $erreur = 'Veuillez rentrer un mot de passe.';
    }
    if ($valide) {
        if (userConnect($email, $pass)) {
            header('Location: ' . ROOT_SITE . '/index.php');
        } else {
            $valide = FALSE;
            $erreur = "L'addresse email ou le mot de passe est incorrect";
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
                <h2><span class="glyphicon glyphicon-log-out"></span> Connexion utilisateur</h2>
                <h5>Connectez-vous sur Visio'Loc pour pouvoir acheter et louer des films</h5><hr/>
                <!-- CONTAINER LOGIN -->
                <form class="form-signin" method="post" action="">
                    <label>Email :</label>
                    <input class="form-control" name="email" type="text" value="<?php if (isset($valide) && !$valide) {
            echo $email;
        } ?>" placeholder="ex : ''john.doe@placeholder.com''"/><br/> 
                    <label>Password :</label><input class="form-control" name="password" type="password"/><br/>
                    <?php
                    if (isset($valide) && !$valide) {
                        echo '<p class="alert alert-danger" role="alert">' . $erreur . '</p>';
                    }
                    ?>
                    <input name="login" class="btn btn-lg btn-primary btn-block" type="submit" value="Se connecter"/>
                </form>
            </div>
        </div>
    </body>
</html>