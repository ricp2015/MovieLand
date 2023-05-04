<?php
    session_start();
    $email = $_SESSION['user_id'];
    $movie = $_GET['movie'];
    $title = $_GET['title'];
    $dbconn = pg_connect("host=localhost port=5432 dbname=MovieLand
            user=postgres password=password") 
            or die('Could not connect: ' . pg_last_error());
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scheda Film</title>
</head>
<body>
    <script> getMovies(API_URL + '&with_genres='+encodeURI(selectedGenre.join(','))) </script>
</body>
</html>