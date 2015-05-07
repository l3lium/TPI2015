<?php

require_once '../includes/specific_funtions.php';

if (isset($_FILES["poster"]) && $_FILES["poster"]["error"] == UPLOAD_ERR_OK) {
    //Vérifie si c'est une requette ajax
    if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        die();
    }

    //Vérifie la taille du fichier
    if ($_FILES["poster"]["size"] > MAX_SIZE_IMG) {
        die('<p class="alert alert-danger">La taille du fichier est trop grand!. (' . (MAX_SIZE_IMG / 100000) . 'Go)</p>');
    }

    //Vérifie le type de l'image
    if (!checkImageType($_FILES['poster']['type'])) {
        die('<p class="alert alert-danger">Type de fichier non supporté!</p>');
    }

    $file = $_FILES['poster']['name'];
    $imgFilename = uniqid($_SESSION['id']) . '.' . pathinfo($file, PATHINFO_EXTENSION);
    $imgPath = realpath(".") .IMG_FOLDER. $imgFilename;
    
    if (move_uploaded_file($_FILES['poster']['tmp_name'], $imgPath)) {
        // do other stuff 
        echo '<p class="alert alert-success">Le fichier a été upload.</p>';
        echo "<input type=\"hidden\" name=\"srcPoster\" value=\"" . ROOT_SITE.CONTENT_UPLOAD.IMG_FOLDER . "$imgFilename\">";
    } else {
        die('<p class="alert alert-danger">Une erreur est survenue lors de l\'upload!</p>');
    }
} else {
    die('<p class="alert alert-danger">Une errreur est survenue!</p>');
}