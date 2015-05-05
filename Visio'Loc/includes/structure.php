<?php
/*
  ======Structure PHP======
  Auteur: 	Oliveira Stéphane
  Classe: 	I.IN-P4B
  Date:		29/04/2015
  Version:	0.1
  Description:  Script permettant de définir quel include a utiliser dépendamment de l'utilisateur
 */
require_once 'specific_funtions.php';

function getHeaderHtml($pageName) {
    echo
    "<head>
        <meta charset=\"utf-8\">
        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
        <title>$pageName - Visio'Loc</title>

        <!-- Bootstrap -->
        <link href=\"" . ROOT_SITE . "/css/bootstrap.min.css\" rel=\"stylesheet\">
        <link href=\"" . ROOT_SITE . "/css/style.css\" rel=\"stylesheet\">
        <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js\"></script>
        <script src=\"" . ROOT_SITE . "/js/bootstrap.min.js\"></script>
        <script src=\"" . ROOT_SITE . "/js/upload.js\"></script>
    </head>";
}

function getHeader() {
    include '/struct/header_base.php';
}
