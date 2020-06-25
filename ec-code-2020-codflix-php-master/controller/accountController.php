<?php
require_once( 'model/user.php' );
require_once( 'loginController.php' );


//get the good session
function accountPage(){
    $user_id = $_SESSION['user_id'];

    $response = User::getUserById($user_id);

    require('view/accountView.php');
}

//function to update account informations
function updateAccount( $post )
{
    $user_id = $_SESSION['user_id'];
    $email = $post['email'];
    $password = hash('sha256', $post['password']); // Hash input password to compare with the hashed password within DB.
    //$password =  $post['password'];
    $newPassword = $post['newPassword'];
    $newPasswordConfirm = $post['newPasswordConfirm'];
    $user = new User();
    $userData = $user->getUserById($user_id); // Get the current user's data in order to compare the inputs with the current data.
    // The current password is required to save new data.
    if ($password != $userData['password']) {
        $error_msg = "Le mot de passe n'est pas valide.";
    }
    elseif (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $email))
    {
        $error_msg = "Format de mail non valide.";
    }
    elseif (strlen($newPassword) < 5)
    {
        $error_msg = "Nouveau mot de passe incorrect, 5 caractères minimum.";
    }
    elseif ($newPassword != $newPasswordConfirm)
    {
        $error_msg = "Les nouveaux mots de passe ne correspondent pas.";
    }
    else
    {
        $user->setId($user_id);
        $user->setEmail($email);
        $user->setPassword($newPassword);
        $userData = $user->getUserByEmail();
        if ($userData && sizeof( $userData ) > 0) // If email address is already in used, show error.
        {
            $error_msg = " Adresse mail est déjà utilisée.";
        }
        else
        {
            $user->updateUser();
            $success_msg = "Vos informations ont été modifiées avec succès.";
        }
    }
    require('view/accountView.php');
}

//function to delete account
function deleteAccount($post){
    $user_id = $_SESSION['user_id'];
    $password = hash('sha256', $post['password']);
    $user = new User();
    $userData = $user->getUserById($user_id); // Get the current user's data in order to compare the inputs with the current data.
    // The current password is required to save new data.
    if ($password != $userData['password']) {
        $error_msg = "Le mot de passe actuel est erroné.";
    }
    else{
        $user->setId($user_id);
        $user->deleteUser();
        logOut(); // Logging out the current user once the account has been successfully deleted.
    }
    require('view/accountView.php');
}

//require('view/accountView.php');


?>
