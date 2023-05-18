<?php
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: /");
}
else {
    $dbconn = pg_connect("host=localhost port=5432 dbname=MovieLand 
                user=postgres password=password") 
                or die('Could not connect: ' . pg_last_error());
}
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="signin.css"/>
        <script type="application/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body class="text-center container">
        <?php
            if ($dbconn) {
                $email = $_POST['inputEmail'];
                $q1="select * from utente where email= $1";
                $result=pg_query_params($dbconn, $q1, array($email));
                if ($tuple=pg_fetch_array($result, null, PGSQL_ASSOC)) {
                    /*echo "<h1> Spiacente, l'indirizzo email non e' disponibile</h1>
                        Se vuoi, <a href=../login/index.html> clicca qui per loggarti </a>";*/
                    header("Location:emailInUse.html");
                    exit();
                }
                else {
                    $nome = $_POST['inputName'];
                    $password = $_POST['inputPassword'];
                    $q2 = "insert into utente values ($1,$2,$3)";
                    $data = pg_query_params($dbconn, $q2,
                        array($email, $nome, $password));
                    if ($data) {
                        /*echo "<h1> Registrazione completata. 
                            Puoi iniziare a usare il sito <br/></h1>";
                        echo "<a href=../login/index.html> Clicca qui </a>
                            per loggarti!";*/
                        header("Location:registrComplete.html");
                        exit();
                    }
                }
            }
        ?> 
    </body>
</html>