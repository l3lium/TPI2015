<?php
require_once '../includes/specific_funtions.php';
require_once '../includes/crud_User.php';

echo "Test - Update username actuellement connecté";
echo "user name id = 1 :";
debug(getUserById(1)->username);
echo "update name to 'dada'";
updateActualUsername("dada");
echo "user name id = 1 :";
debug(getUserByUsername("dada"));
echo "update name to 'SaaS-Test'";
updateActualUsername("SaaS-test3");
debug(getUserByUsername("SaaS-test3"));

echo "Test - Update Mot de passe avec l'id";
$realPassword = getConnectedUser()->password;
debug($realPassword);
updateActualUserPassword("SaaS-Test le mpd");
debug(getConnectedUser()->password);
updateActualUserPassword($realPassword);
