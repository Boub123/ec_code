<?php

require_once( 'model/media.php' );

/***************************
* ----- LOAD HOME PAGE -----
***************************/

function mediaPage() {

  //$search = isset( $_GET['title'] ) ? $_GET['title'] : null;
  //$medias = Media::filterMedias( $search );
  //var_dump($medias);
    if(! empty($_GET['media'])) details();
    else listMedia();


}

function listMedia()
{
    $search = isset( $_GET['title'] ) ? $_GET['title'] : null;
    if(!empty($search))
    {
        $medias = Media::filterMedias($search);
    }else // no word in search bar, show all
        {
            $series = Media::showAllMediasByType("série");
            $movies = Media::showAllMediasByType("film");
        }
    require_once('view/mediaListView.php');
}

//list details of media
function details(){
    $media = Media::details($_GET['media']);
    $getGenre = Media::getGenreById($media['genre_id']);
    $genre = $getGenre['name'];

    require('view/detailsMediasView.php');
    $detailStream = false;
    /*//try to catch number of saison and episode
    if($media['type'] == 'série')
    {
        $seasons = Media::getsaisonsByMediaId($media['id']);
        $episodes = Media::getepisodesByMediaId($media['id'], 1);
        $episodes = null;

        if(isset($_GET['season']) && isset($_GET['episode']))
        {
            $detailStream = Media::getEpisodesDetails( $_GET['media'], $_GET['season'], $_GET['episode'] );
            if ($detailStream) $stream = $detailStream['stream_url'];
        }elseif (isset($_GET["season"]))
        {
            $episodes = Media::getepisodesByMediaId($media['id'], $_GET["season"]);
        }
    }*/
    require_once('view/detailsMediasView.php');

}
