<?php
session_start();

$email = $_SESSION['user_id'];

$dbconn = pg_connect("host=localhost port=5432 dbname=MovieLand
            user=postgres password=password") 
            or die('Could not connect: ' . pg_last_error());

if ($dbconn) {
    $q1 = "select * from watchlist where username = $1";
    $result = pg_query_params($dbconn, $q1, array($email));
    if (!($tuple=pg_fetch_array($result, null, PGSQL_ASSOC))) {
        echo "<h1>Non hai ancora creato una watchlist $email</h1>
            <a href=creaWatchlist.php> Clicca qui per crearne una </a>";
    }
    else {
        $descrizione = $tuple['descrizione'];
        $name = $tuple['name'];
        echo "$nome: $descrizione";
    }
}
/*
$array_values = array();
// output data of each row
while($row = $result->fetch_assoc()) {
   $array_values[] = $row;
};
echo json_encode($array_values);
$conn->close();*/
?>