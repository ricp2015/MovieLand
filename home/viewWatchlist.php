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
                <link rel='stylesheet' type='text/css' href='../bootstrap/css/bootstrap.css'/>
                <script type='application/javascript' src='../bootstrap/js/bootstrap.min.js'></script>
                <link rel='stylesheet' href='viewWatchlist.css'>
                <title>Film nella Watchlist</title>
            </head>
            <body>
                <div id='boxfilm'></div>";
    while ($row = pg_fetch_assoc($result1)){
        $counter++;
        $film = $row['film'];
        $url = "https://api.themoviedb.org/3/movie/$film?api_key=2f5263a1468b8f45e9f589381858425e"; 
        echo "<script>
        var php_var = '<?php echo $url; ?>'; 
        php_var = php_var.substring(11, php_var.length - 4);
        fetch(php_var).then(res => res.json()).then(data => {
        console.log(data);
        const {title, poster_path, vote_average, overview, runtime, release_date, id} = data;
            if(poster_path){
                document.getElementById('boxfilm').innerHTML += '<div class=\"film\"><div class=\"img\"><img src=\'https://image.tmdb.org/t/p/w200'+poster_path+'\' alt=\''+title+'\'></div>' + 
                                                                '<div class=\"titolo\"><h2>' + title + '</h2></div><div class=\"durata\"><h2>Durata: '+ runtime +' minuti</h2></div><div class=\"voto\"><h2>Voto: '+ vote_average.toFixed(1) +'</h2></div>' +
                                                                '<div class=\"scheda-film-button\"><a href=\'dettagliFilm.php?movie='+id+'&title='+title+'&language=it\'><button class=\"btn btn-primary\">Scheda film</button></a></div>' + 
                                                                '<div class=\"rimuovi-button\"><a href=\'rimuoviFilm.php?movie='+id+'&watchlist=$watch\'><button class=\"btn btn-primary\">Rimuovi dalla watchlist</button></a></div></div>';
            } else{ 
                document.getElementById('boxfilm').innerHTML += '<div class=\"film\"><div class=\"img\"><img src=\'http://via.placeholder.com/200x300\' alt=\''+title+'\'></div>' + 
                                                                '<div class=\"titolo\"><h2>Titolo: ' + title + '</h2></div><div class=\"durata\"><h2>Durata: '+ runtime +' minuti</h2></div><div class=\"voto\"><h2>Voto: '+ vote_average.toFixed(1) +'</h2></div>' + 
                                                                '<div class=\"scheda-film-button\"><a href=\'dettagliFilm.php?movie='+id+'&language=it\'><button class=\"btn btn-primary\">Scheda film</button></a></div>' + 
                                                                '<div class=\"rimuovi-button\"><a href=\'rimuoviFilm.php?movie='+id+'&watchlist=$watch\'><button class=\"btn btn-primary\">Rimuovi dalla watchlist</button></a></div></div>';
                }            
        });
        </script>";
    }
    if ($counter == 0) {
        echo "<div class='msg'><h1>Non hai ancora aggiunto film a questa watchlist!</h1></div>";
    }
    echo "<div id='button-row'> <div class='aggiungi-film'><a href=MovieLand.php><button class='btn btn-primary'>Aggiungi film</button></a></div><div class='aggiungi-film'><a href=watchlistIntelligente.php?watchlist=$watch><button class='btn btn-primary'>Aggiungi film suggeriti</button></a></div></div></body></html>";
}
}
?>