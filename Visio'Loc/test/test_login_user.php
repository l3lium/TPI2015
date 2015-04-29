<?php
require_once '../includes/specific_funtions.php';

if (filter_input(INPUT_POST, 'login')) {
    $mail = filter_input(INPUT_POST, 'email');
    $pass = filter_input(INPUT_POST, 'password');
    
    userConnect($mail, $pass);
}
debug($_SESSION);

?>

<form method="post" action="">
    <label>email:</label>
    <input name="email" type="email"/> 
    <input name="password" type="password"/>
    <input name="login" type="submit"/>

</form>

