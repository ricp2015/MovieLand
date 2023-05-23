<?php
session_start();

$email = $_SESSION['user_id'];
$username = $_SESSION['user_name'];
echo "<!DOCTYPE html>
          <html lang='it'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <link rel='stylesheet' type='text/css' href='../../bootstrap/css/bootstrap.css'/>
                <script type='application/javascript' src='../../bootstrap/js/bootstrap.min.js'></script>
                <link rel='stylesheet' href='fetchReviews.css'>
                <title>Recensioni</title>
            </head>
            <body class='recensioni'>";
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
                $counter = 0;
                $q1 = "select * from filmreview where film=$1";
                $result = pg_query_params($dbconn, $q1, array($movie));
                while ($row = pg_fetch_assoc($result)) {
                    $counter++;
                    $review = $row["review"];
                    $q2 = "select * from review where id=$1";
                    $res = pg_query_params($dbconn, $q2, array($review));
                    $rev = pg_fetch_assoc($res);
                    $text = $rev["testo"];
                    $val = $rev["valutazione"];
                    $utente = $rev["utente"];
                    echo "  <div class='recensione'>
                              <h2>$utente ha dato $val stelle: $text</h2>
                          </div>";
                }
                if($counter == 0){
                  echo "<h1>Nessuna recensione disponibile per questo film</h1>";
                }
                echo "    <div class='button-div'>
                            <a href='../details/dettagliFilm.php?movie=$movie&title=$title'><button class='addReview btn btn-primary'>Aggiungi una recensione</button></a>
                          </div>
                        </body>
                      </html>";
            }
  }
?>