<?php
if (isConnected()) {
    if (isAdmin()) {
        ?>
        <!-- Dropdown Admin -->
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href=""><span class="glyphicon glyphicon-user"></span> <?php echo "Administrateur - " . $_SESSION['username']; ?> <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a class="btn btn-link" href="<?php echo ROOT_SITE . "user/edit.php"; ?>">Mon compte <span class="glyphicon glyphicon-cog"></span></a></li>
                    <li><a class="btn btn-link" href="<?php echo ROOT_SITE . "movie/manage.php"; ?>">Administration des films <span class="glyphicon glyphicon-film"></span></a></li>
                    <li><a class="btn btn-link" href="<?php echo ROOT_SITE . "logout.php"; ?>">Se deconnecter <span class="glyphicon glyphicon-log-out"></span></a></li>
                </ul>
            </li>
        </ul>
    <?php } else { ?>
        <!-- Dropdown Utilisateur -->
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href=""><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['username']; ?> <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a class="btn btn-link" href="<?php echo ROOT_SITE . "user/edit.php"; ?>">Mon compte <span class="glyphicon glyphicon-cog"></span></a></li>
                    <li><a class="btn btn-link" href="<?php echo ROOT_SITE . "user/videolibrary.php"; ?>">Ma vidéothèque <span class="glyphicon glyphicon-film"></span></a></li>
                    <li><a class="btn btn-link" href="<?php echo ROOT_SITE . "logout.php"; ?>">Se deconnecter <span class="glyphicon glyphicon-log-out"></span></a></li>
                </ul>
            </li>
        </ul>
        <?php
    }
} else {
    ?>
    <!-- Enregistrement, Connnexion -->
    <ul class="nav navbar-nav navbar-right">
        <li><a href="<?php echo ROOT_SITE . "signup.php"; ?>"><span class="glyphicon glyphicon-user"></span> S'enrengistrer</a></li>
        <li><a href="<?php echo ROOT_SITE . "signin.php"; ?>"><span class="glyphicon glyphicon-log-in"></span> Se connecter</a></li>
    </ul>
<?php } ?>