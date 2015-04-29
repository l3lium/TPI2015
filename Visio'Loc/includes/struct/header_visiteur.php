<?php ?>
<!-- HEADER -->
<header>
    <!-- NAVBAR -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo ROOT_SITE."/"; ?>index.php">Visio'Loc</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;">
                <ul class="nav navbar-nav">
                    <li><a href="<?php echo ROOT_SITE."/"; ?>index.php">Accueil</a></li>
                    <li><a href="#films">Films</a></li>
                </ul>
                <!-- Recherche-->
                <form role="search" class="navbar-form navbar-left">
                    <div class="form-group">
                        <input class="form-control search-bar" type="search" placeholder="Rechercher">
                        <button class="btn btn-success" type="submit" id="searchsubmit" value="search"><span class="glyphicon glyphicon-search"></span></button>
                    </div>
                </form>
                <!-- Enregistrement, Connnexion -->
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="<?php echo ROOT_SITE."/"; ?>signup.php"><span class="glyphicon glyphicon-user"></span> S'enrengistrer</a></li>
                    <li><a href="<?php echo ROOT_SITE."/"; ?>signin.php"><span class="glyphicon glyphicon-log-in"></span> Se connecter</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- END NAVBAR -->
</header>
<!-- END HEADER -->
