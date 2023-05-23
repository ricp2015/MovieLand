<?php

session_start();
session_unset();
session_destroy();
header("Location:../MovieLand.html");
exit();

?>