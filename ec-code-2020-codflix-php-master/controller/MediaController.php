<?php

require_once( 'model/media.php' );

/***************************
* ----- LOAD HOME PAGE -----
***************************/

function mediaPage() {

  //$search = isset( $_GET['title'] ) ? $_GET['title'] : null;
  //$medias = Media::filterMedias( $search );
  //var_dump($medias);
    listMedia();


}

function listMedia()
{
    $search = isset( $_GET['title'] ) ? $_GET['title'] : null;
    $medias = Media::filterMedias( $search );
    if(!empty($search))
    {
        $medias = Media::filterMedias($search);
    }else
        {
            $series = Media::showAllMediasByType("série");
            $movies = Media::showAllMediasByType("film");
        }
    require('view/mediaListView.php');
}
