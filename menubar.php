<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">WisePDX Beers</a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li><a href="index.php">Home</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Beers <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <?php
            // ID for beer from query
            //$BeerId = $_GET["id"];
            // include connection to datatbase
            include("connect.php");

            //Batch data
            $menuSql = "SELECT * FROM batch";
            $menuResult = $conn->query($menuSql);

            if ($menuResult->num_rows > 0) {
                // output data of each row
                while($row = $menuResult->fetch_assoc()) {
                    $beerVar = $row["batchId"];
                    $beerName = $row["batchName"];
                    echo "<li><a href='beer.php?id=".$beerVar."'>".$beerVar." - ".$beerName."</a></li>";
                }
            } else {
                echo "<li><a href='#'>NOPE!</a></li>";
            }
            //$conn->close();
            //echo "<br><br>";
            ?>
          </ul>
        </li>
        <li><a href="mailboxPost.php">Mailbox Post</a></li>
        <li><a href="ingredientPost.php">Ingredient Post</a></li>
        <li><a href="test.php">Test Page</a></li>

      </ul>
      <ul class="nav navbar-nav navbar-right">
        <!-- <li><a href="#">Welcome <?php echo $login_session; ?></a></li> -->
        <li>
          <a class="btn btn-default" href="logout.php">
            <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Logout
          </a>
        </li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>
