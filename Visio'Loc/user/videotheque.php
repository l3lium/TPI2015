<?php
require_once '../includes/structure.php';

//Redirection si le compte est en état temporaire
redirectTempAccount();

if (!isConnected() || isAdmin()){
    goHome();
}

?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <?php getHeaderHtml("Ma vidéothèque"); ?>
    <body>
        <?php
        getHeader();
        ?>
        <!-- CONTAINER -->
        <div class="container">
            <div class="center-block">
                <h2><span class="glyphicon glyphicon-film"></span> Ma vidéothèque</h2>
                <h5></h5><hr/>
                
            </div>
        </div>
    </body>
</html>
