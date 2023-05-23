<?php
    session_start();
    $email = $_SESSION['user_id'];
    $film = $_GET['movie'];
    $title= $_GET['title'];
    $dbconn = pg_connect("host=localhost port=5432 dbname=MovieLand
            user=postgres password=password") 
            or die('Could not connect: ' . pg_last_error());
    $stylesheet_url = "dettagliFilm.css";
    echo '<meta charset="utf-8"/>
          <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
          <link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.css"/>
          <script type="application/javascript" src="../../bootstrap/js/bootstrap.min.js"></script>';
    echo "<link rel='stylesheet' href='{$stylesheet_url}'>";
    echo "<title>$title</title>";
    echo "<div id='dettagli'></div>";
    echo "<div id='providers'></div>";
    echo "<script src='https://code.jquery.com/jquery-3.3.1.min.js'
    integrity='sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8='
    crossorigin='anonymous'> </script>";
    echo "<script type='text/javascript' src='dettagliFilm.js'></script>";
?>