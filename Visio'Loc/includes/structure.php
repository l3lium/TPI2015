<?php

/*
  ======Structure PHP======
  Auteur: 	Oliveira Stéphane
  Classe: 	I.IN-P4B
  Date:		06/05/2015
  Version:	0.3
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

function getSelectKeywords($id = null) {
    echo "<select multiple name=\"keywords[]\" class=\"form-control\">";
    foreach (getAllKeywords() as $value) {
        if (in_array($value->idKeyword, $id))
            echo "<option selected value=\"$value->idKeyword\">$value->label</option>";
        else
            echo "<option value=\"$value->idKeyword\">$value->label</option>";
    }
    echo "</select>";
}

function getSelectActors($id = NULL) {
    getSelectPerson(getAllActors(), "actors", $id);
}

function getSelectCreators($id = null) {
    getSelectPerson(getAllCreators(), "creators", $id);
}

function getSelectPerson($array, $name, $id = null) {
    echo "<select multiple name=\"".$name."[]\" class=\"form-control\">";
    foreach ($array as $value) {
        if (in_array($value->id, $id))
            echo "<option selected value=\"$value->id\">$value->firstName $value->lastName</option>";
        else
            echo "<option value=\"$value->id\">$value->firstName $value->lastName</option>";
    }
    echo "</select>";
}
