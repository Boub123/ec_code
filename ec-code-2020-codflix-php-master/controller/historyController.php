<?php
//let's gooooo
require_once('model/media.php');
function mediaHistory()
{
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : false;
    $mediaVisited = Media::getMediasVisited($user_id);

    if(isset($_POST['deletedHistory']))
    {
        Media::deletedHistory($user_id);
        header('Location: '.$_SERVER['REQUEST_URI']);
    }
    elseif(isset($_POST['supMedia']))
    {
        Media::supMedia($user_id, $_POST['supMedia']);
        header('Location: ' .$_SERVER['REQUEST_URI']);
    }

    require_once('view/historyView.php');
}
