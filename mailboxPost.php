<?php
  include('session.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Mailbox Post</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!--Custom CSS -->
		<link href="css/custom.css" rel="stylesheet">

    <style type="text/css">
    /*div{
      background: #CCC;
      border: thin white solid;
    }*/
    </style>

    <!-- jQuery -->
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
  <body>
    <?php

      // include connection to datatbase
      include("connect.php");

      //include menu.php
      include("menubar.php");
    ?>
    <div class="container">
      <div class='row'>
        <div class='col-md-12'>
          <!-- <?php
          //Batch data
          $batchSql = "SELECT * FROM batch ORDER BY batchId DESC LIMIT 1" ;
          $batchResult = $conn->query($batchSql);

          //Create Batch Vars
          $bvName = "";
          $bvBatchSize = 0;
          $bvBatchId = 0;

          if ($batchResult->num_rows > 0) {
              // output data of each row
              while($row = $batchResult->fetch_assoc()) {
                  //Set Batch Vars
                  $bvName = $row["batchName"];
                  $bvBatchSize = $row["batchSize"];
                  $bvBatchId = $row["batchId"];

                  echo
                  "<div class='page-header'>".
                  "<h1>Latest Batch</h1>".
                  "</div>";
              }
          } else {
              echo "<div class='alert alert-warning' role='alert'>Invalid Batch ID</div>";
          }
          ?> -->
              <div class='page-header'>
                <h1> Post to Arduino Yun</h1>
              </div>
              <div class='col-md-6'>
                <form>
                  <div class="form-group">
                    <label for="BatchId">Batch Id</label>
                    <input id="BatchId" type = "text" name="batchId" class="form-control" placeholder="Batch Id (Integer)" required autofocus/>
                  </div>
                  <div class="form-group">
                    <label for="BatchName">Batch Name</label>
                    <input id="BatchName" type = "text" name="batchName" class="form-control" placeholder="Batch Name (String)" required/>
                  </div>
                  <div class="form-group">
                    <label for="BatchSize">Batch Size</label>
                    <input id="BatchSize" type = "text" name="batchSize" class="form-control" placeholder="Batch Size in Gallons (Integer)" required />
                  </div>
                  <div class="form-group">
                    <label for="TargetTemp">Target Temp</label>
                    <input id="TargetTemp" type = "text" name="targetTemp" class="form-control" placeholder="Target Temp (Integer)" required />
                  </div>
                  <div class="form-group">
                    <label for="TempDiff">Temperature Differential</label>
                    <input id="TempDiff" type = "text" name="tempDiff" class="form-control" placeholder="Temperature Differential (Integer)" required />
                  </div>
                  <div class="form-group">
                    <input class="btn btn-lg btn-primary btn-block" type="submit" value="Post to Arduino"/><br />
                  </div>
                </form>
                <button type="button" class="btn btn-info btn-md">Populate Fields with Latest Values</button>
              </div>

          </div>
      </div>
    </div>
    <?php

      //Close Connection
      $conn->close();
    ?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
