<?php
//function to contact us
function contact($post){
    $email = $post['email'];
    $message = $post['message'];
    //mail verification
    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        echo  "L'adresse email '$email' est considérée comme invalide.";
    }//message verification
    elseif (empty($message))
    {
        echo "le message est vide, veuillez écrire quelque chose.";
    }
    else{
        sendMail($email, $message);
        echo "Nous avons recu votre mail, nous vous répondrons dés que possible.";
    }

    require('view/contactView.php');
}
// function to send mail
function sendMail($senderMail, $message)
{
    $MailSubject ="Contact via formulaire";
    $Mailheader ='FROM: '.$senderMail;
}