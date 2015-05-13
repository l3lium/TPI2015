<?php
require_once './includes/crud_User.php';
require_once './includes/structure.php';

if (isConnected()) {
    goHome();
}

//Connexion utilisateur
if (filter_input(INPUT_POST, 'login')) {
    $erreur = "";
    $valide = true;
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
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
            goHome();
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
    <?php getHeaderHtml("Connexion"); ?>
    <body>
        <?php getFullHeader(); ?>
        <!-- CONTAINER -->
        <div class="container">
            <div class="center-block">
                <h2><span class="glyphicon glyphicon-log-out"></span> Connexion utilisateur</h2>
                <h5>Connectez-vous sur Visio'Loc pour pouvoir acheter et louer des films</h5><hr/>
                <!-- CONTAINER LOGIN -->
                <form class="form form-signin" method="post" action="<?php echo ROOT_SITE."signin.php";?>">
                    <label>Adresse email :</label>
                    <input class="form-control" name="email" type="text" value="<?php
                    if (isset($valide) && !$valide) {
                        echo $email;
                    }
                    ?>" placeholder="ex : ''john.doe@placeholder.com''"/>
                    <label>Mot de passe :</label><input class="form-control" name="password" type="password"/>
                    <a class="form-link" href="<?php echo ROOT_SITE."user/recovery.php"; ?>">Mot de passe oublié ?</a>
                    <?php
                    if (isset($valide) && !$valide) {
                        echo '<p class="alert alert-danger" role="alert">' . $erreur . '</p>';
                    }
                    ?>
                    <div class="form-group-btn">
                        <input name="login" class="btn btn-lg btn-primary col-sm-6" type="submit" value="Se connecter"/>
                        <input name="reset" class="btn btn-lg btn-primary col-sm-6" type="reset" value="Annuler"/>
                    </div>
                    
                </form>
            </div>
        </div>
        <?php getFooter(); ?>
    </body>
</html>