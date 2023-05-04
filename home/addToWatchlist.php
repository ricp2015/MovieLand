<?php
session_start();

$email = $_SESSION['user_id'];
if(!isset($_GET["watchlist"])) {
    echo "Devi selezionare una watchlist per aggiungere un film!";
    //vedere se il film esiste nel moviedb
  } elseif(!isset($_GET["movie"])){
    echo "Devi selezionare un film da aggiungere alla watchlist!";
    echo "<a href=MovieLand.php> Clicca qui</a> per scegliere un film da aggiungere";
  } else {
    $dbconn = pg_connect("host=localhost port=5432 dbname=MovieLand
            user=postgres password=password") 
            or die('Could not connect: ' . pg_last_error());

            if ($dbconn) {
                $film = $_GET["movie"];
                $watch = $_GET["watchlist"];
                $title = trim($_GET['title']);
                $q1="select * from filmwatchlist where film = $1 and watch = $2";
                $result=pg_query_params($dbconn, $q1, array($film, $watch));
                if ($tuple=pg_fetch_array($result, null, PGSQL_ASSOC)) {
                    echo "<h1> Hai già inserito il film \"$title\" in questa watchlist!</h1>";
                }
                else {
                    $q2 = "insert into filmwatchlist values ($1,$2)";
                    $data = pg_query_params($dbconn, $q2,
                        array($watch, $film));
                    if ($data) {
                        $q3="select nome from watchlist where id = $1";
                        $result=pg_query_params($dbconn, $q3, array($watch));
                        $tuple=pg_fetch_array($result, null, PGSQL_ASSOC);
                        $tuple=$tuple["nome"];
                        echo "<h1> Hai inserito \"$title\" in $tuple <br/></h1>";
                        echo "<a href=MovieLand.php> Clicca qui</a>
                             per scegliere altri film da aggiungere";
                    }
                }
            }
  }
?>