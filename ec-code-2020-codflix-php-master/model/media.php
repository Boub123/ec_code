<?php

require_once( 'database.php' );

class Media {

  protected $id;
  protected $genre_id;
  protected $title;
  protected $type;
  protected $status;
  protected $release_date;
  protected $summary;
  protected $trailer_url;

  public function __construct( $media ) {

    $this->setId( isset( $media->id ) ? $media->id : null );
    $this->setGenreId( $media->genre_id );
    $this->setTitle( $media->title );
  }

  /***************************
  * -------- SETTERS ---------
  ***************************/

  public function setId( $id ) {
    $this->id = $id;
  }

  public function setGenreId( $genre_id ) {
    $this->genre_id = $genre_id;
  }

  public function setTitle( $title ) {
    $this->title = $title;
  }

  public function setType( $type ) {
    $this->type = $type;
  }

  public function setStatus( $status ) {
    $this->status = $status;
  }

  public function setReleaseDate( $release_date ) {
    $this->release_date = $release_date;
  }

  /***************************
  * -------- GETTERS ---------
  ***************************/

  /*

   public function getId() {
    return $this->id;
  }

  public function getGenreId() {
    return $this->genre_id;
  }

  public function getTitle() {
    return $this->title;
  }

    public function getType() {
        return $this->type;
    }

  public function getStatus() {
    return $this->status;
  }

  public function getReleaseDate() {
    return $this->release_date;
  }

  public function getSummary() {
    return $this->summary;
  }

  public function getTrailerUrl() {
    return $this->trailer_url;
  }
*/
  /***************************
  * -------- GET LIST --------
  ***************************/
//getters for medias
  //public static function filterMedias( $title ) {
  public static function getMediasByTitle( $title )
  {

    // Open database connection
    $db   = init_db();

    //$req  = $db->prepare( "SELECT * FROM media WHERE title like ? ORDER BY release_date DESC" );
    $req  = $db->prepare( "SELECT * FROM media WHERE title like ? ORDER BY title" );
    $req->execute( array( '%' . $title . '%' ));

    // Close databse connection
    $db   = null;

    return $req->fetchAll();

  }


    //get medias by type
    //public static function showAllMediasByType( $type ) {
    public static function getMediasByType( $type ) {
        // Open database connection
        $db   = init_db();
        // Show movies or tv shows from last id to first id (from new inserts to old inserts).
        $req  = $db->prepare( "SELECT * FROM media WHERE type = ? ORDER BY id DESC");
        $req->execute( array( $type ));
        // Close database connection
        $db   = null;
        return $req->fetchAll();
    }

    public static function details( $id ) // argument
    {

        //    // Open database connection
        $db   = init_db();
        $req  = $db->prepare( "SELECT * FROM media WHERE id = ?" );
        $req->execute( array( $id ));
         // Close databse connection
        $db   = null;

        return $req->fetch();
    }
        public static function getGenreById( $id )
    {
            // Open database connection
         $db   = init_db();
         $req  = $db->prepare( "SELECT name FROM genre WHERE id = ?" );    $req->execute( array( $id ));
         // Close databse connection
        $db   = null;
        return $req->fetch();
    }

    //function to get genreMedia and releaseMedia
    //public  static function genreMedia($genre_id)
    public  static function getMediasByGenre($genre_id)
    {
        // Open database connection
        $db   = init_db();
        $req  = $db->prepare( "SELECT * FROM genre WHERE genre_id = ?" );
        $req->execute( array( $genre_id ));
        // Close databse connection
        $db   = null;
        return $req->fetchAll();
    }

    //public  static function releaseDateMedia($release_date)
    public  static function getMediasByReleaseDate($release_date)
    {
        // Open database connection
        $db   = init_db();
        $req  = $db->prepare( "SELECT * FROM media WHERE release_date like ?" );
        $req->execute( array( $release_date ));
        // Close databse connection
        $db   = null;
        return $req->fetchAll();
    }
//getting saisons and episode
    public static function getsaisonsByMediaId($media_id)
    {
        // Open database connection
        $db   = init_db();
        // Show movies or tv shows from last id to first id (from new inserts to old inserts).
        $req  = $db->prepare( "SELECT DISTINCT saison FROM serie WHERE media_id = ?");
        $req->execute( array( $media_id ));
        // Close database connection
        $db   = null;
        return $req->fetchAll();
    }

    public static function getepisodesByMediaId($media_id, $season)
    {
        // Open database connection
        $db   = init_db();
        $req  = $db->prepare( "SELECT episode FROM serie WHERE media_id = :media_id AND season = :season" );
        $req->execute( array(
            'media_id' => $media_id,
            'season' => $season
        ));
        // Close databse connection
        $db   = null;
        return $req->fetchAll();
    }

    public static function getEpisodesDetails( $media_id, $season, $episode ) {
        // Open database connection
        $db   = init_db();
        $req  = $db->prepare( "SELECT * FROM serie WHERE season = :season AND episode = :episode AND media_id = :media_id " );
        $req->execute( array(
            'media_id' => $media_id,
            'season' => $season,
            'episode' => $episode
        ));
        // Close databse connection
        $db   = null;
        return $req->fetch();
    }

    //delete media
    public static function supMedia($user_id, $media_id)
    {
        // Open database connection
        $db   = init_db();
        $req = $db->prepare("DELETE FROM history WHERE user_id = :user_id AND media_id = :media_id");
        $req->execute( array(
            'user_id' => $user_id,
            'media_id' => $media_id
        ));
        // Close databse connection
        $db   = null;
    }
    // delete history
    public static function deletedHistory( $user_id)
    {
        // Open database connection
        $db   = init_db();
        $req = $db->prepare("DELETE FROM history WHERE user_id = ?");
        $req->execute( array( $user_id ));
        // Close databse connection
        $db   = null;
    }

    //function to add or update in history
    public static function addMediaHistory($user_id, $media_id)
    {
        // database connection
        $db   = init_db();
        $req = $db->prepare("SELECT * FROM history where media_id = :media_id AND user_id = :user_id");
        $req->execute( array(
            'user_id' => $user_id,
            'media_id'=> $media_id
        ));
        //verif if user visite the media
        if( $req->rowCount() <= 0 )
        {
            // data insertion
            $req  = $db->prepare( "INSERT INTO history (user_id, media_id, start_date, finish_date, watch_duration) VALUES (:user_id, :media_id, :start_date, :finish_date, :watch_duration)" );
            $req->execute( array(
                'user_id' => $user_id,
                'media_id' => $media_id,
                'start_date' => date("Y-m-d H:i:s"),
                'finish_date' => date("Y-m-d H:i:s"),
                'watch_duration' => '0'
            ));
        }
        else
        {
            //updating colone
            $req = $db->prepare("UPDATE history SET finish_date = :finish_date WHERE user_id = :user_id AND media_id = :media_id");
            $req->execute( array(
                'finish_date' => date("Y-m-d H:i:s"),
                'user_id' => $user_id,
                'media_id' => $media_id
            ));
        }
        // Close databse connection
        $db   = null;
    }
    //fetch media
    public static function getMediasVisited($user_id)
    {

        $db   = init_db();
        $req  = $db->prepare( "SELECT * FROM history WHERE user_id = ? ORDER BY finish_date DESC" );
        $req->execute( array( $user_id ));
        // Close databse connection
        $db   = null;
        return $req->fetchAll();

    }


}
