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
//function for list media and search by title, genre, release_date or type
function listMedia()
{
    $search = isset( $_GET['title'] ) ? $_GET['title'] : null;
    $search = null;
    //condition of search with another critéres
    if(!empty($_GET['title']))
    {
        $search = $_GET['title'];
    }elseif (!empty($_GET['genre']))
    {
        $search = $_GET['genre'];
    }elseif (!empty($_GET['type']))
    {
        $search = $_GET['type'];
    }elseif (!empty($_GET['release_date']))
    {
        $search = $_GET['release_date'];
    }

    if(!empty($search))
    {
        //$medias = Media::filterMedias($search);
        if (isset($_GET['title']))
        {
            //$medias = Media::filterMedias($search);
            $medias = Media::getMediasByTitle($search);
        }
        elseif (isset($_GET['type']))
        {
            //$medias = Media::showAllMediasByType($search);
            $medias = Media::getMediasByType($search);
        }
        elseif (isset($_GET['genre']))
        {
            //$medias = Media::genreMedia($search);
            $medias = Media::getMediasByGenre($search);
        }
        elseif (isset($_GET['release_date']))
        {
            //$medias = Media::releaseDateMedia($search);
            $medias = Media::getMediasByReleaseDate($search);
        }
    }else // no word in search bar, show all
        {
            //$series = Media::showAllMediasByType("série");
            //$movies = Media::showAllMediasByType("film");
            $series = Media::getMediasByType("série");
            $movies = Media::getMediasByType("film");
        }
    require_once('view/mediaListView.php');
}

// function to list details of medias, and series
function details(){
    //for adding media to history
    $user_id = isset($_SESSION['user_id']) ?$_SESSION['user_id'] : false;
    Media::addMediaHistory($user_id, $_GET['media']);

    $media = Media::details($_GET['media']);
    $getGenre = Media::getGenreById($media['genre_id']);
    $genre = $getGenre['name'];
    $stream = $media['trailer_url'];

    $detailStream = false;
    //try to catch number of saison and episode
    if($media['type'] == 'série')
    {
        $seasons = Media::getsaisonsByMediaId($media['id']);
        $episodes = Media::getepisodesByMediaId($media['id'], 1);

        if(isset($_GET['season']) && isset($_GET['episode']))
        {
            $detailStream = Media::getEpisodesDetails( $_GET['media'], $_GET['season'], $_GET['episode'] );
            if ($detailStream) $stream = $detailStream['stream_url'];
        }
    }
    require('view/detailsMediasView.php');
    $detailStream = false;

    /*//try to catch number of saison and episode but do another way...
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
