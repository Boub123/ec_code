<?php
require_once( 'model/token.php' );

function tokenPage() {
    $token = $_GET['token'];
    $response = getTokenByToken($token);
    // Check if the token exists into the DB.
    if (!$response){
        var_dump("cles non valide");
    }
    else{
        activateAccount($token);
        var_dump("Votre compte est désormais activé.");
    }
}

?>
