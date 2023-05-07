<?php
    session_start();
    $email = $_SESSION['user_id'];
    $film = $_GET['movie'];
    $dbconn = pg_connect("host=localhost port=5432 dbname=MovieLand
            user=postgres password=password") 
            or die('Could not connect: ' . pg_last_error());
    echo "<div id='dettagli'></div>";
    echo "<div id='providers'></div>";
    echo "<script src='https://code.jquery.com/jquery-3.3.1.min.js'
    integrity='sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8='
    crossorigin='anonymous'> </script>";
    echo "<script type='text/javascript' src='scriptdettagli.js'></script>";
?>