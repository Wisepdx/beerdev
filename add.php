<?php
  include("connect.php");

	//GET possible variables
  if (isset($_GET["postType"])){$postType = $_GET["postType"];}else{$postType = "";}
  if (isset($_GET["batchId"])){$batchId = $_GET["batchId"];}else{$batchId = "";}
  if (isset($_GET["batchName"])){$batchName = $_GET["batchName"];}else{$batchName = "";}
  if (isset($_GET["batchSize"])){$batchSize = $_GET["batchSize"];}else{$batchSize = "";}
  if (isset($_GET["targetTemp"])){$targetTemp = $_GET["targetTemp"];}else{$targetTemp = "";}
  if (isset($_GET["currentTemp"])){$currentTemp = $_GET["currentTemp"];}else{$currentTemp = "";}
  if (isset($_GET["ambientTemp"])){$ambientTemp = $_GET["ambientTemp"];}else{$ambientTemp = "";}
  if (isset($_GET["peltStatus"])){$peltStatus = $_GET["peltStatus"];}else{$peltStatus = "";}
  if (isset($_GET["tempDiff"])){$tempDiff = $_GET["tempDiff"];}else{$tempDiff = "";}

  //set date for input
  $batchDate = date('Y-m-d');

  if ($postType == 1){
  //BATCH DATA POST
      //write data to the batch table
      $query = "INSERT INTO `batch` (`batchId`,`batchName`,`batchSize`,`batchDate`)
      VALUES ('".$batchId."','".$batchName."','".$batchSize."','".$batchDate."')";

	}elseif($postType == 2){
  //SENSOR DATA POST
      echo "Post Type 2";
      //write data to the sensor_data table
      $query = "INSERT INTO `sensor_data` (`batchId`,`targetTemp`, `currentTemp`,`ambientTemp`,`peltStatus`,`tempDiff`)
      VALUES ('".$batchId."','".$targetTemp."','".$currentTemp."', '".$ambientTemp."','".$peltStatus."','".$tempDiff."')";
   	}
	else{
	//give an error message that you are not writing to the database
      echo "InsertError | ";
	}

  if ($conn->query($query) === TRUE) {
    echo "<h1>New record created successfully</h1>";
    if ($postType == 1){
      echo "Posting batch data with the folowing information:<br>".
      "<b>Batch ID:</b> ".$_GET['batchId']."<br/>".
      "<b>Batch Name:</b> ".$_GET['batchName']."<br/>".
      "<b>Batch Size:</b> ".$batchSize."<br/>".
      "<b>Batch Date:</b> ".$batchDate."<br/>"."<hr><br>";
    }else if($postType == 2){
      echo "Posting sensor data with the folowing information:<br>".
      "<b>Batch ID:</b> ".$_GET['batchId']."<br/>".
      "<b>Target Temperature:</b> ".$_GET['targetTemp']."<br/>".
      "<b>Current Temperature:</b> ".$_GET['currentTemp']."<br/>".
      "<b>Ambient Temperature:</b> ".$_GET['ambientTemp']."<br/>".
      "<b>Peltier Status Temperature:</b> ".$_GET['peltStatus']."<br/>".
      "<b>Temperature Difference Band:</b> ".$_GET['tempDiff']."<br/>";
    }

  } else {
      echo "<b>Error:</b> " . $query . "<br>" . $conn->error;
  }
  $conn->close();
?>
