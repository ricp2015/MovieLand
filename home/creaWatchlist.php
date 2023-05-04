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
                    echo "<h1> Hai già creato una watchlist con questo nome!</h1>";
                }
                else {
                    $descrizione = $_POST['inputDescription'];
                    //da mettere id progressivo
                    $email = $_SESSION['user_id'];
                    $q2 = "insert into watchlist values ($1,$2,$3)";
                    $data = pg_query_params($dbconn, $q2,
                        array($nome, $descrizione, $email));
                    if ($data) {
                        echo "<h1> Watchlist $nome creata! <br/></h1>";
                        echo "<a href=MovieLand.php> Clicca qui </a>
                            per scegliere i film da aggiungere";
                    }
                }
            }
?>