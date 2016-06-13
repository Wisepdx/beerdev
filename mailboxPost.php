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
          <!-- PHP for populating latest value button -->
          <?php
            //Batch data
            $batchSql = "SELECT * FROM batch ORDER BY batchId DESC LIMIT 1" ;
            $batchResult = $conn->query($batchSql);

            //Create Batch Vars
            $lvBatchName = "test";
            $lvBatchSize = 1;
            $lvBatchId = 0;

            if ($batchResult->num_rows > 0) {
                // output data of each row
                while($row = $batchResult->fetch_assoc()) {
                  //$lvBatchName = $row["batchName"];
                  //$lvBatchSize = $row["batchSize"];
                  $lvBatchId = $row["batchId"];
                }
            }

            //Sensor data
            $sensorSql = "SELECT * FROM sensor_data ORDER BY 'timeStamp' DESC LIMIT 1" ;
            $sensorResult = $conn->query($sensorSql);

            //Create Sensor Vars
            $lvTargetTemp = "0.00";
            $lvTempDiff = 0;

            if ($sensorResult->num_rows > 0) {
                // output data of each row
                while($row = $sensorResult->fetch_assoc()) {
                  $lvTargetTemp = $row['targetTemp'];
                  $lvTempDiff = $row['tempDiff'];
                }
            }
          ?>
              <div class='page-header'>
                <h1> Post to Arduino Yun</h1>
              </div>
              <div class='col-md-6'>
                <form>
                  <div class="form-group">
                    <label for="BatchId">Batch Id</label>
                    <input id="BatchId" type = "text" name="batchId" class="form-control" oninput="setMailboxLink()" placeholder="Batch Id (Integer)" required autofocus/>
                  </div>
                  <div class="form-group">
                    <label for="BatchName">Batch Name</label>
                    <input id="BatchName" type = "text" name="batchName" class="form-control" oninput="setMailboxLink()" placeholder="Batch Name (String)" required/>
                  </div>
                  <div class="form-group">
                    <label for="BatchSize">Batch Size</label>
                    <input id="BatchSize" type = "text" name="batchSize" class="form-control" oninput="setMailboxLink()" placeholder="Batch Size in Gallons (Integer)" required />
                  </div>
                  <div class="form-group">
                    <label for="TargetTemp">Target Temp</label>
                    <input id="TargetTemp" type = "text" name="targetTemp" class="form-control" oninput="setMailboxLink()" placeholder="Target Temp (Integer)" required />
                  </div>
                  <div class="form-group">
                    <label for="TempDiff">Temperature Differential</label>
                    <input id="TempDiff" type = "text" name="tempDiff" class="form-control" oninput="setMailboxLink()" placeholder="Temperature Differential (Integer)" required />
                  </div>
                  <div class="form-group">
                    <a class="btn btn-lg btn-primary btn-block" href="#" id="mailboxLink">Post to Arduino</a>
                  </div>

                </form>



                <button type="button" class="btn btn-info btn-md" onclick="setLatestValues();">Populate Fields with Latest Values</button>
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
    <!-- Mailbox JS -->
    <script type="text/javascript">
    //Populate Latest Values
    function setLatestValues(){
      //replace Values if found
      $("#BatchId").val(<?php echo $lvBatchId; ?>);
      //$("#BatchName").val(<?php echo $lvBatchName; ?>);
      //$("#BatchSize").val(<?php echo $lvBatchSize; ?>);
      $("#TargetTemp").val(<?php echo $lvTargetTemp; ?>);
      $("#TempDiff").val(<?php echo $lvTempDiff; ?>);
      //set Link
      setMailboxLink();
    }

    //Mailbox URL Build
    function setMailboxLink() {
      // Declare variables
      var mailboxURL = "";
      var mailboxArray = []; //array to hold everything
      var mailboxURLPrefix = "//arduino.local/mailbox?"
      var mailboxInputID = "batchid=" + $('input[id="BatchId"]').val()
      var mailboxInputName = "batchname=" + $('input[id="BatchName"]').val()
      var mailboxInputSize = "batchsize=" + $('input[id="BatchSize"]').val()
      var mailboxInputTarget = "targettemp=" + $('input[id="TargetTemp"]').val()
      var mailboxInputTempRange = "tempdiff=" + $('input[id="TempDiff"]').val()

      //place into an array
      if ($('input[id="BatchId"]').val() !== "") {
          mailboxArray.push(mailboxInputID)
      }
      if ($('input[id="BatchName"]').val() !== "") {
          mailboxArray.push(mailboxInputName);
      }

      if ($('input[id="BatchSize"]').val() !== "") {
          mailboxArray.push(mailboxInputSize)
      }
      if ($('input[id="TargetTemp"]').val() !== "") {
          mailboxArray.push(mailboxInputTarget)
      }
      if ($('input[id="TempDiff"]').val() !== "") {
          mailboxArray.push(mailboxInputTempRange)
      }
      //Build URL
      mailboxURL = mailboxURLPrefix;
      if (mailboxArray.length > 1) {
          for (i = 0; i <= (mailboxArray.length - 1); i++) {
              if (i !== (mailboxArray.length - 1)) {
                  mailboxURL += mailboxArray[i] + "&";
              } else {
                  mailboxURL += mailboxArray[i]
              }
          }

      } else {
          mailboxURL += mailboxArray[0];
      }
      //replace link with mailboxURL
      $("#mailboxLink").attr("href", mailboxURL);

  }
    </script>
  </body>
</html>
