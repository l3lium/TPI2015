<?php

require_once '../includes/specific_funtions.php';

if (isset($_FILES["sub"]) && $_FILES["sub"]["error"] == UPLOAD_ERR_OK) {
    //Vérifie si c'est une requette ajax
    if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        die();
    }

    //Vérifie la taille du fichier
    if ($_FILES["sub"]["size"] > MAX_SIZE_SUB) {
        die('<p class="alert alert-danger">La taille du fichier est trop grand! (' . (MAX_SIZE_SUB / 100000) . 'Mo)</p>');
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE); // récupération type mime 
    //Vérifie le type du sous-titre
    if (!checkSubtitleType(finfo_file($finfo, $_FILES["sub"]["tmp_name"]))) {
        die('<p class="alert alert-danger">Type de fichier non supporté! fichier Web VTT seulement</p>');
    }

    $file = $_FILES['sub']['name'];
    $filename = uniqid($_SESSION['id']) . '.' . pathinfo($file, PATHINFO_EXTENSION);
    $subPath = realpath(".") . "/" . SUBTITLE_FOLDER . $filename;

    if (move_uploaded_file($_FILES['sub']['tmp_name'], $subPath)) {
        echo '<p class="alert alert-success">Le fichier a été upload.</p>';
        echo "<input type=\"hidden\" name=\"srcSub\" value=\"" . CONTENT_UPLOAD . SUBTITLE_FOLDER . "$filename\">";
    } else {
        die('<p class="alert alert-danger">Une erreur est survenue lors de l\'upload!</p>');
    }
} else {
    die('<p class="alert alert-danger">Une errreur est survenue!</p>');
}    