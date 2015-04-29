<?php
/*
  ======Constantes======
  Auteur: 	Oliveira Stéphane
  Classe: 	I.IN-P4B
  Date:		29/04/2015
  Version:	0.2
  Description:    Script regroupant les constantes necessaire pour les scripts php du site
 */

DEFINE('DB_LOGIN', 'visioloc_user');
DEFINE('DB_PASS', 'zKTGxrQFfmAZcwWA');
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_NAME', 'visiolocbdd');

DEFINE('ROOT_SITE', '/Visio\'Loc');
DEFINE('NB_PAGINATION', 8);
DEFINE('CONTENT_UPLOAD', 'up-content/');
DEFINE('SOUND_FOLDER', 'sound/animal/');
DEFINE('IMG_FOLDER', 'img/animal/');

DEFINE('ALLOWED_IMAGE_TYPES', serialize( array("image/png", "image/jpeg", "image/gif")));
DEFINE('ALLOWED_SOUND_TYPES', serialize( array("audio/wav", "audio/mp3")));
