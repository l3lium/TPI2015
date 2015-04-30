<?php
require_once '../includes/structure.php';

if (!isConnected()){
    header('Location: ' . ROOT_SITE . '/index.php');
}

?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <?php getHeaderHtml("Accueil"); ?>
    <body>
        <?php
        getHeader();
        ?>
        <!-- CONTAINER -->
        <div class="container">
            <div class="center-block">
                <h2><span class="glyphicon glyphicon-user"></span> Mon compte - <?php echo $_SESSION["username"];?></h2>
                <h5>Inscrivez-vous sur Visio'Loc pour pouvoir acheter et louer des films</h5><hr/>
                <?php
                if (isset($valide) && $valide) {
                    header("refresh:5; url=" . ROOT_SITE . "/index.php");
                    ?>
                    <div class="alert alert-success" role="alert">
                        <p>Votre inscription a été effectué avec succès. <i>Vous allez être redirigé vers l'accueil automatiquement.</i></p>
                    </div>
                <?php } else { ?>
                    <!-- CONTAINER LOGIN -->
                    <form class="form-signin" method="post" action="">

                        <label class="">Pseudo :</label><input class="form-control" name="username" type="text" value="<?php
                        if (isset($valide) && !$valide) {
                            echo $pseudo;
                        }
                        ?>" placeholder="ex : ''Johndoe''"/><br/>
                        <label>Email :</label><input class="form-control" name="email" type="text" value="<?php
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
                        <!-- <input name="signup" class="btn btn-lg btn-primary btn-block" type="submit" value="S'inscrire"/>-->
                    </form>
                <?php } ?>
            </div>
        </div>
    </body>
</html>
