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
                <h1> Post to Database</h1>
              </div>
              alert goes here
              <div class='col-md-12'>
                <form>
                  <h2> Ingredients</h2>
                  <!-- Header -->
                  <div class="row">
                    <div class='col-md-4'>Name</div>
                    <div class='col-md-4'>Amount</div>
                    <div class='col-md-4'>Percentage</div>
                  </div>

                  <!-- Body -->
                  <div class="row">
                    <div class='col-md-4'>
                      <label class='sr-only' for="iName1">Ingredient Name 1</label>
                      <input id="iName1" type = "text" name="iName1" class="form-control" placeholder="Ingredient Name (String)"/>
                    </div>
                    <div class='col-md-4'>
                      <label class='sr-only' for="iAmount1">Ingredient Amount 1</label>
                      <input id="iAmount1" type = "text" name="iAmount1" class="form-control" placeholder="Ingredient Amount in Lbs. (Decimal)"/>
                    </div>
                    <div class='col-md-4'>
                      <label class='sr-only' for="iPercent1">Ingredient Percent 1</label>
                      <input id="iAmountPercent1" type = "text" name="iPercent1" class="form-control" placeholder="Ingredient Percentage (Decimal)"/>
                    </div>
                  </div>

                  <div class="row">
                    <div class='col-md-4'>
                      <label class='sr-only' for="iName2">Ingredient Name 2</label>
                      <input id="iName2" type = "text" name="iName2" class="form-control" placeholder=""/>
                    </div>
                    <div class='col-md-4'>
                      <label class='sr-only' for="iAmount2">Ingredient Amount 2</label>
                      <input id="iAmount2" type = "text" name="iAmount2" class="form-control" placeholder=""/>
                    </div>
                    <div class='col-md-4'>
                      <label class='sr-only' for="iPercent2">Ingredient Percent 2</label>
                      <input id="iAmountPercent2" type = "text" name="iPercent2" class="form-control" placeholder=""/>
                    </div>
                  </div>

                  <div class="row">
                    <div class='col-md-4'>
                      <label class='sr-only' for="iName3">Ingredient Name 3</label>
                      <input id="iName3" type = "text" name="iName3" class="form-control" placeholder=""/>
                    </div>
                    <div class='col-md-4'>
                      <label class='sr-only' for="iAmount3">Ingredient Amount 3</label>
                      <input id="iAmount3" type = "text" name="iAmount3" class="form-control" placeholder=""/>
                    </div>
                    <div class='col-md-4'>
                      <label class='sr-only' for="iPercent3">Ingredient Percent 3</label>
                      <input id="iAmountPercent3" type = "text" name="iPercent3" class="form-control" placeholder=""/>
                    </div>
                  </div>

                  <div class="row">
                    <div class='col-md-4'>
                      <label class='sr-only' for="iName4">Ingredient Name 4</label>
                      <input id="iName4" type = "text" name="iName4" class="form-control" placeholder=""/>
                    </div>
                    <div class='col-md-4'>
                      <label class='sr-only' for="iAmount4">Ingredient Amount 4</label>
                      <input id="iAmount4" type = "text" name="iAmount4" class="form-control" placeholder=""/>
                    </div>
                    <div class='col-md-4'>
                      <label class='sr-only' for="iPercent4">Ingredient Percent 4</label>
                      <input id="iAmountPercent4" type = "text" name="iPercent4" class="form-control" placeholder=""/>
                    </div>
                  </div>

                  <div class="row">
                    <div class='col-md-4'>
                      <label class='sr-only' for="iName5">Ingredient Name 5</label>
                      <input id="iName5" type = "text" name="iName5" class="form-control" placeholder=""/>
                    </div>
                    <div class='col-md-4'>
                      <label class='sr-only' for="iAmount5">Ingredient Amount 5</label>
                      <input id="iAmount5" type = "text" name="iAmount5" class="form-control" placeholder=""/>
                    </div>
                    <div class='col-md-4'>
                      <label class='sr-only' for="iPercent5">Ingredient Percent 5</label>
                      <input id="iAmountPercent5" type = "text" name="iPercent5" class="form-control" placeholder=""/>
                    </div>
                  </div>

                  <div class="row">
                    <div class='col-md-4'>
                      <label class='sr-only' for="iName6">Ingredient Name 6</label>
                      <input id="iName6" type = "text" name="iName6" class="form-control" placeholder=""/>
                    </div>
                    <div class='col-md-4'>
                      <label class='sr-only' for="iAmount6">Ingredient Amount 6</label>
                      <input id="iAmount6" type = "text" name="iAmount6" class="form-control" placeholder=""/>
                    </div>
                    <div class='col-md-4'>
                      <label class='sr-only' for="iPercent6">Ingredient Percent 6</label>
                      <input id="iAmountPercent6" type = "text" name="iPercent6" class="form-control" placeholder=""/>
                    </div>
                  </div>

                  <div class="row">
                    <div class='col-md-4'>
                      <label class='sr-only' for="iName7">Ingredient Name 7</label>
                      <input id="iName7" type = "text" name="iName7" class="form-control" placeholder=""/>
                    </div>
                    <div class='col-md-4'>
                      <label class='sr-only' for="iAmount7">Ingredient Amount 7</label>
                      <input id="iAmount7" type = "text" name="iAmount7" class="form-control" placeholder=""/>
                    </div>
                    <div class='col-md-4'>
                      <label class='sr-only' for="iPercent7">Ingredient Percent 7</label>
                      <input id="iAmountPercent7" type = "text" name="iPercent7" class="form-control" placeholder=""/>
                    </div>
                  </div>

                  <div class="row">
                    <div class='col-md-4'>
                      <label class='sr-only' for="iName8">Ingredient Name 8</label>
                      <input id="iName8" type = "text" name="iName8" class="form-control" placeholder=""/>
                    </div>
                    <div class='col-md-4'>
                      <label class='sr-only' for="iAmount8">Ingredient Amount 8</label>
                      <input id="iAmount8" type = "text" name="iAmount8" class="form-control" placeholder=""/>
                    </div>
                    <div class='col-md-4'>
                      <label class='sr-only' for="iPercent8">Ingredient Percent 8</label>
                      <input id="iAmountPercent8" type = "text" name="iPercent8" class="form-control" placeholder=""/>
                    </div>
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
