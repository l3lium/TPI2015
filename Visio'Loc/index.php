<?php
require_once '/includes/structure.php';

//Redirection si le compte est en état temporaire
redirectTempAccount();
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <?php getHeaderHtml("Accueil"); ?>
    <body>
        <?php
        getHeader();
        ?>
    </body>
</html>
