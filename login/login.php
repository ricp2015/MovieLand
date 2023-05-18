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
        <link rel="stylesheet" type="text/css" href="login.css"/>
        <script type="application/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body class="text-center m-auto">
        <?php
            if ($dbconn) {
                $email = $_POST['inputEmail'];
                $q1 = "select * from utente where email= $1";
                $result = pg_query_params($dbconn, $q1, array($email));
                if (!($tuple=pg_fetch_array($result, null, PGSQL_ASSOC))) {
                    /*echo "<div class='container'>
                            <div class='message'>
                                <h1 class='message'>Non sembra che ti sia registrato/a</h1>
                            </div>
                            <div id='button-div'>
                                <a href=../registrazione/index.html><button class='btn btn-primary' id='registr-button'>Registrati!</button></a>
                            </div>
                        </div>";*/
                    header("Location:noRegistr.html");
                    exit();
                }
                else {
                    $password = $_POST['inputPassword'];
                    $q2 = "select * from utente where email = $1 and password = $2";
                    $result = pg_query_params($dbconn, $q2, array($email,$password));
                    if (!($tuple=pg_fetch_array($result, null, PGSQL_ASSOC))) {
                        /*echo "<div class='container'>
                                <div class='message'>
                                    <h1>La password e' sbagliata!</h1>
                                </div>
                                <div class='button-div'>
                                    <a href=index.html><button class='btn btn-primary' id='login-button'>Ritenta il Login!</button></a>
                                </div>
                              </div>";*/
                        header("Location:wrongPsw.html");
                        exit();
                    }
                    else {
                        session_start();
                        $nome = $tuple['nome'];
                        //echo "Benvenuto $nome! <a href=../home/MovieLand.php> Premi qui</a>
                        //    per iniziare a utilizzare MovieLand";
                        $_SESSION["user_id"] = $email;
                        $_SESSION["user_name"] = $nome;
                        header("Location: ../home/MovieLand.php?nome=".$nome);
                    }
                }
            }
        ?> 
    </body>
</html>