<?php
require_once '../includes/specific_funtions.php';

if (filter_input(INPUT_POST, 'signup')) {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $pseudo = filter_input(INPUT_POST, 'username');
    $pass = filter_input(INPUT_POST, 'password');
    $passConfirm = filter_input(INPUT_POST, 'passwordConfirm');
    
    if ($email && $pseudo && $pass && $passConfirm && $pass==$passConfirm){
        echo 'saas';
        if (!getUserByEmail($email))
            debug(createUser($email,$pseudo, $pass));
        else
            echo "cette addresse email est déjà utilisée";
    }
    
    
}
?>
<form method="post" action="">
    
    <label>Pseudo:</label><input name="username" type="text"/><br/>
    <label>Email:</label><input name="email" type="text"/><br/> 
    <label>Password :</label><input name="password" type="password"/><br/>
    <label>Password confirm :</label><input name="passwordConfirm" type="password"/><br/>
    <input name="signup" type="submit"/>

</form>

