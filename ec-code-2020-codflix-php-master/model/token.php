<?php
require_once( 'database.php' );
// Check key for account validation.
function getTokenByToken($token) {
    // Open database connection
    $db   = init_db();
    $req  = $db->prepare( "SELECT * FROM cles WHERE cles = ?" );
    $req->execute( array( $token ) );
    // Close databse connection
    $db   = null;
    return $req->fetch();
}
// Activate the account and delete the token.
function activateAccount($token)
{
// Open database connection
    $db = init_db();
    $response = getTokenByToken($token);
    $req = $db->prepare("UPDATE user SET active = 'O' WHERE id = ? ");
    $req->execute(array($response['user_id']));
    $req = $db->prepare("DELETE FROM cles WHERE cles = ?");
    $req->execute(array($token));
// Close databse connection
    $db = null;
}
?>
