<?php

/*************************************
* ----- INIT DATABASE CONNECTION -----
*************************************/

function init_db() {
  try {

    $host     = 'localhost';
    $dbname   = 'codflix';
    $charset  = 'utf8';
    $user     = 'root';
    $password = '';
    $port = '3308';

    $db = new PDO( "mysql:host=$host;dbname=$dbname;port=$port;charset=$charset", $user, $password );

  } catch(Exception $e) {

    die( 'Erreur : '.$e->getMessage() );

  }

  return $db;
}
