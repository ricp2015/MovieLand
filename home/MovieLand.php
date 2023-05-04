<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>MovieLand</title>
</head>
<body>  
    <script type="text/javascript">
    email = '<?php echo $_SESSION["user_id"];?>';
    </script>
    <header>
        <a href="fetchWatchlists.php" id="fetchwatchlists">Le mie Watchlists</a> 
    </header>
    <header>
        <form  id="form">
            <input type="text" placeholder="Search" id="search" class="search">
        </form>
    </header>
    <div id="tags"></div>
    <div id="myNav" class="overlay">
        <!-- Button to close the overlay navigation -->
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      
        <!-- Overlay content -->
        <div class="overlay-content" id="overlay-content"></div>
        
        <a href="javascript:void(0)" class="arrow left-arrow" id="left-arrow">&#8656;</a> 
        
        <a href="javascript:void(0)" class="arrow right-arrow" id="right-arrow" >&#8658;</a>

      </div>
      <div id="review" class="overlay">
        <!-- Far comparire un box per le recensioni.-->
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