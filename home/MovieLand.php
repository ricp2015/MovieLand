<?php
    session_start();
    if(!isset($_SESSION["user_id"])){
        header("Location:../MovieLand.html");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"/>
    <script type="application/javascript" src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <title>MovieLand</title>
</head>
<body>  
    <script type="text/javascript">
    email = '<?php echo $_SESSION["user_id"];?>';
    </script>
    <header>
        <div class ="same-row">
        <a href="fetchWatchlists.php" class="fetchwatchlists"><button class="fetchwatchlists">Le mie Watchlists</button></a>
        <br><a href="logout.php" class="logout"><button class="logout">Log-out</button></a>
        </div>
        <div class="same-row">
        <?php
            $nome = $_SESSION["user_name"]; 
            echo "<div id='welcome'><h2 id='welcome-message'>Benvenuto $nome!</h2></div>";
        ?>
    </div>
    <div class="same-row">
        <form  id="form">
            <input type="text" placeholder="Search" id="search" class="search">
        </form>
        <div class="dropend" id="generi">
            <button class="btn dropdown-toggle" data-bs-target="#generi" data-bs-toggle="dropdown" id="generi-dropdown">
                Generi
            </button>
            <div class="dropdown-menu" id ="dropdown">
            </div>
        </div>
</div>
    </header>
    <div id="tags"></div>
    <div id="myNav" class="overlay">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <div class="overlay-content" id="overlay-content"></div>
        
        <a href="javascript:void(0)" class="arrow left-arrow" id="left-arrow">&#8592;</a> 
        
        <a href="javascript:void(0)" class="arrow right-arrow" id="right-arrow">&#8594;</a>
      </div>
      <div id="review" class="overlay">
      </div>
    <main id="main"></main>
    <div class="pagination">
        <div class="page" id="prev">Previous Page</div>
        <div class="current" id="current">1</div>
        <div class="page" id="next">Next Page</div>
    </div>
    <script src="script.js"></script>
</body>
</html>