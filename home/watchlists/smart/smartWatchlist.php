<?php
session_start();
$email = $_SESSION['user_id'];

$dbconn = pg_connect("host=localhost port=5432 dbname=MovieLand
            user=postgres password=password") 
            or die('Could not connect: ' . pg_last_error());

if ($dbconn) {
    if(!isset($_GET["watchlist"])){
        echo "Seleziona una watchlist da consultare!";
    } else{
    $counter = 0;
    $watch = $_GET["watchlist"];
    $q1 = "select * from filmwatchlist where watch = $1";
    $result1 = pg_query_params($dbconn, $q1, array($watch));
    echo "<!DOCTYPE html>
            <html lang='it'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <link rel='stylesheet' type='text/css' href='../../../bootstrap/css/bootstrap.css'/>
                <script type='application/javascript' src='../../../bootstrap/js/bootstrap.min.js'></script>
                <link rel='stylesheet' type='text/css' href='./smartWatchlist.css'/>
                <title>Aggiunta film suggeriti</title>
            </head>
            <body>
                <div class='elencoFilm'>";
    echo "<script src='https://code.jquery.com/jquery-3.3.1.min.js'
    integrity='sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8='
    crossorigin='anonymous'> </script>";
    echo "          <div class='message'>
                        <h2>Scegli un film all'interno della watchlist e la quantità di film suggeriti desiderati:</h2>
                    </div>
                    <div id='sceltafilm'>
                    </div>
                </div>
            </body>
            </html>";
    while ($row = pg_fetch_assoc($result1)){
        $film = $row['film'];
        $url = "https://api.themoviedb.org/3/movie/$film?api_key=2f5263a1468b8f45e9f589381858425e"; 
        echo "<script>
        var php_var = '<?php echo $url; ?>';
        </script>";
        echo "<script type='text/javascript' src='smartWatchlist.js'></script>";
    }
}
}
?>