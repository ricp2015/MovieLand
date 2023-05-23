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
                        /*echo "<h1> Hai eliminato il film da questa watchlist<br/></h1>";
                        echo "<a href=viewWatchlist.php?watchlist=$watch> Clicca qui</a>
                             per tornare alla watchlist";*/
                        echo "<!DOCTYPE html>
                                <html lang='it'>
                                <head>
                                    <meta charset='UTF-8'>
                                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                                    <link rel='stylesheet' type='text/css' href='../bootstrap/css/bootstrap.css'/>
                                    <script type='application/javascript' src='../bootstrap/js/bootstrap.min.js'></script>
                                    <link rel='stylesheet' type='text/css' href='./watchlists.css'/>
                                    <title>Film rimosso dalla Watchlist</title>
                                </head>
                                <body class='text-center'>
                                    <div class='container'>
                                        <div class='message'>
                                            <h1> Hai eliminato il film da questa watchlist</h1>
                                        </div>
                                        <div class='button-div'>
                                            <a href='viewWatchlist.php?watchlist=$watch'><button class='rtnWatchlist'>Ritorna alla Watchlist</button></a>
                                        </div>
                                    </div>
                                </body>
                                </html>";
                    }
                }
            }
?>