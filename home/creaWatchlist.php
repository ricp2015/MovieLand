<?php
session_start();

$email = $_SESSION['user_id'];

$dbconn = pg_connect("host=localhost port=5432 dbname=MovieLand
            user=postgres password=password") 
            or die('Could not connect: ' . pg_last_error());

            if ($dbconn) {
                $nome = $_POST['inputName'];
                $q1="select * from watchlist where nome = $1";
                $result=pg_query_params($dbconn, $q1, array($nome));
                if ($tuple=pg_fetch_array($result, null, PGSQL_ASSOC)) {
                    echo '<!DOCTYPE html>
                            <html lang="it">
                                <head>
                                    <meta charset="UTF-8">
                                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                    <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.css"/>
                                    <script type="application/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
                                    <link rel="stylesheet" href="watchlists.css">
                                    <title>Nome watchlist già in uso</title>
                                </head>
                                <body class="text-center">
                                    <div class="container">
                                        <div>
                                            <h2 class="message">Hai già creato una watchlist con questo nome!</h2>
                                            <h2 class="message">Creane una con un nome diverso.</h2>
                                        </div>
                                        <div class="button-div">
                                            <a href="creaWatchlist.html"><button class="newWatchlist">Crea una watchlist</button></a>
                                        </div>
                                    </div>
                                </body>
                            </html>';
                }
                else {
                    $descrizione = $_POST['inputDescription'];
                    $email = $_SESSION['user_id'];
                    $q2 = "insert into watchlist values ($1,$2,$3)";
                    $data = pg_query_params($dbconn, $q2,
                        array($nome, $descrizione, $email));
                    if ($data) {
                        /*echo "<h1> Watchlist $nome creata! <br/></h1>";
                        echo "<a href=MovieLand.php> Clicca qui </a>
                            per scegliere i film da aggiungere";*/
                        echo "<!DOCTYPE html>
                                <html lang='it'>
                                    <head>
                                        <meta charset='UTF-8'>
                                        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                                        <link rel='stylesheet' type='text/css' href='../bootstrap/css/bootstrap.css'/>
                                        <script type='application/javascript' src='../bootstrap/js/bootstrap.min.js'></script>
                                        <link rel='stylesheet' href='watchlists.css'>
                                        <title>Watchlist creata</title>
                                    </head>
                                    <body class='text-center'>
                                        <div class='container'>
                                            <div>
                                                <h2 class='message'>Watchlist $nome creata!</h2>
                                            </div>
                                            <div class='button-div'>
                                                <a href='MovieLand.php'><button class='addFilm'>Aggiungi dei Film</button></a>
                                            </div>
                                        </div>
                                    </body>
                                </html>";
                    }
                }
            }
?>