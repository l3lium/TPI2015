<?php
require_once '../includes/specific_funtions.php';

if (isset($_FILES["video"]) && $_FILES["video"]["error"] == UPLOAD_ERR_OK) {
    //Vérifie si c'est une requette ajax
    if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        die();
    }

    //Vérifie la taille du fichier
    if ($_FILES["video"]["size"] > MAX_SIZE_VIDEO) {
        die('<p class="alert alert-danger">La taille du fichier est trop grand! (' . (MAX_SIZE_VIDEO / 1000000000) . 'Go)</p>');
    }

    //Vérifie le type de l'image
    if (!checkVideoType($_FILES['video']['type'])) {
        die('<p class="alert alert-danger">Type de fichier non supporté!</p>');
    }

    $file = $_FILES['video']['name'];
    $imgFilename = uniqid($_SESSION['id']) . '.' . pathinfo($file, PATHINFO_EXTENSION);
    $imgPath = realpath(".") . "/" . VIDEO_FOLDER . $imgFilename;

    if (move_uploaded_file($_FILES['video']['tmp_name'], $imgPath)) {
        // do other stuff 
        echo '<p class="alert alert-success">Le fichier a été upload.</p>';
        echo "<input type=\"hidden\" name=\"srcVideo\" value=\"" . CONTENT_UPLOAD . VIDEO_FOLDER . "$imgFilename\">";
    } else {
        die('<p class="alert alert-danger">Une erreur est survenue lors de l\'upload!</p>');
    }
} else {
    die('<p class="alert alert-danger">Une errreur est survenue!</p>');
}