<?php
session_start();

$email = $_SESSION['user_id'];
if(!isset($_GET["watchlist"])) {
    echo "Devi selezionare una watchlist per rimuovere un film!";
  } elseif(!isset($_GET["movie"])){
    echo "Devi selezionare un film da rimuovere dalla watchlist!";
  } else {
    $dbconn = pg_connect("host=localhost port=5432 dbname=MovieLand
            user=postgres password=password") 
            or die('Could not connect: ' . pg_last_error());

            if ($dbconn) {
                $film = $_GET["movie"];
                $watch = $_GET["watchlist"];
                $q1="delete from filmwatchlist where film = $1 and watch = $2";
                $result=pg_query_params($dbconn, $q1, array($film, $watch));
                if ($tuple=pg_fetch_array($result, null, PGSQL_ASSOC)) {
                    echo "<h1> Hai già eliminato il film da questa watchlist!</h1>";
                }
                else {
                        echo "<h1> Hai eliminato il film da questa watchlist<br/></h1>";
                        echo "<a href=viewWatchlist.php?watchlist=$watch> Clicca qui</a>
                             per tornare alla watchlist";
                    }
                }
            }
?>