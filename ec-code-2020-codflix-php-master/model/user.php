<?php

require_once( 'database.php' );

class User {

  protected $id;
  protected $email;
  protected $password;

  public function __construct( $user = null ) {

    if( $user != null ):
      $this->setId( isset( $user->id ) ? $user->id : null );
      $this->setEmail( $user->email );
      $this->setPassword( $user->password, isset( $user->password_confirm ) ? $user->password_confirm : false );
    endif;
  }

  /***************************
  * -------- SETTERS ---------
  ***************************/

  public function setId( $id ) {
    $this->id = $id;
  }

  public function setEmail( $email ) {

    if ( !filter_var($email, FILTER_VALIDATE_EMAIL)):
      throw new Exception( 'Email incorrect' );
    endif;

    $this->email = $email;

  }

  public function setPassword( $password, $password_confirm = false ) {

    if( $password_confirm && $password != $password_confirm ):
      throw new Exception( 'Vos mots de passes sont différents' );
    endif;

    $this->password = $password;
  }

  /***************************
  * -------- GETTERS ---------
  ***************************/

  public function getId() {
    return $this->id;
  }

  public function getEmail() {
    return $this->email;
  }

  public function getPassword() {
    return $this->password;
  }

  /***********************************
  * -------- CREATE NEW USER ---------
  ************************************/

  public function createUser() {

    // Open database connection
    $db   = init_db();

    // Check if email already exist
    $req  = $db->prepare( "SELECT * FROM user WHERE email = ?" );
    $req->execute( array( $this->getEmail() ) );

    if( $req->rowCount() > 0 ) throw new Exception( "Email ou mot de passe incorrect" );

    // Insert new user
    $req->closeCursor();

    $req  = $db->prepare( "INSERT INTO user ( email, password, active ) VALUES ( :email, :password, :active )" );
    $req->execute( array(
      'email'     => $this->getEmail(),
      'password'  => $this->getPassword(),
        'active'    => 'N'
    ));
    //get data of user
    $getUser = $this->getUserByEmail();

    //gener random keys
      $token = md5(microtime(TRUE)*10000);
      //token insertion
      $req = $db->prepare("INSERT INTO cles (user_id, cles) VALUES(:userId, :cles)");
      $req->execute(array(
          'userId' => $getUser['id'],
          'cles' => $token
      ));

      //send validation mail with an url
      $this->sendMailValidation($token, $getUser['email']);

    // Close databse connection
    $db = null;

  }

  //sendmail validation function
    function sendMailValidation($token, $userMail)
    {
        $userMail = $userMail;
        $subject = "Confirmation de votre mail";

        $header = "Codflix";

        $message = 'Codflix a le plaisir de vous compter parmis ses membres !
        Veuillez cliquer sur le lien ci-dessous afin d\'activer votre compte :
        http://localhost/ec_code/ec-code-2020-codflix-php/index.php?token='.$token.'
        A très vite sur Codflix';
        //check php.ini to use mail().
        // mail($userMail, $subject, $message, $header);
    }
  /**************************************
  * -------- GET USER DATA BY ID --------
  ***************************************/
// get users by id
  public static function getUserById( $id ) {

    // Open database connection
    $db   = init_db();

    $req  = $db->prepare( "SELECT * FROM user WHERE id = ?" );
    $req->execute( array( $id ));

    // Close databse connection
    $db   = null;

    return $req->fetch();
  }

  // get user data by mail
  public function getUserByEmail() {

    // Open database connection
    $db   = init_db();

    $req  = $db->prepare( "SELECT * FROM user WHERE email = ?" );
    $req->execute( array( $this->getEmail() ));

    // Close databse connection
    $db   = null;

    return $req->fetch();
  }
//function to update a user account
    public function updateUser() {
        $db   = init_db();
        $req  = $db->prepare( "UPDATE user SET email = :email, password = :password WHERE id = :id;" );
        $req->execute( array(
            'email' => $this->getEmail(),
            'password' => hash('sha256', $this->getPassword()),
            'id' => $this->getId()
        ));
        // Close databse connection
        $db   = null;
    }
    // function delete user
    public function deleteUser() {
        $db   = init_db();
        $req  = $db->prepare( "DELETE FROM user WHERE id = ?" );
        $req->execute( array( $this->getId() ));
        // Close databse connection
        $db   = null;
    }

}
