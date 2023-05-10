<?php
session_start();

$email = $_SESSION['user_id'];
if(!isset($_GET["movie"]) || !isset($_GET["title"])){
    echo "Devi selezionare un film di cui vedere le recensioni!";
    echo "<a href=MovieLand.php> Clicca qui</a> per scegliere un film";
  } else {
    $dbconn = pg_connect("host=localhost port=5432 dbname=MovieLand
            user=postgres password=password") 
            or die('Could not connect: ' . pg_last_error());
            if ($dbconn) {
                $movie = $_GET["movie"];
                $title = $_GET["title"];
                $q1 = "select * from filmreview where film=$1";
                $result = pg_query_params($dbconn, $q1, array($movie));
                while ($row = pg_fetch_assoc($result)) {
                    $review = $row["review"];
                    $q2 = "select * from review where id=$1";
                    $res = pg_query_params($dbconn, $q2, array($review));
                    $rev = pg_fetch_assoc($res);
                    $text = $rev["testo"];
                    $val = $rev["valutazione"];
                    $utente = $rev["utente"];
                    echo "<div>$utente ha dato $val stelle: $text</div><br>";
                }
            }
  }
?>