<?php
session_start();

$email = $_SESSION['user_id'];

$dbconn = pg_connect("host=localhost port=5432 dbname=MovieLand
            user=postgres password=password") 
            or die('Could not connect: ' . pg_last_error());

if ($dbconn) {
    $q1 = "select * from watchlist where utente = $1";
    $result = pg_query_params($dbconn, $q1, array($email));
    $counter = 0;
    echo "<!DOCTYPE html>
            <html lang='it'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <link rel='stylesheet' type='text/css' href='../../bootstrap/css/bootstrap.css'/>
                    <script type='application/javascript' src='../../bootstrap/js/bootstrap.min.js'></script>
                    <link rel='stylesheet' href='fetchWatchlists.css'>
                    <title>Elenco Watchlist</title>
                </head>
                <body class='watchlist-list'>";
    while ($row = pg_fetch_assoc($result)) {
        $counter++;
        $nomew = $row['nome'];
        $descrizionew = $row['descrizione'];
        $watch = $row['id'];
        //echo "$nomew: $descrizionew", PHP_EOL;
        if(isset($_GET["movie"]) and isset($_GET["title"])){
            $movie = $_GET['movie'];
            $title = $_GET['title'];
            $title = urlencode($title);
            echo "  <div class='watchlist'>
                        <div class='watchlist-title'>
                            <h3 class='name-description'>$nomew: $descrizionew</h3>
                        </div>
                        <div class='addToWatchlist-form'>
                            <form action='addToWatchlist.php' method='get'>
                                <input type='hidden' id='movie' name='movie' value='$movie'> 
                                <input type='hidden' id='title' name='title' value='$title'> 
                                <input type='hidden' id='watchlist' name='watchlist' value='$watch'> 
                                <button type='submit' value='Aggiungi a questa Watchlist' class='btn btn-primary'>Aggiungi a questa Watchlist</button>
                            </form>
                        </div>
                    </div>";
        } else{
            echo "  <div class='watchlist'>
                        <div class='watchlist-title'>
                            <h3 class='name-description'>$nomew: $descrizionew</h3>
                        </div>
                        <div class='viewWatchlist-form'>
                            <form action='viewWatchlist.php' method='get'>
                                <input type='hidden' id='watchlist' name='watchlist' value='$watch'> 
                                <button type='submit' value='Consulta' class='btn btn-primary'>Consulta</button>
                            </form>
                        </div>
                    </div>";
        }
    }
    if ($counter == 0) {
        header("Location:fetchWatchlists.html");
        exit();
    }else{
        echo "      <div class='button-div'>
                        <a href='creaWatchlist.html'><button class='newWatchlist btn btn-primary'>Crea una nuova watchlist</button></a>
                    </div>
                </body>
            </html>";
    }
}
?>