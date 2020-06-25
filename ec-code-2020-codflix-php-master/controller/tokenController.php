<?php
require_once( 'model/token.php' );

function tokenPage() {
    $token = $_GET['token'];
    $response = getTokenByToken($token);
    // Check if the token exists into the DB.
    if (!$response){
        $error_msg = "cle non valide";
    }
    else{
        activateAccount($token);
        $success_msg = "Votre compte est désormais activé.";
    }

    require ('view/tokenView.php');
}

?>
