<?php

session_start();

require_once( 'model/user.php' );

/****************************
* ----- LOAD LOGIN PAGE -----
****************************/

function loginPage() {

  $user     = new stdClass();
  $user->id = isset( $_SESSION['user_id'] ) ? $_SESSION['user_id'] : false;

  if( !$user->id ):
    require('view/auth/loginView.php');
  else:
    require('view/homeView.php');
  endif;

}

/***************************
* ----- LOGIN FUNCTION -----
***************************/

function login( $post ) {
  $data           = new stdClass();
  $data->email    = $post['email'];
  $data->password = $post['password'];
  //password rehashing to get a match with current password for connect
  $data->password = hash('sha256', $post['password']);

  $user           = new User( $data );
  $userData       = $user->getUserByEmail();

    $user = null;
    $userData = null;
    // mail verification
    if (preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $post['email']))
    {
        $user           = new User( $data );
        $userData       = $user->getUserByEmail();
    }

  $error_msg      = "Email ou mot de passe incorrect";

  /*
   if( $userData && sizeof( $userData ) != 0 ):
    if( $user->getPassword() == $userData['password'] ):

      // Set session
      $_SESSION['user_id'] = $userData['id'];

      header( 'location: index.php ');
    endif;
  endif;
  */
  
    if( $userData && sizeof( $userData ) != 0 ) // If the user exists.
    {
        if( $user->getPassword() == $userData['password'] ) // If the input password matches with the password in DB.
        {
            if($userData['active'] != 'N') // If user's account is activated.
            {
                // Set session
                $_SESSION['user_id'] = $userData['id'];
                header( 'location: index.php ');
            }
            else // If the user has not activated his account, yet.
            {
                $error_msg = "Votre compte n'est pas activé. Veuillez cliquer sur le lien envoyé par mail lors de votre inscription.";
            }
        }
    }

  require('view/auth/loginView.php');
}

/****************************
* ----- LOGOUT FUNCTION -----
****************************/

function logout() {
  $_SESSION = array();
  session_destroy();

  header( 'location: index.php' );
}
