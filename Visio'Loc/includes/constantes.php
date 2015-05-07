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
DEFINE('NB_PAGINATION', 20);
DEFINE('MAX_SIZE_IMG', 4194304);//4 Mo 2^20*4
DEFINE('MAX_SIZE_VIDEO', 10737418240);//10 Go 2^30*10
DEFINE('CONTENT_UPLOAD', '/up-content');
DEFINE('IMG_FOLDER', '/img/');
DEFINE('VIDEO_FOLDER', '/video/');

DEFINE('ALLOWED_IMAGE_TYPES', serialize( array("image/png", "image/jpeg", "image/gif")));
DEFINE('ALLOWED_VIDEO_TYPES', serialize( array("video/mp4", "video/webm")));
