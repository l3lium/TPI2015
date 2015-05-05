<?php

require_once '../../includes/specific_funtions.php';

if (isset($_FILES["poster"]) && $_FILES["poster"]["error"] == UPLOAD_ERR_OK) {
    ############ Edit settings ##############
    $UploadDirectory = '/home/website/file_upload/uploads/'; //specify upload directory ends with / (slash)
    ##########################################

    /*
      Note : You will run into errors or blank page if "memory_limit" or "upload_max_filesize" is set to low in "php.ini".
      Open "php.ini" file, and search for "memory_limit" or "upload_max_filesize" limit
      and set them adequately, also check "post_max_size".
     */

    //Vérifie si c'est une requette ajax
    if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        die();
    }

    //Vérifie la taille du fichier
    if ($_FILES["poster"]["size"] > MAX_SIZE_IMG) {
        die("La taille du fichier est trop grand!");
    }

    //Vérifie le type de l'image
    if (checkImageType($_FILES['poster']['type'])) {
        die('Type de fichier non supporté!');
    }

    $File_Name = strtolower($_FILES['poster']['name']);
    $File_Ext = substr($File_Name, strrpos($File_Name, '.')); //get file extention
    $Random_Number = rand(0, 9999999999); //Random number to be added to name.
    $NewFileName = $Random_Number . $File_Ext; //new file name

    $file = $_FILES['poster']['name'];
    $imgFilename = uniqid($_SESSION['id']) . '.' . pathinfo($file, PATHINFO_EXTENSION);
    $imgPath = IMG_FOLDER . $imgFilename;

    if (move_uploaded_file($_FILES['poster']['tmp_name'], $imgPath)) {
        // do other stuff 
        die('Le fichier a été upload.');
    } else {
        die('Une erreur est survenue lors de l\'upload!');
    }
} else {
    die('Une errreur est survenue!');
}