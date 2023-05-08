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
    while ($row = pg_fetch_assoc($result)) {
        $counter++;
        $nomew = $row['nome'];
        $descrizionew = $row['descrizione'];
        $watch = $row['id'];
        echo "$nomew: $descrizionew", PHP_EOL;
        if(isset($_GET["movie"]) and isset($_GET["title"])){
            $movie = $_GET['movie'];
            $title = $_GET['title'];
            $title = urlencode($title);
            echo "<form action='addToWatchlist.php' method='get'>
            <input type='hidden' id='movie' name='movie' value='$movie'> 
            <input type='hidden' id='title' name='title' value='$title'> 
            <input type='hidden' id='watchlist' name='watchlist' value='$watch'> 
            <input type='submit' value='Aggiungi a questa Watchlist'> </form>";
        } else{
            echo "<form action='viewWatchlist.php' method='get'>
            <input type='hidden' id='watchlist' name='watchlist' value='$watch'> 
            <input type='submit' value='Consulta'> </form>";
        }
    }
    if ($counter == 0) {
        echo "<h1>Non hai ancora creato una watchlist $email</h1>
            <a href=creaWatchlist.html> Clicca qui per crearne una </a>";
    }else{echo "<a href=creaWatchlist.html> Clicca qui per creare una nuova watchlist</a>";
    }
}
?>