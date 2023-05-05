<?php
    session_start();
    $email = $_SESSION['user_id'];
    $film = $_GET['movie'];
    $dbconn = pg_connect("host=localhost port=5432 dbname=MovieLand
            user=postgres password=password") 
            or die('Could not connect: ' . pg_last_error());
    $url1 = "https://api.themoviedb.org/3/movie/$film?api_key=1cf50e6248dc270629e802686245c2c8"; 
    $url2 = "https://api.themoviedb.org/3/movie/$film/translations?api_key=1cf50e6248dc270629e802686245c2c8"; 
    echo "<div id='dettagli'></div>";
    echo "<script>
    var php_var1 = '<?php echo $url1; ?>'; 
            php_var1 = php_var1.substring(11, php_var1.length - 4);
            var php_var2 = '<?php echo $url2; ?>'; 
            php_var2 = php_var2.substring(11, php_var2.length - 4);
            Promise.all([
                fetch(php_var1).then(resp => resp.json()),
                fetch(php_var2).then(resp => resp.json())
              ]).then(data => {
            console.log(data);
            var {title, poster_path, vote_average, overview, runtime, release_date, id} = data[0];
            overview=getOverview(data[1],overview);
        if(poster_path){
            document.getElementById('dettagli').innerHTML += '<br> <img src=\'https://image.tmdb.org/t/p/w500'+poster_path+'\' alt=\''+title+'\'><br><br>';
        } else{ 
            document.getElementById('dettagli').innerHTML += '<img src=\'http://via.placeholder.com/1080x1580\' alt=\''+title+'\'>';
            }
        document.getElementById('dettagli').innerHTML += 'Titolo: ' + title + ' <br> Durata: '+ runtime +' minuti <br> Voto: '+ vote_average.toFixed(1) +'<br> Trama: ' +overview+'<br>';
        document.getElementById('dettagli').innerHTML += '<a href=\'MovieLand.php\'>Scegli un altro film</a><br><br>';
    });    

    function getOverview(data, trama){
        const {id, translations} = data;
        var overview = '';
        for(let i in translations){
            if(translations[i]['iso_639_1']=='it'){
                overview = translations[i]['data']['overview'];}
                    }
        if(overview != ''){
            return overview;
        }
        else{
            return trama;
        }
    }
        </script>";
?>