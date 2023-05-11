<?php
session_start();

$email = $_SESSION['user_id'];
if(!isset($_GET["movie"]) || !isset($_GET["title"])){
    echo "Devi selezionare un film da recensire!";
    echo "<a href=MovieLand.php> Clicca qui</a> per scegliere un film";
  } else {
    $dbconn = pg_connect("host=localhost port=5432 dbname=MovieLand
            user=postgres password=password") 
            or die('Could not connect: ' . pg_last_error());
            if ($dbconn) {
                $movie = $_GET["movie"];
                $title = $_GET["title"];
                $rating = $_GET["rating"];
                $descrizione = $_GET["recensione"];
                $q1 = "insert into review values ($1,$2,$3) returning id";
                $data = pg_query_params($dbconn, $q1, array($descrizione, $rating, $email));
                $rev = pg_fetch_assoc($data);
                $id = $rev["id"];
                    if ($id) {
                        $q2 = "insert into filmreview values ($1,$2)";
                        $result=pg_query_params($dbconn, $q2, array($id, $movie));
                        $url = "fetchreviews.php?movie=$movie&title=$title";
                        header('Location: ' . $url);
                    }
            }
  }
?>