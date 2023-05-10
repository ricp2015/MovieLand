<?php
session_start();

//mandare a dettagliFilm user e film
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
    while ($row = pg_fetch_assoc($result1)){
        $counter++;
        $film = $row['film'];
        $url = "https://api.themoviedb.org/3/movie/$film?api_key=2f5263a1468b8f45e9f589381858425e"; 
        echo "<div id='boxfilm'></div>";
        echo "<script>
        var php_var = '<?php echo $url; ?>'; 
        php_var = php_var.substring(11, php_var.length - 4);
        fetch(php_var).then(res => res.json()).then(data => {
        console.log(data);
        const {title, poster_path, vote_average, overview, runtime, release_date, id} = data;
            if(poster_path){
                document.getElementById('boxfilm').innerHTML += '<br> <img src=\'https://image.tmdb.org/t/p/w200'+poster_path+'\' alt=\''+title+'\'><br><br>';
            } else{ 
                document.getElementById('boxfilm').innerHTML += '<img src=\'http://via.placeholder.com/1080x1580\' alt=\''+title+'\'>';
                }
            document.getElementById('boxfilm').innerHTML += 'Titolo: ' + title + ' <br> Durata: '+ runtime +' minuti <br> Voto: '+ vote_average.toFixed(1) +'<br>';
            document.getElementById('boxfilm').innerHTML += '<a href=\'dettagliFilm.php?movie='+id+'&language=it\'>Scheda film</a><br>';
            document.getElementById('boxfilm').innerHTML += '<a href=\'rimuoviFilm.php?movie='+id+'&watchlist=$watch\'>Rimuovi dalla watchlist</a><br><br>';
            
        });
        </script>";
    }
    if ($counter == 0) {
        echo "<h1>Non hai ancora aggiunto film a questa watchlist!</h1>
            <a href=MovieLand.php> Clicca qui per aggiungerne uno<br></a>";
    }else{echo "<br> <div><a href=MovieLand.php> Clicca qui</a> per aggiungere un nuovo film alla watchlist</div><br>";
    }
    echo "<a href=watchlistIntelligente.php?watchlist=$watch><div>Clicca qua</a> per aggiungere dei film suggeriti alla watchlist</div>
         <br>";
}
}
?>