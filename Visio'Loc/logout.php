<?php
require_once './includes/specific_funtions.php';
session_start();
session_unset();
session_destroy();

goHome();